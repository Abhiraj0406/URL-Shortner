<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShortUrlRequest;
use App\Models\ShortUrl;
use App\Services\ShortCodeGenerator;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ShortUrlController extends Controller
{
    /**
     * Show the "Generate Short URL" form.
     *
     * Why authorize() here?
     *  Before showing the form, we check if this user is ALLOWED to create URLs.
     *  ShortUrlPolicy::create() returns false for SuperAdmin → Laravel throws 403.
     *  Admin and Member pass → form is shown.
     */
    public function create(): View
    {
        $this->authorize('create', ShortUrl::class);

        return view('urls.create');
    }

    /**
     * Handle the form submission — save the short URL to DB.
     *
     * Why authorize() again here?
     *  Always re-check on POST. A user could bypass the form and POST directly
     *  via Postman/curl. The controller must never trust that the user came from the form.
     *
     * Why ShortCodeGenerator as a parameter?
     *  Laravel automatically injects it (dependency injection).
     *  We don't write: new ShortCodeGenerator() — Laravel handles it.
     *  This makes the controller easier to test.
     *
     * Why redirect()->route('dashboard')?
     *  After creating the URL, we redirect to the dashboard where the user can
     *  see their newly created short URL in the list.
     */
    public function store(
        StoreShortUrlRequest $request,
        ShortCodeGenerator $generator
    ): RedirectResponse {
        $this->authorize('create', ShortUrl::class);

        ShortUrl::create([
            'user_id' => $request->user()->id,         // Who created it
            'company_id' => $request->user()->company_id, // Which company owns it
            'long_url' => $request->validated('long_url'), // Validated input only
            'code' => $generator->generate(),        // Unique short code
        ]);

        return redirect()->route('dashboard')->with('success', 'Short URL created!');
    }
}
