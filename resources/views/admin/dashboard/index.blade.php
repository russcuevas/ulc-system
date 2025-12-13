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
    <style>
    .card-left-orange {
        border-left: 5px solid #ff6b35 !important;
    }
    </style>
</head>

<body>
    @include('admin.components.navbar')
    
    <div class="main-content">
        <div class="row g-4 mb-4">
            <h4>Dashboard</h4>
            <div class="col-12 col-md-6 col-xl-4">
    <div class="card border-2 shadow-lg h-100 card-left-orange">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <span class="text-body-secondary fw-medium">Total Loans</span>
                <div class="icon-box bg-danger-subtle text-danger">
                    <i class="fa-solid fa-coins"></i>
                </div>
            </div>
            <h2 class="h3 fw-bold mb-1">₱{{ number_format($totalLoans, 2) }}</h2>
            <span class="text-success small"><i class="bi bi-arrow-up"></i> +₱{{ number_format($loansTrend, 2) }} over 2024</span>
        </div>
    </div>
</div>

<div class="col-12 col-md-6 col-xl-4">
    <div class="card border-2 shadow-lg h-100 card-left-orange">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <span class="text-body-secondary fw-medium">Total Clients</span>
                <div class="icon-box bg-primary-subtle text-primary">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <h2 class="h3 fw-bold mb-1">{{ $totalClients }}</h2>
            <span class="text-success small">+{{ $clientsTrend }} compared to 2024</span>
        </div>
    </div>
</div>

<div class="col-12 col-md-6 col-xl-4">
    <div class="card border-2 shadow-lg h-100 card-left-orange">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <span class="text-body-secondary fw-medium">Daily Collections</span>
                <div class="icon-box bg-info-subtle text-info">
                    <i class="fa-solid fa-hand-holding-dollar"></i>
                </div>
            </div>
            <h2 class="h3 fw-bold mb-1">₱{{ number_format($dailyCollections, 2) }}</h2>
            <span class="text-body-secondary small">
                As of <span id="currentTime"></span>
            </span>
        </div>
    </div>
</div>

        </div>

        <div class="row g-4">
            <div class="col-12 col-lg-8">
                <div class="card border-2 shadow-lg h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
<div class="d-flex justify-content-between align-items-center mb-2">
    <h5 class="card-title mb-0">Loan Analytics [Monthly Collections]</h5>
</div>

<form id="yearForm">
    <select name="year" id="yearSelect" class="form-select form-select-sm w-auto">
        @for ($y = date('Y'); $y >= date('Y') - 5; $y--)
            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
        @endfor
    </select>
</form>

</div>
    <span class="text-success small">Total this year: ₱<span id="totalYearCollections">{{ number_format($totalYearCollections, 2) }}</span></span>

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
    {{-- CHART JS --}}
<script>
{
    const html = document.documentElement;
    const ctx = document.getElementById('portfolioChart')?.getContext('2d');
    let portfolioChart;

    function initChart(labels = [], data = []) {
        if (!ctx) return;

        const isDark = html.getAttribute('data-bs-theme') === 'dark';
        const gridColor = isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.05)';
        const textColor = isDark ? '#e0e0e0' : '#666';

        if (portfolioChart) portfolioChart.destroy();

        portfolioChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Collections',
                    data: data,
                    borderColor: '#ff6b35',
                    backgroundColor: 'rgba(255, 107, 53, 0.2)',
                    tension: 0.35,
                    borderWidth: 3,
                    pointRadius: 4,
                    pointBackgroundColor: '#ff6b35',
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: gridColor },
                        ticks: {
                            color: textColor,
                            callback: function(value) {
                                return '₱' + value.toLocaleString();
                            }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: textColor }
                    }
                }
            }
        });
    }

const initialLabels = @json($labels);
const initialData = @json(array_values($collectionsData));
initChart(initialLabels, initialData);

    // AJAX call when year changes
    document.getElementById('yearSelect').addEventListener('change', function() {
    const selectedYear = this.value;

    $.ajax({
        url: "{{ route('dashboard.chart-data') }}",
        type: "GET",
        data: { year: selectedYear },
        success: function(response) {
            initChart(response.labels, response.collections);
            document.getElementById('totalYearCollections').textContent = response.total.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        },
        error: function(err) {
            console.error("Failed to fetch chart data:", err);
        }
    });
});
}
</script>



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
    <script>
        function updateTime() {
            const now = new Date();
            const options = { 
                year: 'numeric', month: 'long', day: 'numeric', 
                hour: '2-digit', minute: '2-digit', second: '2-digit', 
                hour12: true 
            };
            document.getElementById('currentTime').textContent = now.toLocaleString('en-US', options);
        }

        updateTime();
        setInterval(updateTime, 1000);
    </script>
</body>

</html>