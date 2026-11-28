@extends('layout.master')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Add Customer</h4>
            <p class="text-sm text-secondary mb-0">Enter the customer details below.</p>
        </div>
        <a href="{{ route('customers.index') }}" class="btn btn-outline-dark mb-0">Back to Customers</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('customers.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="customer_code" class="form-label">Customer Code</label>
                        <input id="customer_code" name="customer_code" type="text" maxlength="30" value="{{ old('customer_code') }}" class="form-control @error('customer_code') is-invalid @enderror" required>
                        @error('customer_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="customer_name" class="form-label">Customer Name</label>
                        <input id="customer_name" name="customer_name" type="text" maxlength="150" value="{{ old('customer_name') }}" class="form-control @error('customer_name') is-invalid @enderror" required>
                        @error('customer_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="customer_type" class="form-label">Customer Type</label>
                        <select id="customer_type" name="customer_type" class="form-select @error('customer_type') is-invalid @enderror" required>
                            <option value="">Select type</option>
                            @foreach (\App\Models\Customer::TYPES as $type)
                                <option value="{{ $type }}" @selected(old('customer_type') === $type)>{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                        @error('customer_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="contact_person" class="form-label">Contact Person <span class="text-secondary">(optional)</span></label>
                        <input id="contact_person" name="contact_person" type="text" maxlength="100" value="{{ old('contact_person') }}" class="form-control @error('contact_person') is-invalid @enderror">
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
                        <label for="buyer_reference" class="form-label">Buyer Reference</label>
                        <input id="buyer_reference" name="buyer_reference" type="text" maxlength="100" value="{{ old('buyer_reference') }}" class="form-control @error('buyer_reference') is-invalid @enderror" required>
                        @error('buyer_reference') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="credit_limit" class="form-label">Credit Limit</label>
                        <input id="credit_limit" name="credit_limit" type="number" min="0" step="0.01" value="{{ old('credit_limit', '0.00') }}" class="form-control @error('credit_limit') is-invalid @enderror" required>
                        @error('credit_limit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                            @foreach (\App\Models\Customer::STATUSES as $value => $label)
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
                <button type="submit" class="btn bg-gradient-dark mb-0">Save Customer</button>
                <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary mb-0">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
