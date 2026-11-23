<?php

namespace App\Http\Controllers;

use App\Models\ProductionOrderMaterial;
use Illuminate\Http\Request;

class ProductionOrderMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductionOrder $productionOrder)
    {
        //
        $items= $productionOrder->Materials->with('materieal')->get();
        return view('production_order_materials.index', compact('production_order','items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(ProductionOrder $productionOrder)
    {
        //
        $materials = Material::orderBy(name)->get();
        return view('production_order_materials.create', compact('productionOrders','materials'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ProductionOrder $productionOrder)
    {
        //
        $data =request->validate(
            [
                'material_id' => [
                    'requred',
                    'exists:materials,id',
                Rule::unique('production_order_materials')
                    ->where('production_order_id', $productionOrder->id),
                ],
                
                    'planned_qty' => 'required|numeric|min:0',
                    'issued_qty'  => 'nullable|numeric|min:0',
                    'used_qty'    => 'nullable|numeric|min:0',
                    'return_qty'  => 'nullable|numeric|min:0',
                    'wastage_qty' => 'nullable|numeric|min:0',
                
            ]
        );

         return redirect()
            ->route('production-orders.materials.index', $productionOrder)
            ->with('success', 'Material added successfully.');



    }

    /**
     * Display the specified resource.
     */
    public function show(ProductionOrderMaterial $productionOrderMaterial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductionOrderMaterial $productionOrderMaterial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductionOrderMaterial $productionOrderMaterial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductionOrderMaterial $productionOrderMaterial)
    {
        //
    }
}
