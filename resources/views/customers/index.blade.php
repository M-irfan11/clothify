@extends('layout.master')

@section('content')
<div class="container-fluid crud-page py-4">
    <div class="d-flex justify-content-between align-items-end">
        <div>
            
            <h4 class="mb-1">Customers</h4>
            <p class="text-sm text-secondary mb-0">Manage customer contacts and credit details.</p>
        </div>
        <a href="{{ route('customers.create') }}" class="btn btn-sm bg-gradient-dark mb-3  ">
            <span class="material-symbols-rounded align-middle me-1" style="font-size: 18px;">add</span>
            Add Customer
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success text-white" role="alert">{{ session('success') }}</div>
    @endif

    <div class="card crud-list-card">
        <div class="card-header d-flex align-items-center justify-content-between bg-white border-0 px-4 pt-4 pb-3">
            <div>
                <h6 class="mb-1">Customer List</h6>
                <p class="text-xs text-secondary mb-0">Review and manage customer records</p>
            </div>
        </div>
        <div class="card-body px-0 pb-2">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customer</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Contact</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Type</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Credit Limit</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customers as $customer)
                            <tr>
                                <td>
                                    <a class="text-sm font-weight-bold mb-0" href="{{ route('customers.show', $customer) }}">{{ $customer->customer_name }}</a>
                                    <p class="text-xs text-secondary mb-0">{{ $customer->customer_code }}</p>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0">{{ $customer->contact_person ?: '—' }}</p>
                                    <p class="text-xs text-secondary mb-0">{{ $customer->phone }}</p>
                                </td>
                                <td class="text-sm">{{ $customer->customer_type_label }}</td>
                                <td class="text-sm">{{ number_format((float) $customer->credit_limit, 2) }}</td>
                                <td>
                                    <span class="badge badge-sm {{ $customer->status === 'active' ? 'bg-gradient-success' : 'bg-gradient-secondary' }}">{{ $customer->status_label }}</span>
                                </td>
                                <td class="align-middle text-end">
                                    <a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-action-view mb-0 me-1">View</a>
                                    <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-action-edit mb-0 me-1">Edit</a>
                                    <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-action-delete mb-0" onclick="return confirm('Delete this customer?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-secondary py-4">No customers found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 pt-3">{{ $customers->links('pagination::bootstrap-5') }}</div>
        </div>
    </div>
</div>
@endsection
