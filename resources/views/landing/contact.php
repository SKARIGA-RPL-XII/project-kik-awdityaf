<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Contact' }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    {{-- STYLE TIDAK DIUBAH --}}
    <style>
    /* === STYLE ASLI (TIDAK DIUBAH) === */
    :root {
        --primary-color: #2dce89;
        --secondary-color: #11cdef;
        --dark-color: #1a1a1a;
        --light-color: #f8f9fa;
        --gradient: linear-gradient(135deg, #2dce89 0%, #11cdef 100%);
    }

    /* (style kamu lanjutkan utuh, tidak diubah) */
    </style>
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">

            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-dumbbell me-2"></i>FitGym
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/#about') }}">About</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/#services') }}">Services</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/#membership') }}">Membership</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('/contact') }}">Contact</a>
                    </li>

                    <li class="nav-item ms-3">
                        <a class="btn btn-primary-custom" href="{{ url('/login') }}">Login</a>
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

    <!-- Contact Form -->
    <section class="py-5 bg-light">

        <div class="container">
            <div class="row">

                <div class="col-lg-6 mb-5">

                    <div class="contact-card">

                        <h3 class="mb-4">Send Us a Message</h3>

                        {{-- SUCCESS --}}
                        @if (session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                        </div>
                        @endif

                        {{-- ERROR --}}
                        @if (session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                        </div>
                        @endif

                        <form action="{{ url('/contact/send') }}" method="POST">

                            @csrf

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">First Name *</label>
                                    <input type="text" class="form-control" name="first_name" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Last Name *</label>
                                    <input type="text" class="form-control" name="last_name" required>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email *</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="tel" class="form-control" name="phone">
                                </div>

                            </div>

                            <div class="mb-3">
                                <label class="form-label">Subject *</label>

                                <select class="form-control" name="subject" required>
                                    <option value="">Select</option>
                                    <option value="membership">Membership</option>
                                    <option value="personal_training">Personal Training</option>
                                    <option value="group_classes">Group Classes</option>
                                    <option value="facilities">Facilities</option>
                                    <option value="complaint">Complaint</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Message *</label>

                                <textarea class="form-control" name="message" rows="5" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary-custom w-100">
                                <i class="fas fa-paper-plane me-2"></i>Send Message
                            </button>

                        </form>

                    </div>

                </div>

            </div>
        </div>

    </section>


    <!-- Footer -->
    <footer class="footer">

        <div class="container">

            <div class="row">

                <div class="col-lg-4">

                    <h5><i class="fas fa-dumbbell me-2"></i>FitGym</h5>

                    <p class="text-muted">
                        Transform your body, transform your life.
                    </p>

                </div>

            </div>

        </div>

    </footer>


    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
    AOS.init({
        duration: 1000,
        once: true
    });
    </script>

</body>

</html>