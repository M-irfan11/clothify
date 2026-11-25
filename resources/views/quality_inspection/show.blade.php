@extends('layout.master')

@section('content')
@php
    $typeBadge = [
        'incoming_material' => 'bg-gradient-info',
        'in_process'        => 'bg-gradient-warning',
        'final_product'     => 'bg-gradient-success',
    ];
    $inspected = (float) $inspection->inspected_qty;
    $passRate  = $inspected > 0 ? ((float) $inspection->passed_qty / $inspected) * 100 : 0;
@endphp
<div class="container-fluid py-4">
    @if (session('success'))
        <div class="alert alert-success text-white" role="alert">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Inspection {{ $inspection->inspection_no }}</h4>
            <p class="text-sm text-secondary mb-0">Quality inspection details</p>
        </div>
        <div>
            <a href="{{ route('quality_inspections.index') }}" class="btn btn-outline-dark mb-0">Back</a>
            <a href="{{ route('quality_inspections.edit', $inspection) }}" class="btn btn-action-edit mb-0">Edit Inspection</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Inspection Type</p>
                    <p class="text-sm font-weight-bold mb-0">
                        <span class="badge badge-sm {{ $typeBadge[$inspection->inspection_type] ?? 'bg-gradient-secondary' }}">
                            {{ \App\Models\QualityInspection::TYPES[$inspection->inspection_type] ?? $inspection->inspection_type }}
                        </span>
                    </p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Inspection Date</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $inspection->inspection_date->format('M d, Y') }}</p>
                </div>

                @if ($inspection->inspection_type === 'incoming_material')
                    <div class="col-md-6 mb-4">
                        <p class="text-xs text-uppercase text-secondary mb-1">Purchase Order Item</p>
                        <p class="text-sm font-weight-bold mb-0">
                            @if ($inspection->purchaseOrderItem)
                                {{ $inspection->purchaseOrderItem->purchaseOrder->po_no ?? 'PO' }} - {{ $inspection->purchaseOrderItem->material->material_name ?? 'Item #'.$inspection->purchase_order_item_id }}
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6 mb-4">
                        <p class="text-xs text-uppercase text-secondary mb-1">Material</p>
                        <p class="text-sm font-weight-bold mb-0">
                            @if ($inspection->material)
                                {{ $inspection->material->material_name }} ({{ $inspection->material->material_code }})
                            @else
                                -
                            @endif
                        </p>
                    </div>
                @else
                    <div class="col-md-6 mb-4">
                        <p class="text-xs text-uppercase text-secondary mb-1">Production Order</p>
                        <p class="text-sm font-weight-bold mb-0">
                            @if ($inspection->productionOrder)
                                {{ $inspection->productionOrder->production_no ?? 'PRD #'.$inspection->production_order_id }}
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6 mb-4">
                        <p class="text-xs text-uppercase text-secondary mb-1">Product Variant</p>
                        <p class="text-sm font-weight-bold mb-0">
                            @if ($inspection->productVariant)
                                {{ $inspection->productVariant->sku }} - {{ $inspection->productVariant->product->product_name ?? 'Product' }}
                                ({{ $inspection->productVariant->size }}, {{ $inspection->productVariant->color }})
                            @else
                                -
                            @endif
                        </p>
                    </div>
                @endif

                <div class="col-md-3 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Inspected Qty</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $inspection->inspected_qty }}</p>
                </div>
                <div class="col-md-3 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Passed Qty</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $inspection->passed_qty }}</p>
                </div>
                <div class="col-md-3 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Rejected Qty</p>
                    <p class="text-sm font-weight-bold mb-0 {{ (float) $inspection->rejected_qty > 0 ? 'text-danger' : '' }}">{{ $inspection->rejected_qty }}</p>
                </div>
                <div class="col-md-3 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Rework Qty</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $inspection->rework_qty }}</p>
                </div>

                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Pass Rate</p>
                    <p class="text-sm font-weight-bold mb-0">{{ number_format($passRate, 1) }}%</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Inspected By</p>
                    <p class="text-sm font-weight-bold mb-0">{{ $inspection->inspector->name ?? '#'.$inspection->inspected_by }}</p>
                </div>

                <div class="col-12 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Defect Details</p>
                    <p class="text-sm font-weight-bold mb-0">{!! nl2br(e($inspection->defect_details)) ?: '-' !!}</p>
                </div>
                <div class="col-12 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Remarks</p>
                    <p class="text-sm font-weight-bold mb-0">{!! nl2br(e($inspection->remarks)) ?: '-' !!}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <p class="text-xs text-uppercase text-secondary mb-1">Last Updated</p>
                    <p class="text-sm font-weight-bold mb-0">{{ optional($inspection->updated_at)->format('M d, Y H:i') ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection