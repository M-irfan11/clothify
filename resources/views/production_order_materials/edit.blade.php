@extends('layout.master')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Edit Production Order Material</h4>
            <p class="text-sm text-secondary mb-0">Update material requirement for {{ $order->production_no }}.</p>
        </div>
        <a href="{{ route('production-orders.materials.show', [$order, $item]) }}" class="btn btn-action-view mb-0">View Material</a>
    </div>
    <div class="card">
        <div class="card-body px-4 py-4">
            @include('production_order_materials._form')
        </div>
    </div>
</div>
@endsection
