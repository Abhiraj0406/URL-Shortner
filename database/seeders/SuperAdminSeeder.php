<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Creates the SuperAdmin user.
     *
     * SuperAdmin has no company, so company_id is null.
     * The assignment requires SuperAdmin to be created via a Database Seeder.
     * Password is hashed using bcrypt via Hash::make().
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('Password'),
            'role' => Role::SuperAdmin,   // Enum value → stored as 'super_admin' in DB
            'company_id' => null,               // SuperAdmin belongs to no company
        ]);
    }
}
