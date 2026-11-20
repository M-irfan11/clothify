@extends('layout.master')

@section('content')
    <div class="container-fluid py-4">
        <div class="mb-4">
            <h4 class="mb-1">My Profile</h4>
            <p class="mb-0 text-sm text-secondary">Your account details and settings.</p>
        </div>

        <div class="card mb-4">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-circle bg-gradient-dark text-white flex-shrink-0" style="width: 72px; height: 72px;">
                        <i class="material-symbols-rounded" style="font-size: 36px;">person</i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="mb-1">{{ $user->name }}</h5>
                        <p class="mb-2 text-sm text-secondary">{{ $user->email }}</p>
                        @if ($user->hasVerifiedEmail())
                            <span class="badge bg-gradient-success">Verified account</span>
                        @else
                            <span class="badge bg-gradient-warning">Email not verified</span>
                        @endif
                    </div>
                    <div class="text-sm text-secondary">
                        <span class="d-block text-xs text-uppercase font-weight-bold">Member since</span>
                        <span class="text-dark">{{ $user->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12 col-xl-6">
                <div class="card h-100">
                    <div class="card-header pb-0">
                        <h6 class="mb-0">Profile information</h6>
                        <p class="text-sm text-secondary mb-0">Update your name and email address.</p>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-6">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6 class="mb-0">Update password</h6>
                        <p class="text-sm text-secondary mb-0">Keep your account secure with a strong password.</p>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="card">
                    <div class="card-header pb-0">
                        <h6 class="mb-0 text-danger">Delete account</h6>
                        <p class="text-sm text-secondary mb-0">Permanently remove your account and its data.</p>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
