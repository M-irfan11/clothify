@extends('layout.master')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h4 class="mb-1">Add Inventory Stock</h4>
            <p class="text-sm text-secondary mb-0">Add material or finished-goods stock to a warehouse.</p>
        </div>
        <a href="{{ route('inventory_stocks.index') }}" class="btn btn-sm btn-outline-dark mb-0">Back to Inventory Stocks</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white border-0 px-4 pt-4 pb-2">
            <h6 class="mb-1">Stock Information</h6>
            <p class="text-xs text-secondary mb-0">Select either a material or a product variant, then enter stock quantities.</p>
        </div>
        <div class="card-body px-4 pb-4">
            <form action="{{ route('inventory_stocks.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="warehouse_id" class="form-label text-sm">Warehouse <span class="text-danger">*</span></label>
                        <select id="warehouse_id" name="warehouse_id" class="form-select border @error('warehouse_id') is-invalid @enderror" required>
                            <option value="">Select warehouse</option>
                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}" @selected((int) old('warehouse_id') === (int) $warehouse->id)>
                                    {{ $warehouse->warehouse_name }} ({{ $warehouse->warehouse_code }})
                                </option>
                            @endforeach
                        </select>
                        @error('warehouse_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="material_id" class="form-label text-sm">Material <span class="text-secondary">(choose this or a product variant)</span></label>
                        <select id="material_id" name="material_id" class="form-select border @error('material_id') is-invalid @enderror">
                            <option value="">Select material</option>
                            @foreach ($materials as $material)
                                <option value="{{ $material->id }}" @selected((int) old('material_id') === (int) $material->id)>
                                    {{ $material->material_name }} ({{ $material->material_code }})
                                </option>
                            @endforeach
                        </select>
                        @error('material_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="product_variant_id" class="form-label text-sm">Product Variant <span class="text-secondary">(choose this or a material)</span></label>
                        <select id="product_variant_id" name="product_variant_id" class="form-select border @error('product_variant_id') is-invalid @enderror">
                            <option value="">Select product variant</option>
                            @foreach ($variants as $variant)
                                <option value="{{ $variant->id }}" @selected((int) old('product_variant_id') === (int) $variant->id)>
                                    {{ $variant->sku }} - {{ $variant->product->product_name ?? 'Product' }} ({{ $variant->size }}, {{ $variant->color }})
                                </option>
                            @endforeach
                        </select>
                        @error('product_variant_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="quantity" class="form-label text-sm">Total Quantity <span class="text-danger">*</span></label>
                        <input id="quantity" name="quantity" type="number" min="0" step="0.001" inputmode="decimal" value="{{ old('quantity', '0.000') }}" class="form-control border @error('quantity') is-invalid @enderror" required>
                        <div class="form-text">Use decimals for KG, meter or cone-based stock.</div>
                        @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="reserved_qty" class="form-label text-sm">Reserved Quantity <span class="text-danger">*</span></label>
                        <input id="reserved_qty" name="reserved_qty" type="number" min="0" step="0.001" inputmode="decimal" value="{{ old('reserved_qty', '0.000') }}" class="form-control border @error('reserved_qty') is-invalid @enderror" required>
                        <div class="form-text">Reserved quantity cannot exceed total quantity.</div>
                        @error('reserved_qty') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="d-flex gap-2 pt-2">
                    <button type="submit" class="btn bg-gradient-dark mb-0">Save Stock</button>
                    <a href="{{ route('inventory_stocks.index') }}" class="btn btn-outline-secondary mb-0">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
