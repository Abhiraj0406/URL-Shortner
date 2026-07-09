<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\StoreCompanyRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    /**
     * Show the Invite Company form.
     * Only SuperAdmin can reach here — protected by 'role:super_admin' middleware on route.
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Handle form submission — create the company AND its first Admin user.
     *
     * Why create both at once?
     *  Every company must have an Admin to manage it.
     *  SuperAdmin registers the company + assigns an Admin user in one step.
     *
     * Why DB::transaction()?
     *  Both Company and User must be created together.
     *  If User creation fails, the Company should NOT be saved (atomic operation).
     */
    public function store(StoreCompanyRequest $request)
    {
        \DB::transaction(function () use ($request) {
            // 1. Create the company
            $company = Company::create([
                'name' => $request->validated('company_name'),
            ]);

            // 2. Create the Admin user for this company
            User::create([
                'name' => $request->validated('admin_name'),
                'email' => $request->validated('admin_email'),
                'password' => Hash::make($request->validated('password')),
                'role' => Role::Admin,
                'company_id' => $company->id,
            ]);
        });

        return redirect()->route('dashboard')->with('success', 'Company invited successfully!');
    }
}
