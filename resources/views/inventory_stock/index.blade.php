@extends('layout.master')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-3">
        <h4 class="mb-1">Inventory Stocks</h4>
        <p class="text-sm text-secondary mb-0">Manage material and product stock by warehouse.</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success text-white" role="alert">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between bg-white border-0 px-4 pt-4 pb-3">
            <div>
                <h6 class="mb-1">Inventory Stock List</h6>
                <p class="text-xs text-secondary mb-0">Review and manage warehouse stock records</p>
            </div>
            <a href="{{ route('inventory_stocks.create') }}" class="btn btn-sm bg-gradient-dark mb-0">
                <span class="material-symbols-rounded align-middle me-1" style="font-size: 18px;">add</span>
                Add Stock
            </a>
        </div>
        <div class="card-body px-0 pb-2">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Warehouse</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Item</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quantity</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Reserved</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Available</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($inventoryStocks as $inventoryStock)
                            <tr>
                                <td class="text-sm">{{ $inventoryStock->warehouse->warehouse_name ?? '#'.$inventoryStock->warehouse_id }}</td>
                                <td>
                                    <a class="text-sm font-weight-bold mb-0" href="{{ route('inventory_stocks.show', $inventoryStock) }}">
                                        @if ($inventoryStock->material)
                                            {{ $inventoryStock->material->material_name }}
                                        @else
                                            {{ $inventoryStock->productVariant->sku ?? '#'.$inventoryStock->product_variant_id }}
                                        @endif
                                    </a>
                                </td>
                                <td class="text-sm">{{ $inventoryStock->quantity }}</td>
                                <td class="text-sm">{{ $inventoryStock->reserved_qty }}</td>
                                <td class="text-sm">{{ number_format((float) $inventoryStock->quantity - (float) $inventoryStock->reserved_qty, 3) }}</td>
                                <td class="align-middle text-end">
                                    <a href="{{ route('inventory_stocks.show', $inventoryStock) }}" class="btn btn-sm btn-action-view mb-0 me-1">View</a>
                                    <a href="{{ route('inventory_stocks.edit', $inventoryStock) }}" class="btn btn-sm btn-action-edit mb-0 me-1">Edit</a>
                                    <form action="{{ route('inventory_stocks.destroy', $inventoryStock) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-action-delete mb-0" onclick="return confirm('Delete this inventory stock?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-secondary py-4">No inventory stocks found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 pt-3">
                {{ $inventoryStocks->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
