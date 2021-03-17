@extends('layouts/app')

@section('content')

    <div class="container">
        <h2 style=" display:inline-block ">Posts</h2>
        <a href="{{ route('post.create') }}"><button class="btn btn-success" style="color:#fff;font-weight:bold;float:right">Add post</button></a>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Photo</th>
                <th>Like</th>
                <th>Dislike</th>
                <th>#</th>
                <th>#</th>
            </tr>
            </thead>
            <tbody>
            @foreach($posts as $key=>$post)
                <tr id="{{ $post->id }}">
                    <td class="keys">{{ $key+1 }}</td>
                    <td><span>{{ $post->name }}</span></td>
                    <td><span>{{ $post->description }}</span></td>
                    <td>
                        @if(!is_null($post->photo))
                            <img src="{{ asset('uploads/posts/'.$post->photo) }}" alt="photo" width="50px" height="50px">
                        @else
                            <img src="{{ asset('uploads/posts/no_img.png') }}" alt="photo" width="50px" height="50px">
                        @endif
                    </td>
                    <td><span>{{ $post->likeDislikes->where('like_vs',1)->count() }}</span></td>
                    <td><span>{{ $post->likeDislikes->where('dislike',1)->count() }}</span></td>
                    <td data-id="{{ $post->id }}"><a href="post/edit/?id={{ $post->id }}"><i class="fas fa-pencil-alt"></i></a></td>
                    <td class="post_delete_modal" data-id="{{ $post->id }}"><i class="fas fa-trash-alt"></i></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div>
            {{ $posts->links() }}
        </div>
    </div>

    <div class="modal fade" id="PostDeleteModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Do you want delete</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" style="text-align:center">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">No</button>
                    <button style="margin-left:10px" type="button" class="btn btn-danger post_delete" data-dismiss="modal">Yes</button>
                </div>
            </div>
        </div>
    </div>

@endsection
