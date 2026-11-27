@extends('layout.master')

@section('content')
<div class="container-fluid crud-page py-4">
    <div class="crud-heading">
        <div>
            <div class="crud-eyebrow">Procurement</div>
            <h4 class="mb-1">Purchase Orders</h4>
            <p class="text-sm text-secondary mb-0">Manage raw material purchase orders.</p>
        </div>
        <a href="{{ route('purchase_orders.create') }}" class="btn bg-gradient-dark mb-0">
            <span class="material-symbols-rounded align-middle me-1" style="font-size: 18px;">add</span>
            New purchase order
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success text-white" role="alert">{{ session('success') }}</div>
    @endif

    <div class="card crud-list-card">
        <div class="card-header d-flex align-items-center justify-content-between bg-white border-0 px-4 pt-4 pb-3">
            <div>
                <h6 class="mb-1">Purchase Order List</h6>
                <p class="text-xs text-secondary mb-0">Review and manage purchase orders</p>
            </div>
        </div>
        <div class="card-body px-0 pb-2">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PO No</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Supplier</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Warehouse</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Expected</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Payment</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($purchaseOrders as $purchaseOrder)
                            <tr>
                                <td>
                                    <a class="text-sm font-weight-bold mb-0" href="{{ route('purchase_orders.show', $purchaseOrder) }}">
                                        {{ $purchaseOrder->po_no }}
                                    </a>
                                    <p class="text-xs text-secondary mb-0">{{ $purchaseOrder->order_date->format('d M Y') }}</p>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0">{{ $purchaseOrder->supplier->company_name ?? '—' }}</p>
                                    <p class="text-xs text-secondary mb-0">{{ $purchaseOrder->supplier->supplier_code ?? '' }}</p>
                                </td>
                                <td class="text-sm">{{ $purchaseOrder->warehouse->warehouse_name ?? '—' }}</td>
                                <td class="text-sm">{{ $purchaseOrder->expected_date->format('d M Y') }}</td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0">{{ number_format($purchaseOrder->total_amount, 2) }}</p>
                                    <p class="text-xs text-secondary mb-0">Paid: {{ number_format($purchaseOrder->paid_amount, 2) }}</p>
                                </td>
                                <td>
                                    <span class="badge badge-sm {{ $purchaseOrder->payment_badge }}">
                                        {{ $purchaseOrder->payment_status_label }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-sm {{ $purchaseOrder->status_badge }}">
                                        {{ $purchaseOrder->status_label }}
                                    </span>
                                </td>
                                <td class="align-middle text-end">
                                    <a href="{{ route('purchase_orders.show', $purchaseOrder) }}" class="btn btn-sm btn-action-view mb-0 me-1">View</a>
                                    <a href="{{ route('purchase_orders.edit', $purchaseOrder) }}" class="btn btn-sm btn-action-edit mb-0 me-1">Edit</a>
                                    <form action="{{ route('purchase_orders.destroy', $purchaseOrder) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-action-delete mb-0" onclick="return confirm('Delete this purchase order?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-secondary py-4">No purchase orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 pt-3">
                {{ $purchaseOrders->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
