<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome to your Dashboard, {{ auth()->user()->name }}!</h1>
    
    <!-- Displaying other user data -->
    <p><strong>Your email:</strong> {{ auth()->user()->email }}</p>
    <p><strong>Your user ID:</strong> {{ auth()->user()->sub }}</p> <!-- Google User ID -->
    
    <!-- Display user's profile picture -->
    <p><strong>Your profile picture:</strong></p>
    <img src="{{ auth()->user()->picture }}" alt="Profile Picture" style="width: 100px; height: 100px; border-radius: 50%;">

    <!-- Display user metadata (if available) -->
    @if(auth()->user()->user_metadata)
        <p><strong>Your color preference:</strong> {{ auth()->user()->user_metadata['color'] ?? 'Not set' }}</p>
    @else
        <p><strong>Your color preference:</strong> Not set</p>
    @endif

    <!-- Logout Button -->
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
