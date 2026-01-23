<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Dashboard</h3>
        </div>
    </div>
</div>

<div class="container-fluid">

    <div class="row">

        <!-- Surat Masuk Bulan Ini -->
        <div class="col-sm-4">
            <div class="card border-end">
                <div class="card-body">
                    <h2 class="text-dark mb-1"><?= $lettermonth ?? 0 ?></h2>
                    <span id="badge-in-month" class="badge bg-primary ms-2"></span>
                    <p class="text-muted">Jumlah surat masuk per bulan ini</p>
                </div>
            </div>
        </div>

        <!-- Surat Keluar Bulan Ini -->
        <div class="col-sm-4">
            <div class="card border-end">
                <div class="card-body">
                    <h2 class="text-dark mb-1"><?= $letterm ?? 0 ?></h2>
                    <span id="badge-out-month" class="badge bg-danger ms-2"></span>
                    <p class="text-muted">Jumlah surat keluar per bulan ini</p>
                </div>
            </div>
        </div>

        <!-- Pending -->
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-dark mb-1"><?= $pendingCount ?? 0 ?></h2>
                    <p class="text-muted">Jumlah surat belum ditindaklanjuti</p>
                </div>
            </div>
        </div>

    </div>


    <!-- Charts -->
    <div class="row mt-3">

        <!-- Doughnut -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4>Grafik Surat Bulanan</h4>
                    <canvas id="totalSalesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Bar -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4>Grafik Bulanan</h4>
                    <canvas id="netIncomeChart"></canvas>
                </div>
            </div>
        </div>

    </div>

</div>


<!-- ChartJS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // ================= DATA =================

    const suratMasuk = <?= json_encode($lettermonth ?? 0) ?>;
    const suratKeluar = <?= json_encode($letterm ?? 0) ?>;

    const monthlyData = <?= json_encode($monthlyData ?? []) ?>;


    // ================= BADGE =================

    const total = suratMasuk + suratKeluar;

    const inPct = total ? Math.round((suratMasuk / total) * 100) : 0;
    const outPct = 100 - inPct;

    document.getElementById('badge-in-month').textContent = inPct + '%';
    document.getElementById('badge-out-month').textContent = outPct + '%';


    // ================= BAR CHART =================

    const netCtx = document
        .getElementById('netIncomeChart')
        .getContext('2d');

    new Chart(netCtx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            datasets: [{
                label: 'Surat Masuk',
                data: monthlyData,
                backgroundColor: '#6675FF'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });


    // ================= DOUGHNUT =================

    const salesCtx = document
        .getElementById('totalSalesChart')
        .getContext('2d');

    new Chart(salesCtx, {
        type: 'doughnut',
        data: {
            labels: [
                'Surat Masuk',
                'Surat Keluar'
            ],
            datasets: [{
                data: [suratMasuk, suratKeluar],
                backgroundColor: [
                    '#6675FF',
                    '#FF577F'
                ]
            }]
        },
        options: {
            responsive: true,
            cutout: '70%',
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

});
</script>