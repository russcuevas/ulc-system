<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ULC - System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</head>

<body>
    @include('admin.components.navbar')
    <div class="main-content">
        <div class="container-fluid">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none"><i
                                class="fas fa-home me-1"></i> Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><i class="fa-solid fa-user-lock me-1"></i>
                        Admin Information</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm border-1">
                        <div class="d-flex justify-content-between align-items-center m-4">
                            <h5 class="card-title mb-0">ADMIN INFORMATION</h5>
                            <button class="btn btn-outline-primary btn-sm d-flex align-items-center"
                                data-bs-toggle="modal" data-bs-target="#addAdminModal">
                                <i class="fas fa-plus-circle me-2"></i> ADD ADMIN
                            </button>
                            <i class="fas fa-plus-circle d-none"></i>
                        </div>

                        <!-- Add Admin Modal -->
                        @include('admin.admins.add_modal')
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped js-basic-example dataTable"
                                    style="min-width: 1000px; border: 2px solid rgba(0, 0, 0, 0.175) !important;;">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Fullname</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($admins as $admin)
                                            <tr>
                                                <td>{{ $admin->fullname }}</td>
                                                <td>{{ $admin->email }}</td>
                                                <td>{{ $admin->phone }}</td>
                                                <td>
                                                    @if ($admin->status === 'verified')
                                                        <span class="badge rounded-pill bg-success">Verified</span>
                                                    @else
                                                        <span class="badge rounded-pill bg-danger">Not Verified</span>
                                                    @endif
                                                </td>
                                                <td>{{ $admin->created_at }} <span
                                                        class="badge rounded-pill bg-success">by:
                                                        {{ $admin->created_by }}</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-warning"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#updateAdminModal{{ $admin->id }}">
                                                        <i class="fas fa-pencil"></i>
                                                    </button>

                                                    <form action="{{ route('admins.destroy', $admin->id) }}"
                                                        method="POST" class="delete-admin-form"
                                                        style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-danger delete-btn"
                                                            data-admin-id="{{ $admin->id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @include('admin.admins.edit_modal')
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('admin/assets/js/script.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.js-basic-example').DataTable({
                responsive: true, // Makes table responsive
                pageLength: 10, // Default rows per page
                lengthMenu: [5, 10, 25, 50], // Rows per page options
                order: [
                    [2, 'desc']
                ], // Default sorting (by Date Requested)
            });
        });
    </script>
    <script>
        (() => {
            'use strict';

            // Select all forms with validation
            const forms = document.querySelectorAll('.needs-validation');

            Array.from(forms).forEach(form => {
                const submitBtn = form.querySelector('button[type="submit"]');
                const btnText = submitBtn.querySelector('.btn-text');
                const spinner = submitBtn.querySelector('.spinner-border');

                form.addEventListener('submit', event => {
                    event.preventDefault(); // prevent default for custom validation

                    // Password match check
                    const password = form.querySelector('#adminPassword');
                    const confirmPassword = form.querySelector('#adminConfirmPassword');
                    const confirmFeedback = form.querySelector('#confirmPasswordFeedback');

                    if (password && confirmPassword) {
                        if (password.value !== confirmPassword.value) {
                            confirmPassword.setCustomValidity("Passwords do not match");
                            if (confirmFeedback) confirmFeedback.textContent =
                                "Passwords do not match.";
                        } else {
                            confirmPassword.setCustomValidity("");
                        }
                    }

                    // Check form validity
                    if (!form.checkValidity()) {
                        event.stopPropagation();
                        form.classList.add('was-validated');
                        return false;
                    }

                    // Show loading state
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        if (btnText) btnText.textContent = 'Please wait...';
                        if (spinner) spinner.classList.remove('d-none');
                    }

                    // Submit the form
                    form.submit();
                }, false);
            });
        })();
    </script>

    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            timeOut: 4000,
            positionClass: "toast-top-right"
        };

        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @elseif (session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    </script>

    @if ($errors->any())
        <script>
            toastr.error(`{!! implode('<br>', $errors->all()) !!}`);
        </script>
    @endif


    <script>
        $(document).ready(function() {
            $('.delete-btn').click(function(e) {
                e.preventDefault();

                var form = $(this).closest('form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>

</body>

</html>
