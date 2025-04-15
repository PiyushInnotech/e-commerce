<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ValidateRequest
{
    protected array $schemas = [
        'register' => [
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
        ],
        'login' => [
            'email' => 'required|email',
            'password' => 'required|string',
        ],
    ];


    public function handle(Request $request, Closure $next, $key=null )
    {
        $schema = $this->schemas[$key] ?? null;
        if (!$key || !isset($this->schemas[$key])) {
            return $next($request);
        }

        $validator = Validator::make($request->all(), $schema);

        if ($validator->fails()) {
            $errors = collect($validator->errors())->map(function ($errorMessages, $field) {
                return $errorMessages[0];
            });
            
            return response()->json([
                'errors' => $errors,
            ], 422);
        }

        return $next($request);
    }
}
