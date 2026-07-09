<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
{
    /**
     * Only SuperAdmin can submit this request.
     * The route already has 'role:super_admin' middleware — returning true here
     * means "don't block at the Form Request level, the route already handles it."
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for the Invite Company form.
     *
     * Rules:
     *  'required'        → field must be present and non-empty
     *  'string'          → must be plain text
     *  'max:255'         → must not exceed 255 characters
     *  'email'           → must be a valid email format
     *  'unique:users,email' → email must not already exist in the users table
     *  'min:8'           → password minimum 8 characters
     *  'confirmed'       → password must match password_confirmation field
     */
    public function rules(): array
    {
        return [
            'company_name' => ['required', 'string', 'max:255'],
            'admin_name'   => ['required', 'string', 'max:255'],
            'admin_email'  => ['required', 'email', 'unique:users,email'],
            'password'     => ['required', 'min:8', 'confirmed'],
        ];
    }
}
