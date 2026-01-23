<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-list text-info mr-2"></i>Laporan Saya
    </h1>
    <div>
        <a href="<?= base_url('member/member_report'); ?>" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Buat Laporan Baru
        </a>
    </div>
</div>

<!-- Member Info -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-success">
            <i class="fas fa-user mr-2"></i>Informasi Member
        </h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Nama:</strong> <?= $user['name'] ?? 'N/A'; ?></p>
                <p><strong>Email:</strong> <?= $user['email'] ?? 'N/A'; ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>Kode Member:</strong> <?= $member['member_code'] ?? 'N/A'; ?></p>
                <p><strong>Total Laporan:</strong> <span class="badge badge-info"><?= count($reports); ?></span></p>
            </div>
        </div>
    </div>
</div>

<!-- Reports Statistics -->
<div class="row mb-4">
    <?php
    $status_counts = ['Open' => 0, 'In Progress' => 0, 'Resolved' => 0, 'Closed' => 0];
    foreach ($reports as $report) {
        if (isset($status_counts[$report['status']])) {
            $status_counts[$report['status']]++;
        }
    }
    ?>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Laporan Baru</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $status_counts['Open']; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
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
                            Sedang Diproses</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $status_counts['In Progress']; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-cog fa-2x text-gray-300"></i>
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
                            Selesai</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $status_counts['Resolved']; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                            Ditutup</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $status_counts['Closed']; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-archive fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reports List -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Laporan</h6>
    </div>
    <div class="card-body">
        <?php if (!empty($reports)): ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="reportsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Subjek</th>
                            <th>Prioritas</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reports as $report): ?>
                            <tr>
                                <td><?= date('d/m/Y H:i', strtotime($report['created_at'])); ?></td>
                                <td>
                                    <span class="badge badge-primary">
                                        <?php
                                        $category_names = [
                                            'facility' => 'Fasilitas',
                                            'equipment' => 'Peralatan',
                                            'service' => 'Pelayanan',
                                            'cleanliness' => 'Kebersihan',
                                            'staff' => 'Staff',
                                            'suggestion' => 'Saran',
                                            'complaint' => 'Keluhan',
                                            'other' => 'Lainnya'
                                        ];
                                        echo $category_names[$report['category']] ?? $report['category'];
                                        ?>
                                    </span>
                                </td>
                                <td>
                                    <?php
                                    $subject = $report['subject'];
                                    if (function_exists('character_limiter')) {
                                        echo character_limiter($subject, 50);
                                    } else {
                                        echo strlen($subject) > 50 ? substr($subject, 0, 50) . '...' : $subject;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $priority_class = [
                                        'Low' => 'secondary',
                                        'Medium' => 'warning',
                                        'High' => 'danger'
                                    ];
                                    $priority_names = [
                                        'Low' => 'Rendah',
                                        'Medium' => 'Sedang',
                                        'High' => 'Tinggi'
                                    ];
                                    ?>
                                    <span class="badge badge-<?= $priority_class[$report['priority']] ?? 'secondary'; ?>">
                                        <?= $priority_names[$report['priority']] ?? $report['priority']; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php
                                    $status_class = [
                                        'Open' => 'warning',
                                        'In Progress' => 'info',
                                        'Resolved' => 'success',
                                        'Closed' => 'secondary'
                                    ];
                                    $status_names = [
                                        'Open' => 'Baru',
                                        'In Progress' => 'Diproses',
                                        'Resolved' => 'Selesai',
                                        'Closed' => 'Ditutup'
                                    ];
                                    ?>
                                    <span class="badge badge-<?= $status_class[$report['status']] ?? 'secondary'; ?>">
                                        <?= $status_names[$report['status']] ?? $report['status']; ?>
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info"
                                        onclick="viewReport(<?= $report['id']; ?>)"
                                        data-toggle="modal" data-target="#reportModal">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                <h5 class="text-gray-500">Belum Ada Laporan</h5>
                <p class="text-muted">Anda belum pernah mengirim laporan. Klik tombol "Buat Laporan Baru" untuk mulai.</p>
                <a href="<?= base_url('member/member_report'); ?>" class="btn btn-primary">
                    <i class="fas fa-plus mr-2"></i>Buat Laporan Pertama
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Report Detail Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportModalLabel">
                    <i class="fas fa-file-alt mr-2"></i>Detail Laporan
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="reportModalBody">
                <!-- Content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#reportsTable').DataTable({
            "pageLength": 10,
            "order": [
                [0, "desc"]
            ],
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            }
        });
    });

    function viewReport(reportId) {
        // Find report data
        const reports = <?= json_encode($reports); ?>;
        const report = reports.find(r => r.id == reportId);

        if (!report) {
            alert('Data laporan tidak ditemukan');
            return;
        }

        const categoryNames = {
            'facility': 'Fasilitas Gym',
            'equipment': 'Peralatan',
            'service': 'Pelayanan',
            'cleanliness': 'Kebersihan',
            'staff': 'Staff/Trainer',
            'suggestion': 'Saran & Masukan',
            'complaint': 'Keluhan',
            'other': 'Lainnya'
        };

        const priorityNames = {
            'Low': 'Rendah',
            'Medium': 'Sedang',
            'High': 'Tinggi'
        };

        const statusNames = {
            'Open': 'Baru',
            'In Progress': 'Sedang Diproses',
            'Resolved': 'Selesai',
            'Closed': 'Ditutup'
        };

        const statusClass = {
            'Open': 'warning',
            'In Progress': 'info',
            'Resolved': 'success',
            'Closed': 'secondary'
        };

        const priorityClass = {
            'Low': 'secondary',
            'Medium': 'warning',
            'High': 'danger'
        };

        let modalContent = `
        <div class="row">
            <div class="col-md-6">
                <h6 class="font-weight-bold text-primary mb-3">Informasi Laporan</h6>
                <table class="table table-borderless table-sm">
                    <tr>
                        <td width="40%"><strong>Tanggal:</strong></td>
                        <td>${new Date(report.created_at).toLocaleDateString('id-ID', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        })}</td>
                    </tr>
                    <tr>
                        <td><strong>Kategori:</strong></td>
                        <td><span class="badge badge-primary">${categoryNames[report.category] || report.category}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Prioritas:</strong></td>
                        <td><span class="badge badge-${priorityClass[report.priority]}">${priorityNames[report.priority] || report.priority}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td><span class="badge badge-${statusClass[report.status]}">${statusNames[report.status] || report.status}</span></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h6 class="font-weight-bold text-success mb-3">Detail Laporan</h6>
                <p><strong>Subjek:</strong><br>${report.subject}</p>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-12">
                <h6 class="font-weight-bold text-info mb-3">Deskripsi Lengkap</h6>
                <div class="card border-left-info">
                    <div class="card-body">
                        ${report.description.replace(/\n/g, '<br>')}
                    </div>
                </div>
            </div>
        </div>
    `;

        if (report.admin_response) {
            modalContent += `
            <div class="row mt-3">
                <div class="col-12">
                    <h6 class="font-weight-bold text-success mb-3">Respon Admin</h6>
                    <div class="card border-left-success">
                        <div class="card-body">
                            ${report.admin_response.replace(/\n/g, '<br>')}
                            ${report.responded_at ? `<br><small class="text-muted">Direspon pada: ${new Date(report.responded_at).toLocaleDateString('id-ID')}</small>` : ''}
                        </div>
                    </div>
                </div>
            </div>
        `;
        }

        $('#reportModalBody').html(modalContent);
    }
</script>