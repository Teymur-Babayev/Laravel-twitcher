<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\UniqueUsername;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'username' => [
                'required', 'regex:/^[\w-]*$/',
                new UniqueUsername(),
            ],
            'profilePicture' => ['image', 'mimes:jpg,jpeg,png', 'dimensions:min_width=80,min_height=80'],
        ];
    }
}
