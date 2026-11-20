<?php

namespace Tests\Feature;

use App\Models\inventory_stock;
use App\Models\Material;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class InventoryStockTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_guest_is_redirected_to_login_from_inventory_stocks(): void
    {
        $response = $this->get(route('inventory_stocks.index'));

        $response->assertRedirect(route('login', absolute: false));
    }

    public function test_authenticated_user_can_complete_inventory_stock_crud(): void
    {
        $user = User::factory()->create();
        $warehouse = $this->warehouse();
        $material = $this->material();
        $variant = $this->variant();
        $this->actingAs($user);

        $data = [
            'warehouse_id' => $warehouse->id,
            'material_id' => $material->id,
            'product_variant_id' => null,
            'quantity' => '25.500',
            'reserved_qty' => '2.500',
        ];

        $createResponse = $this->post(route('inventory_stocks.store'), $data);
        $inventoryStock = inventory_stock::query()->where('material_id', $material->id)->firstOrFail();

        $createResponse->assertRedirect(route('inventory_stocks.show', $inventoryStock));
        $this->assertDatabaseHas('inventory_stocks', [
            'id' => $inventoryStock->id,
            'warehouse_id' => $warehouse->id,
            'material_id' => $material->id,
            'quantity' => '25.500',
            'reserved_qty' => '2.500',
        ]);

        $this->get(route('inventory_stocks.index'))
            ->assertOk()
            ->assertSee($material->material_name);
        $this->get(route('inventory_stocks.show', $inventoryStock))
            ->assertOk()
            ->assertSee($material->material_name);
        $this->get(route('inventory_stocks.edit', $inventoryStock))
            ->assertOk()
            ->assertSee('Edit Inventory Stock');

        $updateResponse = $this->put(route('inventory_stocks.update', $inventoryStock), [
            ...$data,
            'material_id' => null,
            'product_variant_id' => $variant->id,
            'quantity' => '30.000',
            'reserved_qty' => '4.000',
        ]);

        $updateResponse->assertRedirect(route('inventory_stocks.show', $inventoryStock));
        $this->assertDatabaseHas('inventory_stocks', [
            'id' => $inventoryStock->id,
            'warehouse_id' => $warehouse->id,
            'material_id' => null,
            'product_variant_id' => $variant->id,
            'quantity' => '30.000',
            'reserved_qty' => '4.000',
        ]);
        $this->get(route('inventory_stocks.show', $inventoryStock))
            ->assertOk()
            ->assertSee($variant->sku);

        $deleteResponse = $this->delete(route('inventory_stocks.destroy', $inventoryStock));

        $deleteResponse->assertRedirect(route('inventory_stocks.index'));
        $this->assertDatabaseMissing('inventory_stocks', ['id' => $inventoryStock->id]);
    }

    public function test_inventory_stock_requires_exactly_one_item_and_rejects_duplicates(): void
    {
        $this->actingAs(User::factory()->create());
        $warehouse = $this->warehouse();
        $material = $this->material();
        $variant = $this->variant();
        $data = [
            'warehouse_id' => $warehouse->id,
            'material_id' => null,
            'product_variant_id' => null,
            'quantity' => '10.000',
            'reserved_qty' => '0.000',
        ];

        $this->post(route('inventory_stocks.store'), $data)
            ->assertInvalid([
                'material_id' => 'required when product variant id is not present',
                'product_variant_id' => 'required when material id is not present',
            ]);

        $this->post(route('inventory_stocks.store'), [
            ...$data,
            'material_id' => $material->id,
            'product_variant_id' => $variant->id,
        ])->assertInvalid([
            'material_id' => 'prohibits product variant id from being present',
            'product_variant_id' => 'prohibits material id from being present',
        ]);

        inventory_stock::create([
            ...$data,
            'material_id' => $material->id,
        ]);

        $this->post(route('inventory_stocks.store'), [
            ...$data,
            'material_id' => $material->id,
        ])->assertInvalid(['material_id' => 'has already been taken']);

        $this->assertDatabaseCount('inventory_stocks', 1);
    }

    public function test_reserved_quantity_cannot_exceed_on_hand_quantity(): void
    {
        $this->actingAs(User::factory()->create());
        $warehouse = $this->warehouse();
        $material = $this->material();

        $this->post(route('inventory_stocks.store'), [
            'warehouse_id' => $warehouse->id,
            'material_id' => $material->id,
            'product_variant_id' => null,
            'quantity' => '5.000',
            'reserved_qty' => '6.000',
        ])->assertInvalid([
            'reserved_qty' => 'less than or equal to 5.000',
        ]);

        $this->assertDatabaseCount('inventory_stocks', 0);
    }

    private function warehouse(): Warehouse
    {
        return Warehouse::create([
            'warehouse_name' => 'Main Warehouse',
            'warehouse_code' => 'WH-001',
            'warehouse_type' => 'both',
            'address' => '100 Warehouse Road',
            'status' => 'active',
        ]);
    }

    private function material(): Material
    {
        return Material::create([
            'material_code' => 'MAT-001',
            'material_name' => 'Cotton Fabric',
            'category' => 'fabric',
            'unit' => 'meter',
            'unit_cost' => '2.50',
            'reorder_level' => '10.00',
            'safety_stock' => '5.00',
            'status' => 'active',
        ]);
    }

    private function variant(): ProductVariant
    {
        $product = Product::create([
            'product_code' => 'PRD-001',
            'product_name' => 'Basic T-Shirt',
            'category' => 'tops',
            'febric_type' => 'cotton',
            'status' => 'active',
        ]);

        return ProductVariant::create([
            'product_id' => $product->id,
            'sku' => 'TSHIRT-BLK-M',
            'size' => 'M',
            'color' => 'Black',
            'cost_price' => '5.00',
            'selling_price' => '12.00',
            'status' => 'active',
        ]);
    }
}
