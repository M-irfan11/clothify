@extends('layout.master')

@section('content')
<div class="container-fluid py-4">
    @if (session('success'))
        <div class="alert alert-success text-white" role="alert">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">BOM Item #{{ $bomItem->id }}</h4>
            <p class="text-sm text-secondary mb-0">BOM item details</p>
        </div>
        <div>
            <a href="{{ route('bom_items.index') }}" class="btn btn-outline-dark mb-0">Back</a>
            <a href="{{ route('bom_items.edit', $bomItem) }}" class="btn btn-action-edit mb-0">Edit BOM Item</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Product Variant</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $bomItem->productVariant->sku ?? '#'.$bomItem->product_variant_id }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Material</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $bomItem->material->material_name ?? '#'.$bomItem->material_id }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Quantity per Unit</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $bomItem->quantity_per_unit }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Wastage</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $bomItem->wastage_percent }}%</p>
                </div>
                <div class="col-md-6">
                    <p class="text-xs text-uppercase text-secondary mb-1">Created At</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $bomItem->created_at->format('M d, Y H:i') }}</p>
                </div>
                <div class="col-md-6">
                    <p class="text-xs text-uppercase text-secondary mb-1">Updated At</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $bomItem->updated_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection