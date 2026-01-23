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

        .page-header {
            background: var(--gradient);
            padding: 150px 0 100px;
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="%23ffffff08" points="0,1000 1000,0 1000,1000"/></svg>');
            background-size: cover;
        }

        .page-header .container {
            position: relative;
            z-index: 2;
        }

        .page-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .page-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            font-weight: 300;
        }

        .contact-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: none;
            height: 100%;
        }

        .contact-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .contact-icon {
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

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 15px 20px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(45, 206, 137, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }

        .map-container {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
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

        .alert {
            border-radius: 10px;
            border: none;
            padding: 15px 20px;
        }

        .alert-success {
            background: rgba(45, 206, 137, 0.1);
            color: var(--primary-color);
            border-left: 4px solid var(--primary-color);
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border-left: 4px solid #dc3545;
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 2.5rem;
            }

            .page-subtitle {
                font-size: 1.1rem;
            }

            .contact-card {
                padding: 30px 20px;
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
                        <a class="nav-link" href="<?= base_url(); ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url(); ?>#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url(); ?>#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url(); ?>#membership">Membership</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url('contact'); ?>">Contact</a>
                    </li>
                    <li class="nav-item ms-3">
                        <a class="btn btn-primary-custom" href="<?= base_url('login'); ?>">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1 class="page-title" data-aos="fade-up">Contact Us</h1>
            <p class="page-subtitle" data-aos="fade-up" data-aos-delay="100">
                Get in touch with our team. We're here to help you start your fitness journey!
            </p>
        </div>
    </section>

    <!-- Contact Information Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="contact-card text-center">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h4>Visit Our Gym</h4>
                        <p class="text-muted mb-3">Come and see our state-of-the-art facilities</p>
                        <p><strong>Jl. Fitness No. 123</strong><br>
                            Jakarta Selatan, DKI Jakarta<br>
                            Indonesia 12345</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="contact-card text-center">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h4>Call Us</h4>
                        <p class="text-muted mb-3">We're available 24/7 for your convenience</p>
                        <p><strong>+62 21 1234 5678</strong><br>
                            <strong>+62 812 3456 7890</strong><br>
                            WhatsApp Available
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="contact-card text-center">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h4>Email Us</h4>
                        <p class="text-muted mb-3">Send us a message anytime</p>
                        <p><strong>info@fitgym.com</strong><br>
                            <strong>support@fitgym.com</strong><br>
                            Response within 24 hours
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form & Map Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <!-- Contact Form -->
                <div class="col-lg-6 mb-5" data-aos="fade-right">
                    <div class="contact-card">
                        <h3 class="mb-4">Send Us a Message</h3>

                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                <?= $this->session->flashdata('success'); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <?= $this->session->flashdata('error'); ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('contact/send'); ?>" method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="first_name" class="form-label">First Name *</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="last_name" class="form-label">Last Name *</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email Address *</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject *</label>
                                <select class="form-control" id="subject" name="subject" required>
                                    <option value="">Select a subject</option>
                                    <option value="membership">Membership Inquiry</option>
                                    <option value="personal_training">Personal Training</option>
                                    <option value="group_classes">Group Classes</option>
                                    <option value="facilities">Facilities Tour</option>
                                    <option value="complaint">Complaint</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="message" class="form-label">Message *</label>
                                <textarea class="form-control" id="message" name="message" rows="5"
                                    placeholder="Tell us how we can help you..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary-custom w-100">
                                <i class="fas fa-paper-plane me-2"></i>Send Message
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Map -->
                <div class="col-lg-6 mb-5" data-aos="fade-left">
                    <div class="contact-card">
                        <h3 class="mb-4">Find Us Here</h3>
                        <div class="map-container">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.521260322283!2d106.8195613!3d-6.2087634!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5390917b759%3A0x6b45e67356080477!2sJl.%20Fitness%20No.%20123%2C%20Jakarta%20Selatan%2C%20DKI%20Jakarta!5e0!3m2!1sen!2sid!4v1635123456789!5m2!1sen!2sid"
                                width="100%"
                                height="400"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>

                        <div class="mt-4">
                            <h5>Operating Hours</h5>
                            <div class="row">
                                <div class="col-6">
                                    <p class="mb-1"><strong>Monday - Friday</strong></p>
                                    <p class="text-muted">24 Hours</p>
                                </div>
                                <div class="col-6">
                                    <p class="mb-1"><strong>Weekend</strong></p>
                                    <p class="text-muted">24 Hours</p>
                                </div>
                            </div>
                            <div class="alert alert-success mt-3">
                                <i class="fas fa-clock me-2"></i>
                                <strong>24/7 Access Available</strong> for all premium members!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="text-center mb-5" data-aos="fade-up">Frequently Asked Questions</h2>

                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item mb-3" data-aos="fade-up" data-aos-delay="100">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    What are your membership options?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    We offer Basic, Premium, and VIP membership plans. Each plan includes different features like gym access, personal training, group classes, and wellness services. Visit our membership page for detailed information.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item mb-3" data-aos="fade-up" data-aos-delay="200">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    Do you offer personal training?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes! We have certified personal trainers available for one-on-one sessions. Personal training is included in our Premium and VIP plans, or can be purchased separately for Basic members.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item mb-3" data-aos="fade-up" data-aos-delay="300">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Can I try the gym before joining?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Absolutely! We offer free facility tours and a complimentary day pass for first-time visitors. Contact us to schedule your visit and experience FitGym firsthand.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item mb-3" data-aos="fade-up" data-aos-delay="400">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    What safety measures do you have in place?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    We maintain the highest safety standards with regular equipment maintenance, 24/7 security, emergency response protocols, and trained staff always on-site. Your safety is our top priority.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5" style="background: var(--gradient);">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-8" data-aos="fade-up">
                    <h2 class="text-white mb-4">Ready to Start Your Fitness Journey?</h2>
                    <p class="text-white mb-4 lead">Join thousands of members who have transformed their lives at FitGym. Your journey to a healthier, stronger you starts today!</p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="<?= base_url('register'); ?>" class="btn btn-light btn-lg">
                            <i class="fas fa-rocket me-2"></i>Join Now
                        </a>
                        <a href="tel:+622112345678" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-phone me-2"></i>Call Now
                        </a>
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
                    <p class="text-muted">Transform your body, transform your life. Join our fitness community and achieve your health goals with expert guidance and state-of-the-art facilities.</p>
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
                        <li><a href="<?= base_url(); ?>" class="text-muted">Home</a></li>
                        <li><a href="<?= base_url(); ?>#about" class="text-muted">About</a></li>
                        <li><a href="<?= base_url(); ?>#services" class="text-muted">Services</a></li>
                        <li><a href="<?= base_url(); ?>#membership" class="text-muted">Membership</a></li>
                        <li><a href="<?= base_url('contact'); ?>" class="text-muted">Contact</a></li>
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

        // Form validation and submission
        document.querySelector('form').addEventListener('submit', function(e) {
            const requiredFields = ['first_name', 'last_name', 'email', 'subject', 'message'];
            let isValid = true;

            requiredFields.forEach(field => {
                const input = document.getElementById(field);
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });

        // Remove validation classes on input
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('is-invalid');
            });
        });
    </script>
</body>

</html>