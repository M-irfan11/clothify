<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_users_create_form_and_create_user(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole(Role::create([
            'name' => 'admin',
            'guard_name' => 'web',
        ]));

        $this->actingAs($admin)
            ->get(route('users.create'))
            ->assertOk()
            ->assertSee('Create User')
            ->assertSee('Manage Users')
            ->assertSee('href="'.route('users.index').'"', escape: false)
            ->assertSee('id="sidenav-main"', escape: false);

        $this->post(route('users.store'), [
            'name' => 'New User',
            'email' => 'new-user@example.com',
            'password' => 'password123',
        ])->assertRedirect(route('users.index'));

        $this->get(route('users.index'))
            ->assertOk()
            ->assertDontSee('bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3');

        $this->assertDatabaseHas('users', [
            'name' => 'New User',
            'email' => 'new-user@example.com',
        ]);
    }
}
