<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductsController extends Controller
{
    public function index(): View
    {
        $products = Product::query()
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('products.index', compact('products'));
    }

    public function create(): View
    {
        return view('products.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $product = Product::create($request->validate($this->rules()));

        return redirect()
            ->route('products.show', $product)
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product): View
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $product->update($request->validate($this->rules($product)));

        return redirect()
            ->route('products.show', $product)
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product moved to trash.');
    }

    private function rules(?Product $product = null): array
    {
        $productCodeRule = Rule::unique('products', 'product_code');

        if ($product !== null) {
            $productCodeRule->ignore($product);
        }

        return [
            'product_code' => ['required', 'string', 'max:30', $productCodeRule],
            'product_name' => ['required', 'string', 'max:150'],
            'category' => ['required', Rule::in(array_keys(Product::CATEGORIES))],
            'febric_type' => ['required', Rule::in(array_keys(Product::FEBRIC_TYPES))],
            'description' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(array_keys(Product::STATUSES))],
        ];
    }
}
