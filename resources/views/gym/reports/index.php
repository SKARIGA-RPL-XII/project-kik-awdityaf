<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Gym Reports & Analytics</h1>
    <div>
        <button class="btn btn-sm btn-success shadow-sm" onclick="exportAllReports()">
            <i class="fas fa-download fa-sm text-white-50"></i> Export All Reports
        </button>
        <button class="btn btn-sm btn-info shadow-sm" onclick="refreshReports()">
            <i class="fas fa-sync fa-sm text-white-50"></i> Refresh
        </button>
    </div>
</div>

<!-- Report Period Selector -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-success">Report Period</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="<?= base_url('gym/reports'); ?>">
            <div class="row">
                <div class="col-md-3">
                    <label for="period">Period</label>
                    <select name="period" id="period" class="form-control" onchange="toggleCustomDate()">
                        <option value="today" <?= $this->input->get('period') == 'today' ? 'selected' : ''; ?>>Today</option>
                        <option value="week" <?= $this->input->get('period') == 'week' ? 'selected' : ''; ?>>This Week</option>
                        <option value="month" <?= $this->input->get('period') == 'month' || !$this->input->get('period') ? 'selected' : ''; ?>>This Month</option>
                        <option value="quarter" <?= $this->input->get('period') == 'quarter' ? 'selected' : ''; ?>>This Quarter</option>
                        <option value="year" <?= $this->input->get('period') == 'year' ? 'selected' : ''; ?>>This Year</option>
                        <option value="custom" <?= $this->input->get('period') == 'custom' ? 'selected' : ''; ?>>Custom Range</option>
                    </select>
                </div>
                <div class="col-md-3" id="start_date_div" style="display: none;">
                    <label for="start_date">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="<?= $this->input->get('start_date'); ?>">
                </div>
                <div class="col-md-3" id="end_date_div" style="display: none;">
                    <label for="end_date">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="<?= $this->input->get('end_date'); ?>">
                </div>
                <div class="col-md-3">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary btn-block">Generate Report</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Summary Statistics -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Revenue</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp <?= isset($subscription_stats['monthly_revenue']) ? number_format($subscription_stats['monthly_revenue'] ?? 0, 0, ',', '.') : number_format(0, 0, ',', '.'); ?>
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
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Active Members</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= isset($member_stats['total_active']) ? $member_stats['total_active'] : 0; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
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
                            New Members</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= isset($member_stats['new_this_month']) ? $member_stats['new_this_month'] : 0; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-plus fa-2x text-gray-300"></i>
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
                            Avg Daily Attendance</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= isset($attendance_stats['avg_daily']) ? $attendance_stats['avg_daily'] : 0; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row">
    <!-- Revenue Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-success">Revenue Overview</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                        <a class="dropdown-item" href="#" onclick="exportChart('revenue')">Export Chart</a>
                        <a class="dropdown-item" href="#" onclick="printChart('revenue')">Print Chart</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Membership Plans Distribution -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-success">Plan Distribution</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                        <a class="dropdown-item" href="#" onclick="exportChart('plans')">Export Chart</a>
                        <a class="dropdown-item" href="#" onclick="printChart('plans')">Print Chart</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="plansChart"></canvas>
                </div>
                <div class="mt-4 text-center small">
                    <?php if (!empty($plan_stats)): ?>
                        <?php foreach ($plan_stats as $index => $plan): ?>
                            <span class="mr-2">
                                <i class="fas fa-circle" style="color: <?= ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'][$index % 5]; ?>"></i>
                                <?= $plan['plan_name']; ?>
                            </span>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Attendance Chart -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-success">Attendance Trends</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                        <a class="dropdown-item" href="#" onclick="exportChart('attendance')">Export Chart</a>
                        <a class="dropdown-item" href="#" onclick="printChart('attendance')">Print Chart</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-bar">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Reports Tables -->
<div class="row">
    <!-- Top Performing Plans -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Top Performing Plans</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>Plan</th>
                                <th>Subscribers</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($plan_stats)): ?>
                                <?php foreach ($plan_stats as $plan): ?>
                                    <tr>
                                        <td><?= $plan['plan_name']; ?></td>
                                        <td><?= $plan['total_subscriptions']; ?></td>
                                        <td>Rp <?= number_format($plan['total_revenue'] ?? 0, 0, ',', '.'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center">No data available</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Member Growth -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Member Statistics</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>Metric</th>
                                <th>Count</th>
                                <th>Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Active Members</td>
                                <td><?= isset($member_stats['total_active']) ? $member_stats['total_active'] : 0; ?></td>
                                <td>
                                    <?php
                                    $total = ($member_stats['total_active'] ?? 0) + ($member_stats['inactive'] ?? 0);
                                    $percentage = $total > 0 ? round(($member_stats['total_active'] ?? 0) / $total * 100, 1) : 0;
                                    echo $percentage . '%';
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Male Members</td>
                                <td><?= isset($member_stats['male']) ? $member_stats['male'] : 0; ?></td>
                                <td>
                                    <?php
                                    $total_gender = ($member_stats['male'] ?? 0) + ($member_stats['female'] ?? 0);
                                    $male_percentage = $total_gender > 0 ? round(($member_stats['male'] ?? 0) / $total_gender * 100, 1) : 0;
                                    echo $male_percentage . '%';
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Female Members</td>
                                <td><?= isset($member_stats['female']) ? $member_stats['female'] : 0; ?></td>
                                <td>
                                    <?php
                                    $female_percentage = $total_gender > 0 ? round(($member_stats['female'] ?? 0) / $total_gender * 100, 1) : 0;
                                    echo $female_percentage . '%';
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>New This Month</td>
                                <td><?= isset($member_stats['new_this_month']) ? $member_stats['new_this_month'] : 0; ?></td>
                                <td>
                                    <?php
                                    $new_percentage = ($member_stats['total_active'] ?? 0) > 0 ? round(($member_stats['new_this_month'] ?? 0) / ($member_stats['total_active'] ?? 1) * 100, 1) : 0;
                                    echo $new_percentage . '%';
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle custom date fields
    function toggleCustomDate() {
        const period = document.getElementById('period').value;
        const startDiv = document.getElementById('start_date_div');
        const endDiv = document.getElementById('end_date_div');

        if (period === 'custom') {
            startDiv.style.display = 'block';
            endDiv.style.display = 'block';
        } else {
            startDiv.style.display = 'none';
            endDiv.style.display = 'none';
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        toggleCustomDate();

        // Revenue Chart
        var ctx1 = document.getElementById("revenueChart");
        var revenueChart = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Revenue (Rp)",
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
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], // TODO: Add real data
                }],
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            callback: function(value, index, values) {
                                return 'Rp ' + value.toLocaleString();
                            }
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            return 'Revenue: Rp ' + tooltipItem.yLabel.toLocaleString();
                        }
                    }
                }
            }
        });

        // Plans Distribution Chart
        var ctx2 = document.getElementById("plansChart");
        var plansChart = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: [<?php if (!empty($plan_stats)): ?><?php foreach ($plan_stats as $plan): ?> "<?= $plan['plan_name']; ?>", <?php endforeach; ?><?php endif; ?>],
                datasets: [{
                    data: [<?php if (!empty($plan_stats)): ?><?php foreach ($plan_stats as $plan): ?><?= $plan['total_subscriptions']; ?>, <?php endforeach; ?><?php endif; ?>],
                    backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
                    hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#f4b619', '#c0392b'],
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

        // Attendance Chart
        var ctx3 = document.getElementById("attendanceChart");
        var attendanceChart = new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                datasets: [{
                    label: "Attendance",
                    backgroundColor: "#1cc88a",
                    hoverBackgroundColor: "#17a673",
                    borderColor: "#4e73df",
                    data: [40, 45, 50, 48, 55, 60, 35], // TODO: Add real data
                }],
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            return 'Attendance: ' + tooltipItem.yLabel + ' members';
                        }
                    }
                }
            }
        });
    });

    function exportChart(chartType) {
        alert('Export ' + chartType + ' chart functionality will be implemented');
    }

    function printChart(chartType) {
        window.print();
    }

    function exportAllReports() {
        window.open('<?= base_url("gym/export_reports"); ?>', '_blank');
    }

    function refreshReports() {
        location.reload();
    }
</script>