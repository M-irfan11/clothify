@extends('layout.master')

@section('content')
<div class="container-fluid py-4">
    @if (session('success'))
        <div class="alert alert-success text-white" role="alert">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">{{ $product_variant->sku }}</h4>
            <p class="text-sm text-secondary mb-0">Product variant details</p>
        </div>
        <div>
            <a href="{{ route('product_variants.index') }}" class="btn btn-outline-dark mb-0">Back</a>
            <a href="{{ route('product_variants.edit', $product_variant) }}" class="btn btn-action-edit mb-0">Edit Variant</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Product</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $product_variant->product->product_name ?? '-' }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">SKU</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $product_variant->sku }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Size</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $product_variant->size }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Color</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $product_variant->color }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Cost Price</p>
                    <p class="text-sm font-weight-bold mb-0">{{ number_format($product_variant->cost_price, 2) }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Selling Price</p>
                    <p class="text-sm font-weight-bold mb-0">{{ number_format($product_variant->selling_price, 2) }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Reorder Level</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $product_variant->reorder_level }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Status</p>
                    <span class="badge badge-sm {{ $product_variant->status === 'active' ? 'bg-gradient-success' : 'bg-gradient-secondary' }}">
                        {{ ucfirst($product_variant->status) }}
                    </span>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Created At</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $product_variant->created_at?->format('M d, Y H:i') }}</p>
                </div>
                <div class="col-md-6">
                    <p class="text-xs text-uppercase text-secondary mb-1">Last Updated</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $product_variant->updated_at?->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection