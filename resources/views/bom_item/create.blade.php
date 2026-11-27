@extends('layout.master')

@section('head')
    <style>
        .bom-form-page { --bom-purple: #7041a5; --bom-purple-soft: #f0e9f8; --bom-ink: #242136; --bom-muted: #747187; background: #f8f7fb; min-height: calc(100vh - 1rem); }
        .bom-form-page .bom-form-topbar, .bom-form-page .bom-form-card, .bom-form-page .bom-help-card { background: #fff; border: 1px solid #e9e6ef; border-radius: 16px; box-shadow: 0 8px 24px rgba(42, 29, 65, .04); }
        .bom-form-page .bom-form-topbar { padding: 24px 28px; }
        .bom-form-page .bom-eyebrow { color: var(--bom-purple); font-size: 11px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; }
        .bom-form-page h1, .bom-form-page h5 { color: var(--bom-ink); }
        .bom-form-page h1 { font-size: clamp(1.35rem, 2.5vw, 1.85rem); font-weight: 700; letter-spacing: -.03em; }
        .bom-form-page .bom-meta { color: var(--bom-muted); font-size: 13px; }
        .bom-form-page .bom-form-card { padding: 28px; }
        .bom-form-page .bom-section-title { align-items: center; display: flex; gap: 12px; }
        .bom-form-page .bom-section-number { align-items: center; background: var(--bom-purple-soft); border-radius: 10px; color: var(--bom-purple); display: flex; font-size: 13px; font-weight: 700; height: 34px; justify-content: center; width: 34px; }
        .bom-form-page .form-label { color: #393349; font-size: 12px; font-weight: 700; margin-bottom: 8px; }
        .bom-form-page .form-control, .bom-form-page .form-select { border: 1px solid #e2dee9; border-radius: 9px; color: #3d384b; min-height: 45px; }
        .bom-form-page .form-control:focus, .bom-form-page .form-select:focus { border-color: var(--bom-purple); box-shadow: 0 0 0 .2rem rgba(112, 65, 165, .12); }
        .bom-form-page .field-hint { color: var(--bom-muted); font-size: 11px; margin-top: 7px; }
        .bom-form-page .bom-primary { box-shadow: 0 5px 12px rgba(112, 65, 165, .2); }
        .bom-form-page .bom-help-card { padding: 22px; }
        .bom-form-page .bom-help-icon { align-items: center; background: var(--bom-purple-soft); border-radius: 10px; color: var(--bom-purple); display: flex; height: 36px; justify-content: center; width: 36px; }
        @media (max-width: 767.98px) { .bom-form-page .bom-form-topbar, .bom-form-page .bom-form-card { padding: 20px; } }
    </style>
@endsection

@section('content')
    <div class="bom-form-page container-fluid px-3 px-lg-4 py-4">
        <div class="bom-form-topbar mb-4">
            <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                <div>
                    <div class="bom-eyebrow mb-2">Bill of materials / New item</div>
                    <h1 class="mb-2">Add BOM item</h1>
                    <p class="bom-meta mb-0">Define the material quantity and wastage required for a product variant.</p>
                </div>
                <a href="{{ route('bom_items.index') }}" class="btn btn-outline-dark mb-0"><span class="material-symbols-rounded align-middle me-1" style="font-size: 17px;">arrow_back</span>Back to library</a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-xl-8">
                <div class="bom-form-card">
                    <div class="bom-section-title mb-4"><span class="bom-section-number">01</span><div><h5 class="mb-1">Material requirement</h5><p class="bom-meta mb-0">Connect a material to the product variant.</p></div></div>
                    <form action="{{ route('bom_items.store') }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="product_variant_id" class="form-label">Product variant <span class="text-danger">*</span></label>
                                <select id="product_variant_id" name="product_variant_id" class="form-select @error('product_variant_id') is-invalid @enderror" required>
                                    <option value="">Select product variant</option>
                                    @foreach ($variants as $variant)
                                        <option value="{{ $variant->id }}" @selected((int) old('product_variant_id') === (int) $variant->id)>{{ $variant->sku ?? '#'.$variant->id }}{{ $variant->color ? ' · '.$variant->color : '' }}{{ $variant->size ? ' · '.$variant->size : '' }}</option>
                                    @endforeach
                                </select>
                                <div class="field-hint">Choose the product version this material belongs to.</div>
                                @error('product_variant_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="material_id" class="form-label">Material <span class="text-danger">*</span></label>
                                <select id="material_id" name="material_id" class="form-select @error('material_id') is-invalid @enderror" required>
                                    <option value="">Select material</option>
                                    @foreach ($materials as $material)
                                        <option value="{{ $material->id }}" @selected((int) old('material_id') === (int) $material->id)>{{ $material->material_name ?? '#'.$material->id }}{{ $material->material_code ? ' · '.$material->material_code : '' }}</option>
                                    @endforeach
                                </select>
                                <div class="field-hint">Select the fabric, trim or packaging material.</div>
                                @error('material_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="quantity_per_unit" class="form-label">Quantity per unit <span class="text-danger">*</span></label>
                                <input id="quantity_per_unit" name="quantity_per_unit" type="number" min="0.0001" step="0.0001" value="{{ old('quantity_per_unit') }}" class="form-control @error('quantity_per_unit') is-invalid @enderror" placeholder="e.g. 0.2500" required>
                                <div class="field-hint">The quantity consumed to make one finished unit.</div>
                                @error('quantity_per_unit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="wastage_percent" class="form-label">Wastage percentage</label>
                                <div class="input-group"><input id="wastage_percent" name="wastage_percent" type="number" min="0" max="100" step="0.01" value="{{ old('wastage_percent', 0) }}" class="form-control @error('wastage_percent') is-invalid @enderror" placeholder="0.00"><span class="input-group-text">%</span></div>
                                <div class="field-hint">Add the expected production loss, from 0 to 100.</div>
                                @error('wastage_percent') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="border-top mt-4 pt-4 d-flex flex-wrap gap-2"><button type="submit" class="btn bom-primary mb-0"><span class="material-symbols-rounded align-middle me-1" style="font-size: 17px;">check</span>Save BOM item</button><a href="{{ route('bom_items.index') }}" class="btn btn-outline-secondary mb-0">Cancel</a></div>
                    </form>
                </div>
            </div>
            <div class="col-xl-4"><div class="bom-help-card"><div class="d-flex gap-3 align-items-start"><div class="bom-help-icon"><span class="material-symbols-rounded">lightbulb</span></div><div><h5 class="mb-2">Before you save</h5><p class="bom-meta mb-0">Make sure the selected material is not already linked to this product variant. Each variant can contain a material only once.</p></div></div></div></div>
        </div>
    </div>
@endsection
