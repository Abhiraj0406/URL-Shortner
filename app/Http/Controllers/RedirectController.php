<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;

class RedirectController extends Controller
{
    /**
     * __invoke() is a special PHP method that makes the class callable like a function.
     * Laravel uses it when a controller is registered without a specific method name.
     * Route: GET /{code} → this method runs automatically.
     *
     * @param string $code  The short code from the URL (e.g. "xk92mq")
     */
    public function __invoke(string $code)
    {
        // Find the short URL by its code, or return 404 if not found
        $shortUrl = ShortUrl::where('code', $code)->firstOrFail();

        // Redirect to the original long URL (external redirect)
        return redirect()->away($shortUrl->long_url);
    }
}
