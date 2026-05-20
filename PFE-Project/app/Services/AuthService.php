<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Handle user authentication.
     *
     * @param array $credentials
     * @param bool $remember
     * @return bool
     * @throws ValidationException
     */
    public function login(array $credentials, bool $remember = false)
    {
        // 1. Validate incoming credentials
        $validator = validator($credentials, [
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // 2. Attempt authentication
        if (Auth::attempt($credentials, $remember)) {
            // Regenerate session to prevent session fixation attacks
            request()->session()->regenerate();
            
            // Determine redirect target path
            $user = Auth::user();
            if ($user && $user->hasRole('client')) {
                return '/client/dashboard';
            }
            return '/coach/dashboard';
        }

        // 3. Throw validation error on authentication failure
        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }

    /**
     * Handle user logout.
     *
     * @return void
     */
    public function logout()
    {
        Auth::logout();
        
        // Invalidate current session and regenerate CSRF token
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
}
