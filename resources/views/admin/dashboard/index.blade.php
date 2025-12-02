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
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</head>

<body>
    @include('admin.components.navbar')
    
    <div class="main-content">
        <div class="row g-4 mb-4">
            <h4>Dashboard</h4>
            <div class="col-12 col-md-6 col-xl-3">
                <div class="card border-2 shadow-lg h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="text-body-secondary fw-medium">Total Loans</span>
                            <div class="icon-box bg-danger-subtle text-danger">
                                <svg width="24" height="24" fill="currentColor" viewBox="0 0 512 512">
                                    <path
                                        d="M320 96H192L144.6 24.9C137.5 14.2 145.1 0 157.9 0H354.1c12.8 0 20.4 14.2 13.3 24.9L320 96zM192 128H320c3.8 2.5 8.1 5.3 13 8.4C389.7 172.7 512 250.9 512 416c0 53-43 96-96 96H96c-53 0-96-43-96-96C0 250.9 122.3 172.7 179 136.4l0 0 0 0c4.8-3.1 9.2-5.9 13-8.4zm84 88c0-11-9-20-20-20s-20 9-20 20v14c-7.6 1.7-15.2 4.4-22.2 8.5c-13.9 8.3-25.9 22.8-25.8 43.9c.1 20.3 12 33.1 24.7 40.7c11 6.6 24.7 10.8 35.6 14l1.7 .5c12.6 3.7 21.9 6.6 28.3 10.5c5.2 3.1 5.3 4.9 5.3 6.7c0 .6-.1 1.9-4.4 5.6c-3.5 3-9.5 5.8-18.8 7.5c-9.4 1.7-21.2 2.2-34.4-.3c-11.2-2.1-22.5-5.4-31.9-8.5l0 0 0 0c-2.1-.7-4.1-1.4-6-2c-10.5-3.5-21.8 2.2-25.3 12.7s2.2 21.8 12.7 25.3c1.9 .6 4 1.3 6.1 2.1l0 0 0 0 0 0c9.3 3.1 21.4 6.8 33.9 9.3V408c0 11 9 20 20 20s20-9 20-20V392.2c8.5-1.2 16.7-3.6 24.1-7.4c14.3-7.8 27.9-22.2 27.9-45.8c0-19.4-11-32.2-23.6-40.3c-11.2-7.2-25.7-11.8-37.8-15.5l-2.8-.9c-12-3.6-20.8-6.2-26.7-9.6c-4.8-2.8-4.8-4-4.8-5.6c0-.8 .1-1.8 3.8-5.1c3-2.6 8.2-5.3 16.4-6.8c8.1-1.5 18.3-1.9 30.2 .1c11.7 2 22.2 5.2 30.6 8.1l0 0 0 0 0 0c2.1 .7 4.1 1.4 6 2c10.5 3.5 21.7-2.2 25.2-12.6s-2.2-21.7-12.6-25.2c-2-.7-4.1-1.4-6.2-2.1c-9.5-3.3-20.8-6.8-33.8-9V216z" />
                                </svg>
                            </div>
                        </div>
                        <h2 class="h3 fw-bold mb-1">₱45.2M</h2>
                        <span class="text-success small"><i class="bi bi-arrow-up"></i> +1.5M in 2024</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="card border-2 shadow-lg h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="text-body-secondary fw-medium">Total Clients</span>
                            <div class="icon-box bg-primary-subtle text-primary">
                                <svg width="24" height="24" fill="currentColor" viewBox="0 0 640 512">
                                    <path
                                        d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM609.3 512H471.4c5.4-9.4 8.6-20.3 8.6-32v-8c0-60.7-27.1-115.2-69.8-151.8c2.4-.1 4.7-.2 7.1-.2h61.4C567.8 320 640 392.2 640 481.3c0 17-13.8 30.7-30.7 30.7zM432 256c-31 0-59-12.6-79.3-32.9C372.4 196.5 384 163.6 384 128c0-26.8-6.6-52.1-18.3-74.3C384.3 40.1 407.2 32 432 32c61.9 0 112 50.1 112 112s-50.1 112-112 112z" />
                                </svg>
                            </div>
                        </div>
                        <h2 class="h3 fw-bold mb-1">8,901</h2>
                        <span class="text-success small">10% is in paid status</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="card border-2 shadow-lg h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="text-body-secondary fw-medium">Daily Collectibles</span>
                            <div class="icon-box bg-success-subtle text-success">
                                <svg width="24" height="24" fill="currentColor" viewBox="0 0 512 512">
                                    <path
                                        d="M64 64c0-17.7-14.3-32-32-32S0 46.3 0 64V400c0 44.2 35.8 80 80 80H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H80c-8.8 0-16-7.2-16-16V64zm406.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L320 210.7l-57.4-57.4c-12.5-12.5-32.8-12.5-45.3 0l-112 112c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L240 221.3l57.4 57.4c12.5 12.5 32.8 12.5 45.3 0l128-128z" />
                                </svg>
                            </div>
                        </div>
                        <h2 class="h3 fw-bold mb-1">₱12,340</h2>
                        <span class="text-danger small">15% overdue today</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <div class="card border-2 shadow-lg h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="text-body-secondary fw-medium">Daily Collections</span>
                            <div class="icon-box bg-info-subtle text-info">
                                <svg width="24" height="24" fill="currentColor" viewBox="0 0 384 512">
                                    <path
                                        d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM112 256H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16z" />
                                </svg>
                            </div>
                        </div>
                        <h2 class="h3 fw-bold mb-1">₱10,450</h2>
                        <span class="text-success small">25% above target</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12 col-lg-8">
                <div class="card border-2 shadow-lg h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title mb-0">Loan Portfolio Growth (Monthly Collections)</h5>
                            <select class="form-select form-select-sm w-auto">
                                <option>2025</option>
                                <option>2024</option>
                                <option>2023</option>
                            </select>
                        </div>
                        <canvas id="portfolioChart" style="width:100%; max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card border-2 shadow-lg h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Recent Activity</h5>

                        <div class="d-flex gap-3 mb-4">
                            <div class="activity-dot bg-success flex-shrink-0"></div>
                            <div>
                                <p class="mb-1 small">New added client <a href="#" class="text-decoration-none"
                                        style="color: var(--brand-orange)">Mr. Russel Vincent Cuevas</a>.</p>
                                <small class="text-body-secondary">1 hour ago by Admin Jess</small>
                            </div>
                        </div>

                        <div class="d-flex gap-3 mb-4">
                            <div class="activity-dot bg-danger flex-shrink-0"></div>
                            <div>
                                <p class="mb-1 small">Client <a href="#" class="text-decoration-none"
                                        style="color: var(--brand-orange)">Ms. Jess</a>, remind not paid for November
                                    26, 2025.</p>
                                <small class="text-body-secondary">4 hours ago by Admin Jess</small>
                            </div>
                        </div>

                        <div class="d-flex gap-3">
                            <div class="activity-dot bg-success flex-shrink-0"></div>
                            <div>
                                <p class="mb-1 small">Client <a href="#" class="text-decoration-none"
                                        style="color: var(--brand-orange)">Mr. Russel Vincent Cuevas</a>, marked as paid
                                    for November 26, 2025.</p>
                                <small class="text-body-secondary">1 hour ago by Admin Cuevas</small>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('admin/assets/js/script.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dashboard_chart.js') }}"></script>
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