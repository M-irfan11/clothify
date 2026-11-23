@extends('layout.master')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Add Product Variant</h4>
            <p class="text-sm text-secondary mb-0">Enter variant, pricing, and inventory details.</p>
        </div>
        <a href="{{ route('product_variants.index') }}" class="btn btn-outline-dark mb-0">Back to Variants</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('product_variants.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="product_id" class="form-label">Product</label>
                        <select id="product_id" name="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                            <option value="">Select product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->product_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="sku" class="form-label">SKU</label>
                        <input id="sku" type="text" name="sku" maxlength="40"
                               class="form-control @error('sku') is-invalid @enderror"
                               value="{{ old('sku') }}" required>
                        @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="size" class="form-label">Size</label>
                        <select id="size" name="size" class="form-select @error('size') is-invalid @enderror" required>
                            <option value="">Select size</option>
                            @foreach (['S', 'M', 'L', 'XL', 'XXL'] as $size)
                                <option value="{{ $size }}" {{ old('size') == $size ? 'selected' : '' }}>{{ $size }}</option>
                            @endforeach
                        </select>
                        @error('size') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="color" class="form-label">Color</label>
                        <input id="color" type="text" name="color" maxlength="30"
                               class="form-control @error('color') is-invalid @enderror"
                               value="{{ old('color') }}" required>
                        @error('color') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="cost_price" class="form-label">Cost Price</label>
                        <input id="cost_price" type="number" step="0.01" min="0" name="cost_price"
                               class="form-control @error('cost_price') is-invalid @enderror"
                               value="{{ old('cost_price') }}" required>
                        @error('cost_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="selling_price" class="form-label">Selling Price</label>
                        <input id="selling_price" type="number" step="0.01" min="0" name="selling_price"
                               class="form-control @error('selling_price') is-invalid @enderror"
                               value="{{ old('selling_price') }}" required>
                        @error('selling_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="reorder_level" class="form-label">Reorder Level</label>
                        <input id="reorder_level" type="number" min="0" name="reorder_level"
                               class="form-control @error('reorder_level') is-invalid @enderror"
                               value="{{ old('reorder_level', 0) }}">
                        @error('reorder_level') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
                            @foreach (['active', 'inactive'] as $status)
                                <option value="{{ $status }}" {{ old('status', 'active') == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <button type="submit" class="btn bg-gradient-dark mb-0">Save Variant</button>
                <a href="{{ route('product_variants.index') }}" class="btn btn-outline-secondary mb-0">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection