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
    public function index(Request $request): View
    {
        $materials = Material::query()
            ->with('supplier')
            ->withSum('inventoryStocks', 'quantity')
            ->when($request->filled('search'), function ($query) use ($request): void {
                $search = $request->string('search')->toString();

                $query->where(function ($query) use ($search): void {
                    $query->where('material_name', 'like', "%{$search}%")
                        ->orWhere('material_code', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('category'), fn ($query) => $query->where('category', $request->string('category')))
            ->when($request->filled('supplier_id'), fn ($query) => $query->where('supplier_id', $request->integer('supplier_id')))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        $allMaterials = Material::query()
            ->withSum('inventoryStocks', 'quantity')
            ->get();

        $materialStats = [
            'total' => $allMaterials->count(),
            'low_stock' => $allMaterials->filter(fn (Material $material): bool => $this->stockStatus($material) === 'low')->count(),
            'out_of_stock' => $allMaterials->filter(fn (Material $material): bool => $this->stockStatus($material) === 'out')->count(),
            'inactive' => $allMaterials->where('status', 'inactive')->count(),
        ];

        return view('materials.index', [
            'materials' => $materials,
            'materialStats' => $materialStats,
            'categories' => Material::CATEGORIES,
            'suppliers' => $this->suppliers(),
        ]);
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

    private function stockStatus(Material $material): string
    {
        $onHand = (float) ($material->inventory_stocks_sum_quantity ?? 0);

        if ($onHand <= 0) {
            return 'out';
        }

        if ($onHand <= (float) $material->reorder_level) {
            return 'low';
        }

        return 'in';
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
            'sales_order_number' => ['nullable', 'string', 'max:30'],
            'category' => ['required', Rule::in(array_keys(Material::CATEGORIES))],
            'unit' => ['required', Rule::in(array_keys(Material::UNITS))],
            'unit_cost' => ['required', 'numeric', 'decimal:0,2', 'min:0', 'max:9999999999999999.99'],
            'reorder_level' => ['required', 'numeric', 'decimal:0,2', 'min:0', 'max:999999999999.99'],
            'safety_stock' => ['required', 'numeric', 'decimal:0,2', 'min:0', 'max:999999999999.99'],
            'status' => ['required', Rule::in(array_keys(Material::STATUSES))],
        ];
    }
}
