<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    @vite('resources/css/welcome.css')
</head>

<body class="bg-dark text-light">

    <div class="position-absolute top-0 start-0 p-3">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm">
            ← Back
        </a>
    </div>

    <div class="position-absolute top-0 end-0 p-3">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
        </form>
    </div>

    <div class="center-container">
        <h1>Admin Dashboard</h1>

        <div class="d-flex flex-column align-items-center gap-4 mt-4">
            <a href="{{ route('admin.users') }}" class="btn btn-custom btn-login">Users</a>
            <a href="{{ route('admin.puzzles') }}" class="btn btn-custom btn-register">Puzzles</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>