<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\ShortUrl;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the role-aware dashboard.
     *
     * Uses match() on the user's role to fetch the correct scoped URL list:
     *  - SuperAdmin → all URLs from all companies (with company + user info)
     *  - Admin      → only URLs from their own company
     *  - Member     → only URLs they personally created
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Fetch short URLs scoped to the user's role
        $shortUrls = match ($user->role) {
            // SuperAdmin sees everything — load company + user for display
            Role::SuperAdmin => ShortUrl::with(['company', 'user'])->latest()->get(),

            // Admin sees all URLs within their company only
            Role::Admin => ShortUrl::where('company_id', $user->company_id)->latest()->get(),

            // Member sees only URLs they personally created
            Role::Member => ShortUrl::where('user_id', $user->id)->latest()->get(),
        };

        return view('dashboard', compact('user', 'shortUrls'));
    }
}
