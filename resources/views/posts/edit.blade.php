@extends('layouts/app')

@section('content')

    <div class="container">
        <h2>Edit Post</h2>
        <form method="post" action="{{ route('post.update') }}" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{ $post->id }}">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value = "{{ $post->name }}">
            </div>
            <div class="form-group">
                <label for="categories">Categories</label>
                <select class="form-control" id="categories" name="categories[]" multiple>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @if(in_array($category->id, $category_ids)) selected @endif>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description">{{ $post->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="photo">Photo</label>
                <input style="display:none" type="file" class="form-control" id="photo" name="photo" accept=".jpg,.jpeg,.gif,.png,.JPG,.JPEG,.GIF,.PNG">
                <button type="button" id="photo_button" class="btn btn-primary" style="width:100%">Click button for photo</button>
            </div>
            @if(!is_null($post->photo))
                <div>
                    <img src="{{ asset('uploads/posts/'.$post->photo) }}" alt="photo" width="200px" height="200px">
                </div>
            @endif
            <button type="submit" class="btn btn-success" style="width:100%">Save</button>
        </form>
        <div class="form-group">
            <label for="photo">Like</label>
            <span>{{ $post->likeDislikes->where('like_vs',1)->count() }}</span>
        </div>
        <div class="form-group">
            <label for="photo">Dislike</label>
            <span>{{ $post->likeDislikes->where('dislike',1)->count() }}</span>
        </div>
        <div class="form-group">
            <label for="photo">Comments</label>
            <div class="row">
                @foreach($post->comments as $comment)
                    <div class="col-md-2" style="padding:0">{{ $comment->user->name }}</div>
                    <div class="col-md-10" style="padding:0">{{ $comment->comment }}</div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
