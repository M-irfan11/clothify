@extends('layout.master')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Edit Stock Movement</h4>
            <p class="text-sm text-secondary mb-0">Update stock movement #{{ $stockMovement->id }}.</p>
        </div>
        <a href="{{ route('stock_movements.show', $stockMovement) }}" class="btn btn-action-view mb-0">View Movement</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('stock_movements.update', $stockMovement) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="warehouse_id" class="form-label">Warehouse</label>
                        <select id="warehouse_id" name="warehouse_id" class="form-select @error('warehouse_id') is-invalid @enderror" required>
                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}" @selected((int) old('warehouse_id', $stockMovement->warehouse_id) === (int) $warehouse->id)>
                                    {{ $warehouse->warehouse_name }} ({{ $warehouse->warehouse_code }})
                                </option>
                            @endforeach
                        </select>
                        @error('warehouse_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="movement_type" class="form-label">Movement Type</label>
                        <select id="movement_type" name="movement_type" class="form-select @error('movement_type') is-invalid @enderror" required>
                            @foreach (\App\Models\stock_movement::MOVEMENT_TYPES as $value => $label)
                                <option value="{{ $value }}" @selected(old('movement_type', $stockMovement->movement_type) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('movement_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="material_id" class="form-label">Material <span class="text-secondary">(choose this or a product variant)</span></label>
                        <select id="material_id" name="material_id" class="form-select @error('material_id') is-invalid @enderror">
                            <option value="">Select material</option>
                            @foreach ($materials as $material)
                                <option value="{{ $material->id }}" @selected((int) old('material_id', $stockMovement->material_id) === (int) $material->id)>
                                    {{ $material->material_name }} ({{ $material->material_code }})
                                </option>
                            @endforeach
                        </select>
                        @error('material_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="product_variant_id" class="form-label">Product Variant <span class="text-secondary">(choose this or a material)</span></label>
                        <select id="product_variant_id" name="product_variant_id" class="form-select @error('product_variant_id') is-invalid @enderror">
                            <option value="">Select product variant</option>
                            @foreach ($variants as $variant)
                                <option value="{{ $variant->id }}" @selected((int) old('product_variant_id', $stockMovement->product_variant_id) === (int) $variant->id)>
                                    {{ $variant->sku }} - {{ $variant->product->product_name ?? 'Product' }} ({{ $variant->size }}, {{ $variant->color }})
                                </option>
                            @endforeach
                        </select>
                        @error('product_variant_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="quantity" class="form-label">Signed Quantity</label>
                        <input id="quantity" name="quantity" type="number" step="0.001" value="{{ old('quantity', $stockMovement->quantity) }}" class="form-control @error('quantity') is-invalid @enderror" required>
                        <small class="text-secondary">IN movements use a positive amount; OUT movements use a negative amount.</small>
                        @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="unit_cost" class="form-label">Unit Cost <span class="text-secondary">(optional)</span></label>
                        <input id="unit_cost" name="unit_cost" type="number" min="0" step="0.01" value="{{ old('unit_cost', $stockMovement->unit_cost) }}" class="form-control @error('unit_cost') is-invalid @enderror">
                        @error('unit_cost') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="movement_date" class="form-label">Movement Date</label>
                        <input id="movement_date" name="movement_date" type="datetime-local" value="{{ old('movement_date', $stockMovement->movement_date->format('Y-m-d\TH:i')) }}" class="form-control @error('movement_date') is-invalid @enderror" required>
                        @error('movement_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="reference_type" class="form-label">Reference Type <span class="text-secondary">(optional)</span></label>
                        <select id="reference_type" name="reference_type" class="form-select @error('reference_type') is-invalid @enderror">
                            <option value="">No reference</option>
                            @foreach (\App\Models\stock_movement::REFERENCE_TYPES as $value => $label)
                                <option value="{{ $value }}" @selected(old('reference_type', $stockMovement->reference_type) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('reference_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="reference_id" class="form-label">Reference ID <span class="text-secondary">(optional)</span></label>
                        <input id="reference_id" name="reference_id" type="number" min="1" step="1" value="{{ old('reference_id', $stockMovement->reference_id) }}" class="form-control @error('reference_id') is-invalid @enderror">
                        @error('reference_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="remarks" class="form-label">Remarks <span class="text-secondary">(optional)</span></label>
                        <textarea id="remarks" name="remarks" rows="3" maxlength="255" class="form-control @error('remarks') is-invalid @enderror">{{ old('remarks', $stockMovement->remarks) }}</textarea>
                        @error('remarks') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-action-edit mb-0">Update Movement</button>
                <a href="{{ route('stock_movements.index') }}" class="btn btn-outline-secondary mb-0">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
