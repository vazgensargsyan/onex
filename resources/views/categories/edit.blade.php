@extends('layouts/app')

@section('content')

    <div class="container">
        <h2>Edit Category</h2>
        <form method="post" action="{{ route('category.update') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{ $category->id }}">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value = "{{ $category->name }}">
            </div>
            <div class="form-group">
                <label for="sort">Sort</label>
                <input type="number" class="form-control" id="sort" name="sort" value = "{{ $category->sort }}">
            </div>
            <div class="form-group">
                <label for="parents">Parents</label>
                <select class="form-control" id="parents" name="parents[]" multiple>
                    @foreach($parents as $parent)
                        <option value="{{ $parent->id }}" @if(in_array($parent->id, $parent_ids)) selected @endif>{{ $parent->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success" style="width:100%">Save</button>
        </form>
    </div>

@endsection
