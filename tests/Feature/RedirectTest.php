<?php

namespace Tests\Feature;

use App\Enums\Role;
use App\Models\Company;
use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RedirectTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Visiting a valid short code redirects to the long URL.
     *
     * Why assertRedirect()?
     *  Checks that the response is a 301/302 redirect to the expected URL.
     */
    public function test_valid_short_code_redirects_to_long_url(): void
    {
        $company = Company::create(['name' => 'Test Corp']);
        $user = User::factory()->create(['role' => Role::Admin, 'company_id' => $company->id]);

        ShortUrl::create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'long_url' => 'https://google.com',
            'code' => 'abc123',
        ]);

        $response = $this->get('/abc123');

        $response->assertRedirect('https://google.com');
    }

    /**
     * Test: Visiting an invalid short code returns 404.
     *
     * Why assertNotFound()?
     *  firstOrFail() in RedirectController throws ModelNotFoundException
     *  which Laravel converts to HTTP 404.
     */
    public function test_invalid_short_code_returns_404(): void
    {
        $response = $this->get('/wrongcode');

        $response->assertNotFound(); // 404
    }

    /**
     * Test: Public redirect works for guests (no login required).
     */
    public function test_redirect_works_without_login(): void
    {
        $company = Company::create(['name' => 'Test Corp']);
        $user = User::factory()->create(['role' => Role::Admin, 'company_id' => $company->id]);

        ShortUrl::create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'long_url' => 'https://example.com',
            'code' => 'xyz789',
        ]);

        // No actingAs() = guest/unauthenticated request
        $response = $this->get('/xyz789');

        $response->assertRedirect('https://example.com');
    }
}
