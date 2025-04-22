<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\VerificationCode;
use App\Constants\Constants;
use App\Mail\EmailVerification;
use App\Http\Controllers\Controller;
use App\ValidationSchemas\Schemas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PanelAuthController extends Controller
{

    public function registerPanelUser(Request $request) {
        $user = User::create([
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return redirect('/login');
    }

    public function signinPanelUser(Request $request) 
    {    
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->back()
                ->with('error', 'The provided credentials are incorrect.')
                ->withInput();
        }
        Auth::guard('web')->login($user);
        return redirect('/dashboard');
    }

    public function logoutCurrentUser(Request $request)
    {    
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function sendEmailCodeForUser(Request $request)
    {
        $email = $request->email;
        VerificationCode::where('email', $email)->delete();

        $code = rand(100000, 999999);

        $verificationCode = VerificationCode::create([
            'email' => $email,
            'code' => $code,
            'is_used' => false
        ]);

        Mail::to($email)->send(new EmailVerification($verificationCode));
        return redirect('/verify-reset-code');
    }

    public function verifyEmailCode(Request $request)
    {
        $email = $request->email;
        $code = $request->code;
        $expiryMinutes = Constants::EMAIL_VERIFICATION_CODE_EXPIRY_MINUTES;

        $verification = VerificationCode::where('email', $email)
        ->where('code', (int) $code)
        ->where('is_used', false)
        ->first();

        if (!$verification) {
            return response()->json(['message' => 'Invalid or expired verification code.'], 401);
        }

        if ($verification->created_at->addMinutes($expiryMinutes)->lt(now())) {
            $verification->delete();
            return response()->json(['message' => 'Invalid or expired verification code.'], 401);
        }

        $verification->is_used = true;
        $verification->save();

        return response()->json([
            'message' => 'You email has been verified successfully',
        ]);
    }

    public function resetUserPassword(Request $request)
    {
        $email = $request->email;
        $code = $request->code;
        $password = $request->password;
        $expiryMinutes = Constants::EMAIL_VERIFICATION_CODE_EXPIRY_MINUTES;

        $user = User::where('email', $email)->first();

        $verificationCode = VerificationCode::where('email', $email)
        ->where('code', (int) $code)
        ->first();

        if (!$verificationCode) {
            return response()->json(['message' => 'Invalid or expired verification code.'], 401);
        }

        if ($verificationCode->created_at->addMinutes($expiryMinutes)->lt(now())) {
            $verificationCode->delete();
            return response()->json(['message' => 'Invalid or expired verification code.'], 401);
        }

        $verificationCode->delete();
        $user->password = Hash::make($request->password);
        $user->tokens()->delete();
        $user->save();

        return response()->json([
            'message' => 'You Password has been reset succesfully.',
        ]);
    }
}
