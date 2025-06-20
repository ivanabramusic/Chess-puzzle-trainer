<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Chess Tactics Trainer - Home</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Custom CSS via Vite -->
    @vite('resources/css/welcome.css')
</head>

<body>

    <div class="position-absolute top-0 end-0 p-3">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
        </form>
    </div>


    <div class="center-container">
        <h1>Welcome back to Chess Tactics Trainer</h1>
        <div class="buttons mt-4 d-flex flex-column align-items-center gap-3">
            <div class="d-flex flex-row flex-wrap justify-content-center gap-3">
                <button type="button" class="btn btn-custom btn-login" data-bs-toggle="modal" data-bs-target="#difficultyModal">
                    Play
                </button>
                <a href="{{ route('puzzles.create') }}" class="btn btn-custom btn-register">Add Puzzle</a>
            </div>

            @if(auth()->check() && auth()->user()->role_id === 1)
            <a href="{{ route('admin.dashboard') }}" class="btn btn-custom btn-dashboard">Admin Dashboard</a>
            @endif
        </div>


        @if (session('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
        @endif

        <div class="modal fade" id="difficultyModal" tabindex="-1" aria-labelledby="difficultyModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form method="GET" action="{{ route('puzzles.play') }}">
                    <div class="modal-content bg-dark text-light">
                        <div class="modal-header">
                            <h5 class="modal-title" id="difficultyModalLabel">Select Puzzle Difficulty</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <label for="difficulty" class="form-label">Difficulty (1-10)</label>
                            <select name="difficulty" id="difficulty" class="form-select" required>
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Play</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>