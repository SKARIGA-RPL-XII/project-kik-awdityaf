<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-comments text-primary mr-2"></i>Kelola Laporan Member
    </h1>
    <div>
        <button onclick="exportReports()" class="btn btn-sm btn-success shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Export Excel
        </button>
        <button onclick="printReports()" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-print fa-sm text-white-50"></i> Print
        </button>
    </div>
</div>

<!-- Flash Messages -->
<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle mr-2"></i><?= $this->session->flashdata('success'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle mr-2"></i><?= $this->session->flashdata('error'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<!-- Report Statistics -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Laporan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $report_stats['total']; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-gray-300"></i>
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
                            Laporan Baru</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $report_stats['open']; ?>
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
                            <?= $report_stats['in_progress']; ?>
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
                            <?= $report_stats['resolved']; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-filter mr-2"></i>Filter Laporan
        </h6>
    </div>
    <div class="card-body">
        <form method="GET" action="<?= base_url('gym/member_report'); ?>" class="row">
            <div class="col-md-3">
                <label for="status" class="font-weight-bold">Status:</label>
                <select name="status" id="status" class="form-control">
                    <option value="all" <?= $status_filter == 'all' ? 'selected' : ''; ?>>Semua Status</option>
                    <option value="Open" <?= $status_filter == 'Open' ? 'selected' : ''; ?>>Baru</option>
                    <option value="In Progress" <?= $status_filter == 'In Progress' ? 'selected' : ''; ?>>Sedang Diproses</option>
                    <option value="Resolved" <?= $status_filter == 'Resolved' ? 'selected' : ''; ?>>Selesai</option>
                    <option value="Closed" <?= $status_filter == 'Closed' ? 'selected' : ''; ?>>Ditutup</option>
                </select>
            </div>

            <div class="col-md-3">
                <label for="category" class="font-weight-bold">Kategori:</label>
                <select name="category" id="category" class="form-control">
                    <option value="all" <?= $category_filter == 'all' ? 'selected' : ''; ?>>Semua Kategori</option>
                    <?php foreach ($categories as $key => $value): ?>
                        <option value="<?= $key; ?>" <?= $category_filter == $key ? 'selected' : ''; ?>>
                            <?= $value; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-2">
                <label for="start_date" class="font-weight-bold">Dari Tanggal:</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="<?= $start_date; ?>">
            </div>

            <div class="col-md-2">
                <label for="end_date" class="font-weight-bold">Sampai Tanggal:</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="<?= $end_date; ?>">
            </div>

            <div class="col-md-2">
                <label class="font-weight-bold">&nbsp;</label>
                <div>
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-search mr-1"></i>Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Reports Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Laporan Member</h6>
    </div>
    <div class="card-body">
        <?php if (!empty($reports)): ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="reportsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Member</th>
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
                                    <div>
                                        <strong><?= $report['member_name'] ?: 'N/A'; ?></strong><br>
                                        <small class="text-muted"><?= $report['member_code'] ?: 'N/A'; ?></small><br>
                                        <small class="text-muted"><?= $report['member_email'] ?: 'N/A'; ?></small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-primary">
                                        <?= $categories[$report['category']] ?? $report['category']; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php
                                    $subject = $report['subject'];
                                    if (function_exists('character_limiter')) {
                                        echo character_limiter($subject, 40);
                                    } else {
                                        echo strlen($subject) > 40 ? substr($subject, 0, 40) . '...' : $subject;
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
                                    <button type="button" class="btn btn-sm btn-info mr-1"
                                        onclick="viewReport(<?= $report['id']; ?>)"
                                        data-toggle="modal" data-target="#reportModal">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-primary"
                                        onclick="updateStatus(<?= $report['id']; ?>)"
                                        data-toggle="modal" data-target="#statusModal">
                                        <i class="fas fa-edit"></i>
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
                <h5 class="text-gray-500">Tidak Ada Laporan</h5>
                <p class="text-muted">Belum ada laporan member yang sesuai dengan filter yang dipilih.</p>
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

<!-- Update Status Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">
                    <i class="fas fa-edit mr-2"></i>Update Status Laporan
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('gym/update_report_status'); ?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="report_id" id="update_report_id">

                    <div class="form-group">
                        <label for="status" class="font-weight-bold">Status:</label>
                        <select name="status" id="update_status" class="form-control" required>
                            <option value="Open">Baru</option>
                            <option value="In Progress">Sedang Diproses</option>
                            <option value="Resolved">Selesai</option>
                            <option value="Closed">Ditutup</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="admin_response" class="font-weight-bold">Respon Admin:</label>
                        <textarea name="admin_response" id="admin_response" class="form-control" rows="4"
                            placeholder="Berikan respon atau keterangan untuk member..."></textarea>
                        <small class="form-text text-muted">Respon ini akan dilihat oleh member yang mengirim laporan.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i>Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#reportsTable').DataTable({
            "pageLength": 25,
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

        const categoryNames = <?= json_encode($categories); ?>;

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
                <h6 class="font-weight-bold text-primary mb-3">Informasi Member</h6>
                <table class="table table-borderless table-sm">
                    <tr>
                        <td width="40%"><strong>Nama:</strong></td>
                        <td>${report.member_name || 'N/A'}</td>
                    </tr>
                    <tr>
                        <td><strong>Kode Member:</strong></td>
                        <td>${report.member_code || 'N/A'}</td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td>${report.member_email || 'N/A'}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h6 class="font-weight-bold text-success mb-3">Informasi Laporan</h6>
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
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <h6 class="font-weight-bold text-info mb-3">Subjek</h6>
                <div class="card border-left-info">
                    <div class="card-body">
                        <strong>${report.subject}</strong>
                    </div>
                </div>
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

    function updateStatus(reportId) {
        // Find report data
        const reports = <?= json_encode($reports); ?>;
        const report = reports.find(r => r.id == reportId);

        if (!report) {
            alert('Data laporan tidak ditemukan');
            return;
        }

        // Set form values
        $('#update_report_id').val(reportId);
        $('#update_status').val(report.status);
        $('#admin_response').val(report.admin_response || '');
    }

    function exportReports() {
        const params = new URLSearchParams(window.location.search);
        params.set('export', 'excel');
        window.open('<?= base_url("gym/member_report"); ?>?' + params.toString(), '_blank');
    }

    function printReports() {
        window.print();
    }
</script>