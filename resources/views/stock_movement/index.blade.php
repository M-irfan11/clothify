@extends('layout.master')

@section('content')
<div class="container-fluid crud-page py-4">
    <div class="mb-3">
        <h4 class="mb-1">Stock Movements</h4>
        <p class="text-sm text-secondary mb-0">Review material and product stock movements by warehouse.</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success text-white" role="alert">{{ session('success') }}</div>
    @endif

    <div class="card crud-list-card">
        <div class="card-header d-flex align-items-center justify-content-between bg-white border-0 px-4 pt-4 pb-3">
            <div>
                <h6 class="mb-1">Stock Movement List</h6>
                <p class="text-xs text-secondary mb-0">IN quantities are positive; OUT quantities are negative</p>
            </div>
            <a href="{{ route('stock_movements.create') }}" class="btn btn-sm bg-gradient-dark mb-0">
                <span class="material-symbols-rounded align-middle me-1" style="font-size: 18px;">add</span>
                Add Movement
            </a>
        </div>
        <div class="card-body px-0 pb-2">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Warehouse</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Item</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Movement</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quantity</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($stockMovements as $stockMovement)
                            <tr>
                                <td class="text-sm">{{ $stockMovement->movement_date->format('M d, Y H:i') }}</td>
                                <td class="text-sm">{{ $stockMovement->warehouse->warehouse_name ?? '#'.$stockMovement->warehouse_id }}</td>
                                <td>
                                    <a class="text-sm font-weight-bold mb-0" href="{{ route('stock_movements.show', $stockMovement) }}">
                                        @if ($stockMovement->material)
                                            {{ $stockMovement->material->material_name }}
                                        @else
                                            {{ $stockMovement->productVariant->sku ?? '#'.$stockMovement->product_variant_id }}
                                        @endif
                                    </a>
                                </td>
                                <td class="text-sm">{{ $stockMovement->movement_type_label }}</td>
                                <td class="text-sm">{{ $stockMovement->quantity }}</td>
                                <td class="align-middle text-end">
                                    <a href="{{ route('stock_movements.show', $stockMovement) }}" class="btn btn-sm btn-action-view mb-0 me-1">View</a>
                                    <a href="{{ route('stock_movements.edit', $stockMovement) }}" class="btn btn-sm btn-action-edit mb-0 me-1">Edit</a>
                                    <form action="{{ route('stock_movements.destroy', $stockMovement) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-action-delete mb-0" onclick="return confirm('Delete this stock movement?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-secondary py-4">No stock movements found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 pt-3">
                {{ $stockMovements->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
