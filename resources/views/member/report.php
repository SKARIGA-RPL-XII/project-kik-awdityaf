<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-comment-alt text-primary mr-2"></i>Laporan Member
    </h1>
    <div>
        <a href="<?= base_url('member/my_reports'); ?>" class="btn btn-sm btn-info shadow-sm">
            <i class="fas fa-list fa-sm text-white-50"></i> Lihat Laporan Saya
        </a>
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
                <p><strong>Status:</strong> 
                    <span class="badge badge-<?= ($member['status'] ?? '') == 'Active' ? 'success' : 'secondary'; ?>">
                        <?= $member['status'] ?? 'Unknown'; ?>
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Report Form -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-edit mr-2"></i>Form Laporan
        </h6>
    </div>
    <div class="card-body">
        <div class="alert alert-info mb-4">
            <i class="fas fa-info-circle mr-2"></i>
            <strong>Informasi:</strong> Gunakan form ini untuk menyampaikan saran, keluhan, atau masukan terkait fasilitas dan pelayanan gym. 
            Tim kami akan merespon laporan Anda dalam 1-2 hari kerja.
        </div>

        <form action="<?= base_url('member/submit_report'); ?>" method="POST" id="reportForm">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="category" class="font-weight-bold">
                            <i class="fas fa-tags mr-1"></i>Kategori Laporan <span class="text-danger">*</span>
                        </label>
                        <select class="form-control <?= form_error('category') ? 'is-invalid' : ''; ?>" 
                                id="category" name="category" required>
                            <option value="">Pilih Kategori</option>
                            <?php foreach ($categories as $key => $value): ?>
                                <option value="<?= $key; ?>" <?= set_select('category', $key); ?>>
                                    <?= $value; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (form_error('category')): ?>
                            <div class="invalid-feedback"><?= form_error('category'); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="priority" class="font-weight-bold">
                            <i class="fas fa-exclamation-circle mr-1"></i>Prioritas
                        </label>
                        <select class="form-control" id="priority" name="priority">
                            <option value="Low" <?= set_select('priority', 'Low'); ?>>Rendah</option>
                            <option value="Medium" <?= set_select('priority', 'Medium', TRUE); ?>>Sedang</option>
                            <option value="High" <?= set_select('priority', 'High'); ?>>Tinggi</option>
                        </select>
                        <small class="form-text text-muted">Pilih tingkat prioritas laporan Anda</small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="subject" class="font-weight-bold">
                            <i class="fas fa-heading mr-1"></i>Subjek <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control <?= form_error('subject') ? 'is-invalid' : ''; ?>" 
                               id="subject" name="subject" value="<?= set_value('subject'); ?>" 
                               placeholder="Ringkasan singkat laporan Anda" required>
                        <?php if (form_error('subject')): ?>
                            <div class="invalid-feedback"><?= form_error('subject'); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="description" class="font-weight-bold">
                            <i class="fas fa-align-left mr-1"></i>Deskripsi Lengkap <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control <?= form_error('description') ? 'is-invalid' : ''; ?>" 
                                  id="description" name="description" rows="6" 
                                  placeholder="Jelaskan secara detail laporan, saran, atau keluhan Anda..." required><?= set_value('description'); ?></textarea>
                        <?php if (form_error('description')): ?>
                            <div class="invalid-feedback"><?= form_error('description'); ?></div>
                        <?php endif; ?>
                        <small class="form-text text-muted">
                            Semakin detail informasi yang Anda berikan, semakin mudah bagi kami untuk membantu Anda
                        </small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary btn-lg mr-3">
                            <i class="fas fa-paper-plane mr-2"></i>Kirim Laporan
                        </button>
                        <button type="reset" class="btn btn-secondary btn-lg mr-3">
                            <i class="fas fa-undo mr-2"></i>Reset Form
                        </button>
                        <a href="<?= base_url('member'); ?>" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Guidelines -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">
            <i class="fas fa-lightbulb mr-2"></i>Panduan Laporan
        </h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6 class="font-weight-bold text-primary">Kategori Laporan:</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-building text-primary mr-2"></i><strong>Fasilitas Gym:</strong> Ruang latihan, loker, toilet, AC</li>
                    <li><i class="fas fa-dumbbell text-success mr-2"></i><strong>Peralatan:</strong> Kondisi alat fitness, kerusakan</li>
                    <li><i class="fas fa-handshake text-info mr-2"></i><strong>Pelayanan:</strong> Kualitas layanan staff</li>
                    <li><i class="fas fa-broom text-warning mr-2"></i><strong>Kebersihan:</strong> Kondisi kebersihan area gym</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h6 class="font-weight-bold text-primary">Tips Menulis Laporan:</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success mr-2"></i>Gunakan bahasa yang sopan dan jelas</li>
                    <li><i class="fas fa-check text-success mr-2"></i>Sertakan detail waktu dan lokasi jika relevan</li>
                    <li><i class="fas fa-check text-success mr-2"></i>Berikan saran konstruktif jika memungkinkan</li>
                    <li><i class="fas fa-check text-success mr-2"></i>Pilih kategori yang paling sesuai</li>
                </ul>
            </div>
        </div>
        
        <div class="alert alert-success mt-3">
            <i class="fas fa-clock mr-2"></i>
            <strong>Waktu Respon:</strong> Tim kami akan merespon laporan Anda dalam 1-2 hari kerja. 
            Anda dapat melihat status dan respon laporan di halaman "Laporan Saya".
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Form validation
    $('#reportForm').on('submit', function(e) {
        let isValid = true;
        let errorMessage = '';

        // Check required fields
        if (!$('#category').val()) {
            isValid = false;
            errorMessage += '- Kategori laporan harus dipilih\n';
        }

        if (!$('#subject').val().trim()) {
            isValid = false;
            errorMessage += '- Subjek harus diisi\n';
        }

        if (!$('#description').val().trim()) {
            isValid = false;
            errorMessage += '- Deskripsi harus diisi\n';
        }

        if ($('#description').val().trim().length < 10) {
            isValid = false;
            errorMessage += '- Deskripsi minimal 10 karakter\n';
        }

        if (!isValid) {
            e.preventDefault();
            alert('Mohon lengkapi data berikut:\n\n' + errorMessage);
            return false;
        }

        // Confirm submission
        if (!confirm('Apakah Anda yakin ingin mengirim laporan ini?')) {
            e.preventDefault();
            return false;
        }
    });

    // Character counter for description
    $('#description').on('input', function() {
        const maxLength = 1000;
        const currentLength = $(this).val().length;
        const remaining = maxLength - currentLength;
        
        if (!$('#charCounter').length) {
            $(this).after('<small id="charCounter" class="form-text text-muted"></small>');
        }
        
        $('#charCounter').text(`${currentLength}/${maxLength} karakter`);
        
        if (remaining < 50) {
            $('#charCounter').removeClass('text-muted').addClass('text-warning');
        } else {
            $('#charCounter').removeClass('text-warning').addClass('text-muted');
        }
    });

    // Auto-focus on category
    $('#category').focus();
});
</script>
