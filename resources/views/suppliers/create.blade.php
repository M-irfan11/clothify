@extends('layout.master')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Add Supplier</h4>
            <p class="text-sm text-secondary mb-0">Enter the supplier details below.</p>
        </div>
        <a href="{{ route('suppliers.index') }}" class="btn btn-outline-dark mb-0">Back to Suppliers</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('suppliers.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="supplier_code" class="form-label">Supplier Code</label>
                        <input id="supplier_code" name="supplier_code" type="text" maxlength="30" value="{{ old('supplier_code') }}" class="form-control @error('supplier_code') is-invalid @enderror" required>
                        @error('supplier_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="company_name" class="form-label">Company Name</label>
                        <input id="company_name" name="company_name" type="text" maxlength="150" value="{{ old('company_name') }}" class="form-control @error('company_name') is-invalid @enderror" required>
                        @error('company_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="contact_person" class="form-label">Contact Person</label>
                        <input id="contact_person" name="contact_person" type="text" maxlength="100" value="{{ old('contact_person') }}" class="form-control @error('contact_person') is-invalid @enderror" required>
                        @error('contact_person') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input id="phone" name="phone" type="tel" maxlength="20" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" required>
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email <span class="text-secondary">(optional)</span></label>
                        <input id="email" name="email" type="email" maxlength="150" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="supplier_type" class="form-label">Supplier Type</label>
                        <select id="supplier_type" name="supplier_type" class="form-select @error('supplier_type') is-invalid @enderror" required>
                            <option value="">Select type</option>
                            @foreach (\App\Models\Supplier::TYPES as $value => $label)
                                <option value="{{ $value }}" @selected(old('supplier_type') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('supplier_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="payment_terms_days" class="form-label">Payment Terms (days)</label>
                        <input id="payment_terms_days" name="payment_terms_days" type="number" min="0" step="1" value="{{ old('payment_terms_days', 30) }}" class="form-control @error('payment_terms_days') is-invalid @enderror" required>
                        @error('payment_terms_days') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lead_time_days" class="form-label">Lead Time (days)</label>
                        <input id="lead_time_days" name="lead_time_days" type="number" min="0" step="1" value="{{ old('lead_time_days', 7) }}" class="form-control @error('lead_time_days') is-invalid @enderror" required>
                        @error('lead_time_days') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="rating" class="form-label">Rating <span class="text-secondary">(optional, 0.00–9.99)</span></label>
                        <input id="rating" name="rating" type="number" min="0" max="9.99" step="0.01" value="{{ old('rating') }}" class="form-control @error('rating') is-invalid @enderror">
                        @error('rating') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                            @foreach (\App\Models\Supplier::STATUSES as $value => $label)
                                <option value="{{ $value }}" @selected(old('status', 'active') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea id="address" name="address" rows="3" maxlength="255" class="form-control @error('address') is-invalid @enderror" required>{{ old('address') }}</textarea>
                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <button type="submit" class="btn bg-gradient-dark mb-0">Save Supplier</button>
                <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary mb-0">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
