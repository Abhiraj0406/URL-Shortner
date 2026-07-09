<?php

namespace App\Policies;

use App\Models\ShortUrl;
use App\Models\User;

class ShortUrlPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ShortUrl $shortUrl): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create a ShortUrl.
     *
     * Rules (from assignment):
     *  - Admin   → true  (can create short URLs)
     *  - Member  → true  (can create short URLs)
     *  - SuperAdmin → false (cannot create short URLs → 403 Forbidden)
     *
     * The business rule is defined in Role::canCreateShortUrls() inside app/Enums/Role.php.
     * Keeping the rule there means if it changes, we update only ONE place.
     *
     * ---- HOW TO VERIFY IN TERMINAL ------------------------------------------------
     *
     * Run: php artisan tinker
     *
     * Then paste these commands one by one:
     *
     *   // Check Admin → expected: true
     *   $admin = App\Models\User::where('email', 'admin@acme.com')->first();
     *   $admin->role->canCreateShortUrls();
     *
     *   // Check Member → expected: true
     *   $member = App\Models\User::where('email', 'member@acme.com')->first();
     *   $member->role->canCreateShortUrls();
     *
     *   // Check SuperAdmin → expected: false
     *   $super = App\Models\User::where('email', 'superadmin@example.com')->first();
     *   $super->role->canCreateShortUrls();
     *
     *   // Type exit to quit tinker
     *   exit
     *
     * ------------------------------------------------------------------------------------
     */
    public function create(User $user): bool
    {
        return $user->role->canCreateShortUrls();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ShortUrl $shortUrl): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ShortUrl $shortUrl): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ShortUrl $shortUrl): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ShortUrl $shortUrl): bool
    {
        return false;
    }
}
