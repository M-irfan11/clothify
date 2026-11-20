@extends('layout.master')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-3">
        <h4 class="mb-1">BOM Items</h4>
        <p class="text-sm text-secondary mb-0">Manage materials required for each product variant.</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success text-white" role="alert">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between bg-white border-0 px-4 pt-4 pb-3">
            <div>
                <h6 class="mb-1">BOM Item List</h6>
                <p class="text-xs text-secondary mb-0">Review and manage bill of materials records</p>
            </div>
            <a href="{{ route('bom_items.create') }}" class="btn btn-sm bg-gradient-dark mb-0">
                <span class="material-symbols-rounded align-middle me-1" style="font-size: 18px;">add</span>
                Add BOM Item
            </a>
        </div>
        <div class="card-body px-0 pb-2">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product Variant</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Material</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Qty / Unit</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Wastage %</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bomItems as $bomItem)
                            <tr>
                                <td>
                                    <a class="text-sm font-weight-bold mb-0" href="{{ route('bom_items.show', $bomItem) }}">
                                        {{ $bomItem->productVariant->sku ?? '#'.$bomItem->product_variant_id }}
                                    </a>
                                </td>
                                <td class="text-sm">{{ $bomItem->material->material_name ?? '#'.$bomItem->material_id }}</td>
                                <td class="text-sm">{{ $bomItem->quantity_per_unit }}</td>
                                <td class="text-sm">{{ $bomItem->wastage_percent }}%</td>
                                <td class="align-middle text-end">
                                    <a href="{{ route('bom_items.show', $bomItem) }}" class="btn btn-sm btn-action-view mb-0 me-1">View</a>
                                    <a href="{{ route('bom_items.edit', $bomItem) }}" class="btn btn-sm btn-action-edit mb-0 me-1">Edit</a>
                                    <form action="{{ route('bom_items.destroy', $bomItem) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-action-delete mb-0" onclick="return confirm('Delete this BOM item?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-secondary py-4">No BOM items found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 pt-3">
                {{ $bomItems->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection