@extends('layout.master')

@section('content')
<div class="container-fluid py-4">
    @if (session('success'))
        <div class="alert alert-success text-white" role="alert">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">{{ $warehouse->warehouse_name }}</h4>
            <p class="text-sm text-secondary mb-0">Warehouse details</p>
        </div>
        <div>
            <a href="{{ route('warehouses.index') }}" class="btn btn-outline-dark mb-0">Back</a>
            <a href="{{ route('warehouses.edit', $warehouse) }}" class="btn bg-gradient-dark mb-0">Edit Warehouse</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Warehouse Code</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $warehouse->warehouse_code }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Warehouse Type</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $warehouse->warehouse_type_label }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Status</p>
                    <span class="badge badge-sm {{ $warehouse->status === 'active' ? 'bg-gradient-success' : 'bg-gradient-secondary' }}">
                        {{ $warehouse->status_label }}
                    </span>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Phone</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $warehouse->phone ?: 'Not provided' }}</p>
                </div>
                <div class="col-12 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Address</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $warehouse->address }}</p>
                </div>
                <div class="col-12">
                    <p class="text-xs text-uppercase text-secondary mb-1">Created At</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $warehouse->created_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
