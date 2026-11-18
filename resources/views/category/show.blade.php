@extends('layout.master')
@section('content')
    <div class="container-fluid py-4">
        <div class="mb-3">
            <h4 class="mb-1">Products</h4>
            <p class="text-sm text-secondary mb-0">Manage your product catalog.</p>
        </div>

        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between bg-white border-0 px-4 pt-4 pb-3">
                <div>
                    <h6 class="mb-1">Product List</h6>
                    <p class="text-xs text-secondary mb-0">Review and manage product records</p>
                </div>
                <a href="{{ route('products.create') }}" class="btn btn-sm bg-gradient-dark mb-0">
                    <span class="material-symbols-rounded align-middle me-1" style="font-size: 18px;">add</span>
                    Add Product
                </a>
            </div>
            <div class="card-body">
                @if ($products->isEmpty())
                    <p class="text-sm text-secondary mb-0">No products found. Click "Add Product" to create a new product.</p>
                @else
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Product Code</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Febric Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->product_code }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->category }}</td>
                                    <td>{{ $product->febric_type }}</td>
                                    <td>{{ ucfirst($product->status) }}</td>
                                    <td>
                                        <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-action-view mb-0 me-1">View</a>
                                        <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-action-edit mb-0 me-1">Edit</a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-action-delete mb-0" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $products->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection