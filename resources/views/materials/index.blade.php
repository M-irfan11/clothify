@extends('layout.master')

@section('content')
<div class="container-fluid materials-page py-4">
    <div class="materials-heading d-flex flex-wrap align-items-start justify-content-between gap-3 mb-4">
        <div>
            <h4 class="mb-1">Materials</h4>
            <p class="text-sm text-secondary mb-0">Raw materials, trims &amp; reorder settings manage করুন</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-material-outline mb-0">Export Excel</button>
            <a href="{{ route('materials.create') }}" class="btn btn-material-primary mb-0">+ Add Material</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert materials-alert" role="alert">{{ session('success') }}</div>
    @endif

    <div class="row g-3 mb-4">
        @foreach ([
            ['label' => 'Total Materials', 'value' => $materialStats['total'], 'class' => ''],
            ['label' => 'Low Stock', 'value' => $materialStats['low_stock'], 'class' => 'material-stat-warning'],
            ['label' => 'Out of Stock', 'value' => $materialStats['out_of_stock'], 'class' => 'material-stat-danger'],
            ['label' => 'Inactive', 'value' => $materialStats['inactive'], 'class' => 'material-stat-muted'],
        ] as $stat)
            <div class="col-sm-6 col-xl-3">
                <div class="material-stat-card {{ $stat['class'] }}">
                    <span class="material-stat-label">{{ $stat['label'] }}</span>
                    <strong>{{ $stat['value'] }}</strong>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card materials-card">
        <div class="card-body p-0">
            <form method="GET" action="{{ route('materials.index') }}" class="materials-toolbar d-flex flex-wrap gap-2 align-items-center">
                <div class="materials-search flex-grow-1">
                    <span class="material-symbols-rounded">search</span>
                    <input type="search" name="search" value="{{ request('search') }}" placeholder="Search code or name..." aria-label="Search materials">
                </div>
                <select name="category" class="btn btn-material-filter" aria-label="Filter by category">
                    <option value="">Category</option>
                    @foreach ($categories as $value => $label)
                        <option value="{{ $value }}" @selected(request('category') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <select name="supplier_id" class="btn btn-material-filter" aria-label="Filter by supplier">
                    <option value="">Supplier</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" @selected((string) request('supplier_id') === (string) $supplier->id)>{{ $supplier->company_name }}</option>
                    @endforeach
                </select>
                <select name="status" class="btn btn-material-filter" aria-label="Filter by status">
                    <option value="">Status</option>
                    @foreach (\App\Models\Material::STATUSES as $value => $label)
                        <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-material-primary mb-0">Filter</button>
            </form>

            <div class="table-responsive">
                <table class="table materials-table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th>Material</th>
                            <th>Category</th>
                            <th>Supplier</th>
                            <th>Unit Cost</th>
                            <th>On-hand / Reorder</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($materials as $material)
                            @php
                                $onHand = (float) ($material->inventory_stocks_sum_quantity ?? 0);
                                $reorderLevel = (float) $material->reorder_level;
                                $stockStatus = $onHand <= 0 ? 'out' : ($onHand <= $reorderLevel ? 'low' : 'in');
                                $stockLabel = ['in' => 'In Stock', 'low' => 'Low Stock', 'out' => 'Out of Stock'][$stockStatus];
                                $stockPercent = $reorderLevel > 0 ? min(100, ($onHand / $reorderLevel) * 100) : ($onHand > 0 ? 100 : 0);
                            @endphp
                            <tr>
                                <td>
                                    <a class="text-sm font-weight-bold mb-0" href="{{ route('materials.show', $material) }}">{{ $material->material_name }}</a>
                                    <p class="text-xs text-secondary mb-0">{{ $material->material_code }}</p>
                                    @if ($material->sales_order_number)
                                        <p class="text-xs text-secondary mb-0">SO: {{ $material->sales_order_number }}</p>
                                    @endif
                                </td>
                                <td><span class="material-category">{{ $material->category_label }}</span></td>
                                <td class="text-sm">{{ $material->supplier?->company_name ?? 'Not assigned' }}</td>
                                <td class="text-sm">৳ {{ number_format((float) $material->unit_cost, 2) }}</td>
                                <td>
                                    <span class="text-sm">{{ number_format($onHand, 2) }} / {{ number_format($reorderLevel, 2) }} {{ $material->unit }}</span>
                                    <div class="material-progress mt-2 material-progress-{{ $stockStatus }}"><span style="width: {{ $stockPercent }}%"></span></div>
                                </td>
                                <td><span class="material-status material-status-{{ $stockStatus }}">{{ $stockLabel }}</span></td>
                                <td class="align-middle text-end">
                                    <div class="dropdown">
                                        <button type="button" class="btn material-menu-button mb-0" data-bs-toggle="dropdown" aria-label="Actions for {{ $material->material_name }}">...</button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="{{ route('materials.show', $material) }}">View</a></li>
                                            <li><a class="dropdown-item" href="{{ route('materials.edit', $material) }}">Edit</a></li>
                                            <li>
                                                <form action="{{ route('materials.destroy', $material) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Move this material to trash?')">Delete</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-secondary py-4">No materials found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="materials-footer px-4 pt-3">
                <span>{{ $materials->firstItem() ?? 0 }}–{{ $materials->lastItem() ?? 0 }} / {{ $materials->total() }} materials</span>
                {{ $materials->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
