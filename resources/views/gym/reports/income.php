<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-arrow-up text-success mr-2"></i>Laporan Uang Masuk
    </h1>
    <div>
        <button class="btn btn-sm btn-success shadow-sm mr-2" onclick="exportIncomeReport()">
            <i class="fas fa-download fa-sm text-white-50"></i> Export Excel
        </button>
        <button class="btn btn-sm btn-info shadow-sm" onclick="printIncomeReport()">
            <i class="fas fa-print fa-sm text-white-50"></i> Print
        </button>
    </div>
</div>

<!-- Date Filter -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-success">Filter Periode</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="<?= base_url('gym/income_report'); ?>">
            <div class="row">
                <div class="col-md-4">
                    <label for="start_date">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="start_date" name="start_date"
                        value="<?= $start_date; ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="end_date">Tanggal Akhir</label>
                    <input type="date" class="form-control" id="end_date" name="end_date"
                        value="<?= $end_date; ?>" required>
                </div>
                <div class="col-md-4">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Income Statistics -->
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Pendapatan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp <?= number_format($total_income, 0, ',', '.'); ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Rata-rata Harian</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp <?= number_format($income_stats['daily_average'], 0, ',', '.'); ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total Transaksi</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= count($subscription_income); ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Periode</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                            <?= date('d/m/Y', strtotime($start_date)); ?> - <?= date('d/m/Y', strtotime($end_date)); ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Income by Plan Chart -->
<div class="row">
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Pendapatan Harian</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="dailyIncomeChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Pendapatan per Paket</h6>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="planIncomeChart"></canvas>
                </div>
                <div class="mt-4 text-center small">
                    <?php foreach ($income_stats['by_plan'] as $plan): ?>
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> <?= $plan['plan_name']; ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Income Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Detail Transaksi Pendapatan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="incomeTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Member</th>
                        <th>Kode Member</th>
                        <th>Paket</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($subscription_income)): ?>
                        <?php foreach ($subscription_income as $income): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($income['payment_date'])); ?></td>
                                <td><?= $income['member_name']; ?></td>
                                <td><?= $income['member_code']; ?></td>
                                <td><?= $income['plan_name']; ?></td>
                                <td>Rp <?= number_format($income['amount_paid'], 0, ',', '.'); ?></td>
                                <td>
                                    <span class="badge badge-success"><?= $income['payment_status']; ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data pendapatan pada periode ini</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#incomeTable').DataTable({
            "pageLength": 25,
            "order": [
                [0, "desc"]
            ]
        });

        // Daily Income Chart
        var ctx = document.getElementById("dailyIncomeChart");
        var dailyData = <?= json_encode($daily_income); ?>;

        // Prepare data for chart
        var labels = [];
        var data = [];

        if (dailyData && dailyData.length > 0) {
            labels = dailyData.map(item => {
                const date = new Date(item.date);
                return date.toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'short'
                });
            });
            data = dailyData.map(item => parseFloat(item.total));
        } else {
            // Sample data if no real data exists
            labels = ['1 Jan', '2 Jan', '3 Jan', '4 Jan', '5 Jan'];
            data = [0, 0, 0, 0, 0];
        }

        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: "Pendapatan (Rp)",
                    backgroundColor: "rgba(78, 115, 223, 0.1)",
                    borderColor: "rgba(78, 115, 223, 1)",
                    borderWidth: 2,
                    data: data,
                    fill: true,
                    tension: 0.4
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                elements: {
                    point: {
                        radius: 4,
                        hoverRadius: 6
                    }
                }
            }
        });

        // Plan Income Pie Chart
        var ctx2 = document.getElementById("planIncomeChart");
        var planData = <?= json_encode($income_stats['by_plan']); ?>;

        // Prepare data for pie chart
        var planLabels = [];
        var planValues = [];
        var backgroundColors = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#f39c12', '#9b59b6'];

        if (planData && planData.length > 0) {
            planLabels = planData.map(item => item.plan_name);
            planValues = planData.map(item => parseFloat(item.total));
        } else {
            // Sample data if no real data exists
            planLabels = ['Basic Plan', 'VIP Plan'];
            planValues = [0, 0];
        }

        var myPieChart = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: planLabels,
                datasets: [{
                    data: planValues,
                    backgroundColor: backgroundColors.slice(0, planLabels.length),
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return label + ': Rp ' + value.toLocaleString('id-ID') + ' (' + percentage + '%)';
                            }
                        }
                    }
                },
                cutout: '60%'
            }
        });
    });

    function exportIncomeReport() {
        window.open('<?= base_url("gym/export_income_report?start_date=" . $start_date . "&end_date=" . $end_date); ?>', '_blank');
    }

    function printIncomeReport() {
        window.print();
    }
</script>