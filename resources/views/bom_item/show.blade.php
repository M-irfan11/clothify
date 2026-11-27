@extends('layout.master')

@section('head')
    <style>
        .bom-view-page { --bom-purple: #7041a5; --bom-purple-soft: #f0e9f8; --bom-ink: #242136; --bom-muted: #747187; background: #f8f7fb; min-height: calc(100vh - 1rem); }
        .bom-view-page .bom-view-topbar, .bom-view-page .bom-view-card, .bom-view-page .bom-side-card { background: #fff; border: 1px solid #e9e6ef; border-radius: 16px; box-shadow: 0 8px 24px rgba(42, 29, 65, .04); }
        .bom-view-page .bom-view-topbar { padding: 24px 28px; }
        .bom-view-page .bom-eyebrow { color: var(--bom-purple); font-size: 11px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; }
        .bom-view-page h1, .bom-view-page h5 { color: var(--bom-ink); }
        .bom-view-page h1 { font-size: clamp(1.35rem, 2.5vw, 1.85rem); font-weight: 700; letter-spacing: -.03em; }
        .bom-view-page .bom-meta { color: var(--bom-muted); font-size: 13px; }
        .bom-view-page .bom-view-card { padding: 28px; }
        .bom-view-page .bom-section-title { align-items: center; display: flex; gap: 12px; }
        .bom-view-page .bom-section-icon { align-items: center; background: var(--bom-purple-soft); border-radius: 10px; color: var(--bom-purple); display: flex; height: 36px; justify-content: center; width: 36px; }
        .bom-view-page .bom-field { border-bottom: 1px solid #f0edf4; padding: 0 0 18px; }
        .bom-view-page .bom-field-label { color: var(--bom-muted); font-size: 10px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; }
        .bom-view-page .bom-field-value { color: var(--bom-ink); font-size: 15px; font-weight: 700; }
        .bom-view-page .bom-chip { background: var(--bom-purple-soft); border-radius: 999px; color: var(--bom-purple); display: inline-block; font-size: 12px; font-weight: 700; padding: 6px 11px; }
        .bom-view-page .bom-side-card { padding: 22px; }
        .bom-view-page .bom-side-icon { align-items: center; background: #fff3d9; border-radius: 10px; color: #966500; display: flex; height: 36px; justify-content: center; width: 36px; }
        .bom-view-page .bom-primary { box-shadow: 0 5px 12px rgba(112, 65, 165, .2); }
        @media (max-width: 767.98px) { .bom-view-page .bom-view-topbar, .bom-view-page .bom-view-card { padding: 20px; } }
    </style>
@endsection

@section('content')
    <div class="bom-view-page container-fluid px-3 px-lg-4 py-4">
        @if (session('success'))
            <div class="alert alert-success text-white" role="alert">{{ session('success') }}</div>
        @endif
        <div class="bom-view-topbar mb-4">
            <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                <div><div class="bom-eyebrow mb-2">Bill of materials / Item details</div><h1 class="mb-2">BOM item #{{ $bomItem->id }}</h1><p class="bom-meta mb-0">Review the material requirement and production allowance.</p></div>
                <div class="d-flex flex-wrap gap-2"><a href="{{ route('bom_items.index') }}" class="btn btn-outline-dark mb-0"><span class="material-symbols-rounded align-middle me-1" style="font-size: 17px;">arrow_back</span>Back to library</a><a href="{{ route('bom_items.edit', $bomItem) }}" class="btn bom-primary mb-0"><span class="material-symbols-rounded align-middle me-1" style="font-size: 17px;">edit</span>Edit item</a></div>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-xl-8">
                <div class="bom-view-card">
                    <div class="bom-section-title mb-4"><div class="bom-section-icon"><span class="material-symbols-rounded">description</span></div><div><h5 class="mb-1">Requirement overview</h5><p class="bom-meta mb-0">The current configuration for this BOM item.</p></div></div>
                    <div class="row g-4">
                        <div class="col-md-6"><div class="bom-field"><div class="bom-field-label mb-2">Product variant</div><div class="bom-field-value">{{ $bomItem->productVariant->sku ?? '#'.$bomItem->product_variant_id }}</div>@if ($bomItem->productVariant)<div class="bom-meta mt-1">{{ $bomItem->productVariant->color ?? 'Standard' }} · {{ $bomItem->productVariant->size ?? 'One size' }}</div>@endif</div></div>
                        <div class="col-md-6"><div class="bom-field"><div class="bom-field-label mb-2">Material</div><div class="bom-field-value">{{ $bomItem->material->material_name ?? '#'.$bomItem->material_id }}</div><div class="bom-meta mt-1">{{ $bomItem->material->material_code ?? 'Material reference' }}</div></div></div>
                        <div class="col-md-6"><div class="bom-field"><div class="bom-field-label mb-2">Quantity per unit</div><div class="bom-field-value">{{ $bomItem->quantity_per_unit }}</div><div class="bom-meta mt-1">Consumption for one finished unit</div></div></div>
                        <div class="col-md-6"><div class="bom-field"><div class="bom-field-label mb-2">Wastage percentage</div><div class="bom-chip">{{ $bomItem->wastage_percent }}%</div><div class="bom-meta mt-2">Expected production loss</div></div></div>
                    </div>
                    <div class="border-top mt-4 pt-4"><a href="{{ route('bom_items.edit', $bomItem) }}" class="btn bom-primary mb-0"><span class="material-symbols-rounded align-middle me-1" style="font-size: 17px;">edit</span>Update requirement</a></div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="bom-side-card mb-4"><div class="d-flex gap-3 align-items-start"><div class="bom-side-icon"><span class="material-symbols-rounded">history</span></div><div><h5 class="mb-2">Record history</h5><div class="bom-meta">Created {{ $bomItem->created_at?->format('M d, Y · h:i A') }}</div><div class="bom-meta mt-1">Updated {{ $bomItem->updated_at?->format('M d, Y · h:i A') }}</div></div></div></div>
                <div class="bom-side-card"><h5 class="mb-2">Need to change this?</h5><p class="bom-meta mb-3">Edit the quantity or wastage values when your production specification changes.</p><a href="{{ route('bom_items.edit', $bomItem) }}" class="btn btn-outline-dark btn-sm mb-0">Open edit form</a></div>
            </div>
        </div>
    </div>
@endsection
