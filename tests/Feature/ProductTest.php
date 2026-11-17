<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_complete_product_crud(): void
    {
        $user = User::factory()->create();
        $data = $this->productData();

        $this->actingAs($user)
            ->get(route('products.create'))
            ->assertOk()
            ->assertSee('Add Product')
            ->assertSee('Tops')
            ->assertSee('Cotton');

        $createResponse = $this->post(route('products.store'), $data);
        $product = Product::query()->where('product_code', $data['product_code'])->firstOrFail();

        $createResponse->assertRedirect(route('products.show', $product));
        $this->assertDatabaseHas('products', [
            'product_code' => $data['product_code'],
            'product_name' => $data['product_name'],
        ]);

        $this->get(route('products.show', $product))
            ->assertOk()
            ->assertSee($data['product_name'])
            ->assertSee('Tops')
            ->assertSee('Cotton');

        $this->get(route('products.edit', $product))
            ->assertOk()
            ->assertSee('Edit Product');

        $this->put(route('products.update', $product), [
            ...$data,
            'product_name' => 'Updated Cotton Shirt',
        ])->assertRedirect(route('products.show', $product));

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'product_name' => 'Updated Cotton Shirt',
        ]);

        $this->delete(route('products.destroy', $product))
            ->assertRedirect(route('products.index'));

        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }

    public function test_product_fields_and_code_are_validated(): void
    {
        $this->actingAs(User::factory()->create());
        $data = $this->productData();

        $this->post(route('products.store'), [
            ...$data,
            'category' => 'unsupported',
            'febric_type' => 'unsupported',
            'status' => 'unsupported',
        ])->assertSessionHasErrors(['category', 'febric_type', 'status']);

        Product::create($data);

        $this->post(route('products.store'), $data)
            ->assertSessionHasErrors('product_code');
    }

    private function productData(): array
    {
        return [
            'product_code' => 'PRD-001',
            'product_name' => 'Cotton Shirt',
            'category' => 'tops',
            'febric_type' => 'cotton',
            'description' => 'Lightweight cotton shirt.',
            'status' => 'active',
        ];
    }
}
