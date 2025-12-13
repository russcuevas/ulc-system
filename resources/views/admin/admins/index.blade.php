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
                        <div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-top modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addAdminModalLabel">Add Admin</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form method="POST" action="{{ route('admins.store') }}" id="addAdminForm"
                                        class="needs-validation" novalidate>
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <!-- Left Column: Personal Info -->
                                                <div class="col-md-6">
                                                    <h6 class="mb-3">Personal Information</h6>
                                                    <div class="mb-3">
                                                        <label for="adminName" class="form-label">Full Name <span
                                                                style="color: rgb(126, 30, 30)">*</span></label>
                                                        <input type="text" class="form-control" name="fullname"
                                                            required>

                                                        <div class="invalid-feedback">
                                                            Please enter full name.
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="adminPhone" class="form-label">Phone <span
                                                                style="color: rgb(126, 30, 30)">*</span></label>
                                                        <input type="text" class="form-control" name="phone"
                                                            required pattern="\d{11}" minlength="11" maxlength="11">

                                                        <div class="invalid-feedback">
                                                            Please enter a valid phone number (11 digits required).
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label d-block">Gender <span
                                                                style="color: rgb(126, 30, 30)">*</span></label>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="gender" value="Male" checked>

                                                            <label class="form-check-label"
                                                                for="genderMale">Male</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="gender" value="Female">

                                                            <label class="form-check-label"
                                                                for="genderFemale">Female</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Right Column: Account Info -->
                                                <div class="col-md-6">
                                                    <h6 class="mb-3">Account Information</h6>
                                                    <div class="mb-3">
                                                        <label for="adminEmail" class="form-label">Email <span
                                                                style="color: rgb(126, 30, 30)">*</span></label>
                                                        <input type="email" class="form-control" name="email"
                                                            required>

                                                        <div class="invalid-feedback">
                                                            Please enter a valid email.
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="adminPassword" class="form-label">Password <span
                                                                style="color: rgb(126, 30, 30)">*</span></label>
                                                        <input type="password" class="form-control"
                                                            id="adminPassword" name="password" required
                                                            minlength="6">
                                                        <div class="invalid-feedback">
                                                            Password must be at least 6 characters.
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="adminConfirmPassword" class="form-label">Confirm
                                                            Password <span
                                                                style="color: rgb(126, 30, 30)">*</span></label>
                                                        <input type="password" class="form-control"
                                                            id="adminConfirmPassword" name="password_confirmation"
                                                            required>
                                                        <div class="invalid-feedback" id="confirmPasswordFeedback">
                                                            Passwords do not match.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>


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
                                                    <button class="btn btn-sm btn-warning" title="Update">Update <i
                                                            class="fas fa-pencil"></i></button>
                                                    <button class="btn btn-sm btn-danger" title="Delete">Delete <i
                                                            class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('admin/assets/js/script.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dashboard_chart.js') }}"></script>
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
            'use strict'

            const forms = document.querySelectorAll('.needs-validation')

            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    const password = form.querySelector('#adminPassword');
                    const confirmPassword = form.querySelector('#adminConfirmPassword');
                    const confirmFeedback = form.querySelector('#confirmPasswordFeedback');

                    if (password.value !== confirmPassword.value) {
                        confirmPassword.setCustomValidity("Passwords do not match");
                        confirmFeedback.textContent = "Passwords do not match.";
                    } else {
                        confirmPassword.setCustomValidity("");
                    }

                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    form.classList.add('was-validated');
                }, false)
            })
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
        @endif
    </script>
</body>

</html>
