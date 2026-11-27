@extends('layout.master')

@section('head')
    <style>
        .so-view-page { --so-purple: #7041a5; --so-purple-soft: #f0e9f8; --so-ink: #242136; --so-muted: #747187; background: #f8f7fb; min-height: calc(100vh - 1rem); }
        .so-view-page .so-topbar, .so-view-page .so-card, .so-view-page .so-stat, .so-view-page .so-side-card { background: #fff; border: 1px solid #e9e6ef; border-radius: 16px; box-shadow: 0 8px 24px rgba(42, 29, 65, .04); }
        .so-view-page .so-topbar { padding: 24px 28px; }
        .so-view-page .so-eyebrow { color: var(--so-purple); font-size: 11px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; }
        .so-view-page h1, .so-view-page h5, .so-view-page .so-value { color: var(--so-ink); }
        .so-view-page h1 { font-size: clamp(1.35rem, 2.5vw, 1.85rem); font-weight: 700; letter-spacing: -.03em; }
        .so-view-page .so-meta { color: var(--so-muted); font-size: 13px; }
        .so-view-page .so-primary { box-shadow: 0 5px 12px rgba(112, 65, 165, .2); }
        .so-view-page .so-section-title { align-items: center; display: flex; gap: 12px; }
        .so-view-page .so-section-icon { align-items: center; background: var(--so-purple-soft); border-radius: 10px; color: var(--so-purple); display: flex; font-size: 13px; font-weight: 700; height: 34px; justify-content: center; width: 34px; }
        .so-view-page .so-badge { border-radius: 999px; display: inline-block; font-size: 11px; font-weight: 700; padding: 5px 10px; white-space: nowrap; }
        .so-view-page .so-status-pending { background: #fff3d9; color: #966500; }
        .so-view-page .so-status-confirmed { background: #e3f0ff; color: #1f5fa8; }
        .so-view-page .so-status-packed { background: #f0e9f8; color: #7041a5; }
        .so-view-page .so-status-partially_shipped { background: #e0f5f5; color: #157a7a; }
        .so-view-page .so-status-shipped { background: #dff3ea; color: #1b7a4b; }
        .so-view-page .so-status-delivered { background: #d4f1df; color: #146c3c; }
        .so-view-page .so-status-cancelled { background: #fde4e4; color: #b42318; }
        .so-view-page .so-pay-unpaid { background: #fde4e4; color: #b42318; }
        .so-view-page .so-pay-partial { background: #fff3d9; color: #966500; }
        .so-view-page .so-pay-paid { background: #d4f1df; color: #146c3c; }
        .so-view-page .so-card { padding: 28px; }
        .so-view-page .so-field { border-bottom: 1px solid #f0edf4; padding: 0 0 18px; }
        .so-view-page .so-field-label { color: var(--so-muted); font-size: 10px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; }
        .so-view-page .so-field-value { color: var(--so-ink); font-size: 15px; font-weight: 700; }
        .so-view-page .so-side-card { padding: 22px; }
        .so-view-page .so-amount-row { align-items: center; display: flex; justify-content: space-between; padding: 9px 0; font-size: 13px; color: #4f4a5d; }
        .so-view-page .so-amount-row.total { border-top: 1px solid #eeeaf3; color: var(--so-ink); font-size: 16px; font-weight: 700; margin-top: 6px; padding-top: 14px; }
        .so-view-page .so-side-icon { align-items: center; background: #fff3d9; border-radius: 10px; color: #966500; display: flex; height: 36px; justify-content: center; width: 36px; }
        @media (max-width: 767.98px) { .so-view-page .so-topbar, .so-view-page .so-card { padding: 20px; } }
    </style>
@endsection

@section('content')
    <div class="so-view-page container-fluid px-3 px-lg-4 py-4">
        @if (session('success'))
            <div class="alert alert-success text-white" role="alert">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger text-white" role="alert">{{ session('error') }}</div>
        @endif

        <div class="so-topbar mb-4">
            <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                <div>
                    <div class="so-eyebrow mb-2">Sales / Order details</div>
                    <div class="d-flex align-items-center flex-wrap gap-2"><h1 class="mb-0">{{ $order->order_no }}</h1><span class="so-badge so-status-{{ $order->status }}">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span><span class="so-badge so-pay-{{ $order->payment_status }}">{{ ucfirst($order->payment_status) }}</span></div>
                    <p class="so-meta mb-0 mt-2">Review the buyer order, pricing and payment progress.</p>
                </div>
                <div class="d-flex flex-wrap gap-2"><a href="{{ route('sales_orders.index') }}" class="btn btn-outline-dark mb-0"><span class="material-symbols-rounded align-middle me-1" style="font-size: 17px;">arrow_back</span>Back to orders</a><a href="{{ route('sales_orders.edit', $order) }}" class="btn so-primary mb-0"><span class="material-symbols-rounded align-middle me-1" style="font-size: 17px;">edit</span>Edit order</a></div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-xl-8">
                <div class="so-card">
                    <div class="so-section-title mb-4"><div class="so-section-icon"><span class="material-symbols-rounded">description</span></div><div><h5 class="mb-1">Order overview</h5><p class="so-meta mb-0">The current details of this sales order.</p></div></div>
                    <div class="row g-4">
                        <div class="col-md-6"><div class="so-field"><div class="so-field-label mb-2">Order number</div><div class="so-field-value">{{ $order->order_no }}</div></div></div>
                        <div class="col-md-6"><div class="so-field"><div class="so-field-label mb-2">Buyer PO number</div><div class="so-field-value">{{ $order->buyer_po_no ?? '—' }}</div></div></div>
                        <div class="col-md-6"><div class="so-field"><div class="so-field-label mb-2">Customer</div><div class="so-field-value">{{ $order->customer->name ?? $order->customer->company_name ?? '#'.$order->customer_id }}</div></div></div>
                        <div class="col-md-6"><div class="so-field"><div class="so-field-label mb-2">Warehouse</div><div class="so-field-value">{{ $order->warehouse->name ?? '#'.$order->warehouse_id }}</div><div class="so-meta mt-1">Finished goods source</div></div></div>
                        <div class="col-md-6"><div class="so-field"><div class="so-field-label mb-2">Order date</div><div class="so-field-value">{{ $order->order_date?->format('d M Y') }}</div></div></div>
                        <div class="col-md-6"><div class="so-field"><div class="so-field-label mb-2">Required date</div><div class="so-field-value">{{ $order->required_date?->format('d M Y') }}</div><div class="so-meta mt-1">Requested delivery date</div></div></div>
                        <div class="col-12"><div class="so-field"><div class="so-field-label mb-2">Shipping address</div><div class="so-field-value">{{ $order->shipping_address }}</div></div></div>
                        <div class="col-12"><div class="so-field"><div class="so-field-label mb-2">Remarks</div><div class="so-field-value">{{ $order->remarks ?? '—' }}</div></div></div>
                    </div>
                    <div class="border-top mt-4 pt-4"><a href="{{ route('sales_orders.edit', $order) }}" class="btn so-primary mb-0"><span class="material-symbols-rounded align-middle me-1" style="font-size: 17px;">edit</span>Update order</a></div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="so-side-card mb-4">
                    <h5 class="mb-3">Amount summary</h5>
                    <div class="so-amount-row"><span>Subtotal</span><span>{{ number_format((float) $order->subtotal, 2) }}</span></div>
                    <div class="so-amount-row"><span>Discount</span><span>− {{ number_format((float) $order->discount_amount, 2) }}</span></div>
                    <div class="so-amount-row"><span>Shipping cost</span><span>+ {{ number_format((float) $order->shipping_cost, 2) }}</span></div>
                    <div class="so-amount-row total"><span>Total</span><span>{{ number_format((float) $order->total_amount, 2) }}</span></div>
                    <div class="so-amount-row"><span>Paid</span><span>{{ number_format((float) $order->paid_amount, 2) }}</span></div>
                    <div class="so-amount-row"><span>Balance due</span><span class="so-name">{{ number_format((float) ($order->total_amount - $order->paid_amount), 2) }}</span></div>
                </div>
                <div class="so-side-card">
                    <div class="d-flex gap-3 align-items-start"><div class="so-side-icon"><span class="material-symbols-rounded">history</span></div><div><h5 class="mb-2">Record history</h5><div class="so-meta">Created by {{ $order->creator->name ?? 'User #'.$order->created_by }}</div><div class="so-meta mt-1">Created {{ $order->created_at?->format('M d, Y · h:i A') }}</div><div class="so-meta mt-1">Updated {{ $order->updated_at?->format('M d, Y · h:i A') }}</div></div></div>
                </div>
            </div>
        </div>
    </div>
@endsection
