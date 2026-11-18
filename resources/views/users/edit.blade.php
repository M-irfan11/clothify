@extends('layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header bg-white px-4 py-3">
                        <h6 class="mb-0 text-capitalize">Edit User</h6>
                    </div>
                    <div class="card-body p-6">
                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                            </div>
                            <button type="submit" class="btn btn-action-edit">Update User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
