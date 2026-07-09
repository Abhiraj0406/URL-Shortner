<?php

namespace Tests\Feature;

use App\Enums\Role;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RbacTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Only SuperAdmin can access /companies/create.
     */
    public function test_superadmin_can_access_invite_company_page(): void
    {
        $super = User::factory()->create(['role' => Role::SuperAdmin, 'company_id' => null]);

        $this->actingAs($super)->get('/companies/create')->assertOk();
    }

    /**
     * Test: Admin is blocked from /companies/create → 403.
     */
    public function test_admin_cannot_access_invite_company_page(): void
    {
        $company = Company::create(['name' => 'Test Corp']);
        $admin = User::factory()->create(['role' => Role::Admin, 'company_id' => $company->id]);

        $this->actingAs($admin)->get('/companies/create')->assertForbidden();
    }

    /**
     * Test: Only Admin can access /team/create.
     */
    public function test_admin_can_access_invite_team_page(): void
    {
        $company = Company::create(['name' => 'Test Corp']);
        $admin = User::factory()->create(['role' => Role::Admin, 'company_id' => $company->id]);

        $this->actingAs($admin)->get('/team/create')->assertOk();
    }

    /**
     * Test: SuperAdmin is blocked from /team/create → 403.
     */
    public function test_superadmin_cannot_access_invite_team_page(): void
    {
        $super = User::factory()->create(['role' => Role::SuperAdmin, 'company_id' => null]);

        $this->actingAs($super)->get('/team/create')->assertForbidden();
    }

    /**
     * Test: Guest is redirected to login when visiting protected routes.
     */
    public function test_guest_redirected_to_login(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
        $this->get('/urls/create')->assertRedirect('/login');
    }

    /**
     * Test: Admin can only see short URLs from their own company (not other companies).
     * Required by assignment: "Admin can only see the list of all short urls created in their own company"
     */
    public function test_admin_sees_only_their_company_urls(): void
    {
        $company1 = Company::create(['name' => 'Company A']);
        $company2 = Company::create(['name' => 'Company B']);

        $admin = User::factory()->create(['role' => Role::Admin, 'company_id' => $company1->id]);

        // URL belonging to company1 (admin's company)
        \App\Models\ShortUrl::create([
            'user_id'    => $admin->id,
            'company_id' => $company1->id,
            'long_url'   => 'https://company-a.com',
            'code'       => 'aaa111',
        ]);

        // URL belonging to company2 (different company)
        $otherUser = User::factory()->create(['role' => Role::Admin, 'company_id' => $company2->id]);
        \App\Models\ShortUrl::create([
            'user_id'    => $otherUser->id,
            'company_id' => $company2->id,
            'long_url'   => 'https://company-b.com',
            'code'       => 'bbb222',
        ]);

        $response = $this->actingAs($admin)->get('/dashboard');
        $response->assertOk();

        // Admin should see company A's URL
        $response->assertSee('aaa111');
        // Admin should NOT see company B's URL
        $response->assertDontSee('bbb222');
    }

    /**
     * Test: Member can only see their own short URLs (not other members' URLs).
     * Required by assignment: "Member can only see the list of all short urls created by themselves"
     */
    public function test_member_sees_only_their_own_urls(): void
    {
        $company = Company::create(['name' => 'Test Corp']);

        $member1 = User::factory()->create(['role' => Role::Member, 'company_id' => $company->id]);
        $member2 = User::factory()->create(['role' => Role::Member, 'company_id' => $company->id]);

        // URL created by member1
        \App\Models\ShortUrl::create([
            'user_id'    => $member1->id,
            'company_id' => $company->id,
            'long_url'   => 'https://member1.com',
            'code'       => 'mem111',
        ]);

        // URL created by member2 (same company, different user)
        \App\Models\ShortUrl::create([
            'user_id'    => $member2->id,
            'company_id' => $company->id,
            'long_url'   => 'https://member2.com',
            'code'       => 'mem222',
        ]);

        $response = $this->actingAs($member1)->get('/dashboard');
        $response->assertOk();

        // Member1 should see their own URL
        $response->assertSee('mem111');
        // Member1 should NOT see member2's URL
        $response->assertDontSee('mem222');
    }
}
