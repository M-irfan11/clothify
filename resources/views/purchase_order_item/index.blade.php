@extends('layout.master')

@section('content')
<div class="container-fluid crud-page py-4">
    <div class="mb-3">
        <h4 class="mb-1">Purchase Order Items</h4>
        <p class="text-sm text-secondary mb-0">Manage material lines of purchase orders.</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success text-white" role="alert">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger text-white" role="alert">{{ session('error') }}</div>
    @endif

    <div class="card crud-list-card">
        <div class="card-header d-flex align-items-center justify-content-between bg-white border-0 px-4 pt-4 pb-3">
            <div>
                <h6 class="mb-1">PO Item List</h6>
                <p class="text-xs text-secondary mb-0">Review ordered, received and QC quantities</p>
            </div>
            <a href="{{ route('purchase_order_items.create') }}" class="btn btn-sm bg-gradient-dark mb-0">
                <span class="material-symbols-rounded align-middle me-1" style="font-size: 18px;">add</span>
                Add PO Item
            </a>
        </div>
        <div class="card-body px-0 pb-2">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PO / Material</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ordered</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Received</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Accepted</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Rejected</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Unit Price</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Line Total</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($purchaseOrderItems as $purchaseOrderItem)
                            <tr>
                                <td>
                                    <a class="text-sm font-weight-bold mb-0" href="{{ route('purchase_order_items.show', $purchaseOrderItem) }}">
                                        {{ $purchaseOrderItem->material->material_name ?? '—' }}
                                    </a>
                                    <p class="text-xs text-secondary mb-0">PO: {{ $purchaseOrderItem->purchaseOrder->po_no ?? '#'.$purchaseOrderItem->purchase_order_id }}</p>
                                </td>
                                <td class="text-sm">{{ number_format($purchaseOrderItem->ordered_qty, 3) }}</td>
                                <td class="text-sm">{{ number_format($purchaseOrderItem->received_qty, 3) }}</td>
                                <td class="text-sm text-success">{{ number_format($purchaseOrderItem->accepted_qty, 3) }}</td>
                                <td class="text-sm text-danger">{{ number_format($purchaseOrderItem->rejected_qty, 3) }}</td>
                                <td class="text-sm">{{ number_format($purchaseOrderItem->unit_price, 2) }}</td>
                                <td class="text-sm font-weight-bold">{{ number_format($purchaseOrderItem->line_total, 2) }}</td>
                                <td class="align-middle text-end">
                                    <a href="{{ route('purchase_order_items.show', $purchaseOrderItem) }}" class="btn btn-sm btn-action-view mb-0 me-1">View</a>
                                    <a href="{{ route('purchase_order_items.edit', $purchaseOrderItem) }}" class="btn btn-sm btn-action-edit mb-0 me-1">Edit</a>
                                    <form action="{{ route('purchase_order_items.destroy', $purchaseOrderItem) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-action-delete mb-0" onclick="return confirm('Delete this PO item?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-secondary py-4">No purchase order items found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 pt-3">
                {{ $purchaseOrderItems->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
