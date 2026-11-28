@extends('layout.master')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Edit Purchase Order</h4>
            <p class="text-sm text-secondary mb-0">Update details for {{ $purchaseOrder->po_no }}.</p>
        </div>
        <a href="{{ route('purchase_orders.index') }}" class="btn btn-outline-dark mb-0">Back to Purchase Orders</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('purchase_orders.update', $purchaseOrder) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="po_no" class="form-label">PO No</label>
                        <input id="po_no" name="po_no" type="text" maxlength="30" value="{{ old('po_no', $purchaseOrder->po_no) }}" class="form-control @error('po_no') is-invalid @enderror" required>
                        @error('po_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="supplier_id" class="form-label">Supplier</label>
                        <select id="supplier_id" name="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror" required>
                            <option value="">Select supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" @selected((string) old('supplier_id', $purchaseOrder->supplier_id) === (string) $supplier->id)>
                                    {{ $supplier->company_name }} ({{ $supplier->supplier_code }})
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="warehouse_id" class="form-label">Receiving Warehouse</label>
                        <select id="warehouse_id" name="warehouse_name" class="form-select @error('warehouse_id') is-invalid @enderror" required>
                            <option value="">Select warehouse</option>
                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}" @selected((string) old('warehouse_id', $purchaseOrder->warehouse_id) === (string) $warehouse->id)>
                                    {{ $warehouse->warehouse_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('warehouse_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="so_no" class="form-label">SO No</label>
                        <input id="so_no" name="so_no" type="text" maxlength="30" value="{{ old('so_no', $purchaseOrder->so_no) }}" class="form-control @error('so_no') is-invalid @enderror" required>
                        @error('so_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="order_date" class="form-label">Order Date</label>
                        <input id="order_date" name="order_date" type="date" value="{{ old('order_date', $purchaseOrder->order_date->format('Y-m-d')) }}" class="form-control @error('order_date') is-invalid @enderror" required>
                        @error('order_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="expected_date" class="form-label">Expected Date</label>
                        <input id="expected_date" name="expected_date" type="date" value="{{ old('expected_date', $purchaseOrder->expected_date->format('Y-m-d')) }}" class="form-control @error('expected_date') is-invalid @enderror" required>
                        @error('expected_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="received_date" class="form-label">Received Date <span class="text-secondary">(optional)</span></label>
                        <input id="received_date" name="received_date" type="date" value="{{ old('received_date', $purchaseOrder->received_date?->format('Y-m-d')) }}" class="form-control @error('received_date') is-invalid @enderror">
                        @error('received_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="subtotal" class="form-label">Subtotal</label>
                        <input id="subtotal" name="subtotal" type="number" min="0" step="0.01" value="{{ old('subtotal', $purchaseOrder->subtotal) }}" class="form-control @error('subtotal') is-invalid @enderror" required>
                        @error('subtotal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="tax_amount" class="form-label">Tax Amount <span class="text-secondary">(optional)</span></label>
                        <input id="tax_amount" name="tax_amount" type="number" min="0" step="0.01" value="{{ old('tax_amount', $purchaseOrder->tax_amount) }}" class="form-control @error('tax_amount') is-invalid @enderror">
                        @error('tax_amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="paid_amount" class="form-label">Paid Amount <span class="text-secondary">(optional)</span></label>
                        <input id="paid_amount" name="paid_amount" type="number" min="0" step="0.01" value="{{ old('paid_amount', $purchaseOrder->paid_amount) }}" class="form-control @error('paid_amount') is-invalid @enderror">
                        @error('paid_amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="payment_status" class="form-label">Payment Status</label>
                        <select id="payment_status" name="payment_status" class="form-select @error('payment_status') is-invalid @enderror" required>
                            @foreach (\App\Models\PurchaseOrder::PAYMENT_STATUSES as $value => $label)
                                <option value="{{ $value }}" @selected(old('payment_status', $purchaseOrder->payment_status) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('payment_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                            @foreach (\App\Models\PurchaseOrder::STATUSES as $value => $label)
                                <option value="{{ $value }}" @selected(old('status', $purchaseOrder->status) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label for="remarks" class="form-label">Remarks <span class="text-secondary">(optional)</span></label>
                        <textarea id="remarks" name="remarks" rows="3" maxlength="255" class="form-control @error('remarks') is-invalid @enderror">{{ old('remarks', $purchaseOrder->remarks) }}</textarea>
                        @error('remarks') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <button type="submit" class="btn bg-gradient-dark mb-0">Update Purchase Order</button>
                <a href="{{ route('purchase_orders.show', $purchaseOrder) }}" class="btn btn-outline-secondary mb-0">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
