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

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">{{ $order->production_no }}</h4>
            <p class="text-sm text-secondary mb-0">Production order details</p>
        </div>
        <div>
            <a href="{{ route('production-orders.index') }}" class="btn btn-outline-dark mb-0">Back</a>
            <a href="{{ route('production-orders.edit', $order) }}" class="btn btn-action-edit mb-0">Edit Production Order</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Production No</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $order->production_no }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Status</p>
                    <span class="badge badge-sm {{ $statusClasses[$order->status] ?? 'bg-gradient-secondary' }}">
                        {{ $order->status_label }}
                    </span>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Product Variant</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $order->productVariant->name ?? ('Variant #' . $order->product_variant_id) }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Source Warehouse</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $order->sourceWarehouse->name ?? '—' }}</p>
                </div>
                <div class="col-md-4 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Planned Quantity</p>
                    <p class="text-sm font-weight-bold mb-0">{{ number_format($order->planned_qty) }}</p>
                </div>
                <div class="col-md-4 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Produced Quantity</p>
                    <p class="text-sm font-weight-bold mb-0">{{ number_format($order->produced_qty) }}</p>
                </div>
                <div class="col-md-4 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Wastage Quantity</p>
                    <p class="text-sm font-weight-bold mb-0">{{ number_format($order->wastage_qty) }}</p>
                </div>
                <div class="col-md-4 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Start Date</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $order->start_date->format('M d, Y') }}</p>
                </div>
                <div class="col-md-4 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Due Date</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $order->due_date->format('M d, Y') }}</p>
                </div>
                <div class="col-md-4 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Completed Date</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $order->completed_date?->format('M d, Y') ?? 'Not completed' }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Created By</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $order->creator->name ?? '—' }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Created At</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $order->created_at->format('M d, Y H:i') }}</p>
                </div>
                <div class="col-12">
                    <p class="text-xs text-uppercase text-secondary mb-1">Remarks</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $order->remarks ?: 'No remarks' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection