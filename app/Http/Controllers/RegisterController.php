<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Basic validation including email format
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // Check if email is from a disposable domain (example implementation)
        if ($this->isDisposableEmail($validatedData['email'])) {
            return back()->withErrors(['email' => 'Please use a non-disposable email address'])->withInput();
        }

        // Create user with unverified status
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'email_verification_token' => Str::random(60),
            'email_verified_at' => null,
        ]);

        // Send verification email
        Mail::to($user->email)->send(new EmailVerification($user));

        return redirect()->route('verification.notice')
            ->with('success', 'Registration successful! Please check your email to verify your account.');
    }

    public function verifyEmail($token)
    {
        $user = User::where('email_verification_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Invalid verification token');
        }

        $user->email_verified_at = now();
        $user->email_verification_token = null;
        $user->save();

        return redirect()->route('login')->with('success', 'Email verified! You can now log in.');
    }

    /**
     * Check if email is from a disposable domain
     * 
     * @param string $email
     * @return bool
     */
    private function isDisposableEmail($email)
    {
        $domain = substr(strrchr($email, "@"), 1);
        
        // List of common disposable email domains
        $disposableDomains = [
            'tempmail.com',
            'throwawaymail.com',
            'mailinator.com',
            'guerrillamail.com',
            'trashmail.com',
            'yopmail.com',
            // Add more domains as needed
        ];
        
        // For more comprehensive checking, consider using an API service
        // like https://verify-email.org or https://quickemailverification.com
        
        return in_array($domain, $disposableDomains);
    }
}