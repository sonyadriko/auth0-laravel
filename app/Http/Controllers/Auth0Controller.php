<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Auth0\Laravel\Facade\Auth0;
// use Auth0\SDK\Auth0;
// use Auth0\Login\Facade\Auth0;
use Auth0\Laravel\Facade\Auth0;


class Auth0Controller extends Controller
{
    public function login()
    {
        // Redirect ke halaman login Auth0
        return Auth0::login();
    }

    public function callback()
    {
        // Process the callback and log the user in
        $credentials = Auth0::getCredentials();

        if ($credentials) {
            // You can access the user info using $credentials->user.
            return redirect()->route('dashboard');
        }

        return redirect()->route('home')->with('error', 'Login failed. Please try again.');
    }

    public function logout()
    {
        // Log out user and redirect to home
        Auth0::logout();
        return redirect()->route('home');
    }
}
