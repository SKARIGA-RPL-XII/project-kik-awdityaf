<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="FitGym - Your Ultimate Fitness Destination">
    <meta name="author" content="FitGym">

    <title><?= $title; ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="%23ffffff08" points="0,1000 1000,0 1000,1000"/></svg>');
            background-size: cover;
        }

        .auth-container {
            position: relative;
            z-index: 2;
            width: 100%;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
        }

        .auth-header {
            background: var(--gradient);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .auth-header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .auth-header p {
            opacity: 0.9;
            margin-bottom: 0;
        }

        .auth-body {
            padding: 2.5rem;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 15px 20px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(45, 206, 137, 0.25);
            background: white;
        }

        .btn-primary-custom {
            background: var(--gradient);
            border: none;
            padding: 15px 30px;
            border-radius: 15px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(45, 206, 137, 0.3);
            width: 100%;
            font-size: 1.1rem;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(45, 206, 137, 0.4);
            color: white;
        }

        .auth-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .auth-link:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }

        .alert {
            border-radius: 15px;
            border: none;
            padding: 1rem 1.5rem;
        }

        .text-danger {
            color: #e74c3c !important;
            font-size: 0.875rem;
        }

        .back-to-home {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 10;
        }

        .back-to-home a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .back-to-home a:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .auth-body {
                padding: 2rem 1.5rem;
            }

            .auth-header {
                padding: 1.5rem;
            }

            .auth-header h1 {
                font-size: 1.5rem;
            }
        }
    </style>

</head>

<body>
    <div class="back-to-home">
        <a href="<?= base_url(); ?>">
            <i class="fas fa-arrow-left me-2"></i>Back to Home
        </a>
    </div>

    <div class="auth-container">