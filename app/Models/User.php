<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * $fillable — columns allowed for mass assignment.
     *
     * Added 'company_id' and 'role' to the default Laravel fillable list
     * because we need them when creating/inviting users via User::create([...]).
     *
     * - company_id : links user to their company (NULL for SuperAdmin)
     * - role       : defines what the user can do (super_admin / admin / member)
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'company_id', // NULL for SuperAdmin; set for Admin and Member
        'role',       // One of: super_admin, admin, member
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * - 'role' => Role::class
     *   Automatically converts the string "admin" stored in DB
     *   into the Role::Admin enum object when you access $user->role.
     *   This makes comparisons like ($user->role === Role::Admin) work correctly.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'role'              => Role::class, // Cast DB string → Role Enum automatically
        ];
    }

    /**
     * A User BELONGS TO a Company.
     *
     * Relationship: users.company_id ──> companies.id
     *
     * Usage: $user->company  → returns the Company this user belongs to.
     * Returns NULL for SuperAdmin since their company_id is null.
     * Used in: ShortUrlController to set company_id when creating a URL.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * A User HAS MANY ShortUrls (URLs they have created).
     *
     * Relationship: users.id ──< short_urls.user_id
     *
     * Usage: $user->shortUrls  → returns all URLs created by this user.
     * Used in: Member dashboard — members only see their own URLs.
     */
    public function shortUrls(): HasMany
    {
        return $this->hasMany(ShortUrl::class);
    }
}
