@extends('layout.master')
@section('content')
    <div class="container-fluid py-4">
        <div class="mb-3">
            <h4 class="mb-1">Users</h4>
            <p class="text-sm text-secondary mb-0">Manage user accounts and access.</p>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between bg-white border-0 px-4 pt-4 pb-3">
                        <div>
                            <h6 class="mb-1">User List</h6>
                            <p class="text-xs text-secondary mb-0">Review and manage account records</p>
                        </div>
                        <a href="{{ route('users.create') }}" class="btn btn-sm bg-gradient-dark mb-0">
                            <span class="material-symbols-rounded align-middle me-1" style="font-size: 18px;">add</span>
                            Add User
                        </a>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
