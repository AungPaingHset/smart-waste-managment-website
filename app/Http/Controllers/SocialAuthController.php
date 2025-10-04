<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * Redirect to provider
     */
    public function redirect($provider)
    {
        try {
            return Socialite::driver($provider)->redirect();
        } catch (\Exception $e) {
            Log::error("Social auth redirect failed for {$provider}: " . $e->getMessage());
            return redirect('/login')->with('error', 'Authentication service unavailable');
        }
    }

    /**
     * Handle provider callback
     */
    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
            
            // Handle missing email (GitHub especially)
            $email = $socialUser->getEmail() ?? 
                     ($socialUser->getNickname() ?? $socialUser->getId()) . '@' . $provider . '.com';
            
            // Try to find user by provider_id or email
            $user = User::where($provider . '_id', $socialUser->getId())
                        ->orWhere('email', $email)
                        ->first();

            if ($user) {
                // Update provider ID if not set
                if (!$user->{$provider . '_id'}) {
                    $user->{$provider . '_id'} = $socialUser->getId();
                }
                
                // Update profile info if changed
                $name = $socialUser->getName() ?? $socialUser->getNickname() ?? 'User';
                if ($user->name !== $name) {
                    $user->name = $name;
                }
                
                // Update avatar if available
                if ($socialUser->getAvatar()) {
                    $user->avatar = $socialUser->getAvatar();
                }
                
                // Mark email as verified for social logins
                if (!$user->email_verified_at) {
                    $user->email_verified_at = now();
                }
                
                $user->last_login_at = now();
                $user->save();
            } else {
                // Create new user
                $user = User::create([
                    'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? 'User',
                    'email' => $email,
                    $provider . '_id' => $socialUser->getId(),
                    'provider' => $provider,
                    'avatar' => $socialUser->getAvatar(),
                    'email_verified_at' => now(), // Social logins are pre-verified
                    'last_login_at' => now(),
                ]);
            }

            // Login user with remember me
            Auth::login($user, true);
            
            // Log successful authentication
            Log::info("User {$user->id} logged in via {$provider}");
            
            return redirect()->intended('/home');
            
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            Log::warning("Invalid state exception for {$provider}: " . $e->getMessage());
            return redirect('/login')->with('error', 'Authentication session expired. Please try again.');
        } catch (\Exception $e) {
            Log::error("Social auth callback failed for {$provider}: " . $e->getMessage());
            return redirect('/login')->with('error', 'Authentication failed. Please try again.');
        }
    }

    /**
     * Get provider-specific scopes
     */
    private function getProviderScopes($provider)
    {
        $scopes = [
            'github' => ['user:email'],
            'google' => ['profile', 'email'],
            'facebook' => ['email'],
        ];

        return $scopes[$provider] ?? [];
    }
}
