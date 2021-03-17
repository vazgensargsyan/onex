@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12" style="margin-bottom:20px">
            <div class="card">
                <div class="card-header text-center">
                    <h1>Posts</h1>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center">Search</div>
                <form method="get" action="{{ route('home.search') }}">
                    <div class="form-group" style="padding:0 25px">
                        <label for="home_categories">Categories</label>
                        <select class="form-control" id="home_categories" name="home_category">
                            <option value="0"></option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @if($category_id == $category->id) selected @endif>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="padding:0 25px">
                        <label for="name">Post Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $name }}">
                    </div>
                    <div style="padding:0 25px">
                        <button type="submit" class="btn btn-success" style="width:100%">Save</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-8">
            @foreach($posts as $post)
                <div class="card" id="{{ $post->id }}" style="margin-bottom:25px">
                    <div class="card-header text-center">
                        <h4>{{ $post->name }}</h4>
                    </div>
                    <div class="card-body row" style="padding-bottom:0">
                        <div class="col-md-10">{{ $post->description }}</div>
                        <div class="col-md-2">
                            @if(!is_null($post->photo))
                                <img src="{{ asset('uploads/posts/'.$post->photo) }}" alt="photo" width="100px" height="100px">
                            @else
                                <img src="{{ asset('uploads/posts/no_img.png') }}" alt="photo" width="100px" height="100px">
                            @endif
                        </div>
                        @if(!empty($post->like_dislike))
                            <div class="post_footer post_like col-md-4" data-key="{{ $post->like_dislike->like_vs }}">@if($post->like_dislike->like_vs == 0) <i class="far fa-thumbs-up"></i> @else <i class="fas fa-thumbs-up"></i> @endif </div>
                            <div class="post_footer post_dislike col-md-4" data-key="{{ $post->like_dislike->dislike }}">@if($post->like_dislike->dislike == 0) <i class="far fa-thumbs-down"></i> @else <i class="fas fa-thumbs-down"></i> @endif </div>
                        @else
                            <div class="post_footer post_like col-md-4" data-key="0"><i class="far fa-thumbs-up"></i></div>
                            <div class="post_footer post_dislike col-md-4" data-key="0"><i class="far fa-thumbs-down"></i></div>
                        @endif
                        <div class="post_footer post_comment col-md-4"><i class="fas fa-comments"></i></div>
                        <div class="row col-md-12" style="display:none">
                            <h5>Comments</h5>
                            <div class="row col-md-12 post_comments">
                                @foreach($post->comments as $comment)
                                    <div class="col-md-2" style="padding:0">{{ $comment->user->name }}</div>
                                    <div class="col-md-10" style="padding:0">{{ $comment->comment }}</div>
                                @endforeach
                            </div>
                            <div class="col-md-10" style="padding:0"><input type="text" class="form-control post_comment_input" style="width:100%"></div>
                            <div class="col-md-2" style="padding:0"><button type="button" class="btn btn-success send_post_comment" style="float:right">Send</button></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
