// Chart.js Setup
let portfolioChart;
const ctx = document.getElementById('portfolioChart')?.getContext('2d');

function initChart() {
    if (!ctx) return;

    const isDark = html.getAttribute('data-bs-theme') === 'dark';
    const gridColor = isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.05)';
    const textColor = isDark ? '#e0e0e0' : '#666';

    if (portfolioChart) portfolioChart.destroy();

    portfolioChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Collections',
                data: [12, 19, 3, 5, 2, 3, 15, 10, 8, 12, 15, 20],
                borderColor: '#ff6b35',
                backgroundColor: 'rgba(255, 107, 53, 0.2)',
                tension: 0.35,       // curve smoothness
                borderWidth: 3,
                pointRadius: 4,
                pointBackgroundColor: '#ff6b35',
                fill: true           // optional area fill
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: gridColor },
                    ticks: { color: textColor }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: textColor }
                }
            }
        }
    });
}

function updateChartTheme() {
    initChart();
}

initChart();
