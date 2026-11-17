@extends('layout.master')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Materials</h4>
            <p class="text-sm text-secondary mb-0">Manage raw materials and reorder settings.</p>
        </div>
        <a href="{{ route('materials.create') }}" class="btn bg-gradient-dark mb-0">Add Material</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success text-white" role="alert">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body px-0 pb-2">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Material</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category / Unit</th>
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
                                    <p class="text-sm font-weight-bold mb-0">{{ $material->category_label }}</p>
                                    <p class="text-xs text-secondary mb-0">{{ $material->unit_label }}</p>
                                </td>
                                <td class="text-sm">{{ $material->supplier?->company_name ?? 'Not assigned' }}</td>
                                <td class="text-sm">{{ $material->unit_cost }}</td>
                                <td class="text-sm">{{ $material->reorder_level }} / {{ $material->safety_stock }}</td>
                                <td>
                                    <span class="badge badge-sm {{ $material->status === 'active' ? 'bg-gradient-success' : 'bg-gradient-secondary' }}">
                                        {{ $material->status_label }}
                                    </span>
                                </td>
                                <td class="align-middle text-end">
                                    <a href="{{ route('materials.show', $material) }}" class="text-secondary font-weight-bold text-xs me-2">View</a>
                                    <a href="{{ route('materials.edit', $material) }}" class="text-secondary font-weight-bold text-xs me-2">Edit</a>
                                    <form action="{{ route('materials.destroy', $material) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger text-xs font-weight-bold p-0 mb-0" onclick="return confirm('Move this material to trash?')">Delete</button>
                                    </form>
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
            <div class="px-4 pt-3">
                {{ $materials->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
