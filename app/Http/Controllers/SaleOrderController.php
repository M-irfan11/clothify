<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\SalesOrder;
use App\Models\Warehouse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SaleOrderController extends Controller
{
    public function index(): View
    {
        $orders = SalesOrder::query()
            ->with(['customer', 'warehouse'])
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('sales_order.index', compact('orders'));
    }

    public function create(): View
    {
        return view('sales_order.create', [
            'customers' => Customer::query()->orderBy('customer_name')->get(),
            'warehouses' => Warehouse::query()->orderBy('warehouse_name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules());
        $data['order_no'] = 'SO-'.now()->format('YmdHis');
        $data['created_by'] = $request->user()->id;
        $data['total_amount'] = $this->totalAmount($data);

        $order = SalesOrder::create($data);

        return redirect()
            ->route('sales_orders.show', $order)
            ->with('success', 'Sales order created successfully.');
    }

    public function show(SalesOrder $saleOrder): View
    {
        $saleOrder->load(['customer', 'warehouse', 'creator']);

        return view('sales_order.show', ['order' => $saleOrder]);
    }

    public function edit(SalesOrder $saleOrder): View
    {
        return view('sales_order.edit', [
            'order' => $saleOrder,
            'customers' => Customer::query()->orderBy('customer_name')->get(),
            'warehouses' => Warehouse::query()->orderBy('warehouse_name')->get(),
        ]);
    }

    public function update(Request $request, SalesOrder $saleOrder): RedirectResponse
    {
        $data = $request->validate($this->rules());
        $data['total_amount'] = $this->totalAmount($data);

        $saleOrder->update($data);

        return redirect()
            ->route('sales_orders.show', $saleOrder)
            ->with('success', 'Sales order updated successfully.');
    }

    public function destroy(SalesOrder $saleOrder): RedirectResponse
    {
        $saleOrder->delete();

        return redirect()
            ->route('sales_orders.index')
            ->with('success', 'Sales order deleted successfully.');
    }

    private function totalAmount(array $data): float
    {
        return (float) $data['subtotal']
            - (float) ($data['discount_amount'] ?? 0)
            + (float) ($data['shipping_cost'] ?? 0);
    }

    private function rules(): array
    {
        return [
            'buyer_po_no' => ['nullable', 'string', 'max:50'],
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'warehouse_id' => ['required', 'integer', 'exists:warehouses,id'],
            'order_date' => ['required', 'date'],
            'required_date' => ['required', 'date', 'after_or_equal:order_date'],
            'subtotal' => ['required', 'numeric', 'min:0'],
            'discount_amount' => ['nullable', 'numeric', 'min:0'],
            'shipping_cost' => ['nullable', 'numeric', 'min:0'],
            'paid_amount' => ['nullable', 'numeric', 'min:0'],
            'payment_status' => ['required', Rule::in(SalesOrder::PAYMENT_STATUSES)],
            'status' => ['required', Rule::in(SalesOrder::STATUSES)],
            'shipping_address' => ['required', 'string', 'max:255'],
            'remarks' => ['nullable', 'string', 'max:255'],
        ];
    }
}
