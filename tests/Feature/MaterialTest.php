<?php

namespace Tests\Feature;

use App\Models\Material;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MaterialTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_materials(): void
    {
        $response = $this->get(route('materials.index'));

        $response->assertRedirect(route('login', absolute: false));
    }

    public function test_authenticated_user_can_complete_material_crud(): void
    {
        $user = User::factory()->create();
        $supplier = Supplier::create($this->supplierData());
        $data = $this->materialData($supplier->id);

        $this->actingAs($user)
            ->get(route('materials.create'))
            ->assertOk()
            ->assertSee($supplier->company_name);

        $createResponse = $this->post(route('materials.store'), $data);
        $material = Material::query()->where('material_code', $data['material_code'])->firstOrFail();

        $createResponse->assertRedirect(route('materials.show', $material));
        $this->assertDatabaseHas('materials', [
            'material_code' => $data['material_code'],
            'material_name' => $data['material_name'],
            'supplier_id' => $supplier->id,
        ]);

        $this->get(route('materials.index'))
            ->assertOk()
            ->assertSee($data['material_name'])
            ->assertSee($supplier->company_name);

        $this->get(route('materials.show', $material))
            ->assertOk()
            ->assertSee($data['material_code']);

        $this->get(route('materials.edit', $material))
            ->assertOk()
            ->assertSee('Edit Material');

        $updateResponse = $this->put(route('materials.update', $material), [
            ...$data,
            'material_name' => 'Updated Cotton Thread',
        ]);

        $updateResponse->assertRedirect(route('materials.show', $material));
        $this->assertDatabaseHas('materials', [
            'id' => $material->id,
            'material_name' => 'Updated Cotton Thread',
            'material_code' => $data['material_code'],
        ]);

        $deleteResponse = $this->delete(route('materials.destroy', $material));

        $deleteResponse->assertRedirect(route('materials.index'));
        $this->assertSoftDeleted('materials', ['id' => $material->id]);
        $this->get(route('materials.show', $material))->assertNotFound();
    }

    public function test_deleting_a_supplier_keeps_material_and_clears_supplier_id(): void
    {
        $supplier = Supplier::create($this->supplierData());
        $material = Material::create($this->materialData($supplier->id));

        $supplier->delete();

        $this->assertDatabaseHas('materials', [
            'id' => $material->id,
            'supplier_id' => null,
        ]);
    }

    public function test_material_fields_and_supplier_reference_are_validated(): void
    {
        $this->actingAs(User::factory()->create());

        $this->post(route('materials.store'), [
            ...$this->materialData(),
            'supplier_id' => 999999,
            'category' => 'unsupported',
            'unit' => 'unsupported',
            'unit_cost' => '1.234',
        ])->assertSessionHasErrors(['supplier_id', 'category', 'unit', 'unit_cost']);
    }

    private function supplierData(): array
    {
        return [
            'supplier_code' => 'SUP-MAT-001',
            'company_name' => 'Materials Supplier',
            'contact_person' => 'Alex Supplier',
            'phone' => '0123456789',
            'email' => null,
            'address' => '100 Supplier Road',
            'supplier_type' => 'fabric',
            'payment_terms_days' => 30,
            'lead_time_days' => 7,
            'rating' => null,
            'status' => 'active',
        ];
    }

    private function materialData(?int $supplierId = null): array
    {
        return [
            'supplier_id' => $supplierId,
            'material_code' => 'MAT-001',
            'material_name' => 'Cotton Thread',
            'category' => 'thread',
            'unit' => 'cone',
            'unit_cost' => '12.50',
            'reorder_level' => '100.00',
            'safety_stock' => '25.00',
            'status' => 'active',
        ];
    }
}
