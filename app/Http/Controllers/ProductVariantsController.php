<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductVariantsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $product_variants = ProductVariant::query()
            ->with('product')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('product_variants.index', compact('product_variants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $products = Product::orderBy('id')->get();

        return view('product_variants.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $product_variant = ProductVariant::create(
            $request->validate($this->rules())
        );

        return redirect()
            ->route('product_variants.show', $product_variant)
            ->with('success', 'Product variant created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductVariant $product_variant): View
    {
        $product_variant->load('product');

        return view('product_variants.show', compact('product_variant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductVariant $product_variant): View
    {
        $products = Product::orderBy('id')->get();

        return view('product_variants.edit', compact('product_variant', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductVariant $product_variant): RedirectResponse
    {
        $product_variant->update(
            $request->validate($this->rules($product_variant))
        );

        return redirect()
            ->route('product_variants.show', $product_variant)
            ->with('success', 'Product variant updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductVariant $product_variant): RedirectResponse
    {
        $product_variant->delete();

        return redirect()
            ->route('product_variants.index')
            ->with('success', 'Product variant deleted successfully.');
    }

    /**
     * Validation rules (create ও update দুটোতেই ব্যবহৃত)।
     */
    private function rules(?ProductVariant $variant = null): array
    {
        $id = $variant?->id;

        return [
            'product_id' => ['required', 'integer', 'exists:products,id'],

            'sku' => [
                'required', 'string', 'max:40',
                Rule::unique('product_variants', 'sku')->ignore($id),
            ],

            'size' => ['required', Rule::in(['S', 'M', 'L', 'XL', 'XXL'])],

            'color' => [
                'required', 'string', 'max:30',
                // (product_id + size + color) একসাথে unique
                Rule::unique('product_variants', 'color')
                    ->where(fn ($q) => $q
                        ->where('product_id', request('product_id'))
                        ->where('size', request('size')))
                    ->ignore($id),
            ],

            'cost_price' => ['required', 'numeric', 'min:0'],
            'selling_price' => ['required', 'numeric', 'min:0', 'gte:cost_price'],
            'reorder_level' => ['nullable', 'integer', 'min:0'],
            'status' => ['nullable', Rule::in(['active', 'inactive'])],
        ];
    }
}
