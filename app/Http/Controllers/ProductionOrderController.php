<?php

namespace App\Http\Controllers;

use App\Models\ProductionOrder;
use App\Models\ProductVariant;
use App\Models\Warehouse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductionOrderController extends Controller
{
    public function index(): View
    {
        $orders = ProductionOrder::query()
            ->with(['productVariant', 'sourceWarehouse'])
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('production_orders.index', compact('orders'));
    }

    public function create(): View
    {
        return view('production_orders.create', [
            'variants' => ProductVariant::all(),
            'warehouses' => Warehouse::all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $order = ProductionOrder::create($request->validate($this->rules()) + [
            'production_no' => ProductionOrder::generateProductionNo(),
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('production-orders.show', $order)
            ->with('success', 'Production order created successfully.');
    }

    public function show(ProductionOrder $productionOrder): View
    {
        $productionOrder->load(['productVariant', 'sourceWarehouse', 'creator']);

        return view('production_orders.show', ['order' => $productionOrder]);
    }

    public function edit(ProductionOrder $productionOrder): View
    {
        return view('production_orders.edit', [
            'order' => $productionOrder,
            'variants' => ProductVariant::all(),
            'warehouses' => Warehouse::all(),
        ]);
    }

    public function update(Request $request, ProductionOrder $productionOrder): RedirectResponse
    {
        $productionOrder->update($request->validate($this->rules()));

        return redirect()
            ->route('production-orders.show', $productionOrder)
            ->with('success', 'Production order updated successfully.');
    }

    public function destroy(ProductionOrder $productionOrder): RedirectResponse
    {
        $productionOrder->delete();

        return redirect()
            ->route('production-orders.index')
            ->with('success', 'Production order deleted successfully.');
    }

    private function rules(): array
    {
        return [
            'product_variant_id' => ['required', 'exists:product_variants,id'],
            'source_warehouse_id' => ['required', 'exists:warehouses,id'],
            'planned_qty' => ['required', 'integer', 'min:1'],
            'produced_qty' => ['sometimes', 'integer', 'min:0'],
            'wastage_qty' => ['sometimes', 'integer', 'min:0'],
            'start_date' => ['required', 'date'],
            'due_date' => ['required', 'date', 'after_or_equal:start_date'],
            'completed_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['sometimes', Rule::in(ProductionOrder::STATUSES)],
            'remarks' => ['nullable', 'string', 'max:255'],
        ];
    }
}