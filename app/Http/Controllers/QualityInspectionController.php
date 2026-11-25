<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\ProductionOrder;
use App\Models\ProductVariant;
use App\Models\PurchaseOrderItem;
use App\Models\QualityInspection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class QualityInspectionController extends Controller
{
    public function index(): View
    {
        $inspections = QualityInspection::query()
            ->orderByDesc('inspection_date')
            ->paginate(15);

        return view('quality_inspections.index', compact('inspections'));
    }

    public function create(): View
    {
        return view('quality_inspections.create', [
            'purchaseOrderItems' => PurchaseOrderItem::all(),
            'productionOrders'   => ProductionOrder::all(),
            'materials'          => Material::all(),
            'productVariants'    => ProductVariant::all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $inspection = QualityInspection::create($request->validate($this->rules()));

        return redirect()
            ->route('quality-inspections.show', $inspection)
            ->with('success', 'Quality inspection created successfully.');
    }

    public function show(QualityInspection $qualityInspection): View
    {
        return view('quality_inspections.show', ['inspection' => $qualityInspection]);
    }

    public function edit(QualityInspection $qualityInspection): View
    {
        return view('quality_inspections.edit', [
            'inspection'         => $qualityInspection,
            'purchaseOrderItems' => PurchaseOrderItem::all(),
            'productionOrders'   => ProductionOrder::all(),
            'materials'          => Material::all(),
            'productVariants'    => ProductVariant::all(),
        ]);
    }

    public function update(Request $request, QualityInspection $qualityInspection): RedirectResponse
    {
        $qualityInspection->update($request->validate($this->rules($qualityInspection)));

        return redirect()
            ->route('quality-inspections.show', $qualityInspection)
            ->with('success', 'Quality inspection updated successfully.');
    }

    public function destroy(QualityInspection $qualityInspection): RedirectResponse
    {
        $qualityInspection->delete();

        return redirect()
            ->route('quality-inspections.index')
            ->with('success', 'Quality inspection deleted successfully.');
    }

    private function rules(?QualityInspection $inspection = null): array
    {
        $inspectionNoRule = Rule::unique('quality_inspections', 'inspection_no');

        if ($inspection !== null) {
            $inspectionNoRule->ignore($inspection);
        }

        return [
            'inspection_no' => ['required', 'string', 'max:30', $inspectionNoRule],
            'inspection_type' => ['required', Rule::in(array_keys(QualityInspection::TYPES))],
            'purchase_order_item_id' => ['nullable', 'exists:purchase_order_items,id'],
            'production_order_id' => ['nullable', 'exists:production_orders,id'],
            'material_id' => ['nullable', 'exists:materials,id'],
            'product_variant_id' => ['nullable', 'exists:product_variants,id'],
            'inspected_qty' => ['required', 'numeric', 'min:0'],
            'passed_qty' => ['required', 'numeric', 'min:0', 'lte:inspected_qty'],
            'rejected_qty' => ['required', 'numeric', 'min:0', 'lte:inspected_qty'],
            'rework_qty' => ['required', 'numeric', 'min:0', 'lte:inspected_qty'],
            'defect_details' => ['nullable', 'string'],
            'remarks' => ['nullable', 'string'],
            'inspected_by' => ['required', 'exists:users,id'],
            'inspection_date' => ['required', 'date'],
        ];
    }
}