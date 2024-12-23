<?php

use Illuminate\Support\Facades\Route;
use Auth0\Laravel\Facade\Auth0;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth0Controller;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Default route
// Default route
Route::get('/', function () {
    // Check if the user is authenticated
    if (auth()->check()) {
        // If logged in, redirect to dashboard
        return view('dashboard'); // Return the dashboard view if logged in
    }

    // If not logged in, show the welcome page
    return view('welcome');
});

// // Dashboard route (accessible only when logged in)
// Route::get('/dashboard', function () {
//     // Fetch user data from Auth0
//     // $user = Auth0::getUser();
//     $user = auth()->user(); // This retrieves the full user profile from Auth0

//     // Pass the user data to the Blade view
//     return view('dashboard', ['user' => $user]);
// });

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

// Example of route with permission check
Route::get('/scope', function () {
    return response('You have the `read:messages` permissions, and can therefore access this resource.');
})->middleware('auth')->can('read:messages');

// Route for user details with authentication check
Route::get('/profile', function () {
    if (!auth()->check()) {
        return response('You are not logged in.');
    }

    $user = auth()->user();
    $name = $user->name ?? 'User';
    $email = $user->email ?? '';

    return response("Hello {$name}! Your email address is {$email}.");
});

// Route to update user metadata (favorite color)
Route::get('/colors', function () {
    $endpoint = Auth0::management()->users();

    $colors = ['red', 'blue', 'green', 'black', 'white', 'yellow', 'purple', 'orange', 'pink', 'brown'];

    // Update user metadata with a random color
    $endpoint->update(
        id: auth()->id(),
        body: [
            'user_metadata' => [
                'color' => $colors[random_int(0, count($colors) - 1)]
            ]
        ]
    );

    // Retrieve the updated metadata
    $metadata = $endpoint->get(auth()->id());
    $metadata = Auth0::json($metadata);

    $color = $metadata['user_metadata']['color'] ?? 'unknown';
    $name = auth()->user()->name;

    return response("Hello {$name}! Your favorite color is {$color}.");
})->middleware('auth');

// Route::post('/logout', function () {
//     Auth0::logout(); // Use Auth0's logout method to log the user out

//     // Redirect to the home page after logging out
//     return redirect('/');
// })->name('logout');

// Route::get('/', function () {
//     return view('welcome'); // Tampilan sebelum login
// })->name('home');

// // Halaman dashboard setelah login
// Route::get('/dashboard', function () {
//     return view('dashboard'); // Halaman setelah login
// })->middleware('auth')->name('dashboard');

// // Rute untuk Login
// Route::get('/login', [Auth0Controller::class, 'login'])->name('login');

// // Rute untuk Callback
// Route::get('/callback', [Auth0Controller::class, 'callback'])->name('auth0.callback');

// // Rute untuk Logout
// Route::get('/logout', [Auth0Controller::class, 'logout'])->name('logout');
