@extends('layout.master')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Variant Details</h4>
        <div>
            <a href="{{ route('product_variants.edit', $product_variant) }}" class="btn btn-warning btn-sm">Edit</a>
            <a href="{{ route('product_variants.index') }}" class="btn btn-secondary btn-sm">Back</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered mb-0">
                <tr><th width="30%">Product</th><td>{{ $product_variant->product->product_name ?? '-' }}</td></tr>
                <tr><th>SKU</th><td>{{ $product_variant->sku }}</td></tr>
                <tr><th>Size</th><td>{{ $product_variant->size }}</td></tr>
                <tr><th>Color</th><td>{{ $product_variant->color }}</td></tr>
                <tr><th>Cost Price</th><td>{{ number_format($product_variant->cost_price, 2) }}</td></tr>
                <tr><th>Selling Price</th><td>{{ number_format($product_variant->selling_price, 2) }}</td></tr>
                <tr><th>Reorder Level</th><td>{{ $product_variant->reorder_level }}</td></tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="badge {{ $product_variant->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                            {{ ucfirst($product_variant->status) }}
                        </span>
                    </td>
                </tr>
                <tr><th>Created At</th><td>{{ $product_variant->created_at?->format('d M Y, h:i A') }}</td></tr>
                <tr><th>Updated At</th><td>{{ $product_variant->updated_at?->format('d M Y, h:i A') }}</td></tr>
            </table>
        </div>
    </div>
</div>
@endsection