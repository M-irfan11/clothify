<?php

namespace Tests\Feature;

use App\Models\Material;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BomItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_a_recipe_with_multiple_materials(): void
    {
        $user = User::factory()->create();
        $variant = ProductVariant::create([
            'product_id' => Product::create([
                'product_code' => 'PRD-001',
                'product_name' => 'Classic Shirt',
                'category' => 'tops',
                'febric_type' => 'cotton',
                'status' => 'active',
            ])->id,
            'sku' => 'SKU-001',
            'size' => 'M',
            'color' => 'Blue',
            'cost_price' => 100,
            'selling_price' => 150,
            'status' => 'active',
        ]);
        $fabric = Material::create($this->materialData('MAT-FABRIC', 'Fabric'));
        $thread = Material::create($this->materialData('MAT-THREAD', 'Thread', 'thread', 'cone'));

        $response = $this->actingAs($user)->post(route('bom_items.store'), [
            'product_variant_id' => $variant->id,
            'materials' => [
                ['material_id' => $fabric->id, 'quantity_per_unit' => '1.5000', 'wastage_percent' => '3.00'],
                ['material_id' => $thread->id, 'quantity_per_unit' => '0.2500', 'wastage_percent' => '0'],
            ],
        ]);

        $response->assertRedirect(route('bom_items.index', ['product_variant_id' => $variant->id]));
        $this->assertDatabaseHas('bom_items', [
            'product_variant_id' => $variant->id,
            'material_id' => $fabric->id,
            'quantity_per_unit' => '1.5000',
            'wastage_percent' => '3.00',
        ]);
        $this->assertDatabaseHas('bom_items', [
            'product_variant_id' => $variant->id,
            'material_id' => $thread->id,
            'quantity_per_unit' => '0.2500',
        ]);
    }

    private function materialData(string $code, string $name, string $category = 'fabric', string $unit = 'meter'): array
    {
        return [
            'material_code' => $code,
            'material_name' => $name,
            'category' => $category,
            'unit' => $unit,
            'unit_cost' => 10,
            'reorder_level' => 0,
            'safety_stock' => 0,
            'status' => 'active',
        ];
    }
}
