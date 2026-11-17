<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function index(): View
    {
        $suppliers = Supplier::query()
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('suppliers.index', compact('suppliers'));
    }

    public function create(): View
    {
        return view('suppliers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $supplier = Supplier::create($request->validate($this->rules()));

        return redirect()
            ->route('suppliers.show', $supplier)
            ->with('success', 'Supplier created successfully.');
    }

    public function show(Supplier $supplier): View
    {
        return view('suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier): View
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier): RedirectResponse
    {
        $supplier->update($request->validate($this->rules($supplier)));

        return redirect()
            ->route('suppliers.show', $supplier)
            ->with('success', 'Supplier updated successfully.');
    }

    public function destroy(Supplier $supplier): RedirectResponse
    {
        $supplier->delete();

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier deleted successfully.');
    }

    private function rules(?Supplier $supplier = null): array
    {
        $supplierCodeRule = Rule::unique('suppliers', 'supplier_code');

        if ($supplier !== null) {
            $supplierCodeRule->ignore($supplier);
        }

        return [
            'supplier_code' => ['required', 'string', 'max:30', $supplierCodeRule],
            'company_name' => ['required', 'string', 'max:150'],
            'contact_person' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:150'],
            'address' => ['required', 'string', 'max:255'],
            'supplier_type' => ['required', Rule::in(array_keys(Supplier::TYPES))],
            'payment_terms_days' => ['required', 'integer', 'min:0'],
            'lead_time_days' => ['required', 'integer', 'min:0'],
            'rating' => ['nullable', 'numeric', 'decimal:0,2', 'min:0', 'max:9.99'],
            'status' => ['required', Rule::in(array_keys(Supplier::STATUSES))],
        ];
    }
}
