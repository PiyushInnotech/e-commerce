<?php

namespace App\ValidationSchemas;

class Schemas
{
    public static function get(): array
    {
        return [
            'registerSchema' => [
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required',
            ],
            'loginSchema' => [
                'email' => 'required|email',
                'password' => 'required|string',
            ],
            'isRegisteredEmailSchema' => [
                'email' => 'required|email|exists:users,email',
            ],
            'verifyEmailSchema' => [
                'code' => 'required|digits:6',
                'email' => 'required|email|exists:users,email'
            ],
            'resetPasswordSchema' => [
                'email' => 'required|email|exists:users,email',
                'password' => 'required|string|min:8|confirmed',
                'code' => 'required|digits:6',
                'password_confirmation' => 'required',
            ],
            'updateUserSchema' => [
                'first_name' => 'sometimes|string|max:255|min:3',
                'last_name' => 'sometimes|string|max:255|min:3',
                'email' => 'sometimes|email',
                'phone_number' => 'sometimes|string|regex:/^[+]\d{2}?\d{10}$/',
                'isUniqueMobileExceptUsers' => true,
                'isUniqueEmailExceptUsers' => true
            ],
            'imageSchema' => [
                'image' => 'required|image|max:2048'
            ],

            // custom error messages
            'errorMessages' => [
                'email.exists' => 'This email is not registered.',
                'role_id.exists' => 'The selected role is invalid.',
                'phone_number.regex' => 'The phone number format is invalid.',
            ]
        ];
    }
}