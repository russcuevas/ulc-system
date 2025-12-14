<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ULC Reset Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }

        .bg-ulc-primary {
            background-image: url("https://t4.ftcdn.net/jpg/04/32/76/65/360_F_432766524_GEG8dDw2lRcwsthAOFP57fFhQ3R2cDki.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
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
    </style>
</head>

<body class="bg-light">
    <div class="container-fluid p-0 d-flex min-vh-100">
        <!-- Left side -->
        <div
            class="col-md-4 col-xl-3 bg-ulc-primary text-white p-5 d-none d-md-flex flex-column justify-content-between shadow-lg">
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

        <!-- Right side -->
        <div
            class="col-12 col-md-8 col-xl-9 d-flex justify-content-center align-items-center p-3 p-sm-5 position-relative">
            <div class="w-100" style="max-width: 450px;">
                <h2 class="fs-3 fw-semibold mb-5 text-center text-dark">
                    RESET PASSWORD
                </h2>

                <!-- Step wizard -->
                <div class="text-center mb-4">
                    <span
                        class="badge {{ $step == 1 ? 'bg-primary' : ($step > 1 ? 'bg-secondary' : 'bg-light text-dark') }}">
                        Verify Code
                    </span>
                    <span class="mx-2">→</span>
                    <span class="badge {{ $step == 2 ? 'bg-primary' : 'bg-light text-dark' }}">
                        Reset Password
                    </span>
                </div>

                <!-- Form -->
                <form method="POST"
                    action="{{ $step == 1 ? route('admin.reset-password.verify') : route('admin.reset-password.submit') }}"
                    class="needs-validation" novalidate>
                    @csrf

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label fw-medium">Email Address</label>
                        <input style="background-color: gray; color: white;" type="email" name="email"
                            class="form-control rounded-3 shadow-sm" value="{{ old('email', $email) }}" readonly
                            required>
                    </div>

                    <!-- STEP 1: Access Code -->
                    @if ($step == 1)
                        <div class="mb-3">
                            <label class="form-label fw-medium">Access Code</label>
                            <input type="text" name="code" class="form-control rounded-3 shadow-sm" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-medium shadow">
                            Verify Code
                        </button>
                    @endif

                    <!-- STEP 2: Reset Password -->
                    @if ($step == 2)
                        <div class="mb-3">
                            <label class="form-label fw-medium">New Password</label>
                            <input type="password" name="password" class="form-control rounded-3 shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-medium">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control rounded-3 shadow-sm"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-medium shadow">
                            Reset Password
                        </button>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>

    <!-- Validation JS -->
    <script>
        (() => {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })();
    </script>
    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            timeOut: 4000,
            positionClass: "toast-top-right"
        };

        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @elseif (session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    </script>

    @if ($errors->any())
        <script>
            toastr.error(`{!! implode('<br>', $errors->all()) !!}`);
        </script>
    @endif
</body>

</html>
