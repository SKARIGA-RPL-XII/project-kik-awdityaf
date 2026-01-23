<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-plus text-primary mr-2"></i>Tambah Pengeluaran
    </h1>
    <div>
        <a href="<?= base_url('gym/expense_report'); ?>" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali ke Laporan
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

<!-- Add Expense Form -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-money-bill-wave mr-2"></i>Form Tambah Pengeluaran
        </h6>
    </div>
    <div class="card-body">
        <form action="<?= base_url('gym/process_add_expense'); ?>" method="POST" id="expenseForm">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="expense_date" class="font-weight-bold">
                            <i class="fas fa-calendar mr-1"></i>Tanggal Pengeluaran <span class="text-danger">*</span>
                        </label>
                        <input type="date" class="form-control <?= form_error('expense_date') ? 'is-invalid' : ''; ?>" 
                               id="expense_date" name="expense_date" value="<?= set_value('expense_date', date('Y-m-d')); ?>" required>
                        <?php if (form_error('expense_date')): ?>
                            <div class="invalid-feedback"><?= form_error('expense_date'); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="category" class="font-weight-bold">
                            <i class="fas fa-tags mr-1"></i>Kategori <span class="text-danger">*</span>
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
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="amount" class="font-weight-bold">
                            <i class="fas fa-dollar-sign mr-1"></i>Jumlah (Rp) <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="number" class="form-control <?= form_error('amount') ? 'is-invalid' : ''; ?>" 
                                   id="amount" name="amount" value="<?= set_value('amount'); ?>" 
                                   placeholder="0" min="0" step="1000" required>
                            <?php if (form_error('amount')): ?>
                                <div class="invalid-feedback"><?= form_error('amount'); ?></div>
                            <?php endif; ?>
                        </div>
                        <small class="form-text text-muted">Masukkan jumlah pengeluaran dalam Rupiah</small>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="description" class="font-weight-bold">
                            <i class="fas fa-edit mr-1"></i>Deskripsi <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control <?= form_error('description') ? 'is-invalid' : ''; ?>" 
                               id="description" name="description" value="<?= set_value('description'); ?>" 
                               placeholder="Deskripsi singkat pengeluaran" required>
                        <?php if (form_error('description')): ?>
                            <div class="invalid-feedback"><?= form_error('description'); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="notes" class="font-weight-bold">
                            <i class="fas fa-sticky-note mr-1"></i>Catatan Tambahan
                        </label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" 
                                  placeholder="Catatan atau keterangan tambahan (opsional)"><?= set_value('notes'); ?></textarea>
                        <small class="form-text text-muted">Informasi tambahan tentang pengeluaran ini</small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary btn-lg mr-3">
                            <i class="fas fa-save mr-2"></i>Simpan Pengeluaran
                        </button>
                        <button type="reset" class="btn btn-secondary btn-lg mr-3">
                            <i class="fas fa-undo mr-2"></i>Reset Form
                        </button>
                        <a href="<?= base_url('gym/expense_report'); ?>" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-times mr-2"></i>Batal
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Quick Tips -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">
            <i class="fas fa-lightbulb mr-2"></i>Tips Penggunaan
        </h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6 class="font-weight-bold text-primary">Kategori Pengeluaran:</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-dumbbell text-primary mr-2"></i><strong>Peralatan Gym:</strong> Pembelian alat fitness, maintenance equipment</li>
                    <li><i class="fas fa-bolt text-warning mr-2"></i><strong>Utilitas:</strong> Listrik, air, internet, telepon</li>
                    <li><i class="fas fa-tools text-info mr-2"></i><strong>Perawatan:</strong> Perbaikan, cleaning service, maintenance</li>
                    <li><i class="fas fa-users text-success mr-2"></i><strong>Gaji Karyawan:</strong> Salary staff, trainer, cleaning service</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h6 class="font-weight-bold text-primary">Panduan Input:</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success mr-2"></i>Pastikan tanggal sesuai dengan waktu pengeluaran</li>
                    <li><i class="fas fa-check text-success mr-2"></i>Pilih kategori yang paling sesuai</li>
                    <li><i class="fas fa-check text-success mr-2"></i>Deskripsi harus jelas dan informatif</li>
                    <li><i class="fas fa-check text-success mr-2"></i>Jumlah harus akurat sesuai bukti pembayaran</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Format number input
    $('#amount').on('input', function() {
        let value = $(this).val();
        if (value) {
            // Remove non-numeric characters except decimal point
            value = value.replace(/[^0-9]/g, '');
            $(this).val(value);
        }
    });

    // Form validation
    $('#expenseForm').on('submit', function(e) {
        let isValid = true;
        let errorMessage = '';

        // Check required fields
        if (!$('#expense_date').val()) {
            isValid = false;
            errorMessage += '- Tanggal pengeluaran harus diisi\n';
        }

        if (!$('#category').val()) {
            isValid = false;
            errorMessage += '- Kategori harus dipilih\n';
        }

        if (!$('#description').val().trim()) {
            isValid = false;
            errorMessage += '- Deskripsi harus diisi\n';
        }

        if (!$('#amount').val() || parseFloat($('#amount').val()) <= 0) {
            isValid = false;
            errorMessage += '- Jumlah harus lebih dari 0\n';
        }

        if (!isValid) {
            e.preventDefault();
            alert('Mohon lengkapi data berikut:\n\n' + errorMessage);
            return false;
        }

        // Confirm submission
        if (!confirm('Apakah Anda yakin ingin menyimpan data pengeluaran ini?')) {
            e.preventDefault();
            return false;
        }
    });

    // Auto-focus on first input
    $('#expense_date').focus();
});
</script>
