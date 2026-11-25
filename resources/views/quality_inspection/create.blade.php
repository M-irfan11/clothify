@extends('layout.master')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Add Quality Inspection</h4>
            <p class="text-sm text-secondary mb-0">Choose the inspection type to show the related fields.</p>
        </div>
        <a href="{{ route('quality_inspections.index') }}" class="btn btn-outline-dark mb-0">Back to Quality Inspections</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('quality_inspections.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="inspection_no" class="form-label">Inspection No</label>
                        <input id="inspection_no" name="inspection_no" type="text" maxlength="30" value="{{ old('inspection_no') }}" class="form-control @error('inspection_no') is-invalid @enderror" required>
                        @error('inspection_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="inspection_type" class="form-label">Inspection Type</label>
                        <select id="inspection_type" name="inspection_type" class="form-select @error('inspection_type') is-invalid @enderror" required>
                            <option value="">Select type</option>
                            @foreach (\App\Models\QualityInspection::TYPES as $value => $label)
                                <option value="{{ $value }}" @selected(old('inspection_type') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('inspection_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Incoming material --}}
                    <div class="col-md-6 mb-3 type-field" data-types="incoming_material">
                        <label for="purchase_order_item_id" class="form-label">Purchase Order Item</label>
                        <select id="purchase_order_item_id" name="purchase_order_item_id" class="form-select @error('purchase_order_item_id') is-invalid @enderror">
                            <option value="">Select PO item</option>
                            @foreach ($purchaseOrderItems as $item)
                                <option value="{{ $item->id }}" @selected((string) old('purchase_order_item_id') === (string) $item->id)>
                                    {{ $item->purchaseOrder->po_no ?? 'PO' }} - {{ $item->material->material_name ?? 'Item #'.$item->id }}
                                </option>
                            @endforeach
                        </select>
                        @error('purchase_order_item_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3 type-field" data-types="incoming_material">
                        <label for="material_id" class="form-label">Material</label>
                        <select id="material_id" name="material_id" class="form-select @error('material_id') is-invalid @enderror">
                            <option value="">Select material</option>
                            @foreach ($materials as $material)
                                <option value="{{ $material->id }}" @selected((string) old('material_id') === (string) $material->id)>
                                    {{ $material->material_name }} ({{ $material->material_code }})
                                </option>
                            @endforeach
                        </select>
                        @error('material_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- In process / Final product --}}
                    <div class="col-md-6 mb-3 type-field" data-types="in_process,final_product">
                        <label for="production_order_id" class="form-label">Production Order</label>
                        <select id="production_order_id" name="production_order_id" class="form-select @error('production_order_id') is-invalid @enderror">
                            <option value="">Select production order</option>
                            @foreach ($productionOrders as $productionOrder)
                                <option value="{{ $productionOrder->id }}" @selected((string) old('production_order_id') === (string) $productionOrder->id)>
                                    {{ $productionOrder->production_no ?? 'PRD #'.$productionOrder->id }}
                                </option>
                            @endforeach
                        </select>
                        @error('production_order_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3 type-field" data-types="in_process,final_product">
                        <label for="product_variant_id" class="form-label">Product Variant</label>
                        <select id="product_variant_id" name="product_variant_id" class="form-select @error('product_variant_id') is-invalid @enderror">
                            <option value="">Select product variant</option>
                            @foreach ($productVariants as $variant)
                                <option value="{{ $variant->id }}" @selected((string) old('product_variant_id') === (string) $variant->id)>
                                    {{ $variant->sku }} - {{ $variant->product->product_name ?? 'Product' }} ({{ $variant->size }}, {{ $variant->color }})
                                </option>
                            @endforeach
                        </select>
                        @error('product_variant_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="inspected_qty" class="form-label">Inspected Qty</label>
                        <input id="inspected_qty" name="inspected_qty" type="number" min="0" step="0.001" value="{{ old('inspected_qty') }}" class="form-control @error('inspected_qty') is-invalid @enderror" required>
                        @error('inspected_qty') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="passed_qty" class="form-label">Passed Qty</label>
                        <input id="passed_qty" name="passed_qty" type="number" min="0" step="0.001" value="{{ old('passed_qty', '0.000') }}" class="form-control @error('passed_qty') is-invalid @enderror" required>
                        @error('passed_qty') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="rejected_qty" class="form-label">Rejected Qty</label>
                        <input id="rejected_qty" name="rejected_qty" type="number" min="0" step="0.001" value="{{ old('rejected_qty', '0.000') }}" class="form-control @error('rejected_qty') is-invalid @enderror" required>
                        @error('rejected_qty') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="rework_qty" class="form-label">Rework Qty</label>
                        <input id="rework_qty" name="rework_qty" type="number" min="0" step="0.001" value="{{ old('rework_qty', '0.000') }}" class="form-control @error('rework_qty') is-invalid @enderror" required>
                        @error('rework_qty') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="inspected_by" class="form-label">Inspected By</label>
                        <select id="inspected_by" name="inspected_by" class="form-select @error('inspected_by') is-invalid @enderror" required>
                            <option value="">Select inspector</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @selected((string) old('inspected_by', auth()->id()) === (string) $user->id)>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('inspected_by') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="inspection_date" class="form-label">Inspection Date</label>
                        <input id="inspection_date" name="inspection_date" type="date" value="{{ old('inspection_date', now()->format('Y-m-d')) }}" class="form-control @error('inspection_date') is-invalid @enderror" required>
                        @error('inspection_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label for="defect_details" class="form-label">Defect Details <span class="text-secondary">(optional)</span></label>
                        <textarea id="defect_details" name="defect_details" rows="3" class="form-control @error('defect_details') is-invalid @enderror">{{ old('defect_details') }}</textarea>
                        @error('defect_details') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label for="remarks" class="form-label">Remarks <span class="text-secondary">(optional)</span></label>
                        <textarea id="remarks" name="remarks" rows="3" class="form-control @error('remarks') is-invalid @enderror">{{ old('remarks') }}</textarea>
                        @error('remarks') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <button type="submit" class="btn bg-gradient-dark mb-0">Save Inspection</button>
                <a href="{{ route('quality_inspections.index') }}" class="btn btn-outline-secondary mb-0">Cancel</a>
            </form>
        </div>
    </div>
</div>

<script>
    (function () {
        const typeSelect = document.getElementById('inspection_type');
        const fields = document.querySelectorAll('.type-field');

        function toggleFields(clearHidden) {
            const current = typeSelect.value;
            fields.forEach(function (el) {
                const show = el.dataset.types.split(',').includes(current);
                el.style.display = show ? '' : 'none';
                if (!show && clearHidden) {
                    // hidden field-er value muche dei, jate onno type-er value save na hoy
                    el.querySelectorAll('select').forEach(function (s) { s.value = ''; });
                }
            });
        }

        typeSelect.addEventListener('change', function () { toggleFields(true); });
        toggleFields(false);
    })();
</script>
@endsection