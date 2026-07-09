<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShortUrlRequest extends FormRequest
{
    /**
     * Only authenticated users with permission can make this request.
     *
     * Why authorize() here?
     *  This is a second layer of protection. The ShortUrlPolicy::create()
     *  check in the controller is the primary check. Returning true here
     *  means "let the request reach the controller" — the policy handles
     *  the role-specific decision.
     */
    public function authorize(): bool
    {
        return true; // Auth check is handled by 'auth' middleware + ShortUrlPolicy
    }

    /**
     * Validation rules for the form input.
     *
     * Rules explained:
     *  'required' → field must be present and not empty
     *  'url'      → must be a valid URL format (e.g. https://google.com)
     *  'max:2048' → prevent extremely long URLs from being stored
     */
    public function rules(): array
    {
        return [
            'long_url' => ['required', 'url', 'max:2048'],
        ];
    }
}
