@extends('layouts.admin.app')

@section('content')

<!-- Welcome Section -->
<div class="card-gym shadow mb-4" style="border-left: 4px solid #ff006e;">
    <div class="p-4"
        style="background: linear-gradient(135deg, rgba(0,212,255,0.1) 0%, rgba(255,0,110,0.1) 100%); border-radius: 8px;">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="gym-accent font-weight-bold mb-2">
                    <i class="fas fa-dumbbell mr-2"></i>Gym Dashboard
                </h2>
                <p class="text-light-custom mb-2" style="opacity: 0.8;">
                    💪 Manage your gym operations efficiently
                </p>
            </div>
            <div class="col-auto">
                <a href="#" class="btn btn-gym-primary btn-lg rounded-pill">
                    <i class="fas fa-user-plus mr-2"></i>Add Member
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Status Cards Row -->
<div class="row">
    <!-- Active Members -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card-gym shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold gym-accent text-uppercase mb-1">Active
                            Members</div>
                        <div class="h5 mb-0 font-weight-bold text-light-custom">142</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x gym-accent" style="opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Members -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card-gym shadow h-100 py-2" style="border-left: 4px solid #ff006e;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold gym-accent-secondary text-uppercase mb-1">
                            New Members (This Month)</div>
                        <div class="h5 mb-0 font-weight-bold text-light-custom">24</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-plus fa-2x gym-accent-secondary" style="opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card-gym shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold gym-accent text-uppercase mb-1">Monthly
                            Revenue</div>
                        <div class="h5 mb-0 font-weight-bold text-light-custom">Rp 45.200.000</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-wallet fa-2x gym-accent" style="opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card-gym shadow h-100 py-2" style="border-left: 4px solid #ff006e;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold gym-accent-secondary text-uppercase mb-1">
                            Today's Attendance</div>
                        <div class="h5 mb-0 font-weight-bold text-light-custom">58</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-check fa-2x gym-accent-secondary" style="opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row">
    <!-- Growth -->
    <div class="col-xl-8 col-lg-7">
        <div class="card-gym shadow mb-4">
            <div class="card-body">
                <h3 class="gym-accent font-weight-bold mb-4">
                    <i class="fas fa-chart-line mr-2"></i>Member Growth Overview
                </h3>
                <canvas id="memberGrowthChart" style="height: 300px;"></canvas>
            </div>
        </div>
    </div>

    <!-- Distribution -->
    <div class="col-xl-4 col-lg-5">
        <div class="card-gym shadow mb-4" style="border-left: 4px solid #ff006e;">
            <div class="card-body">
                <h3 class="gym-accent-secondary font-weight-bold mb-4">
                    <i class="fas fa-chart-pie mr-2"></i>Member Distribution
                </h3>
                <canvas id="memberDistributionChart" style="height: 300px;"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Members & Expiring -->
<div class="row">
    <!-- Recent Members -->
    <div class="col-lg-6 mb-4">
        <div class="card-gym shadow mb-4">
            <div class="card-body">
                <h3 class="gym-accent font-weight-bold mb-4">
                    <i class="fas fa-users mr-2"></i>Recent New Members
                </h3>

                <div class="d-flex align-items-center mb-3"
                    style="border-bottom: 1px solid rgba(0,212,255,0.2); padding-bottom: 15px;">
                    <div class="bg-secondary rounded-circle mr-3 d-flex align-items-center justify-content-center"
                        style="width: 40px; height: 40px;">
                        <i class="fas fa-user text-light"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="font-weight-bold text-light-custom">Budi Santoso</div>
                        <div class="text-muted-custom small">MEM-001 • Oct 24, 2023</div>
                    </div>
                    <span class="badge font-weight-bold" style="background-color: #28a745; color: #fff;">Active</span>
                </div>

                <div class="d-flex align-items-center mb-3"
                    style="border-bottom: 1px solid rgba(0,212,255,0.2); padding-bottom: 15px;">
                    <div class="bg-secondary rounded-circle mr-3 d-flex align-items-center justify-content-center"
                        style="width: 40px; height: 40px;">
                        <i class="fas fa-user text-light"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="font-weight-bold text-light-custom">Siti Aminah</div>
                        <div class="text-muted-custom small">MEM-002 • Oct 23, 2023</div>
                    </div>
                    <span class="badge font-weight-bold" style="background-color: #28a745; color: #fff;">Active</span>
                </div>

                <div class="d-flex align-items-center mb-3"
                    style="border-bottom: 1px solid rgba(0,212,255,0.2); padding-bottom: 15px;">
                    <div class="bg-secondary rounded-circle mr-3 d-flex align-items-center justify-content-center"
                        style="width: 40px; height: 40px;">
                        <i class="fas fa-user text-light"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="font-weight-bold text-light-custom">Joko Anwar</div>
                        <div class="text-muted-custom small">MEM-003 • Oct 22, 2023</div>
                    </div>
                    <span class="badge font-weight-bold" style="background-color: #28a745; color: #fff;">Active</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Expiring Subscriptions -->
    <div class="col-lg-6 mb-4">
        <div class="card-gym shadow mb-4" style="border-left: 4px solid #ff006e;">
            <div class="card-body">
                <h3 class="gym-accent-secondary font-weight-bold mb-4">
                    <i class="fas fa-exclamation-triangle mr-2"></i>Expiring Subscriptions
                </h3>

                <div class="d-flex align-items-center mb-3"
                    style="border-bottom: 1px solid rgba(255,0,110,0.2); padding-bottom: 15px;">
                    <i class="fas fa-exclamation-triangle text-warning mr-3" style="font-size: 24px;"></i>
                    <div class="flex-grow-1">
                        <div class="font-weight-bold text-light-custom">Rina Wati</div>
                        <div class="text-muted-custom small">Annual Plan • Expires: Oct 30, 2023</div>
                    </div>
                    <a href="#" class="btn btn-gym-secondary btn-sm">
                        <i class="fas fa-renew"></i> Renew
                    </a>
                </div>

                <div class="d-flex align-items-center mb-3"
                    style="border-bottom: 1px solid rgba(255,0,110,0.2); padding-bottom: 15px;">
                    <i class="fas fa-exclamation-triangle text-warning mr-3" style="font-size: 24px;"></i>
                    <div class="flex-grow-1">
                        <div class="font-weight-bold text-light-custom">Doni Tata</div>
                        <div class="text-muted-custom small">Monthly Plan • Expires: Nov 01, 2023</div>
                    </div>
                    <a href="#" class="btn btn-gym-secondary btn-sm">
                        <i class="fas fa-renew"></i> Renew
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sample Data
    const monthlyGrowth = [12, 19, 13, 25, 22, 30, 28, 35, 40, 45, 50, 60];
    const maleCount = 65;
    const femaleCount = 35;

    // Global Chart Defaults for Dark Theme
    Chart.defaults.color = '#aab2bd';
    Chart.defaults.borderColor = 'rgba(255,255,255,0.05)';
    Chart.defaults.font.family = "'Segoe UI', 'Helvetica', 'Arial', sans-serif";

    // Member Growth Chart
    const ctxGrowth = document.getElementById('memberGrowthChart').getContext('2d');

    // Gradient Fill
    let gradient = ctxGrowth.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(0, 212, 255, 0.5)');
    gradient.addColorStop(1, 'rgba(0, 212, 255, 0.0)');

    new Chart(ctxGrowth, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov",
                "Dec"
            ],
            datasets: [{
                label: 'New Members',
                data: monthlyGrowth,
                borderColor: '#00d4ff',
                backgroundColor: gradient,
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#0f1419',
                pointBorderColor: '#00d4ff',
                pointHoverBackgroundColor: '#00d4ff',
                pointHoverBorderColor: '#fff',
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: '#00d4ff',
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 20, 25, 0.9)',
                    titleColor: '#00d4ff',
                    bodyColor: '#fff',
                    borderColor: 'rgba(0, 212, 255, 0.3)',
                    borderWidth: 1
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 212, 255, 0.1)'
                    },
                    ticks: {
                        color: '#00d4ff'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#dbeef6'
                    }
                }
            }
        }
    });

    // Member Distribution Chart
    new Chart(document.getElementById('memberDistributionChart'), {
        type: 'doughnut',
        data: {
            labels: ['Male', 'Female'],
            datasets: [{
                data: [maleCount, femaleCount],
                backgroundColor: ['#00d4ff', '#ff006e'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#fff',
                        padding: 20,
                        font: {
                            size: 14
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 20, 25, 0.9)',
                    bodyColor: '#fff',
                    borderColor: 'rgba(255, 255, 255, 0.1)',
                    borderWidth: 1
                }
            },
            cutout: '70%',
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    });
});
</script>
@endpush
@endsection