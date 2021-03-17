@extends('layouts/app')

@section('content')

    <div class="container">
        <h2 style=" display:inline-block ">Categpries</h2>
        <a href="{{ route('category.create') }}"><button class="btn btn-success" style="color:#fff;font-weight:bold;float:right">Add category</button></a>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Sort</th>
                <th>#</th>
                <th>#</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $key=>$category)
                <tr id="{{ $category->id }}">
                    <td class="keys">{{ $key+1 }}</td>
                    <td><span>{{ $category->name }}</span></td>
                    <td><span>{{ $category->sort }}</span></td>
                    <td data-id="{{ $category->id }}"><a href="category/edit/?id={{ $category->id }}"><i class="fas fa-pencil-alt"></i></a></td>
                    <td class="category_delete_modal" data-id="{{ $category->id }}"><i class="fas fa-trash-alt"></i></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div>
            {{ $categories->links() }}
        </div>
    </div>

    <div class="modal fade" id="CategoryDeleteModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Do you want delete</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" style="text-align:center">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">No</button>
                    <button style="margin-left:10px" type="button" class="btn btn-danger category_delete" data-dismiss="modal">Yes</button>
                </div>
            </div>
        </div>
    </div>

@endsection
