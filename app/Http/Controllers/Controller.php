<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller
{
    // In Laravel 12, this trait is NOT included by default.
    // We add it manually so that $this->authorize() works in all controllers.
    // $this->authorize('create', ShortUrl::class) → checks ShortUrlPolicy::create()
    use AuthorizesRequests;
}
