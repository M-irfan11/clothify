@extends('layout.master')

@section('content')
<div class="container-fluid materials-page py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Edit Material</h4>
            <p class="text-sm text-secondary mb-0">Update {{ $material->material_name }}.</p>
        </div>
        <a href="{{ route('materials.show', $material) }}" class="btn btn-material-outline mb-0">View Material</a>
    </div>

    <div class="card materials-card">
        <div class="card-body">
            <form action="{{ route('materials.update', $material) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="material_code" class="form-label">Material Code</label>
                        <input id="material_code" name="material_code" type="text" maxlength="30" value="{{ old('material_code', $material->material_code) }}" class="form-control @error('material_code') is-invalid @enderror" required>
                        @error('material_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="material_name" class="form-label">Material Name</label>
                        <input id="material_name" name="material_name" type="text" maxlength="150" value="{{ old('material_name', $material->material_name) }}" class="form-control @error('material_name') is-invalid @enderror" required>
                        @error('material_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="supplier_id" class="form-label">Supplier <span class="text-secondary">(optional)</span></label>
                        <select id="supplier_id" name="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror">
                            <option value="">No supplier assigned</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" @selected((string) old('supplier_id', $material->supplier_id) === (string) $supplier->id)>
                                    {{ $supplier->supplier_code }} — {{ $supplier->company_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select id="category" name="category" class="form-select @error('category') is-invalid @enderror" required>
                            @foreach (\App\Models\Material::CATEGORIES as $value => $label)
                                <option value="{{ $value }}" @selected(old('category', $material->category) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="unit" class="form-label">Unit</label>
                        <select id="unit" name="unit" class="form-select @error('unit') is-invalid @enderror" required>
                            @foreach (\App\Models\Material::UNITS as $value => $label)
                                <option value="{{ $value }}" @selected(old('unit', $material->unit) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('unit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="unit_cost" class="form-label">Unit Cost</label>
                        <input id="unit_cost" name="unit_cost" type="number" min="0" max="9999999999999999.99" step="0.01" value="{{ old('unit_cost', $material->unit_cost) }}" class="form-control @error('unit_cost') is-invalid @enderror" required>
                        @error('unit_cost') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="reorder_level" class="form-label">Reorder Level</label>
                        <input id="reorder_level" name="reorder_level" type="number" min="0" max="999999999999.99" step="0.01" value="{{ old('reorder_level', $material->reorder_level) }}" class="form-control @error('reorder_level') is-invalid @enderror" required>
                        @error('reorder_level') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="safety_stock" class="form-label">Safety Stock</label>
                        <input id="safety_stock" name="safety_stock" type="number" min="0" max="999999999999.99" step="0.01" value="{{ old('safety_stock', $material->safety_stock) }}" class="form-control @error('safety_stock') is-invalid @enderror" required>
                        @error('safety_stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                            @foreach (\App\Models\Material::STATUSES as $value => $label)
                                <option value="{{ $value }}" @selected(old('status', $material->status) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-material-primary mb-0">Update Material</button>
                <a href="{{ route('materials.index') }}" class="btn btn-material-outline mb-0">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
