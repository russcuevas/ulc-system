<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ULC-System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .bg-ulc-primary {
            background-image: url("https://t4.ftcdn.net/jpg/04/32/76/65/360_F_432766524_GEG8dDw2lRcwsthAOFP57fFhQ3R2cDki.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .text-ulc-accent {
            color: #C5CAE9;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }

        .logo-placeholder {
            width: 48px;
            height: 48px;
            background: linear-gradient(45deg, #4CAF50, #9C27B0, #FFEB3B);
            clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
        }

        .btn-primary {
            background-color: #ff6b35 !important;
            border-color: #ff6b35 !important;
        }

        .btn-primary:hover {
            background-color: #e85d2f !important;
            border-color: #e85d2f !important;
        }

        .text-primary {
            color: #ff6b35 !important;
        }

        .error-message {
            background-color: rgba(255, 0, 0, 0.1);
            border-left: 5px solid #e74c3c;
            color: #c0392b; 
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-weight: 500;
            font-size: 15px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

    </style>
</head>

<body class="bg-light">
    <div class="container-fluid p-0 d-flex min-vh-100">
        <div
            class="col-md-4 col-xl-3 bg-ulc-primary text-white p-5 p-lg-5 d-none d-md-flex flex-column justify-content-between shadow-lg">
            <div class="d-flex flex-column" style="margin-top: 5rem;">
                <div class="d-flex align-items-center mb-5">
                    <div class="logo-placeholder me-3"></div>
                    <span class="fs-4 fw-bold text-uppercase">ulc</span>
                </div>

                <div class="mt-4">
                    <h1 class="display-5 fw-bold mb-3">
                        Ultraritz Lending Corporation
                    </h1>
                </div>
            </div>
        </div>

        <div
            class="col-12 col-md-8 col-xl-9 d-flex justify-content-center align-items-center p-3 p-sm-5 position-relative">
            <div class="w-100" style="max-width: 450px;">
                <h2 class="fs-3 fw-semibold mb-5 text-center text-dark">
                    Login to ULC System
                </h2>

                @if (session('error'))
                    <div class="error-message mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="error-message mb-4">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login-request') }}" class="needs-validation" novalidate>
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="form-label fw-medium">
                            Email Address <span style="color: rgb(126, 30, 30)">*</span>
                        </label>
                        <input type="email" id="email" name="email" placeholder="Email Address"
                            class="form-control rounded-3 shadow-sm" required>
                        <div class="invalid-feedback">
                            Please enter your email address.
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="mb-4">
                        <label for="password" class="form-label fw-medium">
                            Password <span style="color: rgb(126, 30, 30)">*</span>
                        </label>
                        <input type="password" id="password" name="password" placeholder="Password"
                            class="form-control rounded-3 shadow-sm" required>
                        <div class="invalid-feedback">
                            Please enter your password.
                        </div>
                    </div>

                    <!-- Login Button -->
                    <button type="submit"
                        class="btn btn-primary w-100 d-flex justify-content-center align-items-center py-2 rounded-3 fw-medium shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-log-in me-2">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                            <polyline points="10 17 15 12 10 7" />
                            <line x1="15" x2="3" y1="12" y2="12" />
                        </svg>
                        <span>Login</span>
                    </button>
                </form>

                <!-- Utility Links -->
                <div class="d-flex justify-content-between mt-3 fs-6">
                    <a href="#" class="text-primary text-decoration-none fw-medium"></a>
                    <a href="{{ route('admin.forgot-password') }}" class="text-primary text-decoration-none fw-medium">Forgot password?</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        (() => {
            'use strict'

            const forms = document.querySelectorAll('.needs-validation')

            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {

                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    form.classList.add('was-validated');
                }, false)
            })
        })();
    </script>
</body>

</html>
