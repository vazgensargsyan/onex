<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryParent;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(){
        $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index','create','store','edit','update','delete']]);
    }

    public function index(){
        $categories = Category::orderByDesc('sort')->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create(){
        $parents = Category::orderByDesc('sort')->get();
        return view('categories.create', compact('parents'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
        ]);
        if(!is_null($request->sort)){
            $sort = $request->sort;
        }else{
            $sort = 0;
        }
        $category = new Category([
            'name'=>$request->name,
            'sort'=>$sort,
        ]);
        $category->save();
        if($request->parents){
            foreach($request->parents as $parent){
                $category_parent = new CategoryParent([
                    'category_id'=>$category->id,
                    'parent_category_id'=>$parent,
                ]);
                $category_parent->save();
            }
        }
        return redirect(route('category.index'))->with('message', 'Success');
    }

    public function edit(Request $request){
        $category = Category::find($request->id);
        $parent_ids = $category->parent_ids->pluck('parent_category_id')->toArray();
        $parents = Category::orderByDesc('sort')->get();
        return view('categories.edit', compact('category', 'parent_ids', 'parents'));
    }

    public function update(Request $request){
        $request->validate([
            'name' => 'required',
        ]);
        $category = Category::find($request->id);
        if(!is_null($request->sort)){
            $sort = $request->sort;
        }else{
            $sort = 0;
        }
        $category->update([
            'name'=>$request->name,
            'sort'=>$sort,
        ]);
        if($request->parents){
            $parent_ids = $category->parent_ids->pluck('parent_category_id')->toArray();
            if(!empty($parent_ids)){
                foreach($parent_ids as $parent){
                    if(!in_array($parent, $request->parents)){
                        CategoryParent::where(['category_id'=>$category->id, 'parent_category_id'=>$parent])->delete();
                    }
                }
                foreach($request->parents as $parent){
                    if(!in_array($parent, $parent_ids)){
                        $category_parent = new CategoryParent([
                            'category_id'=>$category->id,
                            'parent_category_id'=>$parent,
                        ]);
                        $category_parent->save();
                    }
                }
            }else{
                foreach($request->parents as $parent){
                    $category_parent = new CategoryParent([
                        'category_id'=>$category->id,
                        'parent_category_id'=>$parent,
                    ]);
                    $category_parent->save();
                }
            }
        }
        return redirect(route('category.index'))->with('message', 'Success');
    }

    public function delete(Request $request){
        Category::find($request->id)->delete();
        return 1;
    }
}
