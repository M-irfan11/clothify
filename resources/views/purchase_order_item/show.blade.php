@extends('layout.master')

@section('content')
<div class="container-fluid py-4">
    @if (session('success'))
        <div class="alert alert-success text-white" role="alert">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">{{ $purchaseOrderItem->material->material_name ?? 'PO Item' }}</h4>
            <p class="text-sm text-secondary mb-0">Purchase order item details</p>
        </div>
        <div>
            <a href="{{ route('purchase_order_items.index') }}" class="btn btn-outline-dark mb-0">Back</a>
            <a href="{{ route('purchase_order_items.edit', $purchaseOrderItem) }}" class="btn btn-action-edit mb-0">Edit PO Item</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Purchase Order</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $purchaseOrderItem->purchaseOrder->po_no ?? '#'.$purchaseOrderItem->purchase_order_id }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Material</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $purchaseOrderItem->material->material_name ?? '—' }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Ordered Qty</p>
                    <p class="text-sm font-weight-bold mb-0">{{ number_format($purchaseOrderItem->ordered_qty, 3) }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Received Qty</p>
                    <p class="text-sm font-weight-bold mb-0">{{ number_format($purchaseOrderItem->received_qty, 3) }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Accepted Qty (QC Passed)</p>
                    <span class="badge badge-sm bg-gradient-success">{{ number_format($purchaseOrderItem->accepted_qty, 3) }}</span>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Rejected Qty (QC Failed)</p>
                    <span class="badge badge-sm {{ $purchaseOrderItem->rejected_qty > 0 ? 'bg-gradient-danger' : 'bg-gradient-secondary' }}">{{ number_format($purchaseOrderItem->rejected_qty, 3) }}</span>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Pending Qty</p>
                    <p class="text-sm font-weight-bold mb-0">{{ number_format(max($purchaseOrderItem->ordered_qty - $purchaseOrderItem->received_qty, 0), 3) }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Unit Price</p>
                    <p class="text-sm font-weight-bold mb-0">{{ number_format($purchaseOrderItem->unit_price, 2) }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Line Total</p>
                    <p class="text-sm font-weight-bold mb-0">{{ number_format($purchaseOrderItem->line_total, 2) }}</p>
                </div>
                <div class="col-md-6">
                    <p class="text-xs text-uppercase text-secondary mb-1">Created At</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $purchaseOrderItem->created_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection