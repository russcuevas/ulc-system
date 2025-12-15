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
                    <li class="breadcrumb-item"><a href="{{ route('areas.index') }}" class="text-decoration-none"><i
                                class="fas fa-solid fa-hand-holding-dollar me-1"></i> Financial Counselor Area (FC)</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('areas.payments.show', $area->id) }}"
                            class="text-decoration-none"><i class="fa-solid fa-coins me-1"></i> Payments -
                            {{ $area->area_name }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><i class="fa-solid fa-coins me-1"></i>
                        Collections - {{ $area->area_name }}</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm border-1">
                        <div class="row align-items-start m-3">
                            <!-- Left Side -->
                            <div class="col-12 col-md-6 mb-3 mb-md-0">
                                <h5 class="mb-0">
                                    REFERENCE NUMBER: {{ $reference_number }}<br>
                                    Date: {{ \Carbon\Carbon::parse($clients->first()->due_date)->format('F j, Y') }}<br>
                                    No. of Clients: {{ $clients->count() }}
                                </h5>
                            </div>

                            <!-- Right Side -->
                            <div class="col-12 col-md-6 text-md-end">
                                <h5 class="mb-0">
                                    Collector: {{ $clients->first()->collected_by ?? '-' }}<br>
                                    Total Collected: <span
                                        class="text-danger">₱{{ number_format($clients->sum('collection'), 2) }}</span>
                                </h5>
                            </div>
                        </div>



                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table id="paymentsTable"
                                    class="table table-hover table-striped dataTable js-basic-example"
                                    style="min-width: 1000px; border: 2px solid rgba(0,0,0,0.175) !important;">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Client Name</th>
                                            <th>Loan Amount</th>
                                            <th>Balance</th>
                                            <th>Collection</th>
                                            <th>Type</th>
                                            <th>Created By</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($clients as $client)
                                            <tr
                                                class="{{ $client->collection === null || $client->collection == 0 ? 'table-danger' : '' }}">
                                                <td>{{ $client->fullname }}</td>
                                                <td>₱{{ number_format($client->loan_amount, 2) }}</td>
                                                <td>₱{{ number_format($client->balance, 2) }}</td>
                                                <td>
                                                    @if ($client->type === 'NO PAYMENT')
                                                        <span class="text-danger fw-bold">₱0.00</span>
                                                    @elseif ($client->collection !== null)
                                                        ₱{{ number_format($client->collection, 2) }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ $client->type ?? '-' }}</td>
                                                <td>{{ $client->created_by }}</td>
                                                <td>

                                                    @if ($client->collection === null)
                                                        <form method="POST"
                                                            action="{{ route('areas.payments.update', [$area->id, $reference_number]) }}"
                                                            class="paymentForm">
                                                            @csrf
                                                            <input type="hidden" name="client_id"
                                                                value="{{ $client->client_id }}">
                                                            <input type="hidden" name="fullname"
                                                                value="{{ $client->fullname }}">

                                                            <button type="button"
                                                                class="btn btn-sm btn-success collectPaymentBtn">Collect
                                                                Payment</button>
                                                            <button type="button"
                                                                class="btn btn-sm btn-warning remindPaymentBtn">Remind
                                                                Payment</button>
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger noPaymentBtn">No
                                                                Payment</button>
                                                        </form>
                                                    @elseif ($client->collection == 0)
                                                        <span class="badge rounded-pill bg-danger">
                                                            NO PAYMENT FOR THIS DAY
                                                        </span>
                                                    @else
                                                        <span class="badge rounded-pill bg-success">
                                                            PAID FOR THIS DAY
                                                        </span>
                                                    @endif

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
        $(document).ready(function() {
            $('.collectPaymentBtn').on('click', function() {
                let form = $(this).closest('form')[0]; // get raw form DOM element

                Swal.fire({
                    title: 'Collect Payment',
                    html: `
                <select id="paymentType" class="swal2-input">
                    <option value="">SELECT MODE OF PAYMENT</option>
                    <option value="GCASH">GCASH</option>
                    <option value="CHEQUE">CHEQUE</option>
                    <option value="CASH">CASH</option>
                </select>
                <input type="number" id="amount" class="swal2-input" placeholder="Amount">
            `,
                    focusConfirm: false,
                    showCancelButton: true,
                    confirmButtonText: 'Submit',
                    preConfirm: () => {
                        const amount = document.getElementById('amount').value;
                        const paymentType = document.getElementById('paymentType').value;

                        if (!amount || !paymentType) {
                            Swal.showValidationMessage(
                                'Please enter amount and select payment type');
                        }

                        return {
                            amount: amount,
                            type: paymentType
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(form).find('input[name="amount"], input[name="type"]').remove();

                        let amountInput = document.createElement('input');
                        amountInput.type = 'hidden';
                        amountInput.name = 'amount';
                        amountInput.value = result.value.amount;

                        let typeInput = document.createElement('input');
                        typeInput.type = 'hidden';
                        typeInput.name = 'type';
                        typeInput.value = result.value.type;

                        form.appendChild(amountInput);
                        form.appendChild(typeInput);

                        form.submit();
                    }
                });
            });

            // ================================
            // REMIND PAYMENT BUTTON
            // ================================
            $('.remindPaymentBtn').on('click', function() {
                let form = $(this).closest('form')[0];
                let fullname = $(form).find('input[name="fullname"]').val();

                Swal.fire({
                    title: `Remind ${fullname} for payment?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, remind',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $(form).find('input[name="amount"], input[name="type"]').remove();

                        // Send REMINDER with type = REMINDER
                        let typeInput = document.createElement('input');
                        typeInput.type = 'hidden';
                        typeInput.name = 'type';
                        typeInput.value = 'REMINDER';

                        form.appendChild(typeInput);
                        form.submit();
                    }
                });
            });


            // ================================
            // NO PAYMENT BUTTON
            // ================================
            $('.noPaymentBtn').on('click', function() {
                let form = $(this).closest('form')[0];
                let fullname = $(form).find('input[name="fullname"]').val();

                Swal.fire({
                    title: `Mark NO PAYMENT for ${fullname}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, mark as No Payment',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $(form).find('input[name="amount"], input[name="type"]').remove();

                        let amountInput = document.createElement('input');
                        amountInput.type = 'hidden';
                        amountInput.name = 'amount';
                        amountInput.value = 0;

                        let typeInput = document.createElement('input');
                        typeInput.type = 'hidden';
                        typeInput.name = 'type';
                        typeInput.value = 'NO PAYMENT';

                        form.appendChild(amountInput);
                        form.appendChild(typeInput);

                        form.submit();
                    }
                });
            });
        });
    </script>

</body>

</html>
