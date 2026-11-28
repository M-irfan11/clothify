@extends('layout.master')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">{{ $purchaseOrder->po_no }}</h4>
            <p class="text-sm text-secondary mb-0">Purchase order details.</p>
        </div>
        <div>
            <a href="{{ route('purchase_orders.edit', $purchaseOrder) }}" class="btn bg-gradient-dark mb-0 me-1">Edit</a>
            <a href="{{ route('purchase_orders.index') }}" class="btn btn-outline-dark mb-0">Back to Purchase Orders</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success text-white" role="alert">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header bg-white border-0 px-4 pt-4 pb-0 d-flex align-items-center justify-content-between">
            <h6 class="mb-0">Order Information</h6>
            <div>
                <span class="badge badge-sm {{ $purchaseOrder->status_badge }}">{{ $purchaseOrder->status_label }}</span>
                <span class="badge badge-sm {{ $purchaseOrder->payment_badge }}">{{ $purchaseOrder->payment_status_label }}</span>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <p class="text-xs text-secondary text-uppercase mb-1">Supplier</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $purchaseOrder->supplier->company_name ?? '—' }}</p>
                    <p class="text-xs text-secondary mb-0">{{ $purchaseOrder->supplier->supplier_code ?? '' }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p class="text-xs text-secondary text-uppercase mb-1">Receiving Warehouse</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $purchaseOrder->warehouse->name ?? '—' }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <p class="text-xs text-secondary text-uppercase mb-1">SO No</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $purchaseOrder->so_no }}</p>
                </div>

                <div class="col-md-4 mb-3">
                    <p class="text-xs text-secondary text-uppercase mb-1">Order Date</p>
                    <p class="text-sm mb-0">{{ $purchaseOrder->order_date->format('d M Y') }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <p class="text-xs text-secondary text-uppercase mb-1">Expected Date</p>
                    <p class="text-sm mb-0">{{ $purchaseOrder->expected_date->format('d M Y') }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <p class="text-xs text-secondary text-uppercase mb-1">Received Date</p>
                    <p class="text-sm mb-0">{{ $purchaseOrder->received_date?->format('d M Y') ?? '—' }}</p>
                </div>

                <div class="col-md-3 mb-3">
                    <p class="text-xs text-secondary text-uppercase mb-1">Subtotal</p>
                    <p class="text-sm mb-0">{{ number_format($purchaseOrder->subtotal, 2) }}</p>
                </div>
                <div class="col-md-3 mb-3">
                    <p class="text-xs text-secondary text-uppercase mb-1">Tax</p>
                    <p class="text-sm mb-0">{{ number_format($purchaseOrder->tax_amount, 2) }}</p>
                </div>
                <div class="col-md-3 mb-3">
                    <p class="text-xs text-secondary text-uppercase mb-1">Total</p>
                    <p class="text-sm font-weight-bold mb-0">{{ number_format($purchaseOrder->total_amount, 2) }}</p>
                </div>
                <div class="col-md-3 mb-3">
                    <p class="text-xs text-secondary text-uppercase mb-1">Paid</p>
                    <p class="text-sm mb-0">{{ number_format($purchaseOrder->paid_amount, 2) }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <p class="text-xs text-secondary text-uppercase mb-1">Created By</p>
                    <p class="text-sm mb-0">{{ $purchaseOrder->creator->name ?? '—' }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p class="text-xs text-secondary text-uppercase mb-1">Approved By</p>
                    <p class="text-sm mb-0">{{ $purchaseOrder->approver->name ?? '—' }}</p>
                </div>

                <div class="col-12">
                    <p class="text-xs text-secondary text-uppercase mb-1">Remarks</p>
                    <p class="text-sm mb-0">{{ $purchaseOrder->remarks ?? '—' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
