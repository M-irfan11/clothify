<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchaseOrders = PurchaseOrder::query()
            ->with(['supplier', 'warehouse'])
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('purchase_orders.index', compact('purchaseOrders'));
    }

    public function create()
    {
        $suppliers = Supplier::orderBy('id')->get();
        $warehouses = Warehouse::orderBy('id')->get();

        return view('purchase_orders.create', compact('suppliers', 'warehouses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        // total server-side এ হিসাব হবে
        $data['total_amount'] = $data['subtotal'] + ($data['tax_amount'] ?? 0);
        $data['created_by'] = auth()->id();

        $purchaseOrder = PurchaseOrder::create($data);

        return redirect()
            ->route('purchase_orders.show', $purchaseOrder)
            ->with('success', 'Purchase Order created successfully.');
    }

    public function show(PurchaseOrder $purchase_order)
    {
        $purchase_order->load(['supplier', 'warehouse', 'approver', 'creator']);

        return view('purchase_orders.show', ['purchaseOrder' => $purchase_order]);
    }

    public function edit(PurchaseOrder $purchase_order)
    {
        $suppliers = Supplier::orderBy('id')->get();
        $warehouses = Warehouse::orderBy('id')->get();

        return view('purchase_orders.edit', [
            'purchaseOrder' => $purchase_order,
            'suppliers' => $suppliers,
            'warehouses' => $warehouses,
        ]);
    }

    public function update(Request $request, PurchaseOrder $purchase_order)
    {
        $data = $request->validate($this->rules($purchase_order));

        $data['total_amount'] = $data['subtotal'] + ($data['tax_amount'] ?? 0);

        $purchase_order->update($data);

        return redirect()
            ->route('purchase_orders.show', $purchase_order)
            ->with('success', 'Purchase Order updated successfully.');
    }

    public function destroy(PurchaseOrder $purchase_order)
    {
        $purchase_order->delete();

        return redirect()
            ->route('purchase_orders.index')
            ->with('success', 'Purchase Order deleted successfully.');
    }

    /**
     * Validation rules (create ও update দুটোতেই ব্যবহৃত)।
     */
    private function rules(?PurchaseOrder $purchaseOrder = null): array
    {
        $id = $purchaseOrder?->id;

        return [
            'po_no' => [
                'required', 'string', 'max:30',
                Rule::unique('purchase_orders', 'po_no')->ignore($id),
            ],

            'so_no' => [
                'required', 'string', 'max:30',
                Rule::unique('purchase_orders', 'so_no')->ignore($id),
            ],

            'supplier_id' => ['required', 'integer', 'exists:suppliers,id'],
            'warehouse_id' => ['required', 'integer', 'exists:warehouses,id'],

            'order_date' => ['required', 'date'],
            'expected_date' => ['required', 'date', 'after_or_equal:order_date'],
            'received_date' => ['nullable', 'date', 'after_or_equal:order_date'],

            'subtotal' => ['required', 'numeric', 'min:0'],
            'tax_amount' => ['nullable', 'numeric', 'min:0'],
            'paid_amount' => ['nullable', 'numeric', 'min:0'],

            'payment_status' => ['required', Rule::in(['unpaid', 'partial', 'paid'])],

            'status' => ['required', Rule::in([
                'draft', 'approved', 'sent', 'partial_received', 'received', 'cancelled',
            ])],

            'approved_by' => ['nullable', 'integer', 'exists:users,id'],
            'remarks' => ['nullable', 'string', 'max:255'],
        ];
    }
}
