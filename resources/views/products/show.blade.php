@extends('layout.master')
@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">{{ $product->product_name }}</h4>
                <p class="text-sm text-secondary mb-0">Product details</p>
            </div>
            <div>
                <a href="{{ route('products.index') }}" class="btn btn-outline-dark mb-0">Back to Products</a>
                <a href="{{ route('products.edit', $product) }}" class="btn bg-gradient-dark mb-0">Edit Product</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3">Product Code</dt>
                    <dd class="col-sm-9">{{ $product->product_code }}</dd>

                    <dt class="col-sm-3">Category</dt>
                    <dd class="col-sm-9">{{ \App\Models\Product::CATEGORIES[$product->category] ?? $product->category }}</dd>

                    <dt class="col-sm-3">Febric Type</dt>
                    <dd class="col-sm-9">{{ \App\Models\Product::FEBRIC_TYPES[$product->febric_type] ?? $product->febric_type }}</dd>

                    <dt class="col-sm-3">Status</dt>
                    <dd class="col-sm-9">{{ \App\Models\Product::STATUSES[$product->status] ?? $product->status }}</dd>

                    <dt class="col-sm-3">Description</dt>
                    <dd class="col-sm-9">{{ $product->description ?: '—' }}</dd>
                </dl>
            </div>
        </div>
    </div>
@endsection
