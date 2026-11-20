<?php

namespace App\Http\Controllers;

use App\Models\inventory_stock;
use App\Models\Material;
use App\Models\ProductVariant;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class InventoryStockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $inventoryStocks = inventory_stock::query()
            ->with(['warehouse', 'material', 'productVariant.product'])
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->paginate(15);

        return view('inventory_stock.index', compact('inventoryStocks'));
    }

    public function create(): View
    {
        return view('inventory_stock.create', $this->formData());
    }

    public function store(Request $request): RedirectResponse
    {
        $inventoryStock = inventory_stock::create($this->validated($request));

        return redirect()
            ->route('inventory_stocks.show', $inventoryStock)
            ->with('success', 'Inventory stock created successfully.');
    }

    public function show(inventory_stock $inventory_stock): View
    {
        $inventory_stock->load(['warehouse', 'material', 'productVariant.product']);

        return view('inventory_stock.show', ['inventoryStock' => $inventory_stock]);
    }

    public function edit(inventory_stock $inventory_stock): View
    {
        return view('inventory_stock.edit', ['inventoryStock' => $inventory_stock] + $this->formData());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, inventory_stock $inventory_stock): RedirectResponse
    {
        $inventory_stock->update($this->validated($request, $inventory_stock));

        return redirect()
            ->route('inventory_stocks.show', $inventory_stock)
            ->with('success', 'Inventory stock updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(inventory_stock $inventory_stock): RedirectResponse
    {
        $inventory_stock->delete();

        return redirect()
            ->route('inventory_stocks.index')
            ->with('success', 'Inventory stock deleted successfully.');
    }

    /**
     * @return array{
     *     warehouses: Collection<int, Warehouse>,
     *     materials: Collection<int, Material>,
     *     variants: Collection<int, ProductVariant>
     * }
     */
    private function formData(): array
    {
        return [
            'warehouses' => Warehouse::query()->orderBy('warehouse_name')->get(),
            'materials' => Material::query()->where('status', 'active')->orderBy('material_name')->get(),
            'variants' => ProductVariant::query()
                ->with('product')
                ->where('status', 'active')
                ->orderBy('sku')
                ->get(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request, ?inventory_stock $inventoryStock = null): array
    {
        $warehouseId = $request->input('warehouse_id');

        $materialRule = Rule::unique('inventory_stocks', 'material_id')
            ->where('warehouse_id', $warehouseId);
        $variantRule = Rule::unique('inventory_stocks', 'product_variant_id')
            ->where('warehouse_id', $warehouseId);

        if ($inventoryStock !== null) {
            $materialRule->ignore($inventoryStock);
            $variantRule->ignore($inventoryStock);
        }

        return $request->validate([
            'warehouse_id' => ['required', 'integer', 'exists:warehouses,id'],
            'material_id' => [
                'nullable',
                'required_without:product_variant_id',
                'prohibits:product_variant_id',
                'integer',
                'exists:materials,id',
                $materialRule,
            ],
            'product_variant_id' => [
                'nullable',
                'required_without:material_id',
                'prohibits:material_id',
                'integer',
                'exists:product_variants,id',
                $variantRule,
            ],
            'quantity' => ['required', 'numeric', 'min:0', 'max:99999999999.999'],
            'reserved_qty' => [
                'required',
                'numeric',
                'min:0',
                'max:99999999999.999',
                'lte:quantity',
            ],
        ]);
    }
}
