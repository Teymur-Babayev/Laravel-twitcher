<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class UniqueUsername implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !User::where('username', $value)->where('id', '!=', auth()->id())->exists() && !in_array($value, $this->reservedUsernames());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('Username is already taken');
    }

    private function reservedUsernames()
    {
        return [
            'admin',
            'vendor',
            'feed',
            'uploads',
            'notifications',
            'messages',
            'my-profile',
            'browse-creators',
            'logout',
            'login',
            'register',
            'report-content',
            'contact-page',
            'contact',
            'withdrawals',
            'upgrader',
            'tests',
            'svg',
            'storage',
            'routes',
            'resources',
            'public',
            'packages',
            'js',
            'images',
            'hooks',
            'helpers',
            'DOCUMENTATION',
            'database',
            'css',
            'config',
            'bootstrap',
            'app'
        ];
    }
}
