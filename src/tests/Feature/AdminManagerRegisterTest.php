<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use App\Models\Manager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminManagerRegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_admin_can_register_manager()
    {
        $admin = AdminUser::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
        ]);
        $response = $this->post(route('admin_login'), [
            'email' => $admin->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect();
        $response = $this->actingAs($admin, 'admins')
            ->get(route('manager_register.show'));
        $response->assertStatus(200);
        $managerData = [
            'name' => 'テストマネージャー',
            'email' => 'manager@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];
        $response = $this->actingAs($admin, 'admins')
            ->post(route('manager_register'), $managerData);
        $response->assertRedirect(route('admin.thanks'));
        $this->assertDatabaseHas('managers', [
            'name' => 'テストマネージャー',
            'email' => 'manager@example.com',
        ]);
    }
}
