<?php

namespace App\Http\Controllers;

use App\Models\PostToCategory;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    public function __construct(){
        $this->middleware('permission:post-list|post-create|post-edit|post-delete', ['only' => ['index','create','store','edit','update','delete']]);
    }

    public function index(){
        $posts = Post::orderByDesc('id')->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function create(){
        $categories = Category::orderByDesc('id')->get();
        return view('posts.create', compact('categories'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'photo' => 'mimes:jpg,jpeg,gif,png,JPG,JPEG,GIF,PNG|max:2048',
        ]);
        if(empty($request->categories)){
            return redirect()->back()->withErrors('The categories field is required')->withInput($request->all());
        }
        if($request->photo){
            $ext = explode('.', $request->photo->getClientOriginalName());
            $format = end($ext);
            $fileName = md5(time().$request->photo->getClientOriginalName()).'.'.$format;
            if(!file_exists(public_path('uploads/posts'))){
                mkdir(public_path('uploads/posts'), 0777);
            }
            $request->photo->move(public_path('uploads/posts'), $fileName);
        }else{
            $fileName = null;
        }
        $post = new Post([
            'name'=>$request->name,
            'description'=>$request->description,
            'photo'=>$fileName,
        ]);
        $post->save();
        if($request->categories){
            foreach($request->categories as $category){
                $post_to_category = new PostToCategory([
                    'post_id'=>$post->id,
                    'category_id'=>$category,
                ]);
                $post_to_category->save();
            }
        }
        return redirect(route('post.index'))->with('message', 'Success');
    }

    public function edit(Request $request){
        $post = Post::find($request->id);
        $category_ids = $post->category_ids->pluck('category_id')->toArray();
        $categories = Category::orderByDesc('sort')->get();
        return view('posts.edit', compact('post', 'category_ids', 'categories'));
    }

    public function update(Request $request){
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'photo' => 'mimes:jpg,jpeg,gif,png,JPG,JPEG,GIF,PNG|max:2048',
        ]);
        if(empty($request->categories)){
            return redirect()->back()->withErrors('The categories field is required')->withInput($request->all());
        }
        $post = Post::find($request->id);
        if($request->photo){
            if(!is_null($post->photo) && file_exists(public_path('uploads/posts/'.$post->photo))){
                unlink(public_path('uploads/posts/'.$post->photo));
            }
            $ext = explode('.', $request->photo->getClientOriginalName());
            $format = end($ext);
            $fileName = md5(time().$request->photo->getClientOriginalName()).'.'.$format;
            if(!file_exists(public_path('uploads/posts'))){
                mkdir(public_path('uploads/posts'), 0777);
            }
            $request->photo->move(public_path('uploads/posts'), $fileName);
        }else{
            $fileName = $post->photo;
        }
        $post->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'photo'=>$fileName,
        ]);
        if($request->categories){
            $category_ids = $post->category_ids->pluck('category_id')->toArray();
            if(!empty($category_ids)){
                foreach($category_ids as $category){
                    if(!in_array($category, $request->categories)){
                        PostToCategory::where(['post_id'=>$post->id, 'category_id'=>$category])->delete();
                    }
                }
                foreach($request->categories as $category){
                    if(!in_array($category, $category_ids)){
                        $post_to_category = new PostToCategory([
                            'post_id'=>$post->id,
                            'category_id'=>$category,
                        ]);
                        $post_to_category->save();
                    }
                }
            }else{
                foreach($request->categories as $category){
                    $post_to_category = new PostToCategory([
                        'post_id'=>$post->id,
                        'category_id'=>$category,
                    ]);
                    $post_to_category->save();
                }
            }
        }
        return redirect(route('post.index'))->with('message', 'Success');
    }

    public function delete(Request $request){
        Post::find($request->id)->delete();
        return 1;
    }
}
