@extends('layout.master')

@section('head')
    <style>
        .so-form-page { --so-purple: #7041a5; --so-purple-soft: #f0e9f8; --so-ink: #242136; --so-muted: #747187; background: #f8f7fb; min-height: calc(100vh - 1rem); }
        .so-form-page .so-topbar, .so-form-page .so-card, .so-form-page .so-stat, .so-form-page .so-side-card { background: #fff; border: 1px solid #e9e6ef; border-radius: 16px; box-shadow: 0 8px 24px rgba(42, 29, 65, .04); }
        .so-form-page .so-topbar { padding: 24px 28px; }
        .so-form-page .so-eyebrow { color: var(--so-purple); font-size: 11px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; }
        .so-form-page h1, .so-form-page h5, .so-form-page .so-value { color: var(--so-ink); }
        .so-form-page h1 { font-size: clamp(1.35rem, 2.5vw, 1.85rem); font-weight: 700; letter-spacing: -.03em; }
        .so-form-page .so-meta { color: var(--so-muted); font-size: 13px; }
        .so-form-page .so-primary { box-shadow: 0 5px 12px rgba(112, 65, 165, .2); }
        .so-form-page .so-section-title { align-items: center; display: flex; gap: 12px; }
        .so-form-page .so-section-icon { align-items: center; background: var(--so-purple-soft); border-radius: 10px; color: var(--so-purple); display: flex; font-size: 13px; font-weight: 700; height: 34px; justify-content: center; width: 34px; }
        .so-form-page .so-badge { border-radius: 999px; display: inline-block; font-size: 11px; font-weight: 700; padding: 5px 10px; white-space: nowrap; }
        .so-form-page .so-status-pending { background: #fff3d9; color: #966500; }
        .so-form-page .so-status-confirmed { background: #e3f0ff; color: #1f5fa8; }
        .so-form-page .so-status-packed { background: #f0e9f8; color: #7041a5; }
        .so-form-page .so-status-partially_shipped { background: #e0f5f5; color: #157a7a; }
        .so-form-page .so-status-shipped { background: #dff3ea; color: #1b7a4b; }
        .so-form-page .so-status-delivered { background: #d4f1df; color: #146c3c; }
        .so-form-page .so-status-cancelled { background: #fde4e4; color: #b42318; }
        .so-form-page .so-pay-unpaid { background: #fde4e4; color: #b42318; }
        .so-form-page .so-pay-partial { background: #fff3d9; color: #966500; }
        .so-form-page .so-pay-paid { background: #d4f1df; color: #146c3c; }
        .so-form-page .so-card { padding: 28px; }
        .so-form-page .form-label { color: #393349; font-size: 12px; font-weight: 700; margin-bottom: 8px; }
        .so-form-page .form-control, .so-form-page .form-select { border: 1px solid #e2dee9; border-radius: 9px; color: #3d384b; min-height: 45px; }
        .so-form-page textarea.form-control { min-height: 90px; }
        .so-form-page .form-control:focus, .so-form-page .form-select:focus { border-color: var(--so-purple); box-shadow: 0 0 0 .2rem rgba(112, 65, 165, .12); }
        .so-form-page .field-hint { color: var(--so-muted); font-size: 11px; margin-top: 7px; }
        .so-form-page .so-side-card { padding: 22px; }
        .so-form-page .so-total-box { background: var(--so-purple-soft); border-radius: 12px; padding: 14px 18px; }
        .so-form-page .so-total-box .so-total-value { color: var(--so-purple); font-size: 22px; font-weight: 700; }
        @media (max-width: 767.98px) { .so-form-page .so-topbar, .so-form-page .so-card { padding: 20px; } }
    </style>
@endsection

@section('content')
    <div class="so-form-page container-fluid px-3 px-lg-4 py-4">
        @if (session('success'))
            <div class="alert alert-success text-white" role="alert">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger text-white" role="alert">{{ session('error') }}</div>
        @endif
        <div class="so-topbar mb-4">
            <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                <div><div class="so-eyebrow mb-2">Sales / Edit order</div><h1 class="mb-2">Edit {{ $order->order_no }}</h1><p class="so-meta mb-0">Update the order details, pricing and payment information.</p></div>
                <a href="{{ route('sales_orders.show', $order) }}" class="btn btn-outline-dark mb-0"><span class="material-symbols-rounded align-middle me-1" style="font-size: 17px;">visibility</span>View order</a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-xl-8">
                <div class="so-card">
                    <form action="{{ route('sales_orders.update', $order) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="so-section-title mb-4"><span class="so-section-icon">01</span><div><h5 class="mb-1">Order information</h5><p class="so-meta mb-0">Who is buying and where the goods ship from.</p></div></div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="customer_id" class="form-label">Customer <span class="text-danger">*</span></label>
                                <select id="customer_id" name="customer_id" class="form-select @error('customer_id') is-invalid @enderror" required>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}" @selected((int) old('customer_id', $order->customer_id) === (int) $customer->id)>{{ $customer->name ?? $customer->company_name ?? '#'.$customer->id }}</option>
                                    @endforeach
                                </select>
                                @error('customer_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="warehouse_id" class="form-label">Warehouse <span class="text-danger">*</span></label>
                                <select id="warehouse_id" name="warehouse_id" class="form-select @error('warehouse_id') is-invalid @enderror" required>
                                    @foreach ($warehouses as $warehouse)
                                        <option value="{{ $warehouse->id }}" @selected((int) old('warehouse_id', $order->warehouse_id) === (int) $warehouse->id)>{{ $warehouse->name ?? '#'.$warehouse->id }}</option>
                                    @endforeach
                                </select>
                                <div class="field-hint">Finished goods will be sourced from this warehouse.</div>
                                @error('warehouse_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="buyer_po_no" class="form-label">Buyer PO number</label>
                                <input id="buyer_po_no" name="buyer_po_no" type="text" value="{{ old('buyer_po_no', $order->buyer_po_no) }}" class="form-control @error('buyer_po_no') is-invalid @enderror" placeholder="e.g. PO-2026-0145">
                                <div class="field-hint">The purchase order number sent by the buyer (optional).</div>
                                @error('buyer_po_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="order_date" class="form-label">Order date <span class="text-danger">*</span></label>
                                <input id="order_date" name="order_date" type="date" value="{{ old('order_date', $order->order_date?->format('Y-m-d')) }}" class="form-control @error('order_date') is-invalid @enderror" placeholder="" required>
                                
                                @error('order_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="required_date" class="form-label">Required date <span class="text-danger">*</span></label>
                                <input id="required_date" name="required_date" type="date" value="{{ old('required_date', $order->required_date?->format('Y-m-d')) }}" class="form-control @error('required_date') is-invalid @enderror" placeholder="" required>
                                <div class="field-hint">The date the buyer needs the goods delivered.</div>
                                @error('required_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="border-top mt-4 pt-4"></div>
                        <div class="so-section-title mb-4"><span class="so-section-icon">02</span><div><h5 class="mb-1">Pricing</h5><p class="so-meta mb-0">Subtotal, discount and shipping cost.</p></div></div>
                        <div class="row g-4">
                            <div class="col-md-4">
                                <label for="subtotal" class="form-label">Subtotal <span class="text-danger">*</span></label>
                                <input id="subtotal" name="subtotal" type="number" min="0" step="0.01" value="{{ old('subtotal', $order->subtotal) }}" class="form-control calc @error('subtotal') is-invalid @enderror" placeholder="0.00" required>
                                <div class="field-hint">Total before discount and shipping.</div>
                                @error('subtotal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="discount_amount" class="form-label">Discount</label>
                                <input id="discount_amount" name="discount_amount" type="number" min="0" step="0.01" value="{{ old('discount_amount', $order->discount_amount) }}" class="form-control calc @error('discount_amount') is-invalid @enderror" placeholder="0.00">
                                <div class="field-hint">Amount deducted from the subtotal.</div>
                                @error('discount_amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="shipping_cost" class="form-label">Shipping cost</label>
                                <input id="shipping_cost" name="shipping_cost" type="number" min="0" step="0.01" value="{{ old('shipping_cost', $order->shipping_cost) }}" class="form-control calc @error('shipping_cost') is-invalid @enderror" placeholder="0.00">
                                <div class="field-hint">Delivery charge added to the total.</div>
                                @error('shipping_cost') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12"><div class="so-total-box d-flex align-items-center justify-content-between"><span class="so-meta">Total amount (auto-calculated)</span><span class="so-total-value" id="total_preview">0.00</span></div></div>
                        </div>

                        <div class="border-top mt-4 pt-4"></div>
                        <div class="so-section-title mb-4"><span class="so-section-icon">03</span><div><h5 class="mb-1">Payment &amp; status</h5><p class="so-meta mb-0">Current payment and order progress.</p></div></div>
                        <div class="row g-4">
                            <div class="col-md-4">
                                <label for="paid_amount" class="form-label">Paid amount</label>
                                <input id="paid_amount" name="paid_amount" type="number" min="0" step="0.01" value="{{ old('paid_amount', $order->paid_amount) }}" class="form-control @error('paid_amount') is-invalid @enderror" placeholder="0.00">
                                <div class="field-hint">Amount received from the buyer so far.</div>
                                @error('paid_amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="payment_status" class="form-label">Payment status <span class="text-danger">*</span></label>
                                <select id="payment_status" name="payment_status" class="form-select @error('payment_status') is-invalid @enderror" required>
                                    @foreach (\App\Models\SalesOrder::PAYMENT_STATUSES as $p)
                                        <option value="{{ $p }}" @selected(old('payment_status', $order->payment_status) === $p)>{{ ucfirst($p) }}</option>
                                    @endforeach
                                </select>
                                @error('payment_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="status" class="form-label">Order status <span class="text-danger">*</span></label>
                                <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    @foreach (\App\Models\SalesOrder::STATUSES as $s)
                                        <option value="{{ $s }}" @selected(old('status', $order->status) === $s)>{{ ucfirst(str_replace('_', ' ', $s)) }}</option>
                                    @endforeach
                                </select>
                                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="border-top mt-4 pt-4"></div>
                        <div class="so-section-title mb-4"><span class="so-section-icon">04</span><div><h5 class="mb-1">Delivery</h5><p class="so-meta mb-0">Shipping address and internal notes.</p></div></div>
                        <div class="row g-4">
                            <div class="col-12">
                                <label for="shipping_address" class="form-label">Shipping address <span class="text-danger">*</span></label>
                                <input id="shipping_address" name="shipping_address" type="text" maxlength="255" value="{{ old('shipping_address', $order->shipping_address) }}" class="form-control @error('shipping_address') is-invalid @enderror" placeholder="Full delivery address" required>
                                @error('shipping_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12">
                                <label for="remarks" class="form-label">Remarks</label>
                                <textarea id="remarks" name="remarks" maxlength="255" rows="3" class="form-control @error('remarks') is-invalid @enderror" placeholder="Optional notes about this order">{{ old('remarks', $order->remarks) }}</textarea>
                                @error('remarks') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="border-top mt-4 pt-4 d-flex flex-wrap gap-2"><button type="submit" class="btn so-primary mb-0"><span class="material-symbols-rounded align-middle me-1" style="font-size: 17px;">save</span>Save changes</button><a href="{{ route('sales_orders.index') }}" class="btn btn-outline-secondary mb-0">Cancel</a></div>
                    </form>
                </div>
            </div>
            <div class="col-xl-4"><div class="so-side-card"><div class="d-flex gap-3 align-items-start"><div class="so-section-icon"><span class="material-symbols-rounded">info</span></div><div><h5 class="mb-2">Editing this order</h5><p class="so-meta mb-0">Total amount is recalculated automatically from subtotal, discount and shipping cost when you save.</p></div></div></div></div>
        </div>
    </div>

    <script>
        (function () {
            var fields = document.querySelectorAll('.calc');
            var preview = document.getElementById('total_preview');
            function num(id) { return parseFloat(document.getElementById(id).value) || 0; }
            function update() {
                var total = num('subtotal') - num('discount_amount') + num('shipping_cost');
                preview.textContent = total.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            }
            fields.forEach(function (el) { el.addEventListener('input', update); });
            update();
        })();
    </script>
@endsection
