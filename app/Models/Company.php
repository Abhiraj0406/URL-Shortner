<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    /**
     * $fillable tells Laravel which columns are allowed for mass assignment.
     * Without this, Company::create([...]) would silently fail (MassAssignmentException).
     * We only allow 'name' since id and timestamps are auto-managed by Laravel.
     */
    protected $fillable = ['name'];

    /**
     * A Company HAS MANY Users.
     *
     * Relationship: companies.id ──< users.company_id
     *
     * Usage: $company->users  → returns all users in this company.
     * Used in: SuperAdmin dashboard to list members per company.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * A Company HAS MANY ShortUrls.
     *
     * Relationship: companies.id ──< short_urls.company_id
     *
     * Usage: $company->shortUrls  → returns all URLs created under this company.
     * Used in: Admin dashboard to show company-scoped URL list.
     */
    public function shortUrls(): HasMany
    {
        return $this->hasMany(ShortUrl::class);
    }
}
