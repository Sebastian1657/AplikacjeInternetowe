<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_role_returns_true_for_correct_role()
    {
        $role = Role::create([
            'name' => 'admin',
            'display_name' => 'Administrator'
        ]);
        
        $user = User::factory()->create(['role_id' => $role->id]);

        $this->assertTrue($user->hasRole('admin'));
        $this->assertFalse($user->hasRole('manager'));
    }
    public function test_user_is_employee_helper_works()
    {
        $role = Role::create([
            'name' => 'employee',
            'display_name' => 'Pracownik'
        ]);
        $user = User::factory()->create(['role_id' => $role->id]);

        $this->assertTrue($user->isEmployee());
    }
    public function test_user_is_manager_helper_works()
    {
        $role = Role::create([
            'name' => 'manager',
            'display_name' => 'Manager'
        ]);
        $user = User::factory()->create(['role_id' => $role->id]);

        $this->assertTrue($user->isManager());
    }
    public function test_user_admin_config_has_correct_structure()
    {
        $config = User::getAdminConfig();

        $this->assertArrayHasKey('title', $config);
        $this->assertArrayHasKey('fields', $config);
        $this->assertEquals('Użytkownicy', $config['title']);
    }
}