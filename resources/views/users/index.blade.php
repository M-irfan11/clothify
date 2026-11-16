@extends('layout.master')

@section('content')
<div class="container py-4">
    <h4>Users</h4>
    <table class="table">
        <tr><th>Name</th><th>Email</th><th>Role</th></tr>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->getRoleNames()->implode(', ') }}</td>
            </tr>
        @endforeach
    </table>
</div>
@endsection