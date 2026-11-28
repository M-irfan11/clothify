<?php

namespace App\Http\Controllers;

use App\Models\bom_item;
use App\Models\Material;
use App\Models\ProductVariant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BomItemController extends Controller
{
    public function index(Request $request): View
    {
        $bomItems = bom_item::query()
            ->with(['productVariant', 'material'])
            ->when($request->filled('product_variant_id'), function ($query) use ($request) {
                $query->where('product_variant_id', $request->product_variant_id);
            })
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('bom_item.index', compact('bomItems'));
    }

    public function create(): View
    {
        return view('bom_item.create', $this->formData());
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->bulkRules());
        $materialIds = collect($data['materials'])->pluck('material_id');

        if (bom_item::query()
            ->where('product_variant_id', $data['product_variant_id'])
            ->whereIn('material_id', $materialIds)
            ->exists()) {
            throw ValidationException::withMessages([
                'materials' => 'One or more selected materials are already linked to this product variant.',
            ]);
        }

        DB::transaction(function () use ($data): void {
            foreach ($data['materials'] as $material) {
                bom_item::create([
                    'product_variant_id' => $data['product_variant_id'],
                    'material_id' => $material['material_id'],
                    'quantity_per_unit' => $material['quantity_per_unit'],
                    'wastage_percent' => $material['wastage_percent'] ?? 0,
                ]);
            }
        });

        return redirect()
            ->route('bom_items.index', ['product_variant_id' => $data['product_variant_id']])
            ->with('success', 'Recipe materials created successfully.');
    }

    public function show(bom_item $bom_item): View
    {
        $bom_item->load(['productVariant', 'material']);

        return view('bom_item.show', ['bomItem' => $bom_item]);
    }

    public function edit(bom_item $bom_item): View
    {
        return view('bom_item.edit', ['bomItem' => $bom_item] + $this->formData());
    }

    public function update(Request $request, bom_item $bom_item): RedirectResponse
    {
        $bom_item->update($this->validated($request, $bom_item));

        return redirect()
            ->route('bom_items.show', $bom_item)
            ->with('success', 'BOM item updated successfully.');
    }

    public function destroy(bom_item $bom_item): RedirectResponse
    {
        $bom_item->delete();

        return redirect()
            ->route('bom_items.index')
            ->with('success', 'BOM item deleted successfully.');
    }

    private function formData(): array
    {
        return [
            'variants' => ProductVariant::query()->get(),
            'materials' => Material::query()->get(),
        ];
    }

    private function validated(Request $request, ?bom_item $bomItem = null): array
    {
        $data = $request->validate($this->rules($request, $bomItem));

        $data['wastage_percent'] = $data['wastage_percent'] ?? 0;

        return $data;
    }

    private function rules(Request $request, ?bom_item $bomItem = null): array
    {
        // product_variant_id + material_id combination unique hote hobe
        $materialRule = Rule::unique('bom_items', 'material_id')
            ->where('product_variant_id', $request->input('product_variant_id'));

        if ($bomItem !== null) {
            $materialRule->ignore($bomItem);
        }

        return [
            'product_variant_id' => ['required', 'integer', 'exists:product_variants,id'],
            'material_id' => ['required', 'integer', 'exists:materials,id', $materialRule],
            'quantity_per_unit' => ['required', 'numeric', 'min:0.0001', 'max:9999999999.9999'],
            'wastage_percent' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ];
    }

    private function bulkRules(): array
    {
        return [
            'product_variant_id' => ['required', 'integer', 'exists:product_variants,id'],
            'materials' => ['required', 'array', 'min:1'],
            'materials.*.material_id' => ['required', 'integer', 'distinct', 'exists:materials,id'],
            'materials.*.quantity_per_unit' => ['required', 'numeric', 'min:0.0001', 'max:9999999999.9999'],
            'materials.*.wastage_percent' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ];
    }
}
