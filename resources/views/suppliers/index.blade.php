@extends('layout.master')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-3">
        <h4 class="mb-1">Suppliers</h4>
        <p class="text-sm text-secondary mb-0">Manage supplier contacts and terms.</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success text-white" role="alert">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between bg-white border-0 px-4 pt-4 pb-3">
            <div>
                <h6 class="mb-1">Supplier List</h6>
                <p class="text-xs text-secondary mb-0">Review and manage supplier records</p>
            </div>
            <a href="{{ route('suppliers.create') }}" class="btn btn-sm bg-gradient-dark mb-0">
                <span class="material-symbols-rounded align-middle me-1" style="font-size: 18px;">add</span>
                Add Supplier
            </a>
        </div>
        <div class="card-body px-0 pb-2">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Supplier</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Contact</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Type</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Rating</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($suppliers as $supplier)
                            <tr>
                                <td>
                                    <a class="text-sm font-weight-bold mb-0" href="{{ route('suppliers.show', $supplier) }}">
                                        {{ $supplier->company_name }}
                                    </a>
                                    <p class="text-xs text-secondary mb-0">{{ $supplier->supplier_code }}</p>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0">{{ $supplier->contact_person }}</p>
                                    <p class="text-xs text-secondary mb-0">{{ $supplier->phone }}</p>
                                </td>
                                <td class="text-sm">{{ $supplier->supplier_type_label }}</td>
                                <td class="text-sm">{{ $supplier->rating ?? '—' }}</td>
                                <td>
                                    <span class="badge badge-sm {{ $supplier->status === 'active' ? 'bg-gradient-success' : 'bg-gradient-secondary' }}">
                                        {{ $supplier->status_label }}
                                    </span>
                                </td>
                                <td class="align-middle text-end">
                                    <a href="{{ route('suppliers.show', $supplier) }}" class="text-secondary font-weight-bold text-xs me-2">View</a>
                                    <a href="{{ route('suppliers.edit', $supplier) }}" class="text-secondary font-weight-bold text-xs me-2">Edit</a>
                                    <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger text-xs font-weight-bold p-0 mb-0" onclick="return confirm('Delete this supplier?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-secondary py-4">No suppliers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 pt-3">
                {{ $suppliers->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
