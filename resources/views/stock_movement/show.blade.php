@extends('layout.master')

@section('content')
<div class="container-fluid py-4">
    @if (session('success'))
        <div class="alert alert-success text-white" role="alert">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Stock Movement #{{ $stockMovement->id }}</h4>
            <p class="text-sm text-secondary mb-0">Stock movement details</p>
        </div>
        <div>
            <a href="{{ route('stock_movements.index') }}" class="btn btn-outline-dark mb-0">Back</a>
            <a href="{{ route('stock_movements.edit', $stockMovement) }}" class="btn btn-action-edit mb-0">Edit Movement</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Movement Date</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $stockMovement->movement_date->format('M d, Y H:i') }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Movement Type</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $stockMovement->movement_type_label }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Warehouse</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $stockMovement->warehouse->warehouse_name ?? '#'.$stockMovement->warehouse_id }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Inventory Item</p>
                    <p class="text-sm font-weight-bold mb-0">
                        @if ($stockMovement->material)
                            {{ $stockMovement->material->material_name }} ({{ $stockMovement->material->material_code }})
                        @else
                            {{ $stockMovement->productVariant->sku ?? '#'.$stockMovement->product_variant_id }}
                            @if ($stockMovement->productVariant)
                                - {{ $stockMovement->productVariant->product->product_name ?? 'Product' }}
                                ({{ $stockMovement->productVariant->size }}, {{ $stockMovement->productVariant->color }})
                            @endif
                        @endif
                    </p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Signed Quantity</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $stockMovement->quantity }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Unit Cost</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $stockMovement->unit_cost ?? '-' }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Reference</p>
                    <p class="text-sm font-weight-bold mb-0">
                        @if ($stockMovement->reference_type)
                            {{ $stockMovement->reference_type_label }} #{{ $stockMovement->reference_id }}
                        @else
                            -
                        @endif
                    </p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Recorded By</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $stockMovement->creator->name ?? '#'.$stockMovement->created_by }}</p>
                </div>
                <div class="col-md-12 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Remarks</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $stockMovement->remarks ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p class="text-xs text-uppercase text-secondary mb-1">Created At</p>
                    <p class="text-sm font-weight-bold mb-0">{{ optional($stockMovement->created_at)->format('M d, Y H:i') ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
