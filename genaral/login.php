<!doctype html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="../com.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0f1115">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Sanasa Easy">
    <title>Admin Login - Affinity Insurance</title>
    <link rel="manifest" href="manifest.webmanifest">
    <link rel="apple-touch-icon" href="../com.png">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous"
    >
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>
        :root {
            --bg-main: #0f1115;
            --bg-panel: #171a21;
            --bg-panel-soft: #1e232c;
            --line: #2d3440;
            --text-main: #f1f5f9;
            --text-soft: #9aa4b2;
            --accent: #00c2ff;
            --accent-soft: rgba(0, 194, 255, 0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-main);
            background:
                radial-gradient(circle at 10% 10%, rgba(0, 194, 255, 0.12), transparent 40%),
                radial-gradient(circle at 90% 90%, rgba(0, 255, 179, 0.08), transparent 35%),
                var(--bg-main);
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            background: linear-gradient(135deg, #171f29 0%, #0f141c 100%);
            border: 1px solid var(--line);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-logo {
            font-size: 2.5rem;
            margin-bottom: 12px;
            background: linear-gradient(135deg, #00c2ff 0%, #17b26a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            letter-spacing: 0.5px;
        }

        .login-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--text-main);
        }

        .login-subtitle {
            font-size: 0.9rem;
            color: var(--text-soft);
            margin-bottom: 0;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            font-size: 0.92rem;
            margin-bottom: 8px;
            color: var(--text-main);
            letter-spacing: 0.3px;
        }

        .form-control {
            background-color: var(--bg-panel-soft);
            border: 1px solid var(--line);
            color: var(--text-main);
            border-radius: 10px;
            min-height: 44px;
            padding: 10px 14px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .form-control::placeholder {
            color: #7c8797;
        }

        .form-control:focus {
            background-color: #222833;
            color: var(--text-main);
            border-color: var(--accent);
            box-shadow: 0 0 0 0.2rem rgba(0, 194, 255, 0.2);
            outline: none;
        }

        .form-control.is-invalid {
            border-color: #ff4757;
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 0.2rem rgba(255, 71, 87, 0.2);
        }

        .invalid-feedback {
            display: block;
            font-size: 0.85rem;
            color: #ff4757;
            margin-top: 4px;
        }

        .btn-login {
            background: linear-gradient(135deg, #00c2ff 0%, #17b26a 120%);
            border: none;
            color: #051018;
            font-weight: 700;
            border-radius: 10px;
            min-height: 48px;
            width: 100%;
            font-size: 1rem;
            letter-spacing: 0.4px;
            transition: all 0.3s ease;
            text-transform: uppercase;
        }

        .btn-login:hover {
            filter: brightness(1.08);
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(0, 194, 255, 0.3);
            color: #051018;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .error-message {
            background: rgba(255, 71, 87, 0.1);
            border: 1px solid rgba(255, 71, 87, 0.3);
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 20px;
            color: #ff6b7a;
            font-size: 0.9rem;
            display: none;
        }

        .error-message.show {
            display: block;
            animation: slideInDown 0.3s ease;
        }

        .success-message {
            background: rgba(23, 178, 106, 0.1);
            border: 1px solid rgba(23, 178, 106, 0.3);
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 20px;
            color: #2ddd6f;
            font-size: 0.9rem;
            display: none;
        }

        .success-message.show {
            display: block;
            animation: slideInDown 0.3s ease;
        }

        @keyframes slideInDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .login-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.85rem;
            color: var(--text-soft);
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .remember-me input[type="checkbox"] {
            cursor: pointer;
            width: 18px;
            height: 18px;
            accent-color: var(--accent);
        }

        .remember-me label {
            cursor: pointer;
            margin: 0;
            font-size: 0.9rem;
            user-select: none;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 30px 20px;
            }

            .login-logo {
                font-size: 2rem;
            }

            .login-title {
                font-size: 1.25rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h1 class="login-title">Affinity Insurance</h1>
                <p class="login-subtitle">Admin Login Portal</p>
            </div>

            <div class="error-message" id="errorMessage"></div>
            <div class="success-message" id="successMessage"></div>

            <form id="loginForm" novalidate>
                <div class="form-group">
                    <label class="form-label" for="mobile">Mobile Number</label>
                    <input
                        type="tel"
                        class="form-control"
                        id="mobile"
                        name="mobile"
                        placeholder="Enter your mobile number"
                        required
                    >
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input
                        type="password"
                        class="form-control"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        required
                    >
                    <div class="invalid-feedback"></div>
                </div>

                <div class="remember-me">
                    <input type="checkbox" id="rememberMe" name="rememberMe">
                    <label for="rememberMe">Remember me</label>
                </div>

                <button type="submit" class="btn-login" id="submitBtn">Login</button>
            </form>

            <div class="login-footer">
                <p>ï¿½ 2026 Affinity Soft. All Rights Reserved.</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const loginForm = document.getElementById('loginForm');
        const submitBtn = document.getElementById('submitBtn');
        const errorMessage = document.getElementById('errorMessage');
        const successMessage = document.getElementById('successMessage');

        function showError(message) {
            errorMessage.textContent = message;
            errorMessage.classList.add('show');
            successMessage.classList.remove('show');
        }

        function showSuccess(message) {
            successMessage.textContent = message;
            successMessage.classList.add('show');
            errorMessage.classList.remove('show');
        }

        function hideMessages() {
            errorMessage.classList.remove('show');
            successMessage.classList.remove('show');
        }

        function validateForm() {
            const mobile = document.getElementById('mobile').value.trim();
            const password = document.getElementById('password').value.trim();
            const errors = {};

            if (!mobile) {
                errors.mobile = 'Mobile number is required.';
            } else if (!/^[0-9+\-\s]{9,15}$/.test(mobile)) {
                errors.mobile = 'Please enter a valid mobile number.';
            }

            if (!password) {
                errors.password = 'Password is required.';
            } else if (password.length < 4) {
                errors.password = 'Password must be at least 4 characters.';
            }

            return { isValid: Object.keys(errors).length === 0, errors };
        }

        function displayValidationErrors(errors) {
            document.querySelectorAll('.invalid-feedback').forEach(el => {
                el.textContent = '';
            });

            Object.keys(errors).forEach(key => {
                const field = document.getElementById(key);
                const feedback = field.nextElementSibling;
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.textContent = errors[key];
                    field.classList.add('is-invalid');
                } else {
                    field.classList.add('is-invalid');
                }
            });
        }

        function clearValidationErrors() {
            document.querySelectorAll('.form-control').forEach(el => {
                el.classList.remove('is-invalid');
            });
            document.querySelectorAll('.invalid-feedback').forEach(el => {
                el.textContent = '';
            });
        }

        loginForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            hideMessages();
            clearValidationErrors();

            const validation = validateForm();
            if (!validation.isValid) {
                displayValidationErrors(validation.errors);
                return;
            }

            const mobile = document.getElementById('mobile').value.trim();
            const password = document.getElementById('password').value.trim();
            const rememberMe = document.getElementById('rememberMe').checked;

            submitBtn.disabled = true;
            submitBtn.textContent = 'Logging in...';

            try {
                const response = await fetch('./loginProcess.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `mobile=${encodeURIComponent(mobile)}&password=${encodeURIComponent(password)}&rememberMe=${rememberMe ? 1 : 0}`
                });

                const result = await response.json();

                if (!response.ok || !result.success) {
                    throw new Error(result.message || 'Login failed.');
                }

                showSuccess(result.message || 'Login successful! Redirecting...');

                setTimeout(() => {
                    window.location.href = './index.php';
                }, 1200);
            } catch (error) {
                showError(error.message || 'An error occurred during login.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Login';
            }
        });

        document.querySelectorAll('.form-control').forEach(field => {
            field.addEventListener('input', function () {
                this.classList.remove('is-invalid');
            });
        });
    </script>

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('service-worker.js').catch(function() {
                    // Login page should still work even when SW registration fails.
                });
            });
        }
    </script>
</body>
</html>

