@extends('layout.master')

@section('head')
    <style>
        .recipe-page { background: #f8f7fb; min-height: calc(100vh - 1rem); }
        .recipe-page .recipe-topbar, .recipe-page .recipe-card { background: #fff; border: 1px solid #e9e6ef; border-radius: 16px; box-shadow: 0 8px 24px rgba(42, 29, 65, .04); }
        .recipe-page .recipe-topbar { padding: 24px 28px; }
        .recipe-page h1, .recipe-page h5 { color: #242136; }
        .recipe-page h1 { font-size: clamp(1.35rem, 2.5vw, 1.85rem); font-weight: 700; letter-spacing: -.03em; }
        .recipe-page .recipe-meta { color: #747187; font-size: 13px; }
        .recipe-page .recipe-card { padding: 28px; }
        .recipe-page .form-label { color: #393349; font-size: 12px; font-weight: 700; margin-bottom: 8px; }
        .recipe-page .form-control, .recipe-page .form-select { border: 1px solid #e2dee9; border-radius: 9px; color: #3d384b; min-height: 45px; }
        .recipe-page .form-control:focus, .recipe-page .form-select:focus { border-color: #7041a5; box-shadow: 0 0 0 .2rem rgba(112, 65, 165, .12); }
        .recipe-page .ingredient-row { align-items: start; display: grid; gap: 8px; grid-template-columns: minmax(220px, 1fr) minmax(130px, .45fr) minmax(130px, .45fr) 42px; }
        .recipe-page .ingredient-row + .ingredient-row { margin-top: 10px; }
        .recipe-page .remove-material { align-items: center; background: #fff5f5; border: 1px solid #f5d4d4; border-radius: 9px; color: #dc3545; display: flex; height: 45px; justify-content: center; width: 42px; }
        .recipe-page .remove-material:hover { background: #dc3545; color: #fff; }
        .recipe-page .add-material { color: #7041a5; font-weight: 600; }
        .recipe-page .recipe-primary { background: #7041a5; border-color: #7041a5; box-shadow: 0 5px 12px rgba(112, 65, 165, .2); }
        @media (max-width: 767.98px) { .recipe-page .recipe-topbar, .recipe-page .recipe-card { padding: 20px; } .recipe-page .ingredient-row { grid-template-columns: 1fr; } .recipe-page .remove-material { width: 100%; } }
    </style>
@endsection

@section('content')
    @php
        $oldMaterials = old('materials', [['material_id' => '', 'quantity_per_unit' => '', 'wastage_percent' => '0']]);
    @endphp

    <div class="recipe-page container-fluid px-3 px-lg-4 py-4">
        <div class="recipe-topbar mb-4">
            <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                <div>
                    <div class="text-uppercase mb-2" style="color:#7041a5;font-size:11px;font-weight:700;letter-spacing:.12em;">Bill of materials / New recipe</div>
                    <h1 class="mb-2">Add recipe</h1>
                    <p class="recipe-meta mb-0">Add all materials needed to make one product variant.</p>
                </div>
                <a href="{{ route('bom_items.index') }}" class="btn btn-outline-dark mb-0">Back to BOM items</a>
            </div>
        </div>

        <div class="recipe-card">
            <h5 class="mb-1">Recipe details</h5>
            <p class="recipe-meta border-bottom pb-4 mb-4">Choose a product and list each material with its required quantity.</p>

            <form action="{{ route('bom_items.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="product_variant_id" class="form-label">Product variant <span class="text-danger">*</span></label>
                    <select id="product_variant_id" name="product_variant_id" class="form-select @error('product_variant_id') is-invalid @enderror" required>
                        <option value="">Choose product variant</option>
                        @foreach ($variants as $variant)
                            <option value="{{ $variant->id }}" @selected((int) old('product_variant_id') === (int) $variant->id)>
                                {{ $variant->sku ?? '#'.$variant->id }}{{ $variant->product?->product_name ? ' — '.$variant->product->product_name : '' }}{{ $variant->color ? ' · '.$variant->color : '' }}{{ $variant->size ? ' · '.$variant->size : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_variant_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <label class="form-label mb-0">Materials <span class="text-danger">*</span></label>
                        <div class="recipe-meta">Quantity needed to make one item</div>
                    </div>
                    <span class="recipe-meta" id="material-count">{{ count($oldMaterials) }} material{{ count($oldMaterials) === 1 ? '' : 's' }}</span>
                </div>

                @error('materials') <div class="alert alert-danger py-2">{{ $message }}</div> @enderror
                <div id="materials-list">
                    @foreach ($oldMaterials as $index => $oldMaterial)
                        <div class="ingredient-row" data-material-row>
                            <div>
                                <select name="materials[{{ $index }}][material_id]" class="form-select @error('materials.'.$index.'.material_id') is-invalid @enderror" required>
                                    <option value="">Choose material</option>
                                    @foreach ($materials as $material)
                                        <option value="{{ $material->id }}" @selected((int) ($oldMaterial['material_id'] ?? '') === (int) $material->id)>{{ $material->material_name }}{{ $material->material_code ? ' — '.$material->material_code : '' }}</option>
                                    @endforeach
                                </select>
                                @error('materials.'.$index.'.material_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div>
                                <input name="materials[{{ $index }}][quantity_per_unit]" type="number" min="0.0001" step="0.0001" value="{{ $oldMaterial['quantity_per_unit'] ?? '' }}" class="form-control @error('materials.'.$index.'.quantity_per_unit') is-invalid @enderror" placeholder="Quantity" required>
                                @error('materials.'.$index.'.quantity_per_unit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div>
                                <div class="input-group"><input name="materials[{{ $index }}][wastage_percent]" type="number" min="0" max="100" step="0.01" value="{{ $oldMaterial['wastage_percent'] ?? '0' }}" class="form-control @error('materials.'.$index.'.wastage_percent') is-invalid @enderror" placeholder="Wastage"><span class="input-group-text">%</span></div>
                                @error('materials.'.$index.'.wastage_percent') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                            <button type="button" class="remove-material" aria-label="Remove material"><span class="material-symbols-rounded" style="font-size:18px;">delete</span></button>
                        </div>
                    @endforeach
                </div>

                <button type="button" id="add-material" class="btn btn-light add-material mt-3 mb-0">+ Add material</button>
                <div class="border-top mt-4 pt-4 d-flex flex-wrap gap-2">
                    <button type="submit" class="btn recipe-primary text-white mb-0">✓ Create recipe</button>
                    <a href="{{ route('bom_items.index') }}" class="btn btn-outline-secondary mb-0">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <template id="material-row-template">
        <div class="ingredient-row" data-material-row>
            <div><select name="materials[__INDEX__][material_id]" class="form-select" required><option value="">Choose material</option>@foreach ($materials as $material)<option value="{{ $material->id }}">{{ $material->material_name }}{{ $material->material_code ? ' — '.$material->material_code : '' }}</option>@endforeach</select></div>
            <div><input name="materials[__INDEX__][quantity_per_unit]" type="number" min="0.0001" step="0.0001" class="form-control" placeholder="Quantity" required></div>
            <div><div class="input-group"><input name="materials[__INDEX__][wastage_percent]" type="number" min="0" max="100" step="0.01" value="0" class="form-control" placeholder="Wastage"><span class="input-group-text">%</span></div></div>
            <button type="button" class="remove-material" aria-label="Remove material"><span class="material-symbols-rounded" style="font-size:18px;">delete</span></button>
        </div>
    </template>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const list = document.getElementById('materials-list');
            const template = document.getElementById('material-row-template');
            const count = document.getElementById('material-count');
            let nextIndex = {{ count($oldMaterials) }};

            const updateCount = () => {
                const total = list.querySelectorAll('[data-material-row]').length;
                count.textContent = `${total} material${total === 1 ? '' : 's'}`;
            };

            document.getElementById('add-material').addEventListener('click', () => {
                list.insertAdjacentHTML('beforeend', template.innerHTML.replaceAll('__INDEX__', nextIndex++));
                updateCount();
            });

            list.addEventListener('click', (event) => {
                const removeButton = event.target.closest('.remove-material');

                if (!removeButton) {
                    return;
                }

                const rows = list.querySelectorAll('[data-material-row]');

                if (rows.length > 1) {
                    removeButton.closest('[data-material-row]').remove();
                    updateCount();
                }
            });
        });
    </script>
@endsection
