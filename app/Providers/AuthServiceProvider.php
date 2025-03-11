<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Auth::provider('drupal', function ($app, array $config) {
            return new class implements \Illuminate\Contracts\Auth\UserProvider {
                public function retrieveById($identifier)
                {
                    return DB::table('users')->where('uid', $identifier)->first();
                }

                public function retrieveByToken($identifier, $token)
                {
                    return null; // Not used for Drupal authentication
                }

                public function updateRememberToken($user, $token)
                {
                    // Drupal does not use remember tokens by default
                }

                public function retrieveByCredentials(array $credentials)
                {
                    return DB::table('users')->where('mail', $credentials['email'])->first();
                }

                public function validateCredentials($user, array $credentials)
                {
                    return Hash::check($credentials['password'], $user->pass);
                }
            };
        });
    }
}
