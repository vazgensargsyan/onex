@extends('layouts/app')

@section('content')

    <div class="container">
        <h2>Add Post</h2>
        <form method="post" action="{{ route('post.store') }}" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value = "{{ old('name') }}">
            </div>
            <div class="form-group">
                <label for="categories">Categories</label>
                <select class="form-control" id="categories" name="categories[]" multiple>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
            </div>
            <div class="form-group">
                <label for="photo">Photo</label>
                <input style="display:none" type="file" class="form-control" id="photo" name="photo" accept=".jpg,.jpeg,.gif,.png,.JPG,.JPEG,.GIF,.PNG">
                <button type="button" id="photo_button" class="btn btn-primary" style="width:100%">Click button for photo</button>
            </div>
            <button type="submit" class="btn btn-success" style="width:100%">Save</button>
        </form>
    </div>

@endsection
