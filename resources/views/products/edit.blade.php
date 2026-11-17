@extends('layout.master')
@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Edit Product</h4>
                <p class="text-sm text-secondary mb-0">Update the product details below.</p>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-outline-dark mb-0">Back to Products</a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('products.update', $product) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="product_code" class="form-label">Product Code</label>
                            <input id="product_code" name="product_code" type="text" maxlength="30" value="{{ old('product_code', $product->product_code) }}" class="form-control @error('product_code') is-invalid @enderror" required>
                            @error('product_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="product_name" class="form-label">Product Name</label>
                            <input id="product_name" name="product_name" type="text" maxlength="150" value="{{ old('product_name', $product->product_name) }}" class="form-control @error('product_name') is-invalid @enderror" required>
                            @error('product_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select id="category" name="category" class="form-select @error('category') is-invalid @enderror" required>
                                <option value="">Select category</option>
                                @foreach (\App\Models\Product::CATEGORIES as $value => $label)
                                    <option value="{{ $value }}" @selected(old('category', $product->category) === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="febric_type" class="form-label">Febric Type</label>
                            <select id="febric_type" name="febric_type" class="form-select @error('febric_type') is-invalid @enderror" required>
                                <option value="">Select febric type</option>
                                @foreach (\App\Models\Product::FEBRIC_TYPES as $value => $label)
                                    <option value="{{ $value }}" @selected(old('febric_type', $product->febric_type) === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('febric_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label for="description" class="form-label">Description <span class="text-secondary">(optional)</span></label>
                            <textarea id="description" name="description" rows="3" maxlength="255" class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                                @foreach (\App\Models\Product::STATUSES as $value => $label)
                                    <option value="{{ $value }}" @selected(old('status', $product->status) === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn bg-gradient-dark mb-0">Update Product</button>
                    <a href="{{ route('products.show', $product) }}" class="btn btn-outline-secondary mb-0">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
