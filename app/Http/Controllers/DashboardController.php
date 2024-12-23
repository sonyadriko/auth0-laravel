<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        if (!auth()->check()) {
            dd('Not authenticated');
        }
    
        $user = auth()->user();
        $name = $user->name ?? 'User';
        $email = $user->email ?? '';

        
        return view('dashboard', compact('user'));

        // $user = auth()->user();

        // // Return the full user data as JSON response
        // return response()->json($user);
    }
}
