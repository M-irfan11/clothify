@extends('layout.master')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Edit Production Order</h4>
            <p class="text-sm text-secondary mb-0">Update {{ $order->production_no }}.</p>
        </div>
        <a href="{{ route('production-orders.show', $order) }}" class="btn btn-action-view mb-0">View Production Order</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('production-orders.update', $order) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="product_variant_id" class="form-label">Product Variant</label>
                        <select id="product_variant_id" name="product_variant_id" class="form-select @error('product_variant_id') is-invalid @enderror" required>
                            <option value="">Select product variant</option>
                            @foreach ($variants as $variant)
                                <option value="{{ $variant->id }}" @selected((string) old('product_variant_id', $order->product_variant_id) === (string) $variant->id)>{{ $variant->name ?? ('Variant #' . $variant->id) }}</option>
                            @endforeach
                        </select>
                        @error('product_variant_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="source_warehouse_id" class="form-label">Source Warehouse</label>
                        <select id="source_warehouse_id" name="source_warehouse_id" class="form-select @error('source_warehouse_id') is-invalid @enderror" required>
                            <option value="">Select warehouse</option>
                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}" @selected((string) old('source_warehouse_id', $order->source_warehouse_id) === (string) $warehouse->id)>{{ $warehouse->name ?? ('Warehouse #' . $warehouse->id) }}</option>
                            @endforeach
                        </select>
                        @error('source_warehouse_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="planned_qty" class="form-label">Planned Quantity</label>
                        <input id="planned_qty" name="planned_qty" type="number" min="1" step="1" value="{{ old('planned_qty', $order->planned_qty) }}" class="form-control @error('planned_qty') is-invalid @enderror" required>
                        @error('planned_qty') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="produced_qty" class="form-label">Produced Quantity</label>
                        <input id="produced_qty" name="produced_qty" type="number" min="0" step="1" value="{{ old('produced_qty', $order->produced_qty) }}" class="form-control @error('produced_qty') is-invalid @enderror" required>
                        @error('produced_qty') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="wastage_qty" class="form-label">Wastage Quantity</label>
                        <input id="wastage_qty" name="wastage_qty" type="number" min="0" step="1" value="{{ old('wastage_qty', $order->wastage_qty) }}" class="form-control @error('wastage_qty') is-invalid @enderror" required>
                        @error('wastage_qty') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input id="start_date" name="start_date" type="date" value="{{ old('start_date', $order->start_date?->format('Y-m-d')) }}" class="form-control @error('start_date') is-invalid @enderror" required>
                        @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="due_date" class="form-label">Due Date</label>
                        <input id="due_date" name="due_date" type="date" value="{{ old('due_date', $order->due_date?->format('Y-m-d')) }}" class="form-control @error('due_date') is-invalid @enderror" required>
                        @error('due_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="completed_date" class="form-label">Completed Date <span class="text-secondary">(optional)</span></label>
                        <input id="completed_date" name="completed_date" type="date" value="{{ old('completed_date', $order->completed_date?->format('Y-m-d')) }}" class="form-control @error('completed_date') is-invalid @enderror">
                        @error('completed_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                            @foreach (\App\Models\ProductionOrder::STATUSES as $value => $label)
                                <option value="{{ $value }}" @selected(old('status', $order->status) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label for="remarks" class="form-label">Remarks <span class="text-secondary">(optional)</span></label>
                        <textarea id="remarks" name="remarks" rows="3" maxlength="255" class="form-control @error('remarks') is-invalid @enderror">{{ old('remarks', $order->remarks) }}</textarea>
                        @error('remarks') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-action-edit mb-0">Update Production Order</button>
                <a href="{{ route('production-orders.index') }}" class="btn btn-outline-secondary mb-0">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection