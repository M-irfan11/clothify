@extends('layout.master')

@section('content')
<div class="container-fluid py-4">
    @if (session('success'))
        <div class="alert alert-success text-white" role="alert">{{ session('success') }}</div>
    @endif

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h4 class="mb-1">Production Order Materials</h4>
            <p class="text-sm text-secondary mb-0">Review material requirements across all production orders.</p>
        </div>
        <a href="{{ route('production-orders.index') }}" class="btn bg-gradient-dark mb-0">View Production Orders</a>
    </div>

    <div class="card">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center bg-white border-0 px-4 pt-4 pb-3 gap-2">
            <div>
                <h6 class="mb-1">Material Requirements</h6>
                <p class="text-xs text-secondary mb-0">Select an order to add or manage its materials.</p>
            </div>
            <form method="GET" action="{{ route('production-order-materials.index') }}" class="d-flex gap-2">
                <select name="production_order_id" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">All Production Orders</option>
                    @foreach ($orders as $productionOrder)
                        <option value="{{ $productionOrder->id }}" @selected((int) request('production_order_id') === (int) $productionOrder->id)>
                            {{ $productionOrder->production_no }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
        <div class="card-body px-0 pb-2">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Production Order</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Material</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category / Unit</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Planned</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Issued</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Used</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Returned</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Wastage</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $item)
                            <tr>
                                <td>
                                    <a class="text-sm font-weight-bold mb-0" href="{{ route('production-orders.materials.index', $item->productionOrder) }}">
                                        {{ $item->productionOrder->production_no }}
                                    </a>
                                    <p class="text-xs text-secondary mb-0">{{ $item->productionOrder->productVariant?->product?->product_name ?? 'Product' }}</p>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0">{{ $item->material->material_name }}</p>
                                    <p class="text-xs text-secondary mb-0">{{ $item->material->material_code }}</p>
                                </td>
                                <td>
                                    <span class="badge badge-sm bg-gradient-info">{{ $item->material->category_label }}</span>
                                    <p class="text-xs text-secondary mb-0 mt-1">{{ $item->material->unit_label }}</p>
                                </td>
                                <td class="text-sm">{{ number_format((float) $item->planned_qty, 3) }}</td>
                                <td class="text-sm">{{ number_format((float) $item->issued_qty, 3) }}</td>
                                <td class="text-sm">{{ number_format((float) $item->used_qty, 3) }}</td>
                                <td class="text-sm">{{ number_format((float) $item->return_qty, 3) }}</td>
                                <td class="text-sm">{{ number_format((float) $item->wastage_qty, 3) }}</td>
                                <td class="text-end">
                                    <a href="{{ route('production-orders.materials.show', [$item->productionOrder, $item]) }}" class="btn btn-sm btn-action-view mb-0">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="9" class="text-center text-secondary py-5">No production order materials found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 pt-3">{{ $items->links('pagination::bootstrap-5') }}</div>
        </div>
    </div>
</div>
@endsection
