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
        .so-page .so-badge-ok { background: #d4f1df; color: #146c3c; }
        .so-page .so-badge-warn { background: #fff3d9; color: #966500; }
        .so-page .so-badge-info { background: #e3f0ff; color: #1f5fa8; }
        .so-page .so-stat { min-height: 112px; padding: 18px 20px; }
        .so-page .so-stat-icon { align-items: center; background: var(--so-purple-soft); border-radius: 11px; color: var(--so-purple); display: flex; height: 38px; justify-content: center; width: 38px; }
        .so-page .so-label { color: var(--so-muted); font-size: 11px; font-weight: 600; letter-spacing: .04em; text-transform: uppercase; }
        .so-page .so-value { font-size: 22px; font-weight: 700; }

        /* list */
        .so-page .so-card.so-list { overflow: hidden; padding: 0; }
        .so-page .so-card-header { align-items: center; border-bottom: 1px solid #eeeaf3; display: flex; justify-content: space-between; padding: 20px 24px; }
        .so-page .so-table-wrap { overflow-x: auto; }
        .so-page .so-table { min-width: 900px; }
        .so-page .so-table thead th { background: #fbfaff; border-bottom: 1px solid #eeeaf3; color: var(--so-muted); font-size: 10px; font-weight: 700; letter-spacing: .08em; padding: 14px 20px; text-transform: uppercase; white-space: nowrap; }
        .so-page .so-table tbody td { border-bottom: 1px solid #f0edf4; color: #4f4a5d; font-size: 13px; padding: 16px 20px; vertical-align: middle; }
        .so-page .so-table tbody tr:last-child td { border-bottom: 0; }
        .so-page .so-table tbody tr:hover { background: #fcfaff; }
        .so-page .so-name { color: var(--so-ink); font-weight: 700; }
        .so-page .so-sub { color: var(--so-muted); font-size: 11px; }
        .so-page .so-action { align-items: center; background: transparent; border: 1px solid #e5e0eb; border-radius: 8px; color: #5e566d; display: inline-flex; height: 31px; justify-content: center; padding: 0 9px; }
        .so-page .so-action:hover { background: var(--so-purple-soft); color: var(--so-purple); }
        .so-page .so-empty { color: var(--so-muted); padding: 48px 20px !important; }

        /* form */
        .so-page .so-card.so-form { padding: 28px; }
        .so-page .form-label { color: #393349; font-size: 12px; font-weight: 700; margin-bottom: 8px; }
        .so-page .form-control, .so-page .form-select { border: 1px solid #e2dee9; border-radius: 9px; color: #3d384b; min-height: 45px; }
        .so-page .form-control:focus, .so-page .form-select:focus { border-color: var(--so-purple); box-shadow: 0 0 0 .2rem rgba(112, 65, 165, .12); }
        .so-page .field-hint { color: var(--so-muted); font-size: 11px; margin-top: 7px; }
        .so-page .so-side-card { padding: 22px; }
        .so-page .so-total-box { background: var(--so-purple-soft); border-radius: 12px; padding: 14px 18px; }
        .so-page .so-total-box .so-total-value { color: var(--so-purple); font-size: 22px; font-weight: 700; }

        /* show */
        .so-page .so-card.so-view { padding: 28px; }
        .so-page .so-field { border-bottom: 1px solid #f0edf4; padding: 0 0 18px; }
        .so-page .so-field-label { color: var(--so-muted); font-size: 10px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; }
        .so-page .so-field-value { color: var(--so-ink); font-size: 15px; font-weight: 700; }
        .so-page .so-amount-row { align-items: center; display: flex; justify-content: space-between; padding: 9px 0; font-size: 13px; color: #4f4a5d; }
        .so-page .so-amount-row.total { border-top: 1px solid #eeeaf3; color: var(--so-ink); font-size: 16px; font-weight: 700; margin-top: 6px; padding-top: 14px; }
        .so-page .so-side-icon { align-items: center; background: #fff3d9; border-radius: 10px; color: #966500; display: flex; height: 36px; justify-content: center; width: 36px; }

        @media (max-width: 767.98px) {
            .so-page .so-card-header { align-items: flex-start; flex-direction: column; gap: 14px; }
            .so-page .so-topbar, .so-page .so-card.so-form, .so-page .so-card.so-view { padding: 20px; }
        }
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

        @php
            $variantName = $item->productVariant->sku ?? $item->productVariant->name ?? '#'.$item->product_variant_id;
            $gross       = $item->quantity * $item->unit_price;
            $discountAmt = $gross - $item->line_total;
            $remaining   = max($item->quantity - $item->shipped_qty, 0);
        @endphp

        <div class="so-topbar mb-4">
            <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                <div>
                    <div class="so-eyebrow mb-2">Sales / {{ $salesOrder->order_no }} / Item details</div>
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <h1 class="mb-0">{{ $variantName }}</h1>
                        @if ($item->shipped_qty >= $item->quantity)
                            <span class="so-badge so-badge-ok">Fully shipped</span>
                        @elseif ($item->shipped_qty > 0)
                            <span class="so-badge so-badge-warn">Partially shipped</span>
                        @else
                            <span class="so-badge so-badge-info">Not shipped</span>
                        @endif
                    </div>
                    <p class="so-meta mb-0 mt-2">Review quantity, shipment progress and pricing of this order line.</p>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('sales_orders.items.index', $salesOrder) }}" class="btn btn-outline-dark mb-0"><span class="material-symbols-rounded align-middle me-1" style="font-size: 17px;">arrow_back</span>Back to items</a>
                    <a href="{{ route('sales_orders.items.edit', [$salesOrder, $item]) }}" class="btn so-primary mb-0"><span class="material-symbols-rounded align-middle me-1" style="font-size: 17px;">edit</span>Edit item</a>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-xl-8">
                <div class="so-card so-view">
                    <div class="so-section-title mb-4"><div class="so-section-icon"><span class="material-symbols-rounded">description</span></div><div><h5 class="mb-1">Item overview</h5><p class="so-meta mb-0">The current details of this order line.</p></div></div>
                    <div class="row g-4">
                        <div class="col-md-6"><div class="so-field"><div class="so-field-label mb-2">Sales order</div><div class="so-field-value"><a href="{{ route('sales_orders.show', $salesOrder) }}" class="so-name">{{ $salesOrder->order_no }}</a></div></div></div>
                        <div class="col-md-6"><div class="so-field"><div class="so-field-label mb-2">Product variant</div><div class="so-field-value">{{ $variantName }}</div><div class="so-meta mt-1">Variant #{{ $item->product_variant_id }}</div></div></div>
                        <div class="col-md-6"><div class="so-field"><div class="so-field-label mb-2">Ordered quantity</div><div class="so-field-value">{{ number_format($item->quantity) }}</div></div></div>
                        <div class="col-md-6"><div class="so-field"><div class="so-field-label mb-2">Reserved quantity</div><div class="so-field-value">{{ number_format($item->reserved_qty) }}</div><div class="so-meta mt-1">Currently reserved from stock</div></div></div>
                        <div class="col-md-6"><div class="so-field"><div class="so-field-label mb-2">Shipped quantity</div><div class="so-field-value">{{ number_format($item->shipped_qty) }}</div><div class="so-meta mt-1">Cumulative shipped</div></div></div>
                        <div class="col-md-6"><div class="so-field"><div class="so-field-label mb-2">Remaining to ship</div><div class="so-field-value">{{ number_format($remaining) }}</div></div></div>
                    </div>
                    <div class="border-top mt-4 pt-4"><a href="{{ route('sales_orders.items.edit', [$salesOrder, $item]) }}" class="btn so-primary mb-0"><span class="material-symbols-rounded align-middle me-1" style="font-size: 17px;">edit</span>Update item</a></div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="so-side-card mb-4">
                    <h5 class="mb-3">Amount summary</h5>
                    <div class="so-amount-row"><span>Unit price</span><span>{{ number_format((float) $item->unit_price, 2) }}</span></div>
                    <div class="so-amount-row"><span>Quantity</span><span>× {{ number_format($item->quantity) }}</span></div>
                    <div class="so-amount-row"><span>Gross amount</span><span>{{ number_format((float) $gross, 2) }}</span></div>
                    <div class="so-amount-row"><span>Discount ({{ rtrim(rtrim(number_format((float) $item->discount_percent, 2), '0'), '.') }}%)</span><span>− {{ number_format((float) $discountAmt, 2) }}</span></div>
                    <div class="so-amount-row total"><span>Line total</span><span>{{ number_format((float) $item->line_total, 2) }}</span></div>
                </div>
                <div class="so-side-card">
                    <div class="d-flex gap-3 align-items-start"><div class="so-side-icon"><span class="material-symbols-rounded">history</span></div><div><h5 class="mb-2">Record history</h5><div class="so-meta">Created {{ $item->created_at?->format('M d, Y · h:i A') }}</div><div class="so-meta mt-1">Updated {{ $item->updated_at?->format('M d, Y · h:i A') }}</div></div></div>
                </div>
            </div>
        </div>
    </div>
@endsection