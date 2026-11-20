@extends('layout.master')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Add Inventory Stock</h4>
            <p class="text-sm text-secondary mb-0">Choose one material or product variant and its warehouse.</p>
        </div>
        <a href="{{ route('inventory_stocks.index') }}" class="btn btn-outline-dark mb-0">Back to Inventory Stocks</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('inventory_stocks.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="warehouse_id" class="form-label">Warehouse</label>
                        <select id="warehouse_id" name="warehouse_id" class="form-select @error('warehouse_id') is-invalid @enderror" required>
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
                        <label for="material_id" class="form-label">Material <span class="text-secondary">(choose this or a product variant)</span></label>
                        <select id="material_id" name="material_id" class="form-select @error('material_id') is-invalid @enderror">
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
                        <label for="product_variant_id" class="form-label">Product Variant <span class="text-secondary">(choose this or a material)</span></label>
                        <select id="product_variant_id" name="product_variant_id" class="form-select @error('product_variant_id') is-invalid @enderror">
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
                        <label for="quantity" class="form-label">Quantity</label>
                        <input id="quantity" name="quantity" type="number" min="0" step="0.001" value="{{ old('quantity', '0.000') }}" class="form-control @error('quantity') is-invalid @enderror" required>
                        @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="reserved_qty" class="form-label">Reserved Quantity</label>
                        <input id="reserved_qty" name="reserved_qty" type="number" min="0" step="0.001" value="{{ old('reserved_qty', '0.000') }}" class="form-control @error('reserved_qty') is-invalid @enderror" required>
                        @error('reserved_qty') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <button type="submit" class="btn bg-gradient-dark mb-0">Save Stock</button>
                <a href="{{ route('inventory_stocks.index') }}" class="btn btn-outline-secondary mb-0">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
