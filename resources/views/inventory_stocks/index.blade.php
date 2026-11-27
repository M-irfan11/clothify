@extends('layout.master')

@section('content')
<div class="container-fluid crud-page py-4">
    <div class="crud-heading">
        <div>
            <h4 class="mb-1">Inventory Management</h4>
            <p class="text-sm text-secondary mb-0">Stock overview, warehouse-wise and material usage</p>
        </div>
        <div class="d-flex align-items-center gap-2 text-sm">
            <span class="text-secondary">Status:</span>
            <span class="badge bg-gradient-success">Live</span>
            <a href="{{ route('inventory_stocks.create') }}" class="btn bg-gradient-dark mb-0">Add Stock</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success text-white" role="alert">{{ session('success') }}</div>
    @endif

    <div class="card crud-list-card shadow-sm">
        <div class="card-header d-flex align-items-center justify-content-between bg-white border-0 px-4 pt-4 pb-3">
            <div>
                <h6 class="mb-1">Warehouse Stock</h6>
                <p class="text-xs text-secondary mb-0">Current stock position of all materials and finished goods</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <form method="GET" action="{{ route('inventory_stocks.index') }}">
                    <select name="warehouse_id" class="form-select form-select-sm" onchange="this.form.submit()" aria-label="Filter by warehouse">
                        <option value="">All Warehouses</option>
                        @foreach ($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}" @selected((string) request('warehouse_id') === (string) $warehouse->id)>
                                {{ $warehouse->warehouse_name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
        <div class="card-body px-0 pb-2">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">#</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Item Code</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Item Name</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Warehouse</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Unit</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Available Qty</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Reserved Qty</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Total Qty</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($stocks as $inventoryStock)
                            @php
                                $itemCode = $inventoryStock->material?->material_code ?? $inventoryStock->productVariant?->sku ?? '-';
                                $itemName = $inventoryStock->material?->material_name ?? $inventoryStock->productVariant?->product?->product_name ?? 'Product';
                                $category = $inventoryStock->material?->category_label ?? ($inventoryStock->productVariant?->product?->category ?? 'Finished Good');
                                $unit = $inventoryStock->material?->unit ?? 'PCS';
                                $available = (float) $inventoryStock->quantity - (float) $inventoryStock->reserved_qty;
                            @endphp
                            <tr>
                                <td class="text-sm ps-4">{{ $stocks->firstItem() + $loop->index }}</td>
                                <td class="text-sm font-weight-bold">{{ $itemCode }}</td>
                                <td>
                                    <a class="text-sm font-weight-bold mb-0" href="{{ route('inventory_stocks.show', $inventoryStock) }}">{{ $itemName }}</a>
                                </td>
                                <td><span class="badge bg-gradient-info">{{ \Illuminate\Support\Str::headline($category) }}</span></td>
                                <td class="text-sm">{{ $inventoryStock->warehouse->warehouse_name ?? '#'.$inventoryStock->warehouse_id }}</td>
                                <td class="text-sm text-uppercase">{{ $unit }}</td>
                                <td class="text-sm text-end">{{ number_format($available, 3) }}</td>
                                <td class="text-sm text-end">{{ number_format((float) $inventoryStock->reserved_qty, 3) }}</td>
                                <td class="text-sm text-end">{{ number_format((float) $inventoryStock->quantity, 3) }}</td>
                                <td class="align-middle text-end">
                                    <a href="{{ route('inventory_stocks.show', $inventoryStock) }}" class="btn btn-sm btn-action-view mb-0 me-1">View</a>
                                    <a href="{{ route('inventory_stocks.edit', $inventoryStock) }}" class="btn btn-sm btn-action-edit mb-0">⋮</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-secondary py-4">No inventory stocks found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 pt-3">
                {{ $stocks->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
