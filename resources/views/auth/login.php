        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="auth-card">
                        <div class="auth-header">
                            <i class="fas fa-dumbbell fa-3x mb-3"></i>
                            <h1>Welcome Back!</h1>
                            <p>Sign in to continue your fitness journey</p>
                        </div>

                        <div class="auth-body">
                            <?= $this->session->flashdata('message'); ?>

                            <form method="post" action="<?= base_url('auth') ?>">
                                <div class="mb-4">
                                    <label for="email" class="form-label fw-semibold">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Enter your email address"
                                        value="<?= set_value('email'); ?>" required>
                                    <?= form_error('email', '<div class="text-danger mt-1">', '</div>'); ?>
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="form-label fw-semibold">Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Enter your password" required>
                                    <?= form_error('password', '<div class="text-danger mt-1">', '</div>'); ?>
                                </div>

                                <button type="submit" class="btn btn-primary-custom mb-4">
                                    <i class="fas fa-sign-in-alt me-2"></i>Sign In to FitGym
                                </button>
                            </form>

                            <div class="text-center">
                                <p class="mb-0">Don't have an account?
                                    <a href="<?= base_url('auth/registration') ?>" class="auth-link">
                                        <i class="fas fa-user-plus me-1"></i>Join Our Fitness Community
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        </div>