@extends('layout.master')
@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">{{ $product_variant->sku }}</h4>
                <p class="text-sm text-secondary mb-0">Product variant details</p>
            </div>
            <div>
                <a href="{{ route('product_variants.index') }}" class="btn btn-outline-dark mb-0">Back to Variants</a>
                <a href="{{ route('product_variants.edit', $product_variant) }}" class="btn btn-action-edit mb-0">Edit Variant</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3">Product</dt>
                    <dd class="col-sm-9">{{ $product_variant->product->product_name ?? '-' }}</dd>

                    <dt class="col-sm-3">SKU</dt>
                    <dd class="col-sm-9">{{ $product_variant->sku }}</dd>

                    <dt class="col-sm-3">Size</dt>
                    <dd class="col-sm-9">{{ $product_variant->size }}</dd>

                    <dt class="col-sm-3">Color</dt>
                    <dd class="col-sm-9">{{ $product_variant->color }}</dd>

                    <dt class="col-sm-3">Cost Price</dt>
                    <dd class="col-sm-9">{{ number_format($product_variant->cost_price, 2) }}</dd>

                    <dt class="col-sm-3">Selling Price</dt>
                    <dd class="col-sm-9">{{ number_format($product_variant->selling_price, 2) }}</dd>

                    <dt class="col-sm-3">Reorder Level</dt>
                    <dd class="col-sm-9">{{ $product_variant->reorder_level }}</dd>

                    <dt class="col-sm-3">Status</dt>
                    <dd class="col-sm-9">{{ ucfirst($product_variant->status) }}</dd>

                    <dt class="col-sm-3">Created At</dt>
                    <dd class="col-sm-9">{{ $product_variant->created_at?->format('d M Y, h:i A') }}</dd>

                    <dt class="col-sm-3">Updated At</dt>
                    <dd class="col-sm-9">{{ $product_variant->updated_at?->format('d M Y, h:i A') }}</dd>
                </dl>
            </div>
        </div>
    </div>
@endsection