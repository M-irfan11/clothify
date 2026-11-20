<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\ProductVariant;
use App\Models\stock_movement;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator as ValidatorInstance;
use Illuminate\View\View;

class StockMovementController extends Controller
{
    public function index(): View
    {
        $stockMovements = stock_movement::query()
            ->with(['warehouse', 'material', 'productVariant.product', 'creator'])
            ->orderByDesc('movement_date')
            ->orderByDesc('id')
            ->paginate(15);

        return view('stock_movement.index', compact('stockMovements'));
    }

    public function create(): View
    {
        return view('stock_movement.create', $this->formData());
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['created_by'] = $request->user()->getAuthIdentifier();

        $stockMovement = stock_movement::create($data);

        return redirect()
            ->route('stock_movements.show', $stockMovement)
            ->with('success', 'Stock movement created successfully.');
    }

    public function show(stock_movement $stock_movement): View
    {
        $stock_movement->load(['warehouse', 'material', 'productVariant.product', 'creator']);

        return view('stock_movement.show', ['stockMovement' => $stock_movement]);
    }

    public function edit(stock_movement $stock_movement): View
    {
        return view('stock_movement.edit', ['stockMovement' => $stock_movement] + $this->formData());
    }

    public function update(Request $request, stock_movement $stock_movement): RedirectResponse
    {
        $stock_movement->update($this->validated($request));

        return redirect()
            ->route('stock_movements.show', $stock_movement)
            ->with('success', 'Stock movement updated successfully.');
    }

    public function destroy(stock_movement $stock_movement): RedirectResponse
    {
        $stock_movement->delete();

        return redirect()
            ->route('stock_movements.index')
            ->with('success', 'Stock movement deleted successfully.');
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
    private function validated(Request $request): array
    {
        $validator = Validator::make($request->all(), [
            'warehouse_id' => ['required', 'integer', 'exists:warehouses,id'],
            'material_id' => [
                'nullable',
                'required_without:product_variant_id',
                'prohibits:product_variant_id',
                'integer',
                'exists:materials,id',
            ],
            'product_variant_id' => [
                'nullable',
                'required_without:material_id',
                'prohibits:material_id',
                'integer',
                'exists:product_variants,id',
            ],
            'movement_type' => ['required', Rule::in(array_keys(stock_movement::MOVEMENT_TYPES))],
            'quantity' => [
                'required',
                'numeric',
                'between:-99999999999.999,99999999999.999',
                'not_in:0',
            ],
            'unit_cost' => ['nullable', 'numeric', 'min:0'],
            'reference_type' => [
                'nullable',
                'required_with:reference_id',
                Rule::in(array_keys(stock_movement::REFERENCE_TYPES)),
            ],
            'reference_id' => ['nullable', 'required_with:reference_type', 'integer', 'min:1'],
            'movement_date' => ['required', 'date'],
            'remarks' => ['nullable', 'string', 'max:255'],
        ]);

        $validator->after(function (ValidatorInstance $validator) use ($request): void {
            if ($validator->errors()->has('movement_type') || $validator->errors()->has('quantity')) {
                return;
            }

            $movementType = $request->input('movement_type');
            $quantity = (float) $request->input('quantity');

            if (in_array($movementType, stock_movement::POSITIVE_QUANTITY_TYPES, true) && $quantity <= 0) {
                $validator->errors()->add('quantity', 'Quantity must be positive for this movement type.');
            } elseif (in_array($movementType, stock_movement::NEGATIVE_QUANTITY_TYPES, true) && $quantity >= 0) {
                $validator->errors()->add('quantity', 'Quantity must be negative for this movement type.');
            }
        });

        return $validator->validate();
    }
}
