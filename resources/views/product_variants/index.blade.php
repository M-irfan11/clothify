@extends('layout.master')
@section('content')
<<<<<<< HEAD
<div class="container-fluid py-4">
    <div class="mb-3">
        <h4 class="mb-1">Product Variants</h4>
        <p class="text-sm text-secondary mb-0">Manage product sizes, colors, pricing, and reorder settings.</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success text-white" role="alert">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between bg-white border-0 px-4 pt-4 pb-3">
            <div>
                <h6 class="mb-1">Variant List</h6>
                <p class="text-xs text-secondary mb-0">Review and manage product variant records</p>
            </div>
            <a href="{{ route('product_variants.create') }}" class="btn btn-sm bg-gradient-dark mb-0">
                <span class="material-symbols-rounded align-middle me-1" style="font-size: 18px;">add</span>
                Add Variant
            </a>
        </div>
        <div class="card-body px-0 pb-2">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product / SKU</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Size / Color</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cost / Selling</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Reorder</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($product_variants as $variant)
                            <tr>
                                <td>
                                    <a class="text-sm font-weight-bold mb-0" href="{{ route('product_variants.show', $variant) }}">
                                        {{ $variant->product->product_name ?? '-' }}
                                    </a>
                                    <p class="text-xs text-secondary mb-0">{{ $variant->sku }}</p>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0">{{ $variant->size }}</p>
                                    <p class="text-xs text-secondary mb-0">{{ $variant->color }}</p>
                                </td>
                                <td class="text-sm">{{ number_format($variant->cost_price, 2) }} / {{ number_format($variant->selling_price, 2) }}</td>
                                <td class="text-sm">{{ $variant->reorder_level }}</td>
                                <td>
                                    <span class="badge badge-sm {{ $variant->status === 'active' ? 'bg-gradient-success' : 'bg-gradient-secondary' }}">
                                        {{ ucfirst($variant->status) }}
                                    </span>
                                </td>
                                <td class="align-middle text-end">
                                    <a href="{{ route('product_variants.show', $variant) }}" class="btn btn-sm btn-action-view mb-0 me-1">View</a>
                                    <a href="{{ route('product_variants.edit', $variant) }}" class="btn btn-sm btn-action-edit mb-0 me-1">Edit</a>
                                    <form action="{{ route('product_variants.destroy', $variant) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-action-delete mb-0" onclick="return confirm('Are you sure you want to delete this variant?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-secondary py-4">No variants found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 pt-3">
                {{ $product_variants->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
=======
    <div class="container-fluid py-4">
        <div class="mb-3">
            <h4 class="mb-1">Product Variants</h4>
            <p class="text-sm text-secondary mb-0">Manage your product variant catalog.</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between bg-white border-0 px-4 pt-4 pb-3">
                <div>
                    <h6 class="mb-1">Variant List</h6>
                    <p class="text-xs text-secondary mb-0">Review and manage product variant records</p>
                </div>
                <a href="{{ route('product_variants.create') }}" class="btn btn-sm bg-gradient-dark mb-0">
                    <span class="material-symbols-rounded align-middle me-1" style="font-size: 18px;">add</span>
                    Add Variant
                </a>
            </div>
            <div class="card-body">
                @if ($product_variants->isEmpty())
                    <p class="text-sm text-secondary mb-0">No variants found. Click "Add Variant" to create a new product variant.</p>
                @else
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>SKU</th>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Cost</th>
                                <th>Selling</th>
                                <th>Reorder</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product_variants as $variant)
                                <tr>
                                    <td>{{ $variant->product->product_name ?? '-' }}</td>
                                    <td>{{ $variant->sku }}</td>
                                    <td>{{ $variant->size }}</td>
                                    <td>{{ $variant->color }}</td>
                                    <td>{{ number_format($variant->cost_price, 2) }}</td>
                                    <td>{{ number_format($variant->selling_price, 2) }}</td>
                                    <td>{{ $variant->reorder_level }}</td>
                                    <td>{{ ucfirst($variant->status) }}</td>
                                    <td>
                                        <a href="{{ route('product_variants.show', $variant) }}" class="btn btn-sm btn-action-view mb-0 me-1">View</a>
                                        <a href="{{ route('product_variants.edit', $variant) }}" class="btn btn-sm btn-action-edit mb-0 me-1">Edit</a>
                                        <form action="{{ route('product_variants.destroy', $variant) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-action-delete mb-0" onclick="return confirm('Are you sure you want to delete this variant?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $product_variants->links() }}
                @endif
            </div>
        </div>
    </div>
>>>>>>> 3c7c2b475dd05bbf33fe4b08ac1cef602bcd8b8e
@endsection