        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="auth-card">
                        <div class="auth-header">
                            <i class="fas fa-user-plus fa-3x mb-3"></i>
                            <h1>Join FitGym Today!</h1>
                            <p>Start your fitness journey with us</p>
                        </div>

                        <div class="auth-body">
                            <form method="post" action="<?= site_url('auth/registration') ?>">
                                <div class="mb-4">
                                    <label for="name" class="form-label fw-semibold">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter your full name" value="<?= set_value('name'); ?>" required>
                                    <?= form_error('name', '<div class="text-danger mt-1">', '</div>'); ?>
                                </div>

                                <div class="mb-4">
                                    <label for="email" class="form-label fw-semibold">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Enter your email address" value="<?= set_value('email'); ?>"
                                        required>
                                    <?= form_error('email', '<div class="text-danger mt-1">', '</div>'); ?>
                                </div>
                                <div class="mb-4">
                                    <label for="phone" class="form-label fw-semibold">Phone Number <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        placeholder="Enter phone number" value="<?= set_value('phone'); ?>" required>
                                    <?= form_error('phone', '<div class="text-danger mt-1">', '</div>'); ?>
                                </div>

                                <div class="mb-4">
                                    <label for="gender" class="form-label fw-semibold">Gender <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" id="gender" name="gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male" <?= set_select('gender', 'Male'); ?>>Male</option>
                                        <option value="Female" <?= set_select('gender', 'Female'); ?>>Female</option>
                                    </select>
                                    <?= form_error('gender', '<div class="text-danger mt-1">', '</div>'); ?>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="password1" class="form-label fw-semibold">Password</label>
                                        <input type="password" class="form-control" id="password1" name="password1"
                                            placeholder="Create password" required>
                                        <?= form_error('password1', '<div class="text-danger mt-1">', '</div>'); ?>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label for="password2" class="form-label fw-semibold">Confirm Password</label>
                                        <input type="password" class="form-control" id="password2" name="password2"
                                            placeholder="Confirm password" required>
                                        <?= form_error('password2', '<div class="text-danger mt-1">', '</div>'); ?>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary-custom mb-4">
                                    <i class="fas fa-dumbbell me-2"></i>Join Our Gym Community
                                </button>
                            </form>

                            <div class="text-center">
                                <p class="mb-0">Already have an account?
                                    <a href="<?= base_url('auth') ?>" class="auth-link">
                                        <i class="fas fa-sign-in-alt me-1"></i>Sign In Here
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>