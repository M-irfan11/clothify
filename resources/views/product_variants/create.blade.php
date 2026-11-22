@extends('layout.master')
@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Add Product Variant</h4>
                <p class="text-sm text-secondary mb-0">Enter the product variant details below.</p>
            </div>
            <a href="{{ route('product_variants.index') }}" class="btn btn-outline-dark mb-0">Back to Variants</a>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('product_variants.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                        <label class="form-label">Product <span class="text-danger">*</span></label>
                        <select name="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                            <option value="">-- Select Product --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->product_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                        <label class="form-label">SKU <span class="text-danger">*</span></label>
                        <input type="text" name="sku" maxlength="40"
                               class="form-control @error('sku') is-invalid @enderror"
                               value="{{ old('sku') }}" required>
                        @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                        <label class="form-label">Size <span class="text-danger">*</span></label>
                        <select name="size" class="form-select @error('size') is-invalid @enderror" required>
                            <option value="">-- Select Size --</option>
                            @foreach (['S', 'M', 'L', 'XL', 'XXL'] as $size)
                                <option value="{{ $size }}" {{ old('size') == $size ? 'selected' : '' }}>{{ $size }}</option>
                            @endforeach
                        </select>
                        @error('size') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                        <label class="form-label">Color <span class="text-danger">*</span></label>
                        <input type="text" name="color" maxlength="30"
                               class="form-control @error('color') is-invalid @enderror"
                               value="{{ old('color') }}" required>
                        @error('color') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                        <label class="form-label">Cost Price <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" name="cost_price"
                               class="form-control @error('cost_price') is-invalid @enderror"
                               value="{{ old('cost_price') }}" required>
                        @error('cost_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                        <label class="form-label">Selling Price <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" name="selling_price"
                               class="form-control @error('selling_price') is-invalid @enderror"
                               value="{{ old('selling_price') }}" required>
                        @error('selling_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                        <label class="form-label">Reorder Level</label>
                        <input type="number" min="0" name="reorder_level"
                               class="form-control @error('reorder_level') is-invalid @enderror"
                               value="{{ old('reorder_level', 0) }}">
                        @error('reorder_level') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
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