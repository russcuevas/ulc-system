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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body>
    @include('admin.components.navbar')
    <div class="main-content">
        <div class="container-fluid">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none"><i
                                class="fas fa-home me-1"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('areas.index') }}" class="text-decoration-none"><i
                                class="fas fa-solid fa-hand-holding-dollar me-1"></i> Financial Counselor Area (FC)</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"><i class="fa-solid fa-coins me-1"></i>
                        Payments - {{ $area->area_name }}</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm border-1">
                        <div class="d-flex justify-content-between align-items-center m-4">
                            <h5 class="card-title mb-0">PAYMENTS SUMMARY - {{ $area->area_name }}</h5>
                            <form action="{{ route('areas.payments.create', $area->id) }}" method="POST">
                                @csrf
                                <button type="button" id="openDatePicker"
                                    class="btn btn-outline-primary btn-sm d-flex align-items-center">
                                    <i class="fas fa-plus-circle"></i>&nbsp;Create Payments
                                </button>
                            </form>
                        </div>

                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table id="paymentsTable"
                                    class="table table-hover table-striped dataTable js-basic-example"
                                    style="min-width: 1000px; border: 2px solid rgba(0,0,0,0.175) !important;">
                                    <thead class="table">
                                        <!-- Main Header -->
                                        <tr class="table-light">
                                            <th>Reference Number</th>
                                            <th>Collector</th>
                                            <th>Due Date</th>
                                            <th>Paid Clients</th>
                                            <th>Unpaid Clients</th>
                                            <th>Created By</th>
                                            <th>Action</th>
                                        </tr>

                                        <!-- Search Inputs Row -->
                                        <tr>
                                            <th><input type="text" class="form-control form-control-sm"
                                                    placeholder="Search Reference"></th>
                                            <th><input type="text" class="form-control form-control-sm"
                                                    placeholder="Search Collector"></th>
                                            <th><input type="text" class="form-control form-control-sm"
                                                    placeholder="Search Date"></th>
                                            <th><input type="text" class="form-control form-control-sm"
                                                    placeholder="Search Paid"></th>
                                            <th><input type="text" class="form-control form-control-sm"
                                                    placeholder="Search Unpaid"></th>
                                            <th><input type="text" class="form-control form-control-sm"
                                                    placeholder="Search Created By"></th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($payments as $payment)
                                            @php
                                                // Count paid clients for this reference number
                                                $paidClients = DB::table('clients_area_dailies')
                                                    ->where('reference_number', $payment->reference_number)
                                                    ->whereNotNull('collection')
                                                    ->where('collection', '>', 0)
                                                    ->count();

                                                // Count unpaid clients (collection NULL or 0)
                                                $unpaidClients = DB::table('clients_area_dailies')
                                                    ->where('reference_number', $payment->reference_number)
                                                    ->where(function ($q) {
                                                        $q->whereNull('collection')->orWhere('collection', 0);
                                                    })
                                                    ->count();
                                            @endphp
                                            <tr>
                                                <td>{{ $payment->reference_number }}</td>
                                                <td>{{ $payment->collected_by }}</td>
                                                <td>{{ \Carbon\Carbon::parse($payment->due_date)->format('F j, Y') }}
                                                </td>
                                                <td>{{ $paidClients }}</td>
                                                <td>{{ $unpaidClients }}</td>
                                                <td>{{ $payment->created_by }}</td>
                                                <td>
                                                    <a href="{{ route('areas.payments.view', [$area->id, $payment->reference_number]) }}"
                                                        class="btn btn-sm btn-outline-info">
                                                        Collections <i class="fas fa-eye"></i>
                                                    </a>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('admin/assets/js/script.js') }}"></script>
    <script>
        $(document).ready(function() {

            // Initialize DataTable
            var table = $('#paymentsTable').DataTable({
                responsive: true,
                pageLength: 10,
                orderCellsTop: true,
                fixedHeader: true,
                columnDefs: [{
                        orderable: false,
                        targets: 4
                    } // Disable sort on Action column
                ]
            });

            // Apply column search
            $('#paymentsTable thead tr:eq(1) th').each(function(i) {
                $('input', this).on('keyup change', function() {
                    if (table.column(i).search() !== this.value) {
                        table.column(i).search(this.value).draw();
                    }
                });
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
    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            timeOut: 4000,
            positionClass: "toast-top-right"
        };

        // TOASTR NOTIFICATIONS
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    </script>

    <script>
        document.getElementById('openDatePicker').addEventListener('click', function() {
            Swal.fire({
                title: 'Select Date and Collector',
                html: `
            <input id="dueDateInput" class="swal2-input" placeholder="Choose date">
            <select id="collectorSelect" class="swal2-input">
                <option value="">Select Collector</option>
                <option value="Russel Vincent Cuevas">Russel Vincent Cuevas</option>
                <option value="Sample1">Sample1</option>
                <option value="Sample2">Sample2</option>
            </select>
        `,
                didOpen: () => {
                    flatpickr("#dueDateInput", {
                        dateFormat: "Y-m-d"
                    });
                },
                showCancelButton: true,
                confirmButtonText: 'Save',
                cancelButtonText: 'Cancel',
                preConfirm: () => {
                    const date = document.getElementById('dueDateInput').value;
                    const collector = document.getElementById('collectorSelect').value;

                    if (!date) {
                        Swal.showValidationMessage('Please select a date');
                    }
                    if (!collector) {
                        Swal.showValidationMessage('Please select a collector');
                    }

                    return {
                        date,
                        collector
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = "{{ route('areas.payments.create', $area->id) }}";

                    // CSRF Token
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);

                    // Due Date
                    const dateInput = document.createElement('input');
                    dateInput.type = 'hidden';
                    dateInput.name = 'due_date';
                    dateInput.value = result.value.date;
                    form.appendChild(dateInput);

                    // Collector
                    const collectorInput = document.createElement('input');
                    collectorInput.type = 'hidden';
                    collectorInput.name = 'collector';
                    collectorInput.value = result.value.collector;
                    form.appendChild(collectorInput);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    </script>

</body>

</html>
