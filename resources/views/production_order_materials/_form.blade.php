@php($isEdit = isset($item))
<form action="{{ $isEdit ? route('production-orders.materials.update', [$order, $item]) : route('production-orders.materials.store', $order) }}" method="POST">
    @csrf
    @if ($isEdit) @method('PUT') @endif
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="material_id" class="form-label">Material <span class="text-danger">*</span></label>
            <select id="material_id" name="material_id" class="form-select @error('material_id') is-invalid @enderror" required>
                <option value="">Select material</option>
                @foreach ($materials as $material)
                    <option value="{{ $material->id }}" @selected((int) old('material_id', $item->material_id ?? '') === (int) $material->id)>
                        {{ $material->material_name }} ({{ $material->material_code }}) — {{ $material->unit_label }}
                    </option>
                @endforeach
            </select>
            @error('material_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label for="planned_qty" class="form-label">Planned Quantity <span class="text-danger">*</span></label>
            <input id="planned_qty" name="planned_qty" type="number" min="0" step="0.001" value="{{ old('planned_qty', $item->planned_qty ?? '0.000') }}" class="form-control @error('planned_qty') is-invalid @enderror" required>
            @error('planned_qty') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label for="issued_qty" class="form-label">Issued Quantity</label>
            <input id="issued_qty" name="issued_qty" type="number" min="0" step="0.001" value="{{ old('issued_qty', $item->issued_qty ?? '0.000') }}" class="form-control @error('issued_qty') is-invalid @enderror">
            @error('issued_qty') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label for="used_qty" class="form-label">Used Quantity</label>
            <input id="used_qty" name="used_qty" type="number" min="0" step="0.001" value="{{ old('used_qty', $item->used_qty ?? '0.000') }}" class="form-control @error('used_qty') is-invalid @enderror">
            @error('used_qty') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label for="return_qty" class="form-label">Returned Quantity</label>
            <input id="return_qty" name="return_qty" type="number" min="0" step="0.001" value="{{ old('return_qty', $item->return_qty ?? '0.000') }}" class="form-control @error('return_qty') is-invalid @enderror">
            @error('return_qty') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label for="wastage_qty" class="form-label">Wastage Quantity</label>
            <input id="wastage_qty" name="wastage_qty" type="number" min="0" step="0.001" value="{{ old('wastage_qty', $item->wastage_qty ?? '0.000') }}" class="form-control @error('wastage_qty') is-invalid @enderror">
            @error('wastage_qty') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
    <div class="d-flex gap-2 pt-2">
        <button type="submit" class="btn {{ $isEdit ? 'btn-action-edit' : 'bg-gradient-dark' }} mb-0">{{ $isEdit ? 'Update Material' : 'Save Material' }}</button>
        <a href="{{ route('production-orders.materials.index', $order) }}" class="btn btn-outline-secondary mb-0">Cancel</a>
    </div>
</form>
