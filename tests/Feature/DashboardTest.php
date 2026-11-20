<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_dashboard(): void
    {
        $response = $this->get(route('home'));

        $response->assertRedirect(route('login', absolute: false));
    }

    public function test_guest_is_redirected_to_login_from_root(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('login', absolute: false));
    }

    public function test_authenticated_user_is_redirected_to_dashboard_from_root(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertRedirect(route('home', absolute: false));
    }

    public function test_authenticated_user_sees_dashboard_and_dashboard_link_targets_home(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('home'));

        $response->assertOk();
        $response->assertSee('Total Raw Materials');
        $response->assertSee('href="'.route('home').'"', escape: false);
    }
}
