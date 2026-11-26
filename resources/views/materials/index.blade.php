@extends('layout.master')

@section('content')
<div class="container-fluid materials-page py-4">
    <div class="materials-heading d-flex flex-wrap align-items-start justify-content-between gap-3 mb-4">
        <div>
            <h4 class="mb-1">Materials</h4>
            <p class="text-sm text-secondary mb-0">Raw materials, trims &amp; reorder settings</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-material-outline mb-0">Export Excel</button>
            <a href="{{ route('materials.create') }}" class="btn btn-material-primary mb-0">
                <span class="material-symbols-rounded align-middle me-1" style="font-size: 17px;">add</span>
                Add Material
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert materials-alert" role="alert">{{ session('success') }}</div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="material-stat-card">
                <span class="material-stat-label">Total Materials</span>
                <strong>{{ $materialStats['total'] }}</strong>
                <span class="material-stat-icon material-symbols-rounded">category</span>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="material-stat-card">
                <span class="material-stat-label">Active Materials</span>
                <strong class="text-success">{{ $materialStats['active'] }}</strong>
                <span class="material-stat-icon material-stat-icon-success material-symbols-rounded">check_circle</span>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="material-stat-card">
                <span class="material-stat-label">Inactive</span>
                <strong class="text-danger">{{ $materialStats['inactive'] }}</strong>
                <span class="material-stat-icon material-stat-icon-danger material-symbols-rounded">block</span>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="material-stat-card">
                <span class="material-stat-label">Categories</span>
                <strong class="text-warning">{{ $materialStats['categories'] }}</strong>
                <span class="material-stat-icon material-stat-icon-warning material-symbols-rounded">sell</span>
            </div>
        </div>
    </div>

    <div class="card materials-card">
        <div class="card-body p-0">
            <div class="materials-toolbar d-flex flex-wrap gap-2 align-items-center">
                <div class="materials-search flex-grow-1">
                    <span class="material-symbols-rounded">search</span>
                    <input type="search" placeholder="Search code or name..." aria-label="Search materials">
                </div>
                <button type="button" class="btn btn-material-filter mb-0">Category <span class="material-symbols-rounded">expand_more</span></button>
                <button type="button" class="btn btn-material-filter mb-0">Supplier <span class="material-symbols-rounded">expand_more</span></button>
                <button type="button" class="btn btn-material-filter mb-0">Status <span class="material-symbols-rounded">expand_more</span></button>
            </div>
            <div class="table-responsive">
                <table class="table materials-table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Material</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Supplier</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Unit Cost</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Reorder / Safety</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($materials as $material)
                            <tr>
                                <td>
                                    <a class="text-sm font-weight-bold mb-0" href="{{ route('materials.show', $material) }}">
                                        {{ $material->material_name }}
                                    </a>
                                    <p class="text-xs text-secondary mb-0">{{ $material->material_code }}</p>
                                </td>
                                <td>
                                    <span class="material-category">{{ $material->category_label }}</span>
                                    <small class="d-block text-muted mt-1">{{ $material->unit_label }}</small>
                                </td>
                                <td class="text-sm">{{ $material->supplier?->company_name ?? 'Not assigned' }}</td>
                                <td class="text-sm">{{ $material->unit_cost }}</td>
                                <td>
                                    <span class="text-sm">{{ $material->reorder_level }} / {{ $material->safety_stock }} {{ $material->unit }}</span>
                                    <div class="material-progress mt-2"><span style="width: {{ $material->safety_stock > 0 ? min(100, ($material->reorder_level / $material->safety_stock) * 100) : 0 }}%"></span></div>
                                </td>
                                <td>
                                    <span class="material-status {{ $material->status === 'active' ? 'material-status-success' : 'material-status-muted' }}">
                                        {{ $material->status_label }}
                                    </span>
                                </td>
                                <td class="align-middle text-end">
                                    <div class="dropdown">
                                        <button type="button" class="btn material-menu-button mb-0" data-bs-toggle="dropdown" aria-label="Actions for {{ $material->material_name }}">•••</button>
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
                            <tr>
                                <td colspan="7" class="text-center text-secondary py-4">No materials found.</td>
                            </tr>
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
