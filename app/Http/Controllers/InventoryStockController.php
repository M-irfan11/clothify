<?php

namespace App\Http\Controllers;

use App\Models\InventoryStock;
use App\Models\Material;
use App\Models\ProductVariant;
use App\Models\Warehouse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class InventoryStockController extends Controller
{
    public function index(Request $request): View
    {
        $stocks = InventoryStock::with([
                'warehouse',
                'material',
                'productVariant.product',
            ])
            ->when($request->warehouse_id, fn ($q, $id) => $q->where('warehouse_id', $id))
            ->orderBy('warehouse_id')
            ->paginate(20)
            ->withQueryString();

        $warehouses = Warehouse::orderBy('warehouse_name')->get();

        return view('inventory_stocks.index', compact('stocks', 'warehouses'));
    }

    public function create(): View
    {
        return view('inventory_stocks.create', $this->formData());
    }

    public function store(Request $request): RedirectResponse
    {
        $inventoryStock = InventoryStock::create($this->validated($request));

        return redirect()
            ->route('inventory_stocks.show', $inventoryStock)
            ->with('success', 'Inventory stock created successfully.');
    }

    public function show(InventoryStock $inventoryStock): View
    {
        $inventoryStock->load(['warehouse', 'material', 'productVariant.product']);

        return view('inventory_stocks.show', compact('inventoryStock'));
    }

    public function edit(InventoryStock $inventoryStock): View
    {
        return view('inventory_stocks.edit', ['inventoryStock' => $inventoryStock] + $this->formData());
    }

    public function update(Request $request, InventoryStock $inventoryStock): RedirectResponse
    {
        $inventoryStock->update($this->validated($request, $inventoryStock));

        return redirect()
            ->route('inventory_stocks.show', $inventoryStock)
            ->with('success', 'Inventory stock updated successfully.');
    }

    public function destroy(InventoryStock $inventoryStock): RedirectResponse
    {
        $inventoryStock->delete();

        return redirect()
            ->route('inventory_stocks.index')
            ->with('success', 'Inventory stock deleted successfully.');
    }

    private function formData(): array
    {
        return [
            'warehouses' => Warehouse::orderBy('warehouse_name')->get(),
            'materials'  => Material::where('status', 'active')->orderBy('material_name')->get(),
            'variants'   => ProductVariant::with('product')
                ->where('status', 'active')
                ->orderBy('sku')
                ->get(),
        ];
    }

    private function validated(Request $request, ?InventoryStock $inventoryStock = null): array
    {
        $warehouseId = $request->input('warehouse_id');

        $materialRule = Rule::unique('inventory_stocks', 'material_id')
            ->where('warehouse_id', $warehouseId);
        $variantRule = Rule::unique('inventory_stocks', 'product_variant_id')
            ->where('warehouse_id', $warehouseId);

        if ($inventoryStock !== null) {
            $materialRule->ignore($inventoryStock->id);
            $variantRule->ignore($inventoryStock->id);
        }

        return $request->validate([
            'warehouse_id' => ['required', 'integer', 'exists:warehouses,id'],
            'material_id' => [
                'nullable', 'required_without:product_variant_id', 'prohibits:product_variant_id',
                'integer', 'exists:materials,id', $materialRule,
            ],
            'product_variant_id' => [
                'nullable', 'required_without:material_id', 'prohibits:material_id',
                'integer', 'exists:product_variants,id', $variantRule,
            ],
            'quantity'     => ['required', 'numeric', 'min:0', 'max:99999999999.999'],
            'reserved_qty' => ['required', 'numeric', 'min:0', 'max:99999999999.999', 'lte:quantity'],
        ]);
    }
}