@extends('layout.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    <p>{{ __('Please check your email for a verification link.') }}</p>

                    @if (session('status') === 'verification-link-sent')
                        <div class="alert alert-success" role="alert">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('verification.send') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            {{ __('Resend Verification Email') }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
