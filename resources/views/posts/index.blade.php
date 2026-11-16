@extends('layout.master')

@section('content')
<div class="container py-4">
    <h4>Posts</h4>

    @can('create posts')
        <a href="{{ route('posts.create') }}" class="btn btn-primary">New Post</a>
    @endcan

    <table class="table mt-3">
        @foreach($posts as $post)
            <tr>
                <td>{{ $post->title }}</td>
                <td>
                    @can('delete posts')
                        <form method="POST" action="{{ route('posts.destroy', $post) }}">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    @endcan
                </td>
            </tr>
        @endforeach
    </table>
</div>
@endsection