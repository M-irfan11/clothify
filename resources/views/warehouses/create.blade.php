@extends('layout.master')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Add Warehouse</h4>
            <p class="text-sm text-secondary mb-0">Enter the warehouse details below.</p>
        </div>
        <a href="{{ route('warehouses.index') }}" class="btn btn-outline-dark mb-0">Back to Warehouses</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('warehouses.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="warehouse_name" class="form-label">Warehouse Name</label>
                        <input id="warehouse_name" name="warehouse_name" type="text" maxlength="150" value="{{ old('warehouse_name') }}" class="form-control @error('warehouse_name') is-invalid @enderror" required>
                        @error('warehouse_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="warehouse_code" class="form-label">Warehouse Code</label>
                        <input id="warehouse_code" name="warehouse_code" type="text" maxlength="20" value="{{ old('warehouse_code') }}" class="form-control @error('warehouse_code') is-invalid @enderror" required>
                        @error('warehouse_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="warehouse_type" class="form-label">Warehouse Type</label>
                        <select id="warehouse_type" name="warehouse_type" class="form-select @error('warehouse_type') is-invalid @enderror" required>
                            <option value="">Select type</option>
                            @foreach (\App\Models\Warehouse::TYPES as $value => $label)
                                <option value="{{ $value }}" @selected(old('warehouse_type') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('warehouse_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                            @foreach (\App\Models\Warehouse::STATUSES as $value => $label)
                                <option value="{{ $value }}" @selected(old('status', 'active') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Phone <span class="text-secondary">(optional)</span></label>
                        <input id="phone" name="phone" type="tel" maxlength="20" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea id="address" name="address" rows="3" maxlength="255" class="form-control @error('address') is-invalid @enderror" required>{{ old('address') }}</textarea>
                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <button type="submit" class="btn bg-gradient-dark mb-0">Save Warehouse</button>
                <a href="{{ route('warehouses.index') }}" class="btn btn-outline-secondary mb-0">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
