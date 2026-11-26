<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
          $customers = Customer::query()
            ->when($request->search, function ($q, $search) {
                $q->where(function ($q) use ($search) {
                    $q->where('customer_name', 'like', "%{$search}%")
                      ->orWhere('customer_code', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($request->customer_type, fn ($q, $type) => $q->where('customer_type', $type))
            ->when($request->status, fn ($q, $status) => $q->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

             return view('customers.index', [
            'customers' => $customers,
            'types'     => Customer::TYPES,
             ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('customers.create',['types'=> Customer::TYPES]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        Customer::create($this->validated($request));

        return redirect()->route('customers.index')
            ->with('success','Customer Created Successfully.');
            
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
        return view('customers.show',compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
        return view(customers.edit,[
            'customer'=> $customer,
            'types' => Customer::TYPES,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        //
        $customer->update($this->validated(request, $customer));

        return redirect()->route('customers.index')
        ->with('success', 'Customer updated Successfully');

        

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
         $customer->delete(); // soft delete

        return redirect()->route('customers.index')
            ->with('success', 'Customer successfully deleted.');
    }

     private function validated(Request $request, ?Customer $customer = null): array
    {
        return $request->validate([
            'customer_code'   => [
                'required', 'string', 'max:30',
                Rule::unique('customers', 'customer_code')->ignore($customer?->id),
            ],
            'customer_name'   => ['required', 'string', 'max:30'],
            'customer_type'   => ['required', Rule::in(Customer::TYPES)],
            'contact_person'  => ['nullable', 'string', 'max:100'],
            'phone'           => ['required', 'string', 'max:20'],
            'email'           => ['nullable', 'email', 'max:150'],
            'address'         => ['required', 'string', 'max:255'],
            'buyer_referance' => ['required', 'string', 'max:100'],
            'credit_limit'    => ['nullable', 'numeric', 'min:0', 'max:9999999999999999.99'],
            'status'          => ['required', Rule::in(['active', 'inactive'])],
        ]);
    }
}
