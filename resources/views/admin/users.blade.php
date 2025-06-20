<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Users - Admin Panel</title>
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
        <h1 class="text-center mb-4">Users</h1>

        <table class="table table-dark table-bordered table-hover text-center align-middle">
            <thead class="table-light text-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role_id }}</td>
                    <td>
                        <a href="#"
                            class="btn btn-sm btn-warning me-2 btn-edit-user"
                            data-id="{{ $user->id }}"
                            data-name="{{ $user->name }}"
                            data-email="{{ $user->email }}"
                            data-role_id="{{ $user->role_id }}">
                            Edit
                        </a>



                        <button
                            class="btn btn-sm btn-danger"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteUserModal"
                            data-user-id="{{ $user->id }}"
                            data-user-name="{{ $user->name }}">
                            Delete
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" id="deleteUserForm">
                    @csrf
                    @method('DELETE')
                    <div class="modal-content bg-dark text-light">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteUserModalLabel">Confirm Deletion</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete <strong id="deleteUserName"></strong>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" id="editUserForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-content bg-dark text-light">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="editUserId" />

                            <div class="mb-3">
                                <label for="editUserName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="editUserName" name="name" required />
                            </div>

                            <div class="mb-3">
                                <label for="editUserEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="editUserEmail" name="email" required />
                            </div>

                            <div class="mb-3">
                                <label for="editUserRole" class="form-label">Role ID</label>
                                <input type="number" class="form-control" id="editUserRole" name="role_id" required />

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


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const deleteUserModal = document.getElementById('deleteUserModal');
        deleteUserModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-user-id');
            const userName = button.getAttribute('data-user-name');


            const userNameElement = deleteUserModal.querySelector('#deleteUserName');
            userNameElement.textContent = userName;


            const deleteForm = document.getElementById('deleteUserForm');
            deleteForm.action = `/admin/users/${userId}`;
        });
    </script>

    <script>
        document.querySelectorAll('.btn-edit-user').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const id = this.dataset.id;
                const name = this.dataset.name;
                const email = this.dataset.email;
                const role_id = this.dataset.role_id;


                document.getElementById('editUserId').value = id;
                document.getElementById('editUserName').value = name;
                document.getElementById('editUserEmail').value = email;
                document.getElementById('editUserRole').value = role_id;


                const editForm = document.getElementById('editUserForm');
                editForm.action = `/admin/users/${id}`;


                const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
                editModal.show();
            });
        });
    </script>


</body>

</html>