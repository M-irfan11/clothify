<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use App\Models\SaleOrderItem;
use App\Models\SalesOrder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SaleOrderItemController extends Controller
{
    public function index(SalesOrder $salesOrder): View
    {
        $items = $salesOrder->items()
            ->with('productVariant')
            ->latest()
            ->paginate(15);

        return view('sale_order_item.index', compact('salesOrder', 'items'));
    }

    public function create(SalesOrder $salesOrder): View
    {
        $variants = ProductVariant::orderBy('id')->get();

        return view('sale_order_item.create', compact('salesOrder', 'variants'));
    }

    public function show(SalesOrder $salesOrder, SaleOrderItem $item): View
    {
        $item->load('productVariant');

        return view('sale_order_item.show', compact('salesOrder', 'item'));
    }

    public function store(Request $request, SalesOrder $salesOrder): RedirectResponse
    {
        $salesOrder->items()->create($request->validate($this->rules()));

        return redirect()
            ->route('sales_orders.items.index', $salesOrder)
            ->with('success', 'Item added successfully.');
    }

    public function edit(SalesOrder $salesOrder, SaleOrderItem $item): View
    {
        $variants = ProductVariant::orderBy('id')->get();

        return view('sale_order_item.edit', compact('salesOrder', 'item', 'variants'));
    }

    public function update(Request $request, SalesOrder $salesOrder, SaleOrderItem $item): RedirectResponse
    {
        $item->update($request->validate($this->rules()));

        return redirect()
            ->route('sales_orders.items.index', $salesOrder)
            ->with('success', 'Item updated successfully.');
    }

    public function destroy(SalesOrder $salesOrder, SaleOrderItem $item): RedirectResponse
    {
        $item->delete();

        return redirect()
            ->route('sales_orders.items.index', $salesOrder)
            ->with('success', 'Item deleted successfully.');
    }

    private function rules(): array
    {
        return [
            'product_variant_id' => ['required', 'exists:product_variants,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'reserved_qty' => ['required', 'integer', 'min:0', 'lte:quantity'],
            'shipped_qty' => ['required', 'integer', 'min:0', 'lte:quantity'],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'discount_percent' => ['required', 'numeric', 'min:0', 'max:100'],
        ];
    }
}
