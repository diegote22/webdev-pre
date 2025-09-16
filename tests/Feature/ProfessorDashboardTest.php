<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfessorDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_professor_can_view_dashboard()
    {
        $role = Role::create(['name' => 'Profesor']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertStatus(200)
            ->assertSee('Mi Panel');
    }
}
