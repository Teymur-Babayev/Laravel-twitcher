<?php

namespace App\Http\Requests;

use App\Rules\UniqueUsername;
use Illuminate\Foundation\Http\FormRequest;

class ChannelSettingsRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => [
                'required', 'regex:/^[\w-]*$/',
                new UniqueUsername(),
            ],
            'category' => 'required|exists:categories,id',
            'profilePicture' => ['image', 'mimes:jpg,jpeg,png', 'dimensions:min_width=80,min_height=80'],
            'coverPicture' => ['image', 'mimes:jpg,jpeg,png', 'dimensions:min_width=960,min_height=280'],
            // 'category' => 'required|exists:categories,id'
        ];
    }
}
