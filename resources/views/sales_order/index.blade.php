@extends('layout.master')

@section('head')
    <style>
        .so-page { --so-purple: #7041a5; --so-purple-soft: #f0e9f8; --so-ink: #242136; --so-muted: #747187; background: #f8f7fb; min-height: calc(100vh - 1rem); }
        .so-page .so-topbar, .so-page .so-card, .so-page .so-stat, .so-page .so-side-card { background: #fff; border: 1px solid #e9e6ef; border-radius: 16px; box-shadow: 0 8px 24px rgba(42, 29, 65, .04); }
        .so-page .so-topbar { padding: 24px 28px; }
        .so-page .so-eyebrow { color: var(--so-purple); font-size: 11px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; }
        .so-page h1, .so-page h5, .so-page .so-value { color: var(--so-ink); }
        .so-page h1 { font-size: clamp(1.35rem, 2.5vw, 1.85rem); font-weight: 700; letter-spacing: -.03em; }
        .so-page .so-meta { color: var(--so-muted); font-size: 13px; }
        .so-page .so-primary { box-shadow: 0 5px 12px rgba(112, 65, 165, .2); }
        .so-page .so-section-title { align-items: center; display: flex; gap: 12px; }
        .so-page .so-section-icon { align-items: center; background: var(--so-purple-soft); border-radius: 10px; color: var(--so-purple); display: flex; font-size: 13px; font-weight: 700; height: 34px; justify-content: center; width: 34px; }
        .so-page .so-badge { border-radius: 999px; display: inline-block; font-size: 11px; font-weight: 700; padding: 5px 10px; white-space: nowrap; }
        .so-page .so-status-pending { background: #fff3d9; color: #966500; }
        .so-page .so-status-confirmed { background: #e3f0ff; color: #1f5fa8; }
        .so-page .so-status-packed { background: #f0e9f8; color: #7041a5; }
        .so-page .so-status-partially_shipped { background: #e0f5f5; color: #157a7a; }
        .so-page .so-status-shipped { background: #dff3ea; color: #1b7a4b; }
        .so-page .so-status-delivered { background: #d4f1df; color: #146c3c; }
        .so-page .so-status-cancelled { background: #fde4e4; color: #b42318; }
        .so-page .so-pay-unpaid { background: #fde4e4; color: #b42318; }
        .so-page .so-pay-partial { background: #fff3d9; color: #966500; }
        .so-page .so-pay-paid { background: #d4f1df; color: #146c3c; }
        .so-page .so-stat { min-height: 112px; padding: 18px 20px; }
        .so-page .so-stat-icon { align-items: center; background: var(--so-purple-soft); border-radius: 11px; color: var(--so-purple); display: flex; height: 38px; justify-content: center; width: 38px; }
        .so-page .so-label { color: var(--so-muted); font-size: 11px; font-weight: 600; letter-spacing: .04em; text-transform: uppercase; }
        .so-page .so-value { font-size: 22px; font-weight: 700; }
        .so-page .so-card { overflow: hidden; }
        .so-page .so-card-header { align-items: center; border-bottom: 1px solid #eeeaf3; display: flex; justify-content: space-between; padding: 20px 24px; }
        .so-page .so-table-wrap { overflow-x: auto; }
        .so-page .so-table { min-width: 980px; }
        .so-page .so-table thead th { background: #fbfaff; border-bottom: 1px solid #eeeaf3; color: var(--so-muted); font-size: 10px; font-weight: 700; letter-spacing: .08em; padding: 14px 20px; text-transform: uppercase; white-space: nowrap; }
        .so-page .so-table tbody td { border-bottom: 1px solid #f0edf4; color: #4f4a5d; font-size: 13px; padding: 16px 20px; vertical-align: middle; }
        .so-page .so-table tbody tr:last-child td { border-bottom: 0; }
        .so-page .so-table tbody tr:hover { background: #fcfaff; }
        .so-page .so-name { color: var(--so-ink); font-weight: 700; }
        .so-page .so-sub { color: var(--so-muted); font-size: 11px; }
        .so-page .so-action { align-items: center; background: transparent; border: 1px solid #e5e0eb; border-radius: 8px; color: #5e566d; display: inline-flex; height: 31px; justify-content: center; padding: 0 9px; }
        .so-page .so-action:hover { background: var(--so-purple-soft); color: var(--so-purple); }
        .so-page .so-empty { color: var(--so-muted); padding: 48px 20px !important; }
        @media (max-width: 767.98px) { .so-page .so-card-header { align-items: flex-start; flex-direction: column; gap: 14px; } }
        @media (max-width: 767.98px) { .so-page .so-topbar, .so-page .so-card { padding: 20px; } }
    </style>
@endsection

@section('content')
    <div class="so-page container-fluid px-3 px-lg-4 py-4">
        @if (session('success'))
            <div class="alert alert-success text-white" role="alert">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger text-white" role="alert">{{ session('error') }}</div>
        @endif

        <div class="so-topbar mb-4">
            <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                <div>
                    <div class="so-eyebrow mb-2">Sales</div>
                    <h1 class="mb-0">Buyer Sales Orders</h1>
                    <p class="so-meta mb-0 mt-2">Track buyer orders, shipment progress and payment status in one place.</p>
                </div>
                <a href="{{ route('sales_orders.create') }}" class="btn so-primary mb-0 px-3"><span class="material-symbols-rounded align-middle me-1" style="font-size: 18px;">add</span>New sales order</a>
            </div>
        </div>

        @php
            $orderCount  = $orders->total();
            $pageTotal   = $orders->getCollection()->sum('total_amount');
            $pagePaid    = $orders->getCollection()->sum('paid_amount');
            $pageDue     = $pageTotal - $pagePaid;
        @endphp

        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-xl-3"><div class="so-stat d-flex align-items-center gap-3"><div class="so-stat-icon"><span class="material-symbols-rounded">receipt_long</span></div><div><div class="so-label">Total orders</div><div class="so-value">{{ number_format($orderCount) }}</div></div></div></div>
            <div class="col-sm-6 col-xl-3"><div class="so-stat d-flex align-items-center gap-3"><div class="so-stat-icon"><span class="material-symbols-rounded">payments</span></div><div><div class="so-label">Order value (page)</div><div class="so-value">{{ number_format((float) $pageTotal, 2) }}</div></div></div></div>
            <div class="col-sm-6 col-xl-3"><div class="so-stat d-flex align-items-center gap-3"><div class="so-stat-icon"><span class="material-symbols-rounded">account_balance_wallet</span></div><div><div class="so-label">Paid (page)</div><div class="so-value">{{ number_format((float) $pagePaid, 2) }}</div></div></div></div>
            <div class="col-sm-6 col-xl-3"><div class="so-stat d-flex align-items-center gap-3"><div class="so-stat-icon"><span class="material-symbols-rounded">pending_actions</span></div><div><div class="so-label">Due (page)</div><div class="so-value">{{ number_format((float) $pageDue, 2) }}</div></div></div></div>
        </div>

        <div class="so-card">
            <div class="so-card-header"><div><h5 class="mb-1">Order list</h5><p class="so-meta mb-0">{{ $orders->total() }} records found</p></div><div class="so-meta">Page {{ $orders->currentPage() }} of {{ $orders->lastPage() }}</div></div>
            <div class="so-table-wrap">
                <table class="table so-table align-items-center mb-0">
                    <thead><tr><th>Order</th><th>Customer</th><th>Dates</th><th>Total</th><th>Paid / Due</th><th>Payment</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td><a class="so-name d-block" href="{{ route('sales_orders.show', $order) }}">{{ $order->order_no }}</a><span class="so-sub">PO: {{ $order->buyer_po_no ?? '—' }}</span></td>
                                <td><span class="so-name d-block">{{ $order->customer->name ?? $order->customer->company_name ?? '#'.$order->customer_id }}</span><span class="so-sub">{{ $order->warehouse->name ?? 'Warehouse #'.$order->warehouse_id }}</span></td>
                                <td>{{ $order->order_date?->format('d M Y') }}<span class="so-sub d-block">Required {{ $order->required_date?->format('d M Y') }}</span></td>
                                <td class="font-weight-bold">{{ number_format((float) $order->total_amount, 2) }}</td>
                                <td>{{ number_format((float) $order->paid_amount, 2) }}<span class="so-sub d-block">Due {{ number_format((float) ($order->total_amount - $order->paid_amount), 2) }}</span></td>
                                <td><span class="so-badge so-pay-{{ $order->payment_status }}">{{ ucfirst($order->payment_status) }}</span></td>
                                <td><span class="so-badge so-status-{{ $order->status }}">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span></td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('sales_orders.show', $order) }}" class="so-action me-1" title="View" aria-label="View order"><span class="material-symbols-rounded" style="font-size: 17px;">visibility</span></a>
                                    <a href="{{ route('sales_orders.edit', $order) }}" class="so-action me-1" title="Edit" aria-label="Edit order"><span class="material-symbols-rounded" style="font-size: 17px;">edit</span></a>
                                    <form action="{{ route('sales_orders.destroy', $order) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button type="submit" class="so-action" title="Delete" aria-label="Delete order" onclick="return confirm('Delete this sales order?')"><span class="material-symbols-rounded" style="font-size: 17px;">delete</span></button></form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="so-empty text-center">No sales orders found. Create your first sales order to get started.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($orders->hasPages())<div class="border-top px-4 py-3">{{ $orders->links('pagination::bootstrap-5') }}</div>@endif
        </div>
    </div>
@endsection
