@extends('layout.master')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Edit PO Item</h4>
            <p class="text-sm text-secondary mb-0">Update {{ $purchaseOrderItem->material->material_name ?? 'item' }} in PO {{ $purchaseOrderItem->purchaseOrder->po_no ?? '#'.$purchaseOrderItem->purchase_order_id }}.</p>
        </div>
        <a href="{{ route('purchase_order_items.show', $purchaseOrderItem) }}" class="btn btn-action-view mb-0">View PO Item</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('purchase_order_items.update', $purchaseOrderItem) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Purchase Order</label>
                        <input type="text" class="form-control" value="{{ $purchaseOrderItem->purchaseOrder->po_no ?? '#'.$purchaseOrderItem->purchase_order_id }}" disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Material</label>
                        <input type="text" class="form-control" value="{{ $purchaseOrderItem->material->material_name ?? '—' }}" disabled>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="ordered_qty" class="form-label">Ordered Qty</label>
                        <input id="ordered_qty" name="ordered_qty" type="number" min="0.001" step="0.001" value="{{ old('ordered_qty', $purchaseOrderItem->ordered_qty) }}" class="form-control @error('ordered_qty') is-invalid @enderror" required>
                        @error('ordered_qty') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="unit_price" class="form-label">Unit Price</label>
                        <input id="unit_price" name="unit_price" type="number" min="0" step="0.01" value="{{ old('unit_price', $purchaseOrderItem->unit_price) }}" class="form-control @error('unit_price') is-invalid @enderror" required>
                        @error('unit_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="line_total_preview" class="form-label">Line Total <span class="text-secondary">(auto)</span></label>
                        <input id="line_total_preview" type="text" class="form-control" value="{{ number_format($purchaseOrderItem->line_total, 2, '.', '') }}" readonly>
                    </div>

                    <div class="col-12 mt-2 mb-2">
                        <h6 class="mb-0">Receiving &amp; QC</h6>
                        <p class="text-xs text-secondary mb-0">Accepted + Rejected must equal Received.</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="received_qty" class="form-label">Received Qty</label>
                        <input id="received_qty" name="received_qty" type="number" min="0" step="0.001" value="{{ old('received_qty', $purchaseOrderItem->received_qty) }}" class="form-control @error('received_qty') is-invalid @enderror" required>
                        @error('received_qty') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="accepted_qty" class="form-label">Accepted Qty <span class="text-secondary">(QC passed)</span></label>
                        <input id="accepted_qty" name="accepted_qty" type="number" min="0" step="0.001" value="{{ old('accepted_qty', $purchaseOrderItem->accepted_qty) }}" class="form-control @error('accepted_qty') is-invalid @enderror" required>
                        @error('accepted_qty') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="rejected_qty" class="form-label">Rejected Qty <span class="text-secondary">(QC failed)</span></label>
                        <input id="rejected_qty" name="rejected_qty" type="number" min="0" step="0.001" value="{{ old('rejected_qty', $purchaseOrderItem->rejected_qty) }}" class="form-control @error('rejected_qty') is-invalid @enderror" required>
                        @error('rejected_qty') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-action-edit mb-0">Update PO Item</button>
                <a href="{{ route('purchase_order_items.index') }}" class="btn btn-outline-secondary mb-0">Cancel</a>
            </form>
        </div>
    </div>
</div>

<script>
    (function () {
        const qty = document.getElementById('ordered_qty');
        const price = document.getElementById('unit_price');
        const total = document.getElementById('line_total_preview');

        function update() {
            total.value = ((parseFloat(qty.value) || 0) * (parseFloat(price.value) || 0)).toFixed(2);
        }

        qty.addEventListener('input', update);
        price.addEventListener('input', update);
    })();
</script>
@endsection