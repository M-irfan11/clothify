<?php

namespace Tests\Feature;

use App\Models\PurchaseOrder;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseOrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_renders_purchase_orders_and_keeps_the_paginator_available(): void
    {
        $user = User::factory()->create();
        $warehouse = Warehouse::create([
            'warehouse_name' => 'Pagination Warehouse',
            'warehouse_code' => 'WH-PAGE-001',
            'warehouse_type' => 'both',
            'address' => '100 Warehouse Road',
            'status' => 'active',
        ]);
        PurchaseOrder::create([
            'po_no' => 'PO-PAGE-001',
            'supplier_id' => 1,
            'warehouse_id' => $warehouse->id,
            'order_date' => '2026-11-21',
            'expected_date' => '2026-11-30',
            'subtotal' => '25.00',
            'tax_amount' => '0.00',
            'total_amount' => '25.00',
            'paid_amount' => '0.00',
            'payment_status' => 'unpaid',
            'status' => 'draft',
            'created_by' => $user->id,
        ]);

        $this->actingAs($user)
            ->get(route('purchase_orders.index'))
            ->assertOk()
            ->assertViewIs('purchase_orders.index')
            ->assertSee('PO-PAGE-001')
            ->assertSee('Pagination Warehouse');
    }
}
