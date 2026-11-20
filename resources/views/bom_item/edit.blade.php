@extends('layout.master')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Edit BOM Item</h4>
            <p class="text-sm text-secondary mb-0">Update BOM item #{{ $bomItem->id }}.</p>
        </div>
        <a href="{{ route('bom_items.show', $bomItem) }}" class="btn btn-action-view mb-0">View BOM Item</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('bom_items.update', $bomItem) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="product_variant_id" class="form-label">Product Variant</label>
                        <select id="product_variant_id" name="product_variant_id" class="form-select @error('product_variant_id') is-invalid @enderror" required>
                            @foreach ($variants as $variant)
                                <option value="{{ $variant->id }}" @selected((int) old('product_variant_id', $bomItem->product_variant_id) === (int) $variant->id)>
                                    {{ $variant->sku ?? '#'.$variant->id }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_variant_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="material_id" class="form-label">Material</label>
                        <select id="material_id" name="material_id" class="form-select @error('material_id') is-invalid @enderror" required>
                            @foreach ($materials as $material)
                                <option value="{{ $material->id }}" @selected((int) old('material_id', $bomItem->material_id) === (int) $material->id)>
                                    {{ $material->material_name ?? '#'.$material->id }}
                                </option>
                            @endforeach
                        </select>
                        @error('material_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="quantity_per_unit" class="form-label">Quantity per Unit</label>
                        <input id="quantity_per_unit" name="quantity_per_unit" type="number" min="0.0001" step="0.0001" value="{{ old('quantity_per_unit', $bomItem->quantity_per_unit) }}" class="form-control @error('quantity_per_unit') is-invalid @enderror" required>
                        @error('quantity_per_unit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="wastage_percent" class="form-label">Wastage % <span class="text-secondary">(optional, 0–100)</span></label>
                        <input id="wastage_percent" name="wastage_percent" type="number" min="0" max="100" step="0.01" value="{{ old('wastage_percent', $bomItem->wastage_percent) }}" class="form-control @error('wastage_percent') is-invalid @enderror">
                        @error('wastage_percent') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-action-edit mb-0">Update BOM Item</button>
                <a href="{{ route('bom_items.index') }}" class="btn btn-outline-secondary mb-0">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection