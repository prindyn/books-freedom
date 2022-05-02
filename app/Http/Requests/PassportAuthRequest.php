<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PassportAuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required_if:q,/api/register|max:55',
            'email' => 'exclude_if:q,/api/login|unique:users',
            'email' => 'exclude_if:q,/api/logout,/api/me|required|email',
            'password' => 'exclude_if:q,/api/logout,/api/me|required',
            'privacy' => 'required_if:q,/api/register',
        ];
    }
}
