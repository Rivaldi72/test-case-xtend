<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Role;
use App\Models\User;

class RoleTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        Role::truncate();
        User::truncate();
        $this->create_new_user();
        $this->create_new_user_rejected();
    }

    public function create_new_user()
    {
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role_id' => 1,
        ]);
        $this->actingAs($admin);
        // Create new user data
        $roleData = [
            'name' => 'Test Role',
        ];

        // Submit the form to create a new user
        $response = $this->post('api/roles', $roleData);

        // Assert that the user was created
        $response->assertStatus(200);
    }

    public function create_new_user_rejected()
    {
        $editor = User::create([
            'name' => 'editor',
            'email' => 'editor@example.com',
            'password' => bcrypt('password'),
            'role_id' => 2,
        ]);
        $this->actingAs($editor);
        // Create new user data
        $roleData = [
            'name' => 'Test Role',
        ];

        // Submit the form to create a new user
        $response = $this->post('api/roles', $roleData);

        $response->assertStatus(403);
    }
}
