<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\ProductionOrder;
use App\Models\ProductionOrderMaterial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductionOrderMaterialController extends Controller
{
    public function all(Request $request): View
    {
        $items = ProductionOrderMaterial::query()
            ->with(['productionOrder.productVariant.product', 'material'])
            ->when($request->filled('production_order_id'), fn ($query) =>
                $query->where('production_order_id', $request->integer('production_order_id')))
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        $orders = ProductionOrder::query()
            ->orderByDesc('created_at')
            ->get(['id', 'production_no']);

        return view('production_order_materials.all', compact('items', 'orders'));
    }

    public function index(ProductionOrder $productionOrder): View
    {
        $productionOrder->load(['productVariant.product', 'sourceWarehouse']);
        $items = $productionOrder->materialRequirements()->with('material')->orderBy('id')->get();

        return view('production_order_materials.index', [
            'order' => $productionOrder,
            'items' => $items,
            'summary' => [
                'materials' => $items->count(),
                'planned' => $items->sum('planned_qty'),
                'issued' => $items->sum('issued_qty'),
                'used' => $items->sum('used_qty'),
                'returned' => $items->sum('return_qty'),
            ],
        ]);
    }

    public function create(ProductionOrder $productionOrder): View
    {
        $productionOrder->load(['productVariant.product', 'sourceWarehouse']);

        return view('production_order_materials.create', [
            'order' => $productionOrder,
            'materials' => $this->materials(),
        ]);
    }

    public function store(Request $request, ProductionOrder $productionOrder): RedirectResponse
    {
        $productionOrder->materialRequirements()->create($this->validated($request, $productionOrder));

        return redirect()->route('production-orders.materials.index', $productionOrder)
            ->with('success', 'Production order material added successfully.');
    }

    public function show(ProductionOrder $productionOrder, ProductionOrderMaterial $productionOrderMaterial): View
    {
        $item = $this->itemForOrder($productionOrder, $productionOrderMaterial);
        $item->load('material');
        $productionOrder->load(['productVariant.product', 'sourceWarehouse']);

        return view('production_order_materials.show', ['order' => $productionOrder, 'item' => $item]);
    }

    public function edit(ProductionOrder $productionOrder, ProductionOrderMaterial $productionOrderMaterial): View
    {
        $item = $this->itemForOrder($productionOrder, $productionOrderMaterial);
        $item->load('material');
        $productionOrder->load(['productVariant.product', 'sourceWarehouse']);

        return view('production_order_materials.edit', [
            'order' => $productionOrder,
            'item' => $item,
            'materials' => $this->materials($item->material_id),
        ]);
    }

    public function update(Request $request, ProductionOrder $productionOrder, ProductionOrderMaterial $productionOrderMaterial): RedirectResponse
    {
        $item = $this->itemForOrder($productionOrder, $productionOrderMaterial);
        $item->update($this->validated($request, $productionOrder, $item));

        return redirect()->route('production-orders.materials.show', [$productionOrder, $item])
            ->with('success', 'Production order material updated successfully.');
    }

    public function destroy(ProductionOrder $productionOrder, ProductionOrderMaterial $productionOrderMaterial): RedirectResponse
    {
        $item = $this->itemForOrder($productionOrder, $productionOrderMaterial);
        $item->delete();

        return redirect()->route('production-orders.materials.index', $productionOrder)
            ->with('success', 'Production order material deleted successfully.');
    }

    private function materials(?int $selectedId = null)
    {
        return Material::query()
            ->where(function ($query) use ($selectedId) {
                $query->where('status', 'active')
                    ->when($selectedId !== null, fn ($query) => $query->orWhereKey($selectedId));
            })
            ->orderBy('material_name')
            ->get();
    }

    private function validated(Request $request, ProductionOrder $productionOrder, ?ProductionOrderMaterial $item = null): array
    {
        $uniqueMaterial = Rule::unique('production_order_materials', 'material_id')
            ->where('production_order_id', $productionOrder->id);

        if ($item !== null) {
            $uniqueMaterial->ignore($item);
        }

        $data = $request->validate([
            'material_id' => ['required', 'integer', 'exists:materials,id', $uniqueMaterial],
            'planned_qty' => ['required', 'numeric', 'min:0', 'max:99999999999.999'],
            'issued_qty' => ['nullable', 'numeric', 'min:0', 'max:99999999999.999'],
            'used_qty' => ['nullable', 'numeric', 'min:0', 'max:99999999999.999'],
            'return_qty' => ['nullable', 'numeric', 'min:0', 'max:99999999999.999'],
            'wastage_qty' => ['nullable', 'numeric', 'min:0', 'max:99999999999.999'],
        ]);

        foreach (['issued_qty', 'used_qty', 'return_qty', 'wastage_qty'] as $field) {
            $data[$field] = $data[$field] ?? 0;
        }

        return $data;
    }

    private function itemForOrder(ProductionOrder $productionOrder, ProductionOrderMaterial $item): ProductionOrderMaterial
    {
        abort_unless((int) $item->production_order_id === (int) $productionOrder->id, 404);

        return $item;
    }
}
