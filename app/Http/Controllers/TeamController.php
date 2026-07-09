<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\StoreTeamMemberRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TeamController extends Controller
{
    /**
     * Show the Invite Team Member form.
     * Only Admin can reach here — protected by 'role:admin' middleware on route.
     */
    public function create()
    {
        return view('team.create');
    }

    /**
     * Create a new Member under the Admin's company.
     *
     * Why $request->user()->company_id?
     *  We never trust the form to send company_id.
     *  We always get it from the logged-in Admin to prevent
     *  inviting users into another company.
     */
    public function store(StoreTeamMemberRequest $request)
    {
        User::create([
            'name'       => $request->validated('name'),
            'email'      => $request->validated('email'),
            'password'   => Hash::make($request->validated('password')),
            'role'       => Role::Member,
            // Always use the logged-in Admin's company — never trust form input for this
            'company_id' => $request->user()->company_id,
        ]);

        return redirect()->route('dashboard')->with('success', 'Team member invited!');
    }
}
