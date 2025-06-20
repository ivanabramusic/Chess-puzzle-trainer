<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Puzzles - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    @vite('resources/css/welcome.css')
</head>

<body class="bg-dark text-light">

    <div class="position-absolute top-0 start-0 p-3">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light btn-sm">
            ← Back
        </a>
    </div>

    <div class="position-absolute top-0 end-0 p-3">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
        </form>
    </div>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Puzzles</h1>

        <table class="table table-dark table-bordered table-hover text-center align-middle">
            <thead class="table-light text-dark">
                <tr>
                    <th>ID</th>
                    <th>FEN</th>
                    <th>Solution</th>
                    <th>Difficulty</th>
                    <th>Created By</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($puzzles as $puzzle)
                <tr>
                    <td>{{ $puzzle->id }}</td>
                    <td>{{ $puzzle->fen }}</td>
                    <td>{{ $puzzle->solution }}</td>
                    <td>{{ $puzzle->difficulty }}</td>
                    <td>{{ $puzzle->user->name ?? 'Unknown' }}</td>
                    <td>
                        <a href="#"
                            class="btn btn-sm btn-warning me-2 btn-edit-puzzle"
                            data-id="{{ $puzzle->id }}"
                            data-fen="{{ $puzzle->fen }}"
                            data-solution="{{ $puzzle->solution }}"
                            data-difficulty="{{ $puzzle->difficulty }}">
                            Edit
                        </a>

                        <button type="button" class="btn btn-sm btn-danger btn-delete-puzzle" data-id="{{ $puzzle->id }}">
                            Delete
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="modal fade" id="deletePuzzleModal" tabindex="-1" aria-labelledby="deletePuzzleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" id="deletePuzzleForm">
                    @csrf
                    @method('DELETE')
                    <div class="modal-content bg-dark text-light">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deletePuzzleModalLabel">Confirm Delete</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            Are you sure you want to delete this puzzle?
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Delete</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editPuzzleModal" tabindex="-1" aria-labelledby="editPuzzleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="editPuzzleForm">
                @csrf
                @method('PUT')
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPuzzleModalLabel">Edit Puzzle</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="id" id="editPuzzleId" />

                        <div class="mb-3">
                            <label for="editFen" class="form-label">FEN</label>
                            <input type="text" class="form-control" id="editFen" name="fen" required>
                        </div>

                        <div class="mb-3">
                            <label for="editSolution" class="form-label">Solution</label>
                            <input type="text" class="form-control" id="editSolution" name="solution" required>
                        </div>

                        <div class="mb-3">
                            <label for="editDifficulty" class="form-label">Difficulty</label>
                            <input type="number" class="form-control" id="editDifficulty" name="difficulty" min="1" max="10" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.querySelectorAll('.btn-delete-puzzle').forEach(button => {
            button.addEventListener('click', function() {
                const puzzleId = this.getAttribute('data-id');
                const deleteForm = document.getElementById('deletePuzzleForm');
                deleteForm.action = `/admin/puzzles/${puzzleId}`;

                const deleteModal = new bootstrap.Modal(document.getElementById('deletePuzzleModal'));
                deleteModal.show();
            });
        });
    </script>

    <script>
        document.querySelectorAll('.btn-edit-puzzle').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const id = this.dataset.id;
                const fen = this.dataset.fen;
                const solution = this.dataset.solution;
                const difficulty = this.dataset.difficulty;


                document.getElementById('editPuzzleId').value = id;
                document.getElementById('editFen').value = fen;
                document.getElementById('editSolution').value = solution;
                document.getElementById('editDifficulty').value = difficulty;


                const editForm = document.getElementById('editPuzzleForm');
                editForm.action = `/admin/puzzles/${id}`;


                const editModal = new bootstrap.Modal(document.getElementById('editPuzzleModal'));
                editModal.show();
            });
        });
    </script>
</body>

</html>