<?php

namespace Tests\Feature;

use App\Models\Material;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\stock_movement;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class StockMovementTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_guest_is_redirected_to_login_from_stock_movements(): void
    {
        $response = $this->get(route('stock_movements.index'));

        $response->assertRedirect(route('login', absolute: false));
    }

    public function test_authenticated_user_can_complete_stock_movement_crud(): void
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $warehouse = $this->warehouse();
        $material = $this->material();
        $variant = $this->variant();
        $this->actingAs($user);

        $data = [
            'warehouse_id' => $warehouse->id,
            'material_id' => $material->id,
            'product_variant_id' => null,
            'movement_type' => 'purchase_in',
            'quantity' => '12.500',
            'unit_cost' => '1.25',
            'reference_type' => 'purchase_order',
            'reference_id' => 501,
            'movement_date' => '2026-11-20T12:30',
            'remarks' => 'Received from supplier',
            'created_by' => $anotherUser->id,
        ];

        $createResponse = $this->post(route('stock_movements.store'), $data);
        $stockMovement = stock_movement::query()->where('reference_id', 501)->firstOrFail();

        $createResponse->assertRedirect(route('stock_movements.show', $stockMovement));
        $this->assertDatabaseHas('stock_movements', [
            'id' => $stockMovement->id,
            'warehouse_id' => $warehouse->id,
            'material_id' => $material->id,
            'movement_type' => 'purchase_in',
            'quantity' => '12.500',
            'created_by' => $user->id,
        ]);

        $this->get(route('stock_movements.index'))
            ->assertOk()
            ->assertSee($material->material_name)
            ->assertSee('Purchase In');
        $this->get(route('stock_movements.show', $stockMovement))
            ->assertOk()
            ->assertSee($user->name);
        $this->get(route('stock_movements.edit', $stockMovement))
            ->assertOk()
            ->assertSee('Edit Stock Movement');

        $updateResponse = $this->put(route('stock_movements.update', $stockMovement), [
            ...$data,
            'material_id' => null,
            'product_variant_id' => $variant->id,
            'movement_type' => 'sale_out',
            'quantity' => '-2.000',
            'created_by' => $anotherUser->id,
        ]);

        $updateResponse->assertRedirect(route('stock_movements.show', $stockMovement));
        $this->assertDatabaseHas('stock_movements', [
            'id' => $stockMovement->id,
            'warehouse_id' => $warehouse->id,
            'material_id' => null,
            'product_variant_id' => $variant->id,
            'movement_type' => 'sale_out',
            'quantity' => '-2.000',
            'created_by' => $user->id,
        ]);
        $this->get(route('stock_movements.show', $stockMovement))
            ->assertOk()
            ->assertSee($variant->sku);

        $deleteResponse = $this->delete(route('stock_movements.destroy', $stockMovement));

        $deleteResponse->assertRedirect(route('stock_movements.index'));
        $this->assertDatabaseMissing('stock_movements', ['id' => $stockMovement->id]);
    }

    public function test_movement_validates_item_selection_and_quantity_direction(): void
    {
        $this->actingAs(User::factory()->create());
        $warehouse = $this->warehouse();
        $material = $this->material();
        $variant = $this->variant();
        $data = [
            'warehouse_id' => $warehouse->id,
            'material_id' => $material->id,
            'product_variant_id' => null,
            'movement_type' => 'purchase_in',
            'quantity' => '-2.000',
            'movement_date' => '2026-11-20T12:30',
        ];

        $this->post(route('stock_movements.store'), $data)
            ->assertInvalid([
                'quantity' => 'Quantity must be positive for this movement type.',
            ]);

        $this->post(route('stock_movements.store'), [
            ...$data,
            'product_variant_id' => $variant->id,
            'quantity' => '2.000',
        ])->assertInvalid([
            'material_id' => 'prohibits product variant id from being present',
            'product_variant_id' => 'prohibits material id from being present',
        ]);

        $this->assertDatabaseCount('stock_movements', 0);
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
