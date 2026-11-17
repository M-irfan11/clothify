<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class WarehouseController extends Controller
{
    public function index(): View
    {
        $warehouses = Warehouse::query()
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('warehouses.index', compact('warehouses'));
    }

    public function create(): View
    {
        return view('warehouses.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $warehouse = Warehouse::create($request->validate($this->rules()));

        return redirect()
            ->route('warehouses.show', $warehouse)
            ->with('success', 'Warehouse created successfully.');
    }

    public function show(Warehouse $warehouse): View
    {
        return view('warehouses.show', compact('warehouse'));
    }

    public function edit(Warehouse $warehouse): View
    {
        return view('warehouses.edit', compact('warehouse'));
    }

    public function update(Request $request, Warehouse $warehouse): RedirectResponse
    {
        $warehouse->update($request->validate($this->rules($warehouse)));

        return redirect()
            ->route('warehouses.show', $warehouse)
            ->with('success', 'Warehouse updated successfully.');
    }

    public function destroy(Warehouse $warehouse): RedirectResponse
    {
        $warehouse->delete();

        return redirect()
            ->route('warehouses.index')
            ->with('success', 'Warehouse deleted successfully.');
    }

    private function rules(?Warehouse $warehouse = null): array
    {
        $warehouseCodeRule = Rule::unique('warehouses', 'warehouse_code');

        if ($warehouse !== null) {
            $warehouseCodeRule->ignore($warehouse);
        }

        return [
            'warehouse_name' => ['required', 'string', 'max:150'],
            'warehouse_code' => ['required', 'string', 'max:20', $warehouseCodeRule],
            'warehouse_type' => ['required', Rule::in(array_keys(Warehouse::TYPES))],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'status' => ['required', Rule::in(array_keys(Warehouse::STATUSES))],
        ];
    }
}
