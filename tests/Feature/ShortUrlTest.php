<?php

namespace Tests\Feature;

use App\Enums\Role;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShortUrlTest extends TestCase
{
    // RefreshDatabase: wraps each test in a transaction and rolls it back after.
    // This means each test starts with a clean database — no leftover data.
    use RefreshDatabase;

    /**
     * Test: Admin CAN create a short URL.
     *
     * Why actingAs()?
     *  Simulates a logged-in user without going through the login form.
     *  Laravel's testing helpers let us fake authentication.
     */
    public function test_admin_can_create_short_url(): void
    {
        $company = Company::create(['name' => 'Test Corp']);

        $admin = User::factory()->create([
            'role' => Role::Admin,
            'company_id' => $company->id,
        ]);

        $response = $this->actingAs($admin)->post('/urls', [
            'long_url' => 'https://google.com',
        ]);

        // After creating, controller redirects to dashboard
        $response->assertRedirect('/dashboard');

        // Assert the record was actually saved to the database
        $this->assertDatabaseHas('short_urls', [
            'long_url' => 'https://google.com',
            'user_id' => $admin->id,
            'company_id' => $company->id,
        ]);
    }

    /**
     * Test: Member CAN create a short URL.
     */
    public function test_member_can_create_short_url(): void
    {
        $company = Company::create(['name' => 'Test Corp']);

        $member = User::factory()->create([
            'role' => Role::Member,
            'company_id' => $company->id,
        ]);

        $response = $this->actingAs($member)->post('/urls', [
            'long_url' => 'https://laravel.com',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('short_urls', ['long_url' => 'https://laravel.com']);
    }

    /**
     * Test: SuperAdmin CANNOT create a short URL → should get 403.
     *
     * Why 403?
     *  ShortUrlPolicy::create() returns false for SuperAdmin.
     *  Laravel converts that to HTTP 403 Forbidden automatically.
     */
    public function test_superadmin_cannot_create_short_url(): void
    {
        $superAdmin = User::factory()->create([
            'role' => Role::SuperAdmin,
            'company_id' => null,
        ]);

        $response = $this->actingAs($superAdmin)->post('/urls', [
            'long_url' => 'https://google.com',
        ]);

        $response->assertForbidden(); // 403
    }
}
