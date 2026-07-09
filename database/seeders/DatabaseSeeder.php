<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seeds the database with:
     *  1. SuperAdmin user (no company)
     *  2. Acme Corp company
     *  3. Admin user belonging to Acme Corp
     *  4. Member user belonging to Acme Corp
     *
     * Run with: php artisan migrate:fresh --seed
     */
    public function run(): void
    {
        // 1. Create the SuperAdmin (calls SuperAdminSeeder)
        $this->call(SuperAdminSeeder::class);

        // 2. Create a sample company — used by Admin and Member below
        $company = Company::create([
            'name' => 'Acme Corp',
        ]);

        // 3. Create an Admin user for Acme Corp
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@acme.com',
            'password' => Hash::make('password'),
            'role' => Role::Admin,         // Can create URLs, invite team members
            'company_id' => $company->id,        // Belongs to Acme Corp
        ]);

        // 4. Create a Member user for Acme Corp
        User::create([
            'name' => 'Member User',
            'email' => 'member@acme.com',
            'password' => Hash::make('password'),
            'role' => Role::Member,         // Can create URLs, sees only own URLs
            'company_id' => $company->id,         // Belongs to Acme Corp
        ]);
    }
}
