<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Play Puzzle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    {{-- Vite + play.js --}}
    @vite(['resources/js/play.js'])

    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        #board {
            width: 90vw;
            max-width: 400px;
            margin: 30px auto;
        }

        .message-area {
            text-align: center;
            font-weight: bold;
            margin-top: 20px;
            font-size: 1.2rem;
            min-height: 1.5em;
        }

        .btn-back {
            position: absolute;
            top: 15px;
            left: 15px;
            z-index: 10;
        }

        .message-success {
            color: lightgreen;
        }

        .message-error {
            color: red;
        }

        .puzzle-solved-message {
            color: #00ff00;
            font-size: 1.5rem;
            animation: fadeInOut 2s infinite alternate;
        }

        @keyframes fadeInOut {
            from {
                opacity: 0.5;
            }

            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body class="bg-dark text-light">

    <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm btn-back" id="backButton">Back</a>

    <div class="container text-center">
        <h1>Play Puzzle</h1>
        <div id="board"></div>
        <div class="message-area" id="messageArea"></div>
    </div>

    <div id="puzzle-data"
        data-fen="{{ $fen }}"
        data-solution="{{ $puzzle->solution }}"
        data-plays-first="{{ strtolower($puzzle->plays_first) }}">
    </div>

</body>

</html>