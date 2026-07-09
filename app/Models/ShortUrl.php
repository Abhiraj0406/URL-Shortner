<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShortUrl extends Model
{
    /**
     * $fillable — columns allowed for mass assignment via ShortUrl::create([...]).
     *
     * - user_id    : who created this short URL
     * - company_id : which company this URL belongs to
     * - long_url   : the original URL to redirect to
     * - code       : the unique short code (e.g. "abc123")
     *
     * id and timestamps are auto-managed by Laravel, so they are NOT in fillable.
     */
    protected $fillable = [
        'user_id',
        'company_id',
        'long_url',
        'code',
    ];

    /**
     * A ShortUrl BELONGS TO a User (the person who created it).
     *
     * Relationship: short_urls.user_id ──> users.id
     *
     * Usage: $shortUrl->user  → returns the User who created this URL.
     * Used in: Admin dashboard "Created By" column.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A ShortUrl BELONGS TO a Company.
     *
     * Relationship: short_urls.company_id ──> companies.id
     *
     * Usage: $shortUrl->company  → returns the Company this URL belongs to.
     * Used in: SuperAdmin dashboard "Company" column to show which company created the URL.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
