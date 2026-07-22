<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: ./userIndex.php');
    exit;
}
?>
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
    <title>User Login - Affinity Insurance</title>
    <link rel="manifest" href="manifest.webmanifest">
    <link rel="apple-touch-icon" href="../com.png">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --bg-main: #0f1115;
            --bg-panel: #171a21;
            --bg-panel-soft: #1f2530;
            --line: #2e3745;
            --text-main: #f1f5f9;
            --text-soft: #9aa4b2;
            --accent: #00c2ff;
            --accent-2: #17b26a;
            --ok: #2ddd6f;
            --danger: #ff6b7a;
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
                radial-gradient(circle at 12% 10%, rgba(0, 194, 255, 0.14), transparent 36%),
                radial-gradient(circle at 88% 92%, rgba(23, 178, 106, 0.1), transparent 34%),
                var(--bg-main);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .auth-shell {
            width: 100%;
            max-width: 980px;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid var(--line);
            background: linear-gradient(180deg, #141923 0%, #10151d 100%);
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.42);
        }

        .auth-left {
            background:
                radial-gradient(circle at 82% 15%, rgba(0, 194, 255, 0.16), transparent 40%),
                linear-gradient(160deg, #202a38 0%, #121924 100%);
            color: var(--text-main);
            padding: 38px;
            position: relative;
            min-height: 100%;
            border-right: 1px solid #2b3442;
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid rgba(0, 194, 255, 0.42);
            background: rgba(0, 194, 255, 0.14);
            border-radius: 999px;
            padding: 7px 12px;
            font-size: 0.76rem;
            letter-spacing: 0.65px;
            text-transform: uppercase;
            font-weight: 700;
            color: #d9f5ff;
        }

        .left-title {
            margin-top: 18px;
            margin-bottom: 12px;
            font-size: 1.9rem;
            line-height: 1.2;
            font-weight: 700;
            color: #eef4fb;
        }

        .left-copy {
            margin: 0;
            max-width: 370px;
            font-size: 0.95rem;
            color: #9fb0c5;
        }

        .left-list {
            list-style: none;
            padding: 0;
            margin: 24px 0 0;
            display: grid;
            gap: 10px;
        }

        .left-list li {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            color: #c6d2e1;
        }

        .left-list i {
            color: #53d9ff;
        }

        .auth-right {
            background: linear-gradient(180deg, #171d28 0%, #111721 100%);
            padding: 34px;
        }

        .top-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .top-row img {
            height: 40px;
            width: auto;
            object-fit: contain;
        }

        .top-badge {
            font-size: 0.75rem;
            color: #9fb0c5;
            border: 1px solid #334050;
            background: rgba(255, 255, 255, 0.02);
            border-radius: 999px;
            padding: 4px 10px;
        }

        .form-title {
            margin: 0;
            font-size: 1.45rem;
            font-weight: 700;
            color: #eaf2fb;
        }

        .form-subtitle {
            margin-top: 7px;
            margin-bottom: 22px;
            font-size: 0.92rem;
            color: var(--text-soft);
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: #c9d6e7;
        }

        .form-control {
            min-height: 46px;
            border-radius: 12px;
            border: 1px solid #334050;
            font-size: 0.95rem;
            color: #f1f5f9;
            background: var(--bg-panel-soft);
        }

        .form-control::placeholder {
            color: #7d8aa0;
        }

        .form-control:focus {
            color: #f1f5f9;
            background: #242d3a;
            border-color: var(--accent);
            box-shadow: 0 0 0 0.2rem rgba(0, 194, 255, 0.2);
        }

        .form-control.is-invalid {
            border-color: #ff6b7a;
        }

        .invalid-feedback {
            font-size: 0.82rem;
            color: #ff6b7a;
        }

        .message {
            border-radius: 12px;
            padding: 11px 12px;
            margin-bottom: 16px;
            display: none;
            font-size: 0.9rem;
        }

        .message.show {
            display: block;
        }

        .message.error {
            border: 1px solid rgba(255, 107, 122, 0.35);
            color: var(--danger);
            background: rgba(255, 107, 122, 0.1);
        }

        .message.success {
            border: 1px solid rgba(45, 221, 111, 0.3);
            color: var(--ok);
            background: rgba(45, 221, 111, 0.1);
        }

        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 14px 0 18px;
        }

        .form-check-input {
            border-color: #3a4658;
            background-color: #1f2530;
        }

        .form-check-input:checked {
            background-color: var(--accent);
            border-color: var(--accent);
        }

        .form-check-label {
            font-size: 0.87rem;
            color: #9fb0c5;
        }

        .btn-login {
            width: 100%;
            min-height: 48px;
            border: none;
            border-radius: 12px;
            color: #051018;
            font-weight: 700;
            letter-spacing: 0.3px;
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 130%);
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }

        .btn-login:hover {
            color: #051018;
            transform: translateY(-1px);
            box-shadow: 0 12px 22px rgba(0, 194, 255, 0.28);
        }

        .footer-note {
            margin-top: 14px;
            margin-bottom: 0;
            font-size: 0.8rem;
            color: #8395ab;
            text-align: center;
        }

        @media (max-width: 991.98px) {
            .auth-left {
                padding: 30px;
                border-right: none;
                border-bottom: 1px solid #2b3442;
            }

            .left-title {
                font-size: 1.65rem;
            }

            .auth-right {
                padding: 28px;
            }
        }

        @media (max-width: 767.98px) {
            body {
                padding: 0;
            }

            .auth-shell {
                border-radius: 0;
                min-height: 100vh;
                border: none;
                box-shadow: none;
            }

            .auth-left {
                padding: 24px 20px;
            }

            .left-title {
                font-size: 1.4rem;
            }

            .auth-right {
                padding: 22px 16px;
            }

            .top-row img {
                height: 33px;
            }

            .left-list {
                margin-top: 16px;
                gap: 8px;
            }
        }
    </style>
</head>

<body>
    <div class="auth-shell">
        <div class="row g-0">
            <div class="col-lg-5 auth-left">
                <span class="chip"><i class="bi bi-shield-lock"></i> User Access</span>
                <h1 class="left-title">Welcome to Affinity Insurance Portal</h1>
                <p class="left-copy">Log in with your user account email to manage customer records, uploads, and policy workflow updates.</p>
                <ul class="left-list">
                    <li><i class="bi bi-check-circle-fill"></i> Customer and policy activity management</li>
                    <li><i class="bi bi-check-circle-fill"></i> Fast uploads and document validation</li>
                    <li><i class="bi bi-check-circle-fill"></i> Live pending and completed status tracking</li>
                </ul>
            </div>

            <div class="col-lg-7 auth-right">
                <div class="top-row">
                    <img src="../sansalogo.png" alt="SANASA Logo">
                    <span class="top-badge">Version 3.0.0</span>
                </div>

                <h2 class="form-title">User Login</h2>
                <p class="form-subtitle">Enter your email and password to continue.</p>

                <div class="message error" id="errorMessage"></div>
                <div class="message success" id="successMessage"></div>

                <form id="loginForm" novalidate>
                    <div class="mb-3">
                        <label class="form-label" for="email">Email Address</label>
                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            placeholder="name@example.com"
                            value=""
                            required>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-1">
                        <label class="form-label" for="password">Password</label>
                        <input
                            type="password"
                            class="form-control"
                            id="password"
                            name="password"
                            placeholder="Enter password"
                            required>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="remember-row">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rememberMe" name="rememberMe">
                            <label class="form-check-label" for="rememberMe">Remember me</label>
                        </div>
                    </div>

                    <button type="submit" class="btn-login" id="submitBtn">Login</button>
                </form>

                <p class="footer-note">Copyright (c) 2026 Affinity Soft. All Rights Reserved.</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const loginForm = document.getElementById("loginForm");
        const submitBtn = document.getElementById("submitBtn");
        const errorMessage = document.getElementById("errorMessage");
        const successMessage = document.getElementById("successMessage");
        const emailInput = document.getElementById("email");
        const passwordInput = document.getElementById("password");
        const rememberInput = document.getElementById("rememberMe");

        function loadSavedEmail() {
            const cookieValue = document.cookie
                .split("; ")
                .find(row => row.startsWith("user_email="));

            if (cookieValue) {
                const val = decodeURIComponent(cookieValue.split("=")[1] || "");
                if (val) {
                    emailInput.value = val;
                    rememberInput.checked = true;
                }
            }
        }

        function hideMessages() {
            errorMessage.classList.remove("show");
            successMessage.classList.remove("show");
        }

        function showError(message) {
            errorMessage.textContent = message;
            errorMessage.classList.add("show");
            successMessage.classList.remove("show");
        }

        function showSuccess(message) {
            successMessage.textContent = message;
            successMessage.classList.add("show");
            errorMessage.classList.remove("show");
        }

        function clearValidation() {
            document.querySelectorAll(".form-control").forEach(el => {
                el.classList.remove("is-invalid");
            });
            document.querySelectorAll(".invalid-feedback").forEach(el => {
                el.textContent = "";
            });
        }

        function validateForm() {
            const errors = {};
            const email = emailInput.value.trim();
            const password = passwordInput.value.trim();

            if (!email) {
                errors.email = "Email is required.";
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                errors.email = "Please enter a valid email address.";
            }

            if (!password) {
                errors.password = "Password is required.";
            }

            return {
                isValid: Object.keys(errors).length === 0,
                errors
            };
        }

        function setErrors(errors) {
            Object.keys(errors).forEach(key => {
                const field = document.getElementById(key);
                if (!field) {
                    return;
                }
                const feedback = field.nextElementSibling;
                field.classList.add("is-invalid");
                if (feedback && feedback.classList.contains("invalid-feedback")) {
                    feedback.textContent = errors[key];
                }
            });
        }

        loginForm.addEventListener("submit", async function (event) {
            event.preventDefault();
            hideMessages();
            clearValidation();

            const validation = validateForm();
            if (!validation.isValid) {
                setErrors(validation.errors);
                return;
            }

            const email = emailInput.value.trim();
            const password = passwordInput.value.trim();
            const rememberMe = rememberInput.checked ? 1 : 0;

            submitBtn.disabled = true;
            submitBtn.textContent = "Logging in...";

            try {
                const response = await fetch("./userLoginProcess.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}&rememberMe=${rememberMe}`
                });

                const result = await response.json();

                if (!response.ok || !result.success) {
                    throw new Error(result.message || "Login failed.");
                }

                showSuccess(result.message || "Login successful. Redirecting...");

                setTimeout(function () {
                    window.location.href = "./userIndex.php";
                }, 1000);
            } catch (error) {
                showError(error.message || "An error occurred during login.");
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = "Login";
            }
        });

        [emailInput, passwordInput].forEach(function (field) {
            field.addEventListener("input", function () {
                this.classList.remove("is-invalid");
            });
        });

        loadSavedEmail();
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

