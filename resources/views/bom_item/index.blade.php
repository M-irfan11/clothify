@extends('layout.master')

@section('head')
    <style>
        .bom-page { --bom-purple: #7041a5; --bom-purple-soft: #f0e9f8; --bom-ink: #242136; --bom-muted: #747187; background: #f8f7fb; min-height: calc(100vh - 1rem); }
        .bom-page .bom-topbar, .bom-page .bom-card, .bom-page .bom-stat { border: 1px solid #e9e6ef; border-radius: 16px; box-shadow: 0 8px 24px rgba(42, 29, 65, .04); }
        .bom-page .bom-topbar { background: #fff; padding: 24px 28px; }
        .bom-page .bom-eyebrow { color: var(--bom-purple); font-size: 11px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; }
        .bom-page h1, .bom-page h5, .bom-page .bom-value { color: var(--bom-ink); }
        .bom-page h1 { font-size: clamp(1.35rem, 2.5vw, 1.85rem); font-weight: 700; letter-spacing: -.03em; }
        .bom-page .bom-meta { color: var(--bom-muted); font-size: 13px; }
        .bom-page .bom-status { background: #fff3d9; border-radius: 999px; color: #966500; font-size: 11px; font-weight: 700; padding: 5px 10px; }
        .bom-page .bom-primary { background: var(--bom-purple); border: 0; color: #fff; box-shadow: 0 5px 12px rgba(112, 65, 165, .2); }
        .bom-page .bom-primary:hover { background: #5d318f; color: #fff; }
        .bom-page .bom-stat { background: #fff; min-height: 112px; padding: 18px 20px; }
        .bom-page .bom-stat-icon { align-items: center; background: var(--bom-purple-soft); border-radius: 11px; color: var(--bom-purple); display: flex; height: 38px; justify-content: center; width: 38px; }
        .bom-page .bom-label { color: var(--bom-muted); font-size: 11px; font-weight: 600; letter-spacing: .04em; text-transform: uppercase; }
        .bom-page .bom-value { font-size: 22px; font-weight: 700; }
        .bom-page .bom-card { background: #fff; overflow: hidden; }
        .bom-page .bom-card-header { align-items: center; border-bottom: 1px solid #eeeaf3; display: flex; justify-content: space-between; padding: 20px 24px; }
        .bom-page .bom-table-wrap { overflow-x: auto; }
        .bom-page .bom-table { min-width: 760px; }
        .bom-page .bom-table thead th { background: #fbfaff; border-bottom: 1px solid #eeeaf3; color: var(--bom-muted); font-size: 10px; font-weight: 700; letter-spacing: .08em; padding: 14px 20px; text-transform: uppercase; white-space: nowrap; }
        .bom-page .bom-table tbody td { border-bottom: 1px solid #f0edf4; color: #4f4a5d; font-size: 13px; padding: 16px 20px; vertical-align: middle; }
        .bom-page .bom-table tbody tr:last-child td { border-bottom: 0; }
        .bom-page .bom-table tbody tr:hover { background: #fcfaff; }
        .bom-page .material-name { color: var(--bom-ink); font-weight: 700; }
        .bom-page .material-code { color: var(--bom-muted); font-size: 11px; }
        .bom-page .bom-chip { background: #f4f1f8; border-radius: 7px; color: #5f5870; display: inline-block; font-size: 12px; padding: 6px 10px; }
        .bom-page .bom-action { align-items: center; background: transparent; border: 1px solid #e5e0eb; border-radius: 8px; color: #5e566d; display: inline-flex; height: 31px; justify-content: center; padding: 0 9px; }
        .bom-page .bom-action:hover { background: var(--bom-purple-soft); color: var(--bom-purple); }
        .bom-page .bom-empty { color: var(--bom-muted); padding: 48px 20px !important; }
        @media (max-width: 767.98px) { .bom-page .bom-topbar { padding: 20px; } .bom-page .bom-card-header { align-items: flex-start; flex-direction: column; gap: 14px; } }
    </style>
@endsection

@section('content')
    <div class="bom-page container-fluid px-3 px-lg-4 py-4">
        @if (session('success'))
            <div class="alert alert-success text-white" role="alert">{{ session('success') }}</div>
        @endif

        <div class="bom-topbar mb-4">
            <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                <div>
                    <div class="bom-eyebrow mb-2">Bill of materials</div>
                    <div class="d-flex align-items-center flex-wrap gap-2"><h1 class="mb-0">BOM Item Library</h1><span class="bom-status">Active workspace</span></div>
                    <p class="bom-meta mb-0 mt-2">Manage material requirements, quantities and wastage for every product variant.</p>
                </div>
                <a href="{{ route('bom_items.create') }}" class="btn bom-primary mb-0 px-3"><span class="material-symbols-rounded align-middle me-1" style="font-size: 18px;">add</span>Add BOM item</a>
            </div>
        </div>

        @php
            $bomItemCount = $bomItems->total();
            $variantCount = $bomItems->getCollection()->pluck('product_variant_id')->unique()->count();
            $materialCount = $bomItems->getCollection()->pluck('material_id')->unique()->count();
            $averageWastage = $bomItems->getCollection()->avg('wastage_percent');
        @endphp

        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-xl-3"><div class="bom-stat d-flex align-items-center gap-3"><div class="bom-stat-icon"><span class="material-symbols-rounded">list_alt</span></div><div><div class="bom-label">Total BOM items</div><div class="bom-value">{{ number_format($bomItemCount) }}</div></div></div></div>
            <div class="col-sm-6 col-xl-3"><div class="bom-stat d-flex align-items-center gap-3"><div class="bom-stat-icon"><span class="material-symbols-rounded">inventory_2</span></div><div><div class="bom-label">Variants on page</div><div class="bom-value">{{ number_format($variantCount) }}</div></div></div></div>
            <div class="col-sm-6 col-xl-3"><div class="bom-stat d-flex align-items-center gap-3"><div class="bom-stat-icon"><span class="material-symbols-rounded">category</span></div><div><div class="bom-label">Materials on page</div><div class="bom-value">{{ number_format($materialCount) }}</div></div></div></div>
            <div class="col-sm-6 col-xl-3"><div class="bom-stat d-flex align-items-center gap-3"><div class="bom-stat-icon"><span class="material-symbols-rounded">percent</span></div><div><div class="bom-label">Avg. wastage</div><div class="bom-value">{{ number_format((float) $averageWastage, 2) }}%</div></div></div></div>
        </div>

        <div class="bom-card">
            <div class="bom-card-header"><div><h5 class="mb-1">Material requirements</h5><p class="bom-meta mb-0">{{ $bomItems->total() }} records across your product variants</p></div><div class="bom-meta">Page {{ $bomItems->currentPage() }} of {{ $bomItems->lastPage() }}</div></div>
            <div class="bom-table-wrap">
                <table class="table bom-table align-items-center mb-0">
                    <thead><tr><th>Product variant</th><th>Material</th><th>Category / unit</th><th>Qty / unit</th><th>Wastage</th><th class="text-end">Actions</th></tr></thead>
                    <tbody>
                        @forelse ($bomItems as $bomItem)
                            <tr>
                                <td><a class="material-name d-block" href="{{ route('bom_items.show', $bomItem) }}">{{ $bomItem->productVariant->sku ?? '#'.$bomItem->product_variant_id }}</a>@if ($bomItem->productVariant)<span class="material-code">{{ $bomItem->productVariant->color ?? 'Standard' }} · {{ $bomItem->productVariant->size ?? 'One size' }}</span>@endif</td>
                                <td><span class="material-name d-block">{{ $bomItem->material->material_name ?? '#'.$bomItem->material_id }}</span><span class="material-code">{{ $bomItem->material->material_code ?? 'Material reference' }}</span></td>
                                <td><span class="bom-chip">{{ $bomItem->material->category_label ?? 'Uncategorised' }}</span><span class="material-code d-block mt-1">{{ $bomItem->material->unit ?? '—' }}</span></td>
                                <td class="font-weight-bold">{{ $bomItem->quantity_per_unit }}</td><td><span class="bom-chip">{{ $bomItem->wastage_percent }}%</span></td>
                                <td class="text-end text-nowrap"><a href="{{ route('bom_items.show', $bomItem) }}" class="bom-action me-1" title="View" aria-label="View BOM item"><span class="material-symbols-rounded" style="font-size: 17px;">visibility</span></a><a href="{{ route('bom_items.edit', $bomItem) }}" class="bom-action me-1" title="Edit" aria-label="Edit BOM item"><span class="material-symbols-rounded" style="font-size: 17px;">edit</span></a><form action="{{ route('bom_items.destroy', $bomItem) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button type="submit" class="bom-action" title="Delete" aria-label="Delete BOM item" onclick="return confirm('Delete this BOM item?')"><span class="material-symbols-rounded" style="font-size: 17px;">delete</span></button></form></td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="bom-empty text-center">No BOM items found. Add your first material requirement to get started.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($bomItems->hasPages())<div class="border-top px-4 py-3">{{ $bomItems->links('pagination::bootstrap-5') }}</div>@endif
        </div>
    </div>
@endsection
