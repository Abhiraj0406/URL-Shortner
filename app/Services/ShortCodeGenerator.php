<?php

namespace App\Services;

use App\Models\ShortUrl;
use Illuminate\Support\Str;

class ShortCodeGenerator
{
    /**
     * Generates a unique 6-character alphanumeric short code.
     *
     * How it works:
     *  1. Generate a random 6-character lowercase string (e.g. "xk92mq")
     *  2. Check if that code already exists in the short_urls table
     *  3. If it exists → try again (loop) until we find a unique one
     *  4. Return the unique code
     *
     * Why do-while?
     *  We need to generate at least once before checking.
     *  do-while runs the body FIRST, then checks the condition.
     *
     * ─── VERIFY IN TINKER ────────────────────────────────
     *  php artisan tinker
     *  (new App\Services\ShortCodeGenerator)->generate();
     *  // Should return a random 6-char string like "xk92mq"
     * ──────────────────────────────────────────────────────
     */
    public function generate(): string
    {
        do {
            // Generate random 6-char lowercase string
            $code = Str::lower(Str::random(6));
        } while (ShortUrl::where('code', $code)->exists()); // Retry if already taken

        return $code;
    }
}
