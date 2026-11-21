@extends('layout.master')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Add PO Item</h4>
            <p class="text-sm text-secondary mb-0">Enter the material line details below.</p>
        </div>
        <a href="{{ route('purchase_order_items.index') }}" class="btn btn-outline-dark mb-0">Back to PO Items</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('purchase_order_items.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="purchase_order_id" class="form-label">Purchase Order</label>
                        <select id="purchase_order_id" name="purchase_order_id" class="form-select @error('purchase_order_id') is-invalid @enderror" required>
                            <option value="">Select purchase order</option>
                            @foreach ($purchaseOrders as $purchaseOrder)
                                <option value="{{ $purchaseOrder->id }}" @selected((string) old('purchase_order_id', request('purchase_order_id')) === (string) $purchaseOrder->id)>
                                    {{ $purchaseOrder->po_no }}
                                </option>
                            @endforeach
                        </select>
                        @error('purchase_order_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="material_id" class="form-label">Material</label>
                        <select id="material_id" name="material_id" class="form-select @error('material_id') is-invalid @enderror" required>
                            <option value="">Select material</option>
                            @foreach ($materials as $material)
                                <option value="{{ $material->id }}" @selected((string) old('material_id') === (string) $material->id)>
                                    {{ $material->material_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('material_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="ordered_qty" class="form-label">Ordered Qty</label>
                        <input id="ordered_qty" name="ordered_qty" type="number" min="0.001" step="0.001" value="{{ old('ordered_qty') }}" class="form-control @error('ordered_qty') is-invalid @enderror" required>
                        @error('ordered_qty') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="unit_price" class="form-label">Unit Price</label>
                        <input id="unit_price" name="unit_price" type="number" min="0" step="0.01" value="{{ old('unit_price') }}" class="form-control @error('unit_price') is-invalid @enderror" required>
                        @error('unit_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="line_total_preview" class="form-label">Line Total <span class="text-secondary">(auto)</span></label>
                        <input id="line_total_preview" type="text" class="form-control" value="0.00" readonly>
                    </div>
                </div>
                <button type="submit" class="btn bg-gradient-dark mb-0">Save PO Item</button>
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
            const value = (parseFloat(qty.value) || 0) * (parseFloat(price.value) || 0);
            total.value = value.toFixed(2);
        }

        qty.addEventListener('input', update);
        price.addEventListener('input', update);
        update();
    })();
</script>
@endsection