<?php

namespace App\Http\Controllers;

use App\Models\CategoryParent;
use App\Models\PostComment;
use App\Models\PostLikeDislik;
use App\Models\PostToCategory;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::orderByDesc('sort')->get();
        $posts = Post::orderByDesc('id')->get();
        $category_id = 0;
        $name = '';
        return view('home', compact('categories', 'posts', 'category_id', 'name'));
    }

    public function like(Request $request){
        $user_id = Auth::user()->id;
        $post_id = (integer)$request->id;
        $like = $request->like;
        $like_dislike = PostLikeDislik::where(['user_id'=>$user_id, 'post_id'=>$post_id])->first();
        if($like_dislike){
            $like_dislike->update(['like_vs'=>$like]);
        }else{
            $new_like_dislike = new PostLikeDislik([
                'user_id'=>$user_id,
                'post_id'=>$post_id,
                'like_vs'=>$like,
                'dislike'=>0,
            ]);
            $new_like_dislike->save();
        }
        return $like;
    }

    public function dislike(Request $request){
        $user_id = Auth::user()->id;
        $post_id = (integer)$request->id;
        $dislike = $request->dislike;
        $like_dislike = PostLikeDislik::where(['user_id'=>$user_id, 'post_id'=>$post_id])->first();
        if($like_dislike){
            $like_dislike->update(['dislike'=>$dislike]);
        }else{
            $new_like_dislike = new PostLikeDislik([
                'user_id'=>$user_id,
                'post_id'=>$post_id,
                'like_vs'=>0,
                'dislike'=>$dislike,
            ]);
            $new_like_dislike->save();
        }
        return $dislike;
    }

    public function comment(Request $request){
        $user_id = Auth::user()->id;
        $post_id = (integer)$request->id;
        $comment = $request->comment;
        $post_comment = new PostComment([
            'user_id'=>$user_id,
            'post_id'=>$post_id,
            'comment'=>$comment,
        ]);
        $post_comment->save();

        return Auth::user()->name;
    }

    public function search(Request $request){
        $category_id = $request->home_category;
        $name = $request->name;
        $category_ids = $this->makeCategoryTree([$category_id]);
        $category_ids[] = (integer)$request->home_category;
        $posts_ids = PostToCategory::whereIn('category_id', $category_ids)->pluck('post_id')->toArray();
        $categories = Category::orderByDesc('sort')->get();
        if($category_id == 0 && !is_null($name)){
            $posts = Post::where('name', 'like', '%'.$name.'%')->orderByDesc('id')->get();
        }else if($category_id != 0 && is_null($name)){
            $posts = Post::whereIn('id', $posts_ids)->orderByDesc('id')->get();
        }else if($category_id == 0 && is_null($name)){
            $posts = Post::orderByDesc('id')->get();;
        }else{
            $posts = Post::where('name', 'like', '%'.$name.'%')->whereIn('id', $posts_ids)->orderByDesc('id')->get();
        }
        return view('home', compact('categories', 'posts', 'category_id', 'name'));
    }

    private function makeCategoryTree($parent, $return = []){
        $data = CategoryParent::whereIn('parent_category_id', $parent)->pluck('category_id')->toArray();
        $return = array_merge($data, $return);
        if(!empty($data)){
            return $this->makeCategoryTree($data, $return);
        }
        return $return;
    }
}
