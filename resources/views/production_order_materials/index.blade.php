@extends('layout.master')

@section('content')
@php
    $statusClasses = [
        'planned' => 'bg-gradient-secondary',
        'in_progress' => 'bg-gradient-info',
        'completed' => 'bg-gradient-success',
        'cancelled' => 'bg-gradient-danger',
    ];
@endphp
<div class="container-fluid py-4">
    @if (session('success'))
        <div class="alert alert-success text-white" role="alert">{{ session('success') }}</div>
    @endif

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <p class="text-sm text-secondary mb-1">Production Order / Material Requirements</p>
            <h4 class="mb-1">{{ $order->production_no }}</h4>
            <p class="text-sm text-secondary mb-0">Track material requirements and usage for this production order.</p>
        </div>
        <div>
            <a href="{{ route('production-orders.show', $order) }}" class="btn btn-outline-dark mb-0 me-1">Back to Order</a>
            <a href="{{ route('production-orders.materials.create', $order) }}" class="btn bg-gradient-dark mb-0">Add Material</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-3 mb-3 mb-md-0">
                    <span class="badge badge-sm {{ $statusClasses[$order->status] ?? 'bg-gradient-secondary' }} mb-2">{{ $order->status_label }}</span>
                    <h5 class="mb-1">{{ $order->production_no }}</h5>
                    <p class="text-xs text-secondary mb-0">Production Order No.</p>
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <p class="text-xs text-secondary mb-1">Product</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $order->productVariant?->product?->product_name ?? 'Product' }}</p>
                    <p class="text-xs text-secondary mb-0">SKU: {{ $order->productVariant?->sku ?? '—' }}</p>
                </div>
                <div class="col-md-2 mb-3 mb-md-0">
                    <p class="text-xs text-secondary mb-1">Planned Qty</p>
                    <p class="text-sm font-weight-bold mb-0">{{ number_format($order->planned_qty) }}</p>
                </div>
                <div class="col-md-2 mb-3 mb-md-0">
                    <p class="text-xs text-secondary mb-1">Schedule</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $order->start_date?->format('M d, Y') }}</p>
                    <p class="text-xs text-secondary mb-0">Due {{ $order->due_date?->format('M d, Y') }}</p>
                </div>
                <div class="col-md-2">
                    <p class="text-xs text-secondary mb-1">Warehouse</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $order->sourceWarehouse?->warehouse_name ?? '—' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        @foreach ([
            ['label' => 'Total Materials', 'value' => number_format($summary['materials']), 'note' => 'Items', 'class' => 'info'],
            ['label' => 'Total Planned Qty', 'value' => number_format((float) $summary['planned'], 3), 'note' => 'All materials', 'class' => 'primary'],
            ['label' => 'Total Issued Qty', 'value' => number_format((float) $summary['issued'], 3), 'note' => 'Warehouse issue', 'class' => 'success'],
            ['label' => 'Total Used Qty', 'value' => number_format((float) $summary['used'], 3), 'note' => 'Actual consumed', 'class' => 'warning'],
            ['label' => 'Total Returned Qty', 'value' => number_format((float) $summary['returned'], 3), 'note' => 'Returned to warehouse', 'class' => 'danger'],
        ] as $card)
            <div class="col-xl col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body p-3">
                        <p class="text-xs text-secondary mb-1">{{ $card['label'] }}</p>
                        <h5 class="mb-1">{{ $card['value'] }}</h5>
                        <p class="text-xs text-secondary mb-0">{{ $card['note'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center bg-white border-0 px-4 pt-4 pb-3 gap-2">
            <div>
                <h6 class="mb-1">Material Details</h6>
                <p class="text-xs text-secondary mb-0">Planned, issued, consumed and returned material quantities.</p>
            </div>
            <span class="badge bg-gradient-info">{{ $items->count() }} Materials</span>
        </div>
        <div class="card-body px-0 pb-2">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Material</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category / Unit</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Planned Qty</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Issued Qty</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Used Qty</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Returned Qty</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Wastage</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $item)
                            <tr>
                                <td class="text-sm">{{ $loop->iteration }}</td>
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
                                    <a href="{{ route('production-orders.materials.show', [$order, $item]) }}" class="btn btn-sm btn-action-view mb-0 me-1">View</a>
                                    <a href="{{ route('production-orders.materials.edit', [$order, $item]) }}" class="btn btn-sm btn-action-edit mb-0">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="9" class="text-center text-secondary py-5">No material requirements added yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
