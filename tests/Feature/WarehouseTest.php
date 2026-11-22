<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class WarehouseTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_warehouses(): void
    {
        $response = $this->get(route('warehouses.index'));

        $response->assertRedirect(route('login', absolute: false));
    }

    public function test_admin_and_editor_can_complete_warehouse_crud(): void
    {
        $editor = $this->userWithRole('editor');
        $data = $this->warehouseData();

        $this->actingAs($editor)
            ->get(route('warehouses.create'))
            ->assertOk()
            ->assertSee('Add Warehouse');

        $createResponse = $this->actingAs($editor)->post(route('warehouses.store'), $data);
        $warehouse = Warehouse::query()->where('warehouse_code', $data['warehouse_code'])->firstOrFail();

        $createResponse->assertRedirect(route('warehouses.show', $warehouse));
        $this->assertDatabaseHas('warehouses', $data);

        $this->get(route('warehouses.index'))
            ->assertOk()
            ->assertSee($data['warehouse_name']);

        $this->get(route('warehouses.show', $warehouse))
            ->assertOk()
            ->assertSee($data['warehouse_code']);

        $this->get(route('warehouses.edit', $warehouse))
            ->assertOk()
            ->assertSee('Edit Warehouse');

        $updateResponse = $this->put(route('warehouses.update', $warehouse), [
            ...$data,
            'warehouse_name' => 'Updated Main Warehouse',
        ]);

        $updateResponse->assertRedirect(route('warehouses.show', $warehouse));
        $this->assertDatabaseHas('warehouses', [
            'id' => $warehouse->id,
            'warehouse_name' => 'Updated Main Warehouse',
            'warehouse_code' => $data['warehouse_code'],
        ]);

        $deleteResponse = $this->delete(route('warehouses.destroy', $warehouse));

        $deleteResponse->assertRedirect(route('warehouses.index'));
        $this->assertDatabaseMissing('warehouses', ['id' => $warehouse->id]);
    }

    public function test_authenticated_user_without_admin_or_editor_role_cannot_view_warehouses(): void
    {
        $user = $this->userWithRole('user');

        $response = $this->actingAs($user)->get(route('warehouses.index'));

        $response->assertForbidden();
    }

    public function test_warehouse_navigation_is_only_shown_to_admin_and_editor(): void
    {
        foreach (['admin', 'editor'] as $roleName) {
            $user = $this->userWithRole($roleName);

            $this->actingAs($user)
                ->get(route('home'))
                ->assertOk()
                ->assertSee(route('warehouses.index'));
        }

        $user = $this->userWithRole('user');

        $this->actingAs($user)
            ->get(route('home'))
            ->assertOk()
            ->assertDontSee(route('warehouses.index'));
    }

    public function test_warehouse_code_must_be_unique_and_type_must_be_supported(): void
    {
        $user = $this->userWithRole('editor');
        $this->actingAs($user);

        $this->post(route('warehouses.store'), [
            ...$this->warehouseData(),
            'warehouse_type' => 'unsupported',
        ])->assertSessionHasErrors('warehouse_type');

        $data = $this->warehouseData();
        Warehouse::create($data);

        $this->post(route('warehouses.store'), $data)
            ->assertSessionHasErrors('warehouse_code');
    }

    private function userWithRole(string $roleName): User
    {
        $role = Role::create([
            'name' => $roleName,
            'guard_name' => 'web',
        ]);
        $user = User::factory()->create();
        $user->assignRole($role);

        return $user;
    }

    private function warehouseData(): array
    {
        return [
            'warehouse_name' => 'Main Warehouse',
            'warehouse_code' => 'WH-001',
            'warehouse_type' => 'both',
            'address' => '100 Warehouse Road',
            'phone' => '0123456789',
            'status' => 'active',
        ];
    }
}
