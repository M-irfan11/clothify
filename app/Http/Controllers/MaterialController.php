<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MaterialController extends Controller
{
    public function index(): View
    {
        $materials = Material::query()
            ->with('supplier')
            ->orderByDesc('created_at')
            ->paginate(15);

        $materialStats = [
            'total' => Material::query()->count(),
            'active' => Material::query()->where('status', 'active')->count(),
            'inactive' => Material::query()->where('status', 'inactive')->count(),
            'categories' => Material::query()->distinct('category')->count('category'),
        ];

        return view('materials.index', compact('materials', 'materialStats'));
    }

    public function create(): View
    {
        $suppliers = $this->suppliers();

        return view('materials.create', compact('suppliers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $material = Material::create($request->validate($this->rules()));

        return redirect()
            ->route('materials.show', $material)
            ->with('success', 'Material created successfully.');
    }

    public function show(Material $material): View
    {
        $material->load('supplier');

        return view('materials.show', compact('material'));
    }

    public function edit(Material $material): View
    {
        $suppliers = $this->suppliers();
        $material->load('supplier');

        return view('materials.edit', compact('material', 'suppliers'));
    }

    public function update(Request $request, Material $material): RedirectResponse
    {
        $material->update($request->validate($this->rules($material)));

        return redirect()
            ->route('materials.show', $material)
            ->with('success', 'Material updated successfully.');
    }

    public function destroy(Material $material): RedirectResponse
    {
        $material->delete();

        return redirect()
            ->route('materials.index')
            ->with('success', 'Material moved to trash.');
    }

    private function suppliers()
    {
        return Supplier::query()
            ->orderBy('company_name')
            ->get(['id', 'company_name', 'supplier_code']);
    }

    private function rules(?Material $material = null): array
    {
        $materialCodeRule = Rule::unique('materials', 'material_code');

        if ($material !== null) {
            $materialCodeRule->ignore($material);
        }

        return [
            'supplier_id' => ['nullable', 'integer', Rule::exists('suppliers', 'id')],
            'material_code' => ['required', 'string', 'max:30', $materialCodeRule],
            'material_name' => ['required', 'string', 'max:150'],
            'category' => ['required', Rule::in(array_keys(Material::CATEGORIES))],
            'unit' => ['required', Rule::in(array_keys(Material::UNITS))],
            'unit_cost' => ['required', 'numeric', 'decimal:0,2', 'min:0', 'max:9999999999999999.99'],
            'reorder_level' => ['required', 'numeric', 'decimal:0,2', 'min:0', 'max:999999999999.99'],
            'safety_stock' => ['required', 'numeric', 'decimal:0,2', 'min:0', 'max:999999999999.99'],
            'status' => ['required', Rule::in(array_keys(Material::STATUSES))],
        ];
    }
}
