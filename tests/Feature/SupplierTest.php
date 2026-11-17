<?php

namespace Tests\Feature;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupplierTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_suppliers(): void
    {
        $response = $this->get(route('suppliers.index'));

        $response->assertRedirect(route('login', absolute: false));
    }

    public function test_any_authenticated_user_can_complete_supplier_crud(): void
    {
        $user = User::factory()->create();
        $data = $this->supplierData();

        $this->actingAs($user)
            ->get(route('suppliers.create'))
            ->assertOk()
            ->assertSee('Add Supplier');

        $createResponse = $this->post(route('suppliers.store'), $data);
        $supplier = Supplier::query()->where('supplier_code', $data['supplier_code'])->firstOrFail();

        $createResponse->assertRedirect(route('suppliers.show', $supplier));
        $this->assertDatabaseHas('suppliers', [
            'supplier_code' => $data['supplier_code'],
            'company_name' => $data['company_name'],
        ]);

        $this->get(route('suppliers.index'))
            ->assertOk()
            ->assertSee($data['company_name'])
            ->assertSee('Suppliers');

        $this->get(route('suppliers.show', $supplier))
            ->assertOk()
            ->assertSee($data['contact_person']);

        $this->get(route('suppliers.edit', $supplier))
            ->assertOk()
            ->assertSee('Edit Supplier');

        $updateResponse = $this->put(route('suppliers.update', $supplier), [
            ...$data,
            'company_name' => 'Updated Supplier Company',
        ]);

        $updateResponse->assertRedirect(route('suppliers.show', $supplier));
        $this->assertDatabaseHas('suppliers', [
            'id' => $supplier->id,
            'company_name' => 'Updated Supplier Company',
            'supplier_code' => $data['supplier_code'],
        ]);

        $deleteResponse = $this->delete(route('suppliers.destroy', $supplier));

        $deleteResponse->assertRedirect(route('suppliers.index'));
        $this->assertDatabaseMissing('suppliers', ['id' => $supplier->id]);
    }

    public function test_supplier_code_type_and_rating_are_validated(): void
    {
        $this->actingAs(User::factory()->create());

        $this->post(route('suppliers.store'), [
            ...$this->supplierData(),
            'supplier_type' => 'unsupported',
            'rating' => '4.123',
        ])->assertSessionHasErrors(['supplier_type', 'rating']);

        $data = $this->supplierData();
        Supplier::create($data);

        $this->post(route('suppliers.store'), $data)
            ->assertSessionHasErrors('supplier_code');
    }

    private function supplierData(): array
    {
        return [
            'supplier_code' => 'SUP-001',
            'company_name' => 'Example Fabric Co.',
            'contact_person' => 'Alex Supplier',
            'phone' => '0123456789',
            'email' => 'supplier@example.test',
            'address' => '100 Supplier Road',
            'supplier_type' => 'fabric',
            'payment_terms_days' => 30,
            'lead_time_days' => 7,
            'rating' => '4.50',
            'status' => 'active',
        ];
    }
}
