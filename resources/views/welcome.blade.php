<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Chess Tactics Trainer</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Custom CSS -->
    @vite('resources/css/welcome.css')
</head>

<body>
    <div class="center-container">
        <h1>Welcome to Chess Tactics Trainer</h1>
        <div class="buttons mt-4">
            <a href="{{ route('login') }}" class="btn btn-login btn-custom me-3">Login</a>
            <a href="{{ route('register') }}" class="btn btn-register btn-custom">Register</a>
        </div>
    </div>
</body>

</html>