<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Gym Dashboard</h1>
    <div>
        <a href="<?= base_url('gym/add_member'); ?>" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
            <i class="fas fa-user-plus fa-sm text-white-50"></i> Add New Member
        </a>
    </div>
</div>

<!-- Content Row -->
<div class="row">

    <!-- Total Active Members Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Active Members</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= isset($member_stats['total_active']) ? $member_stats['total_active'] : 0; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Members This Month Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            New Members (This Month)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= isset($member_stats['new_this_month']) ? $member_stats['new_this_month'] : 0; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Revenue Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Monthly Revenue</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= isset($subscription_stats['monthly_revenue']) ? number_format($subscription_stats['monthly_revenue'], 0, ',', '.') : 0; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Attendance Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Today's Attendance</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= isset($attendance_stats['today']) ? $attendance_stats['today'] : 0; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Content Row -->
<div class="row">

    <!-- Member Growth Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-success">Member Growth Overview</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="memberGrowthChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Member Gender Distribution -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-success">Member Distribution</h6>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="memberDistributionChart"></canvas>
                </div>
                <div class="mt-4 text-center small">
                    <span class="mr-2">
                        <i class="fas fa-circle text-primary"></i> Male
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-success"></i> Female
                    </span>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Content Row -->
<div class="row">

    <!-- Recent Members -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Recent New Members</h6>
            </div>
            <div class="card-body">
                <?php if (!empty($recent_members)): ?>
                    <?php foreach (array_slice($recent_members, 0, 5) as $member): ?>
                        <div class="d-flex align-items-center mb-3">
                            <div class="mr-3">
                                <img class="rounded-circle" width="40" height="40" src="<?= base_url('assets/img/profile/' . ($member['image'] ?? 'default.jpg')); ?>" alt="Member">
                            </div>
                            <div class="flex-grow-1">
                                <div class="font-weight-bold"><?= $member['name']; ?></div>
                                <div class="text-muted small"><?= $member['member_code']; ?> • <?= date('M d, Y', strtotime($member['join_date'])); ?></div>
                            </div>
                            <div>
                                <span class="badge badge-<?= $member['status'] == 'Active' ? 'success' : 'secondary'; ?>"><?= $member['status']; ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted text-center">No recent members found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Expiring Subscriptions -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">Expiring Subscriptions (Next 7 Days)</h6>
            </div>
            <div class="card-body">
                <?php if (!empty($expiring_subscriptions)): ?>
                    <?php foreach ($expiring_subscriptions as $subscription): ?>
                        <div class="d-flex align-items-center mb-3">
                            <div class="mr-3">
                                <i class="fas fa-exclamation-triangle text-warning"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="font-weight-bold"><?= $subscription['member_name']; ?></div>
                                <div class="text-muted small"><?= $subscription['plan_name']; ?> • Expires: <?= date('M d, Y', strtotime($subscription['end_date'])); ?></div>
                            </div>
                            <div>
                                <a href="<?= base_url('gym/subscriptions'); ?>" class="btn btn-sm btn-warning">Renew</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted text-center">No expiring subscriptions.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

<!-- Charts JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Member Growth Chart
    var ctx = document.getElementById("memberGrowthChart");
    var memberGrowthChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: "New Members",
                lineTension: 0.3,
                backgroundColor: "rgba(45, 206, 137, 0.05)",
                borderColor: "rgba(45, 206, 137, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(45, 206, 137, 1)",
                pointBorderColor: "rgba(45, 206, 137, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(45, 206, 137, 1)",
                pointHoverBorderColor: "rgba(45, 206, 137, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: <?= isset($monthly_growth) ? $monthly_growth : '[0,0,0,0,0,0,0,0,0,0,0,0]'; ?>,
            }],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                xAxes: [{
                    time: {
                        unit: 'month'
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 12
                    }
                }],
                yAxes: [{
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        callback: function(value, index, values) {
                            return value;
                        }
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }],
            },
            legend: {
                display: false
            },
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                intersect: false,
                mode: 'index',
                caretPadding: 10,
                callbacks: {
                    label: function(tooltipItem, chart) {
                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                        return datasetLabel + ': ' + tooltipItem.yLabel + ' members';
                    }
                }
            }
        }
    });

    // Member Distribution Pie Chart
    var ctx2 = document.getElementById("memberDistributionChart");
    var memberDistributionChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ["Male", "Female"],
            datasets: [{
                data: [<?= isset($member_stats['male']) ? $member_stats['male'] : 0; ?>, <?= isset($member_stats['female']) ? $member_stats['female'] : 0; ?>],
                backgroundColor: ['#4e73df', '#1cc88a'],
                hoverBackgroundColor: ['#2e59d9', '#17a673'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: false
            },
            cutoutPercentage: 80,
        },
    });
});
</script>
