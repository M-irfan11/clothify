@extends('layout.master')

@section('content')
@php
    $typeBadge = [
        'incoming_material' => 'bg-gradient-info',
        'in_process'        => 'bg-gradient-warning',
        'final_product'     => 'bg-gradient-success',
    ];
@endphp
<div class="container-fluid py-4">
    <div class="mb-3">
        <h4 class="mb-1">Quality Inspections</h4>
        <p class="text-sm text-secondary mb-0">Track incoming, in-process and final product inspections.</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success text-white" role="alert">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between bg-white border-0 px-4 pt-4 pb-3">
            <div>
                <h6 class="mb-1">Quality Inspection List</h6>
                <p class="text-xs text-secondary mb-0">Review and manage inspection records</p>
            </div>
            <a href="{{ route('quality_inspections.create') }}" class="btn btn-sm bg-gradient-dark mb-0">
                <span class="material-symbols-rounded align-middle me-1" style="font-size: 18px;">add</span>
                Add Inspection
            </a>
        </div>
        <div class="card-body px-0 pb-2">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Inspection No</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Type</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Item</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Inspected</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Passed</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Rejected</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Rework</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($inspections as $inspection)
                            <tr>
                                <td>
                                    <a class="text-sm font-weight-bold mb-0" href="{{ route('quality_inspections.show', $inspection) }}">
                                        {{ $inspection->inspection_no }}
                                    </a>
                                </td>
                                <td>
                                    <span class="badge badge-sm {{ $typeBadge[$inspection->inspection_type] ?? 'bg-gradient-secondary' }}">
                                        {{ \App\Models\QualityInspection::TYPES[$inspection->inspection_type] ?? $inspection->inspection_type }}
                                    </span>
                                </td>
                                <td class="text-sm">
                                    @if ($inspection->material)
                                        {{ $inspection->material->material_name }}
                                    @elseif ($inspection->productVariant)
                                        {{ $inspection->productVariant->sku }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-sm">{{ $inspection->inspected_qty }}</td>
                                <td class="text-sm">{{ $inspection->passed_qty }}</td>
                                <td class="text-sm {{ (float) $inspection->rejected_qty > 0 ? 'text-danger font-weight-bold' : '' }}">{{ $inspection->rejected_qty }}</td>
                                <td class="text-sm">{{ $inspection->rework_qty }}</td>
                                <td class="text-sm">{{ $inspection->inspection_date->format('M d, Y') }}</td>
                                <td class="align-middle text-end">
                                    <a href="{{ route('quality_inspections.show', $inspection) }}" class="btn btn-sm btn-action-view mb-0 me-1">View</a>
                                    <a href="{{ route('quality_inspections.edit', $inspection) }}" class="btn btn-sm btn-action-edit mb-0 me-1">Edit</a>
                                    <form action="{{ route('quality_inspections.destroy', $inspection) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-action-delete mb-0" onclick="return confirm('Delete this quality inspection?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-secondary py-4">No quality inspections found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 pt-3">
                {{ $inspections->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection