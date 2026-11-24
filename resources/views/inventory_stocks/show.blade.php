@extends('layout.master')

@section('content')
<div class="container-fluid py-4">
    @if (session('success'))
        <div class="alert alert-success text-white" role="alert">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Inventory Stock #{{ $inventoryStock->id }}</h4>
            <p class="text-sm text-secondary mb-0">Warehouse inventory details</p>
        </div>
        <div>
            <a href="{{ route('inventory_stocks.index') }}" class="btn btn-outline-dark mb-0">Back</a>
            <a href="{{ route('inventory_stocks.edit', $inventoryStock) }}" class="btn btn-action-edit mb-0">Edit Stock</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Warehouse</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $inventoryStock->warehouse->warehouse_name ?? '#'.$inventoryStock->warehouse_id }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Inventory Item</p>
                    <p class="text-sm font-weight-bold mb-0">
                        @if ($inventoryStock->material)
                            {{ $inventoryStock->material->material_name }} ({{ $inventoryStock->material->material_code }})
                        @else
                            {{ $inventoryStock->productVariant->sku ?? '#'.$inventoryStock->product_variant_id }}
                            @if ($inventoryStock->productVariant)
                                - {{ $inventoryStock->productVariant->product->product_name ?? 'Product' }}
                                ({{ $inventoryStock->productVariant->size }}, {{ $inventoryStock->productVariant->color }})
                            @endif
                        @endif
                    </p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Item Code</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $inventoryStock->material->material_code ?? $inventoryStock->productVariant->sku ?? '-' }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Item Name</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $inventoryStock->material->material_name ?? $inventoryStock->productVariant->product->product_name ?? 'Product' }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Quantity</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $inventoryStock->quantity }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Reserved Quantity</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $inventoryStock->reserved_qty }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Unit</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $inventoryStock->material->unit ?? 'PCS' }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Available Quantity</p>
                    <p class="text-sm font-weight-bold mb-0">{{ number_format((float) $inventoryStock->quantity - (float) $inventoryStock->reserved_qty, 3) }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Last Updated</p>
                    <p class="text-sm font-weight-bold mb-0">{{ optional($inventoryStock->updated_at)->format('M d, Y H:i') ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
