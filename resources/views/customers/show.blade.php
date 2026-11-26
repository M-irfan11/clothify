@extends('layout.master')

@section('content')
<div class="container-fluid py-4">
    @if (session('success'))
        <div class="alert alert-success text-white" role="alert">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">{{ $customer->customer_name }}</h4>
            <p class="text-sm text-secondary mb-0">Customer details</p>
        </div>
        <div>
            <a href="{{ route('customers.index') }}" class="btn btn-outline-dark mb-0">Back</a>
            <a href="{{ route('customers.edit', $customer) }}" class="btn btn-action-edit mb-0">Edit Customer</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Customer Code</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $customer->customer_code }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Customer Type</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $customer->customer_type_label }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Contact Person</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $customer->contact_person ?: 'Not provided' }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Phone</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $customer->phone }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Email</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $customer->email ?: 'Not provided' }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Buyer Reference</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $customer->buyer_reference ?: 'Not provided' }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Credit Limit</p>
                    <p class="text-sm font-weight-bold mb-0">{{ number_format((float) $customer->credit_limit, 2) }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Status</p>
                    <span class="badge badge-sm {{ $customer->status === 'active' ? 'bg-gradient-success' : 'bg-gradient-secondary' }}">{{ $customer->status_label }}</span>
                </div>
                <div class="col-12 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Address</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $customer->address }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
