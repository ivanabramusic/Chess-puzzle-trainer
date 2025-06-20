<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Puzzle</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    @vite(['resources/css/add_puzzle.css', 'resources/js/add_puzzle.js'])
</head>

<body class="bg-dark text-light">

    <div class="container py-5">
        <div class="row align-items-center mb-4">
            <div class="col-auto">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-light">
                    ← Back
                </a>
            </div>
            <div class="col text-center">
                <h1 class="mb-0">Add a New Puzzle</h1>
            </div>
        </div>
        <form action="{{ route('puzzles.store') }}" method="POST">
            @csrf
            <div class="row">

                <div class="col-md-6 mb-4">
                    <div id="board" style="width: 100%"></div>
                    <input type="hidden" name="fen" id="fen" value="">
                    <div class="mt-2 d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-secondary" id="clearBoard">Clear</button>
                        <button type="button" class="btn btn-sm btn-warning" id="resetBoard">Reset</button>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Who Plays First?</label>
                        <select name="plays_first" class="form-select" required>
                            <option value="white">White</option>
                            <option value="black">Black</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Difficulty (1-10)</label>
                        <input type="number" name="difficulty" class="form-control" required min="1" max="10">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Solution (PGN or UCI)</label>
                        <input type="text" name="solution" class="form-control" placeholder="e.g. Nf3 Qh5 Qxf7#">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="castlingRights">Castling Rights:</label>
                        <input type="text" id="castlingRights" class="form-control" value="-" placeholder="KQkq or -">
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="toggleRecordingMode">
                        <label class="form-check-label" for="toggleRecordingMode">Use move recording instead of manual input</label>
                    </div>

                    <div id="recordControls" style="display: none;">
                        <button type="button" class="btn btn-outline-primary mb-2" id="startRecording">Start Recording</button>
                        <button type="button" class="btn btn-outline-warning mb-2" id="resetToPreRecording">Reset Board</button>
                        <button type="button" class="btn btn-outline-danger mb-2" id="stopRecording">Stop Recording</button>

                    </div>

                    <button type="submit" class="btn btn-success w-100">Add Puzzle</button>
                </div>
            </div>
        </form>
    </div>

    {{-- Uklonjen neispravan CDN link za chess.js (ostaje uklonjen) --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/chess.js/1.0.0/chess.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/chess.js@1.0.0/chess.min.js"></script>

</body>

</html>