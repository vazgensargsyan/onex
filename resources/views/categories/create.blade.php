@extends('layouts/app')

@section('content')

    <div class="container">
        <h2>Add Category</h2>
        <form method="post" action="{{ route('category.store') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value = "{{ old('name') }}">
            </div>
            <div class="form-group">
                <label for="sort">Sort</label>
                <input type="number" class="form-control" id="sort" name="sort" value = "{{ old('sort') }}">
            </div>
            <div class="form-group">
                <label for="parents">Parents</label>
                <select class="form-control" id="parents" name="parents[]" multiple>
                    @foreach($parents as $parent)
                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success" style="width:100%">Save</button>
        </form>
    </div>

@endsection
