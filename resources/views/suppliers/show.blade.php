@extends('layout.master')

@section('content')
<div class="container-fluid py-4">
    @if (session('success'))
        <div class="alert alert-success text-white" role="alert">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">{{ $supplier->company_name }}</h4>
            <p class="text-sm text-secondary mb-0">Supplier details</p>
        </div>
        <div>
            <a href="{{ route('suppliers.index') }}" class="btn btn-outline-dark mb-0">Back</a>
            <a href="{{ route('suppliers.edit', $supplier) }}" class="btn bg-gradient-dark mb-0">Edit Supplier</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Supplier Code</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $supplier->supplier_code }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Contact Person</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $supplier->contact_person }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Phone</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $supplier->phone }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Email</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $supplier->email ?: 'Not provided' }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Supplier Type</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $supplier->supplier_type_label }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Status</p>
                    <span class="badge badge-sm {{ $supplier->status === 'active' ? 'bg-gradient-success' : 'bg-gradient-secondary' }}">
                        {{ $supplier->status_label }}
                    </span>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Payment Terms</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $supplier->payment_terms_days }} days</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Lead Time</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $supplier->lead_time_days }} days</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Rating</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $supplier->rating ?? 'Not rated' }}</p>
                </div>
                <div class="col-12 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Address</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $supplier->address }}</p>
                </div>
                <div class="col-12">
                    <p class="text-xs text-uppercase text-secondary mb-1">Created At</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $supplier->created_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
