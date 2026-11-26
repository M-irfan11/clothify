@extends('layout.master')

@section('content')
<div class="container-fluid materials-page py-4">
    @if (session('success'))
        <div class="alert alert-success text-white" role="alert">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">{{ $material->material_name }}</h4>
            <p class="text-sm text-secondary mb-0">Material details</p>
        </div>
        <div>
            <a href="{{ route('materials.index') }}" class="btn btn-material-outline mb-0">Back</a>
            <a href="{{ route('materials.edit', $material) }}" class="btn btn-material-primary mb-0">Edit Material</a>
        </div>
    </div>

    <div class="card materials-card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Material Code</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $material->material_code }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Supplier</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $material->supplier?->company_name ?? 'Not assigned' }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Category</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $material->category_label }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Unit</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $material->unit_label }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Unit Cost</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $material->unit_cost }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Status</p>
                    <span class="badge badge-sm {{ $material->status === 'active' ? 'bg-gradient-success' : 'bg-gradient-secondary' }}">
                        {{ $material->status_label }}
                    </span>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Reorder Level</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $material->reorder_level }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Safety Stock</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $material->safety_stock }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Created At</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $material->created_at->format('M d, Y H:i') }}</p>
                </div>
                <div class="col-md-6">
                    <p class="text-xs text-uppercase text-secondary mb-1">Last Updated</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $material->updated_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
