<?php

namespace Tests\Feature;

use App\Models\Material;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseOrderItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_purchase_order_items(): void
    {
        $this->get(route('purchase_order_items.index'))
            ->assertRedirect(route('login', absolute: false));
    }

    public function test_index_renders_purchase_order_items_blade_view(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('purchase_order_items.index'))
            ->assertOk()
            ->assertViewIs('purchase_order_item.index')
            ->assertSee('Purchase Order Items')
            ->assertSee('No purchase order items found.');
    }

    public function test_create_renders_purchase_order_item_form(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('purchase_order_items.create'))
            ->assertOk()
            ->assertViewIs('purchase_order_item.create')
            ->assertSee('Add PO Item')
            ->assertSee('Select purchase order')
            ->assertSee('Select material');
    }

    public function test_purchase_order_item_pages_work_with_existing_order_and_material(): void
    {
        $user = User::factory()->create();
        Supplier::query()->insert([
            'id' => 1,
            'supplier_code' => 'SUP-POI-001',
            'company_name' => 'PO Item Supplier',
            'contact_person' => 'Alex Supplier',
            'phone' => '0123456789',
            'address' => '100 Supplier Road',
            'supplier_type' => 'fabric',
            'status' => 'active',
        ]);
        $supplier = Supplier::query()->where('supplier_code', 'SUP-POI-001')->firstOrFail();
        $warehouse = Warehouse::create([
            'warehouse_name' => 'PO Item Warehouse',
            'warehouse_code' => 'WH-POI-001',
            'warehouse_type' => 'both',
            'address' => '100 Warehouse Road',
            'status' => 'active',
        ]);
        $purchaseOrder = PurchaseOrder::create([
            'po_no' => 'PO-UI-001',
            'so_no' => 'SO-UI-001',
            'supplier_id' => $supplier->id,
            'warehouse_id' => $warehouse->id,
            'order_date' => '2026-11-21',
            'expected_date' => '2026-11-30',
            'subtotal' => '37.50',
            'tax_amount' => '0.00',
            'total_amount' => '37.50',
            'paid_amount' => '0.00',
            'payment_status' => 'unpaid',
            'status' => 'draft',
            'created_by' => $user->id,
        ]);
        $material = Material::create([
            'supplier_id' => $supplier->id,
            'material_code' => 'MAT-POI-001',
            'material_name' => 'PO Item Material',
            'category' => 'fabric',
            'unit' => 'meter',
            'unit_cost' => '12.50',
            'reorder_level' => '0.00',
            'safety_stock' => '0.00',
            'status' => 'active',
        ]);

        $this->actingAs($user)
            ->get(route('purchase_order_items.create'))
            ->assertOk()
            ->assertSee('PO-UI-001')
            ->assertSee('PO Item Material');

        $response = $this->post(route('purchase_order_items.store'), [
            'purchase_order_id' => $purchaseOrder->id,
            'material_id' => $material->id,
            'ordered_qty' => '3.000',
            'unit_price' => '12.50',
        ]);
        $purchaseOrderItem = PurchaseOrderItem::query()->firstOrFail();

        $response->assertRedirect(route('purchase_order_items.show', $purchaseOrderItem));
        $this->assertDatabaseHas('purchase_order_items', [
            'id' => $purchaseOrderItem->id,
            'purchase_order_id' => $purchaseOrder->id,
            'material_id' => $material->id,
            'line_total' => '37.50',
        ]);

        $this->get(route('purchase_order_items.show', $purchaseOrderItem))
            ->assertOk()
            ->assertViewIs('purchase_order_item.show')
            ->assertSee('PO Item Material')
            ->assertSee('PO-UI-001');

        $this->get(route('purchase_order_items.edit', $purchaseOrderItem))
            ->assertOk()
            ->assertViewIs('purchase_order_item.edit')
            ->assertSee('Edit PO Item');

        $this->get(route('purchase_order_items.index'))
            ->assertOk()
            ->assertViewIs('purchase_order_item.index')
            ->assertSee('PO Item Material')
            ->assertSee('PO-UI-001');
    }
}
