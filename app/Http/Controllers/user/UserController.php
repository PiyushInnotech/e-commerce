<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function fetchCurrentUser(Request $request) 
    {
        return response()->json([
            'data' => $request->user()
        ]);
    }

    public function updateUserDetails(Request $request) 
    {
        $user = $request->user();
        $user->update($request->all());        
        return response()->json([
            'data' => $user->fresh()
        ]);
    }
}