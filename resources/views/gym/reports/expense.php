<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-arrow-down text-danger mr-2"></i>Laporan Uang Keluar
    </h1>
    <div>
        <a href="<?= base_url('gym/add_expense'); ?>" class="btn btn-sm btn-primary shadow-sm mr-2">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Pengeluaran
        </a>
        <button class="btn btn-sm btn-success shadow-sm mr-2" onclick="exportExpenseReport()">
            <i class="fas fa-download fa-sm text-white-50"></i> Export Excel
        </button>
        <button class="btn btn-sm btn-info shadow-sm" onclick="printExpenseReport()">
            <i class="fas fa-print fa-sm text-white-50"></i> Print
        </button>
    </div>
</div>

<!-- Date Filter -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-danger">Filter Periode</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="<?= base_url('gym/expense_report'); ?>">
            <div class="row">
                <div class="col-md-4">
                    <label for="start_date">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="start_date" name="start_date"
                        value="<?= $start_date; ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="end_date">Tanggal Akhir</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="<?= $end_date; ?>"
                        required>
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

<!-- Expense Statistics -->
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Total Pengeluaran</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp <?= number_format($total_expenses, 0, ',', '.'); ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
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
                            Rata-rata Harian</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp <?= number_format($expense_stats['daily_average'], 0, ',', '.'); ?>
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
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Transaksi</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= count($expenses); ?>
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

<!-- Expense Categories Chart -->
<div class="row">
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Pengeluaran per Kategori</h6>
            </div>
            <div class="card-body">
                <div class="chart-bar">
                    <canvas id="expenseCategoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Distribusi Pengeluaran</h6>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="expenseDistributionChart"></canvas>
                </div>
                <div class="mt-4 text-center small">
                    <?php foreach ($expense_categories as $category): ?>
                    <span class="mr-2">
                        <i class="fas fa-circle text-danger"></i> <?= $category['category']; ?>
                    </span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Notice for Future Implementation -->
<div class="alert alert-info">
    <i class="fas fa-info-circle mr-2"></i>
    <strong>Catatan:</strong> Fitur pencatatan pengeluaran akan segera tersedia.
    Saat ini menampilkan template untuk kategori pengeluaran yang umum digunakan di gym.
</div>

<!-- Expense Categories Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Kategori Pengeluaran</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="expenseTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>Total Pengeluaran</th>
                        <th>Persentase</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($expense_categories as $category): ?>
                    <tr>
                        <td>
                            <i class="fas fa-tag mr-2"></i><?= $category['category']; ?>
                        </td>
                        <td>Rp <?= number_format($category['total'], 0, ',', '.'); ?></td>
                        <td>
                            <?php
                                $percentage = $total_expenses > 0 ? ($category['total'] / $total_expenses) * 100 : 0;
                                echo number_format($percentage, 1) . '%';
                                ?>
                        </td>
                        <td>
                            <span class="badge badge-secondary">Belum Ada Data</span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#expenseTable').DataTable({
        "pageLength": 25,
        "order": [
            [1, "desc"]
        ]
    });

    // Expense Category Chart
    var ctx = document.getElementById("expenseCategoryChart");
    var categoryData = <?= json_encode($expense_categories); ?>;
    console.log("Isi categoryData:", categoryData);
    alert("Cek console: " + JSON.stringify(categoryData));

    // Prepare data for chart
    var labels = [];
    var data = [];
    var backgroundColors = ['#e74a3b', '#f39c12', '#3498db', '#2ecc71', '#9b59b6', '#e67e22', '#8e44ad'];

    if (categoryData && categoryData.length > 0) {
        labels = categoryData.map(item => {
            // Translate category names to Indonesian
            const categoryNames = {
                'Equipment': 'Peralatan',
                'Utilities': 'Utilitas',
                'Maintenance': 'Perawatan',
                'Staff Salary': 'Gaji Staff',
                'Marketing': 'Marketing',
                'Supplies': 'Perlengkapan',
                'Other': 'Lainnya'
            };
            return categoryNames[item.category] || item.category;
        });
        data = categoryData.map(item => parseFloat(item.total));
    } else {
        // Sample data if no real data exists
        labels = ['Peralatan', 'Utilitas', 'Perawatan', 'Gaji Staff'];
        data = [500000, 300000, 200000, 1500000];
    }

    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: "Pengeluaran (Rp)",
                backgroundColor: backgroundColors.slice(0, labels.length),
                borderColor: backgroundColors.slice(0, labels.length),
                borderWidth: 1,
                data: data,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': Rp ' + context.parsed.y
                                .toLocaleString('id-ID');
                        }
                    }
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
                    ticks: {
                        maxRotation: 45,
                        minRotation: 0
                    }
                }
            }
        }
    });

    // Expense Distribution Pie Chart
    var ctx2 = document.getElementById("expenseDistributionChart");

    var myPieChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: backgroundColors.slice(0, labels.length),
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
                            return label + ': Rp ' + value.toLocaleString('id-ID') + ' (' +
                                percentage + '%)';
                        }
                    }
                }
            },
            cutout: '60%'
        }
    });
});

function exportExpenseReport() {
    window.open('<?= base_url("gym/export_expense_report?start_date=" . $start_date . "&end_date=" . $end_date); ?>',
        '_blank');
}

function printExpenseReport() {
    window.print();
}
</script>