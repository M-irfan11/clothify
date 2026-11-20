@extends('layout.master')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Product Variants</h4>
        <a href="{{ route('product_variants.create') }}" class="btn btn-primary btn-sm">+ Add Variant</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Size</th>
                        <th>Color</th>
                        <th>Cost</th>
                        <th>Selling</th>
                        <th>Reorder</th>
                        <th>Status</th>
                        <th width="200">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($product_variants as $variant)
                        <tr>
                            <td>{{ $product_variants->firstItem() + $loop->index }}</td>
                            <td>{{ $variant->product->product_name ?? '-' }}</td>
                            <td>{{ $variant->sku }}</td>
                            <td>{{ $variant->size }}</td>
                            <td>{{ $variant->color }}</td>
                            <td>{{ number_format($variant->cost_price, 2) }}</td>
                            <td>{{ number_format($variant->selling_price, 2) }}</td>
                            <td>{{ $variant->reorder_level }}</td>
                            <td>
                                <span class="badge {{ $variant->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($variant->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('product_variants.show', $variant) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('product_variants.edit', $variant) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('product_variants.destroy', $variant) }}" method="POST"
                                      class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">No variants found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $product_variants->links() }}
    </div>
</div>
@endsection