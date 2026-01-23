<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
    :root {
        --primary-color: #2dce89;
        --secondary-color: #11cdef;
        --dark-color: #1a1a1a;
        --light-color: #f8f9fa;
        --gradient: linear-gradient(135deg, #2dce89 0%, #11cdef 100%);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
        line-height: 1.6;
        color: #333;
    }

    .navbar {
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(10px);
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .navbar-brand {
        font-weight: 800;
        font-size: 1.8rem;
        color: var(--primary-color) !important;
    }

    .nav-link {
        font-weight: 500;
        color: #333 !important;
        margin: 0 10px;
        transition: all 0.3s ease;
    }

    .nav-link:hover {
        color: var(--primary-color) !important;
        transform: translateY(-2px);
    }

    .btn-primary-custom {
        background: var(--gradient);
        border: none;
        padding: 12px 30px;
        border-radius: 50px;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(45, 206, 137, 0.3);
    }

    .btn-primary-custom:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(45, 206, 137, 0.4);
    }

    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="%23ffffff08" points="0,1000 1000,0 1000,1000"/></svg>');
        background-size: cover;
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .hero-title {
        font-size: 4rem;
        font-weight: 800;
        color: white;
        margin-bottom: 1.5rem;
        line-height: 1.2;
    }

    .hero-subtitle {
        font-size: 1.3rem;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 2rem;
        font-weight: 300;
    }

    .stats-section {
        background: var(--dark-color);
        color: white;
        padding: 80px 0;
    }

    .stat-item {
        text-align: center;
        margin-bottom: 30px;
    }

    .stat-number {
        font-size: 3rem;
        font-weight: 800;
        color: var(--primary-color);
        display: block;
    }

    .stat-label {
        font-size: 1.1rem;
        color: rgba(255, 255, 255, 0.8);
        margin-top: 10px;
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 3rem;
        color: var(--dark-color);
    }

    .feature-card {
        background: white;
        border-radius: 20px;
        padding: 40px 30px;
        text-align: center;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border: none;
        height: 100%;
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }

    .feature-icon {
        width: 80px;
        height: 80px;
        background: var(--gradient);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 2rem;
        color: white;
    }

    .pricing-card {
        background: white;
        border-radius: 20px;
        padding: 40px 30px;
        text-align: center;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .pricing-card.featured {
        transform: scale(1.05);
        border: 3px solid var(--primary-color);
    }

    .pricing-card.featured::before {
        content: 'MOST POPULAR';
        position: absolute;
        top: 20px;
        left: -30px;
        background: var(--primary-color);
        color: white;
        padding: 5px 40px;
        font-size: 0.8rem;
        font-weight: 600;
        transform: rotate(-45deg);
    }

    .price {
        font-size: 3rem;
        font-weight: 800;
        color: var(--primary-color);
        margin: 20px 0;
    }

    .footer {
        background: var(--dark-color);
        color: white;
        padding: 60px 0 30px;
    }

    .footer .text-muted {
        color: white !important;
    }

    .footer h6 {
        color: white;
    }

    .footer ul.list-unstyled a {
        color: rgba(255, 255, 255, 0.8) !important;
    }

    .footer ul.list-unstyled li a:hover {
        color: var(--primary-color) !important;

    }

    .social-links a {
        display: inline-block;
        width: 50px;
        height: 50px;
        background: var(--gradient);
        border-radius: 50%;
        text-align: center;
        line-height: 50px;
        color: white;
        margin: 0 10px;
        transition: all 0.3s ease;
    }

    .social-links a:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(45, 206, 137, 0.3);
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }

        .hero-subtitle {
            font-size: 1.1rem;
        }

        .section-title {
            font-size: 2rem;
        }
    }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url(); ?>">
                <i class="fas fa-dumbbell me-2"></i>FitGym
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#membership">Membership</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item ms-3">
                        <a class="btn btn-primary-custom" href="<?= base_url('login'); ?>">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="hero-content">
                        <h1 class="hero-title">Transform Your Body, Transform Your Life</h1>
                        <p class="hero-subtitle">Join FitGym today and discover the best version of yourself with our
                            state-of-the-art equipment, expert trainers, and supportive community.</p>
                        <div class="d-flex gap-3 flex-wrap">
                            <a href="<?= base_url('register'); ?>" class="btn btn-primary-custom btn-lg">
                                <i class="fas fa-rocket me-2"></i>Start Your Journey
                            </a>
                            <a href="#membership" class="btn btn-outline-light btn-lg">
                                <i class="fas fa-play me-2"></i>View Plans
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            alt="Gym Equipment" class="img-fluid rounded-4 shadow-lg">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-item">
                        <span class="stat-number">500+</span>
                        <div class="stat-label">Happy Members</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-item">
                        <span class="stat-number">50+</span>
                        <div class="stat-label">Expert Trainers</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-item">
                        <span class="stat-number">24/7</span>
                        <div class="stat-label">Gym Access</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="stat-item">
                        <span class="stat-number">5</span>
                        <div class="stat-label">Years Experience</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                        alt="About FitGym" class="img-fluid rounded-4 shadow-lg">
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <h2 class="section-title text-start">Why Choose FitGym?</h2>
                    <p class="lead mb-4">We're not just a gym - we're your fitness partner committed to helping you
                        achieve your health and wellness goals.</p>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="feature-icon me-3" style="width: 60px; height: 60px; font-size: 1.5rem;">
                                    <i class="fas fa-dumbbell"></i>
                                </div>
                                <div>
                                    <h5>Modern Equipment</h5>
                                    <p class="mb-0">State-of-the-art fitness equipment</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="feature-icon me-3" style="width: 60px; height: 60px; font-size: 1.5rem;">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div>
                                    <h5>Expert Trainers</h5>
                                    <p class="mb-0">Certified personal trainers</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="feature-icon me-3" style="width: 60px; height: 60px; font-size: 1.5rem;">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <h5>24/7 Access</h5>
                                    <p class="mb-0">Work out anytime you want</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="feature-icon me-3" style="width: 60px; height: 60px; font-size: 1.5rem;">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <div>
                                    <h5>Community</h5>
                                    <p class="mb-0">Supportive fitness community</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Our Services</h2>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-dumbbell"></i>
                        </div>
                        <h4>Weight Training</h4>
                        <p>Build strength and muscle with our comprehensive weight training programs and equipment.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-running"></i>
                        </div>
                        <h4>Cardio Training</h4>
                        <p>Improve your cardiovascular health with our modern cardio equipment and programs.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4>Group Classes</h4>
                        <p>Join our energetic group fitness classes including Zumba, Yoga, and HIIT workouts.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <h4>Personal Training</h4>
                        <p>Get personalized workout plans and one-on-one training with our certified trainers.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="500">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-apple-alt"></i>
                        </div>
                        <h4>Nutrition Guidance</h4>
                        <p>Receive expert nutrition advice and meal planning to complement your fitness journey.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="600">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-spa"></i>
                        </div>
                        <h4>Recovery & Wellness</h4>
                        <p>Relax and recover with our sauna, massage therapy, and wellness programs.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Membership Section -->
    <section id="membership" class="py-5">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Choose Your Plan</h2>
            <p class="text-center text-muted mb-5" data-aos="fade-up">Select the perfect membership plan that fits your
                lifestyle and fitness goals.</p>

            <div class="row justify-content-center">
                <?php if (!empty($plans)): ?>
                <?php foreach ($plans as $index => $plan): ?>
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="<?= ($index + 1) * 100; ?>">
                    <div class="pricing-card <?= $index == 1 ? 'featured' : ''; ?>">
                        <h4><?= $plan['plan_name']; ?></h4>
                        <div class="price">
                            Rp <?= number_format($plan['price'], 0, ',', '.'); ?>
                            <small class="text-muted d-block" style="font-size: 1rem;">
                                / <?= $plan['duration_months']; ?> month<?= $plan['duration_months'] > 1 ? 's' : ''; ?>
                            </small>
                        </div>

                        <?php if (!empty($plan['features'])): ?>
                        <ul class="list-unstyled">
                            <?php
                                        $features = explode(',', $plan['features']);
                                        foreach (array_slice($features, 0, 5) as $feature):
                                        ?>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                <?= trim($feature); ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>

                        <a href="<?= base_url('register'); ?>" class="btn btn-primary-custom w-100 mt-3">
                            Choose Plan
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="pricing-card">
                        <h4>Basic Plan</h4>
                        <div class="price">Rp 150,000<small class="text-muted d-block" style="font-size: 1rem;">/
                                month</small></div>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Gym Access</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Locker</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Shower</li>
                        </ul>
                        <a href="<?= base_url('register'); ?>" class="btn btn-primary-custom w-100 mt-3">Choose Plan</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="pricing-card featured">
                        <h4>Premium Plan</h4>
                        <div class="price">Rp 300,000<small class="text-muted d-block" style="font-size: 1rem;">/
                                month</small></div>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>All Basic Features</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Personal Trainer</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Group Classes</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Nutrition Consultation</li>
                        </ul>
                        <a href="<?= base_url('register'); ?>" class="btn btn-primary-custom w-100 mt-3">Choose Plan</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="pricing-card">
                        <h4>VIP Plan</h4>
                        <div class="price">Rp 500,000<small class="text-muted d-block" style="font-size: 1rem;">/
                                month</small></div>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>All Premium Features</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Sauna Access</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Massage Therapy</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Priority Support</li>
                        </ul>
                        <a href="<?= base_url('register'); ?>" class="btn btn-primary-custom w-100 mt-3">Choose Plan</a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5" style="background: var(--gradient);">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-8" data-aos="fade-up">
                    <h2 class="text-white mb-4">Ready to Start Your Fitness Journey?</h2>
                    <p class="text-white mb-4 lead">Join thousands of members who have transformed their lives at
                        FitGym. Your journey to a healthier, stronger you starts today!</p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="<?= base_url('register'); ?>" class="btn btn-light btn-lg">
                            <i class="fas fa-rocket me-2"></i>Join Now
                        </a>
                        <a href="<?= base_url('home/contact'); ?>" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-phone me-2"></i>Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Get In Touch</h2>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4" data-aos="fade-up" data-aos-delay="100">
                            <div class="feature-icon mx-auto mb-3">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <h5>Visit Us</h5>
                            <p class="text-muted">Jl. Fitness No. 123<br>Jakarta, Indonesia</p>
                        </div>
                        <div class="col-md-4 text-center mb-4" data-aos="fade-up" data-aos-delay="200">
                            <div class="feature-icon mx-auto mb-3">
                                <i class="fas fa-phone"></i>
                            </div>
                            <h5>Call Us</h5>
                            <p class="text-muted">+62 21 1234 5678<br>+62 812 3456 7890</p>
                        </div>
                        <div class="col-md-4 text-center mb-4" data-aos="fade-up" data-aos-delay="300">
                            <div class="feature-icon mx-auto mb-3">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <h5>Email Us</h5>
                            <p class="text-muted">info@fitgym.com<br>support@fitgym.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="text-white mb-3">
                        <i class="fas fa-dumbbell me-2"></i>FitGym
                    </h5>
                    <p class="text-muted">Transform your body, transform your life. Join our fitness community and
                        achieve your health goals with expert guidance and state-of-the-art facilities.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/aaghdttt/"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="text-white mb-3">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="#home" class="text-muted">Home</a></li>
                        <li><a href="#about" class="text-muted">About</a></li>
                        <li><a href="#services" class="text-muted">Services</a></li>
                        <li><a href="#membership" class="text-muted">Membership</a></li>
                        <li><a href="#contact" class="text-muted">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="text-white mb-3">Services</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-muted">Weight Training</a></li>
                        <li><a href="#" class="text-muted">Cardio Training</a></li>
                        <li><a href="#" class="text-muted">Group Classes</a></li>
                        <li><a href="#" class="text-muted">Personal Training</a></li>
                        <li><a href="#" class="text-muted">Nutrition Guidance</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="text-white mb-3">Contact Info</h6>
                    <ul class="list-unstyled">
                        <li class="text-muted mb-2">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            Jl. Fitness No. 123, Jakarta
                        </li>
                        <li class="text-muted mb-2">
                            <i class="fas fa-phone me-2"></i>
                            +62 21 1234 5678
                        </li>
                        <li class="text-muted mb-2">
                            <i class="fas fa-envelope me-2"></i>
                            info@fitgym.com
                        </li>
                        <li class="text-muted">
                            <i class="fas fa-clock me-2"></i>
                            24/7 Access
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="my-4" style="border-color: #333;">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-muted mb-0">&copy; 2024 FitGym. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="<?= base_url('login'); ?>" class="btn btn-primary-custom">Member Login</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
    // Initialize AOS
    AOS.init({
        duration: 1000,
        once: true
    });

    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Navbar background on scroll
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.style.background = 'rgba(255, 255, 255, 0.98)';
        } else {
            navbar.style.background = 'rgba(255, 255, 255, 0.95)';
        }
    });

    // Counter animation
    function animateCounters() {
        const counters = document.querySelectorAll('.stat-number');
        counters.forEach(counter => {
            const target = parseInt(counter.textContent.replace(/\D/g, ''));
            const increment = target / 100;
            let current = 0;

            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    counter.textContent = counter.textContent.replace(/\d+/, target);
                    clearInterval(timer);
                } else {
                    counter.textContent = counter.textContent.replace(/\d+/, Math.floor(current));
                }
            }, 20);
        });
    }

    // Trigger counter animation when stats section is visible
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounters();
                observer.unobserve(entry.target);
            }
        });
    });

    const statsSection = document.querySelector('.stats-section');
    if (statsSection) {
        observer.observe(statsSection);
    }
    </script>
</body>

</html>