@extends('layout.master')

@section('content')
<div class="container-fluid py-4">
    @if (session('success'))
        <div class="alert alert-success text-white" role="alert">{{ session('success') }}</div>
    @endif
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <p class="text-sm text-secondary mb-1">{{ $order->production_no }}</p>
            <h4 class="mb-1">{{ $item->material->material_name }}</h4>
            <p class="text-sm text-secondary mb-0">Production order material details</p>
        </div>
        <div>
            <a href="{{ route('production-orders.materials.index', $order) }}" class="btn btn-outline-dark mb-0 me-1">Back</a>
            <a href="{{ route('production-orders.materials.edit', [$order, $item]) }}" class="btn btn-action-edit mb-0">Edit Material</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-4"><p class="text-xs text-uppercase text-secondary mb-1">Material</p><p class="text-sm font-weight-bold mb-0">{{ $item->material->material_name }}</p><p class="text-xs text-secondary mb-0">{{ $item->material->material_code }}</p></div>
                <div class="col-md-6 mb-4"><p class="text-xs text-uppercase text-secondary mb-1">Category / Unit</p><p class="text-sm font-weight-bold mb-0">{{ $item->material->category_label }} / {{ $item->material->unit_label }}</p></div>
                <div class="col-md-4 mb-4"><p class="text-xs text-uppercase text-secondary mb-1">Planned Quantity</p><p class="text-sm font-weight-bold mb-0">{{ number_format((float) $item->planned_qty, 3) }}</p></div>
                <div class="col-md-4 mb-4"><p class="text-xs text-uppercase text-secondary mb-1">Issued Quantity</p><p class="text-sm font-weight-bold mb-0">{{ number_format((float) $item->issued_qty, 3) }}</p></div>
                <div class="col-md-4 mb-4"><p class="text-xs text-uppercase text-secondary mb-1">Used Quantity</p><p class="text-sm font-weight-bold mb-0">{{ number_format((float) $item->used_qty, 3) }}</p></div>
                <div class="col-md-4 mb-4"><p class="text-xs text-uppercase text-secondary mb-1">Returned Quantity</p><p class="text-sm font-weight-bold mb-0">{{ number_format((float) $item->return_qty, 3) }}</p></div>
                <div class="col-md-4 mb-4"><p class="text-xs text-uppercase text-secondary mb-1">Wastage Quantity</p><p class="text-sm font-weight-bold mb-0">{{ number_format((float) $item->wastage_qty, 3) }}</p></div>
                <div class="col-md-4 mb-4"><p class="text-xs text-uppercase text-secondary mb-1">Added At</p><p class="text-sm font-weight-bold mb-0">{{ $item->created_at?->format('M d, Y H:i') }}</p></div>
            </div>
            <form action="{{ route('production-orders.materials.destroy', [$order, $item]) }}" method="POST" class="mt-2">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-action-delete mb-0" onclick="return confirm('Delete this material requirement?')">Delete Material</button>
            </form>
        </div>
    </div>
</div>
@endsection
