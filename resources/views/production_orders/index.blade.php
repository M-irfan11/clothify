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
<div class="container-fluid crud-page py-4">
    <div class="d-flex justify-content-between align-items-end mb-3">
        <div>
            <div class="crud-eyebrow">Production</div>
            <h4 class="mb-1">Production Orders</h4>
            <p class="text-sm text-secondary mb-0">Plan and track production runs.</p>
        </div>
        <a href="{{ route('production-orders.create') }}" class="btn bg-gradient-dark mb-0">
            <span class="material-symbols-rounded align-middle me-1" style="font-size: 18px;">add</span>
            New production order
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success text-white" role="alert">{{ session('success') }}</div>
    @endif

    <div class="card crud-list-card">
        <div class="card-header d-flex align-items-center justify-content-between bg-white border-0 px-4 pt-4 pb-3">
            <div>
                <h6 class="mb-1">Production Order List</h6>
                <p class="text-xs text-secondary mb-0">Review and manage production orders</p>
            </div>
        </div>
        <div class="card-body px-0 pb-2">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Production No</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quantity</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Schedule</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>
                                    <a class="text-sm font-weight-bold mb-0" href="{{ route('production-orders.show', $order) }}">
                                        {{ $order->production_no }}
                                    </a>
                                    <p class="text-xs text-secondary mb-0">{{ $order->created_at->format('M d, Y') }}</p>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0">{{ $order->productVariant->name ?? ('Variant #' . $order->product_variant_id) }}</p>
                                    <p class="text-xs text-secondary mb-0">{{ $order->sourceWarehouse->name ?? '—' }}</p>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0">{{ number_format($order->planned_qty) }} planned</p>
                                    <p class="text-xs text-secondary mb-0">
                                        {{ number_format($order->produced_qty) }} produced · {{ number_format($order->wastage_qty) }} wastage
                                    </p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0">{{ $order->start_date->format('M d, Y') }}</p>
                                    <p class="text-xs text-secondary mb-0">Due {{ $order->due_date->format('M d, Y') }}</p>
                                </td>
                                <td>
                                    <span class="badge badge-sm {{ $statusClasses[$order->status] ?? 'bg-gradient-secondary' }}">
                                        {{ $order->status_label }}
                                    </span>
                                </td>
                                <td class="align-middle text-end">
                                    <a href="{{ route('production-orders.show', $order) }}" class="btn btn-sm btn-action-view mb-0 me-1">View</a>
                                    <a href="{{ route('production-orders.edit', $order) }}" class="btn btn-sm btn-action-edit mb-0 me-1">Edit</a>
                                    <form action="{{ route('production-orders.destroy', $order) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-action-delete mb-0" onclick="return confirm('Delete this production order?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-secondary py-4">No production orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 pt-3">
                {{ $orders->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
