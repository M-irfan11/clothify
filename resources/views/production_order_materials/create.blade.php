@extends('layout.master')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Add Production Order Material</h4>
            <p class="text-sm text-secondary mb-0">Add a material requirement to {{ $order->production_no }}.</p>
        </div>
        <a href="{{ route('production-orders.materials.index', $order) }}" class="btn btn-outline-dark mb-0">Back to Materials</a>
    </div>
    <div class="card">
        <div class="card-header bg-white border-0 px-4 pt-4 pb-2">
            <h6 class="mb-1">Material Requirement</h6>
            <p class="text-xs text-secondary mb-0">Enter planned and actual material quantities.</p>
        </div>
        <div class="card-body px-4 pb-4">
            @include('production_order_materials._form')
        </div>
    </div>
</div>
@endsection
