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
</head>

<body>
    @include('admin.components.navbar')
    <div class="main-content">
        <div class="container-fluid">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none"><i
                                class="fas fa-home me-1"></i> Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><i class="fa-solid fa-users me-1"></i>
                        Client Information</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm border-1">
                        <div class="d-flex justify-content-between align-items-center m-4">
                            <h5 class="card-title mb-0">CLIENT INFORMATION</h5>
                            <button class="btn btn-outline-primary btn-sm d-flex align-items-center"
                                data-bs-toggle="modal" data-bs-target="#addClientModal">
                                <i class="fas fa-plus-circle me-2"></i> ADD CLIENT
                            </button>
                            <i class="fas fa-plus-circle d-none"></i>
                        </div>

                        <!-- Add Client Modal -->
                        <div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-top modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addClientModalLabel">Add Client</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form id="addClientForm" class="needs-validation" novalidate>
                                        <div class="modal-body">
                                            <div class="row">
                                                <!-- Left Column: Personal Info -->
                                                <div class="col-md-6">
                                                    <h6 class="mb-3">Personal Information</h6>
                                                    <div class="mb-3">
                                                        <label for="clientName" class="form-label">Full Name <span style="color: rgb(126, 30, 30)">*</span></label>
                                                        <input type="text" class="form-control" id="clientName"
                                                            name="clientName" required>
                                                        <div class="invalid-feedback">
                                                            Please enter full name.
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="clientPhone" class="form-label">Phone <span style="color: rgb(126, 30, 30)">*</span></label>
                                                        <input type="text" class="form-control" id="clientPhone"
                                                            name="clientPhone" required pattern="\d{11}" minlength="11"
                                                            maxlength="11">
                                                        <div class="invalid-feedback">
                                                            Please enter a valid phone number (11 digits required).
                                                        </div>
                                                    </div>


                                                    <div class="mb-3">
                                                        <label for="clientAddress" class="form-label">Address <span style="color: rgb(126, 30, 30)">*</span></label>
                                                        <input type="text" class="form-control" id="clientAddress"
                                                            name="clientAddress" required>
                                                        <div class="invalid-feedback">
                                                            Please enter an address.
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <!-- Loan From -->
                                                        <div class="col-lg-5 mb-3">
                                                            <label for="clientArea" class="form-label">Select
                                                                Area <span style="color: rgb(126, 30, 30)">*</span></label>
                                                            <select class="form-control select-form select2"
                                                                name="SELECT AREA" required>
                                                                <option value="" disabled selected>SELECT AREA
                                                                </option>
                                                                <option value="">Area 1</option>
                                                                <option value="">Area 1</option>
                                                                <option value="">Area 1</option>
                                                                <option value="">Area 1</option>
                                                                <option value="">Area 1</option>
                                                                <option value="">Area 1</option>
                                                                <option value="">Area 1</option>
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                Select an area.
                                                            </div>
                                                        </div>

                                                        <!-- Loan To -->
                                                        <div class="col-lg-7 mb-3">
                                                            <label class="form-label d-block">Gender <span style="color: rgb(126, 30, 30)">*</span></label>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="adminGender" id="genderMale" value="Male"
                                                                    checked>
                                                                <label class="form-check-label"
                                                                    for="genderMale">Male</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="adminGender" id="genderFemale"
                                                                    value="Female">
                                                                <label class="form-check-label"
                                                                    for="genderFemale">Female</label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <!-- Right Column: Account Info -->
                                                <div class="col-md-6">
                                                    <h6 class="mb-3">Loan Information</h6>
                                                    <div class="row">
                                                        <!-- Loan From -->
                                                        <div class="col-lg-6 mb-3">
                                                            <label for="loanFrom" class="form-label">Loan From <span style="color: rgb(126, 30, 30)">*</span></label>
                                                            <input type="date" class="form-control" id="loanFrom"
                                                                name="loanFrom" required>
                                                            <div class="invalid-feedback">Please enter a valid date.
                                                            </div>
                                                        </div>

                                                        <!-- Loan To -->
                                                        <div class="col-lg-6 mb-3">
                                                            <label for="loanTo" class="form-label">Loan To <span style="color: rgb(126, 30, 30)">*</span></label>
                                                            <input type="date" class="form-control" id="loanTo"
                                                                name="loanTo" required>
                                                            <div class="invalid-feedback">Please enter a valid date.
                                                            </div>
                                                        </div>
                                                        <!-- Loan Amount -->
                                                        <div class="col-lg-6 mb-3">
                                                            <label for="loanAmount" class="form-label">Loan
                                                                Amount <span style="color: rgb(126, 30, 30)">*</span></label>
                                                            <input type="number" class="form-control"
                                                                id="loanAmount" name="loanAmount" required
                                                                min="0" step="0.01">
                                                            <div class="invalid-feedback">
                                                                Please enter amount.
                                                            </div>
                                                        </div>
                                                        <!-- Loan Terms -->
                                                        <div class="col-lg-6 mb-3">
                                                            <label for="loanTerms" class="form-label">Loan
                                                                Terms</label>
                                                            <input
                                                                style="background-color: gray; color: white !important;"
                                                                type="text" class="form-control" id="loanTerms"
                                                                name="loanTerms" value="100" placeholder="100"
                                                                readonly required>
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
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Area</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Juan Dela Cruz</td>
                                            <td>09495748302</td>
                                            <td>Calingatan Mataasnakahoy Batangas</td>
                                            <td>Area 1</td>
                                            <td>2025-11-28 - 5:00pm <span class="badge rounded-pill bg-success">by:
                                                    Russel Admin</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-warning" title="View Details">Update <i
                                                        class="fas fa-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" title="View Details">Delete<i
                                                        class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                       
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
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
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

                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    form.classList.add('was-validated');
                }, false)
            })
        })();
    </script>

</body>

</html>
