<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PurchaseOrderItemController extends Controller
{
    public function index(): View
    {
        $purchaseOrderItems = PurchaseOrderItem::query()
            ->with(['material', 'purchaseOrder'])
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('purchase_order_item.index', compact('purchaseOrderItems'));
    }

    public function create(): View
    {
        $purchaseOrders = PurchaseOrder::query()
            ->orderByDesc('order_date')
            ->get(['id', 'po_no']);
        $materials = Material::query()
            ->where('status', 'active')
            ->orderBy('material_name')
            ->get(['id', 'material_name']);

        return view('purchase_order_item.create', compact('purchaseOrders', 'materials'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'purchase_order_id' => ['required', 'integer', 'exists:purchase_orders,id'],
            'material_id' => ['required', 'integer', 'exists:materials,id'],
            'ordered_qty' => ['required', 'numeric', 'gt:0'],
            'unit_price' => ['required', 'numeric', 'min:0'],
        ]);

        if (PurchaseOrderItem::query()
            ->where('purchase_order_id', $data['purchase_order_id'])
            ->where('material_id', $data['material_id'])
            ->exists()) {
            throw ValidationException::withMessages([
                'material_id' => 'এই material এই PO-তে আগেই যোগ করা হয়েছে।',
            ]);
        }

        $purchaseOrderItem = PurchaseOrderItem::create($data);

        return redirect()
            ->route('purchase_order_items.show', $purchaseOrderItem)
            ->with('success', 'Purchase order item created successfully.');
    }

    public function show(PurchaseOrderItem $purchase_order_item): View
    {
        $purchase_order_item->load(['material', 'purchaseOrder']);

        return view('purchase_order_item.show', ['purchaseOrderItem' => $purchase_order_item]);
    }

    public function edit(PurchaseOrderItem $purchase_order_item): View
    {
        $purchase_order_item->load(['material', 'purchaseOrder']);

        return view('purchase_order_item.edit', ['purchaseOrderItem' => $purchase_order_item]);
    }

    public function update(Request $request, PurchaseOrderItem $purchase_order_item): RedirectResponse
    {
        $data = $request->validate([
            'ordered_qty' => ['required', 'numeric', 'gt:0'],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'received_qty' => ['required', 'numeric', 'min:0'],
            'accepted_qty' => ['required', 'numeric', 'min:0'],
            'rejected_qty' => ['required', 'numeric', 'min:0'],
        ]);

        if (bccomp((string) $data['ordered_qty'], (string) $purchase_order_item->received_qty, 3) < 0) {
            throw ValidationException::withMessages([
                'ordered_qty' => 'Ordered qty, received qty-র চেয়ে কম হতে পারে না।',
            ]);
        }

        if (bccomp((string) $data['received_qty'], (string) $data['ordered_qty'], 3) > 0) {
            throw ValidationException::withMessages([
                'received_qty' => 'Received qty, ordered qty-র চেয়ে বেশি হতে পারে না।',
            ]);
        }

        $receivedTotal = bcadd((string) $data['accepted_qty'], (string) $data['rejected_qty'], 3);

        if (bccomp($receivedTotal, (string) $data['received_qty'], 3) !== 0) {
            throw ValidationException::withMessages([
                'accepted_qty' => 'Accepted + Rejected অবশ্যই Received-এর সমান হতে হবে।',
            ]);
        }

        $purchase_order_item->update($data);

        return redirect()
            ->route('purchase_order_items.show', $purchase_order_item)
            ->with('success', 'Purchase order item updated successfully.');
    }

    public function destroy(PurchaseOrderItem $purchase_order_item): RedirectResponse
    {
        if ($purchase_order_item->received_qty > 0) {
            return back()->with('error', 'Receive হয়ে যাওয়া item ডিলিট করা যাবে না।');
        }

        $purchase_order_item->delete();

        return redirect()
            ->route('purchase_order_items.index')
            ->with('success', 'Purchase order item deleted successfully.');
    }
}
