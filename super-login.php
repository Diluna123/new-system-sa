<?php
session_start();

if (isset($_SESSION['user'])) {
    if ((int) ($_SESSION['user']['u_id'] ?? 0) === 1) {
        header('Location: superIndex.php');
        exit;
    }

    header('Location: index.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Super User Login</title>
    <link rel="icon" type="image/png" href="com.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        :root {
            --bg: #0b1320;
            --panel: #121c2b;
            --line: #23324a;
            --text: #e4ebf7;
            --muted: #97a5bf;
            --accent: #3db5ff;
            --danger: #ff6c7a;
        }

        body {
            min-height: 100vh;
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 10% 10%, rgba(61, 181, 255, 0.18), transparent 34%),
                radial-gradient(circle at 85% 90%, rgba(76, 242, 173, 0.13), transparent 28%),
                var(--bg);
            display: grid;
            place-items: center;
            padding: 20px;
        }

        .login-card {
            width: 100%;
            max-width: 430px;
            background: linear-gradient(180deg, #172236 0%, #101a2a 100%);
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 30px;
            box-shadow: 0 20px 42px rgba(0, 0, 0, 0.34);
        }

        .title {
            font-size: 1.55rem;
            font-weight: 700;
            margin: 0;
        }

        .subtitle {
            margin-top: 6px;
            margin-bottom: 20px;
            color: var(--muted);
            font-size: 0.92rem;
        }

        .form-label {
            font-size: 0.86rem;
            font-weight: 600;
            color: #ced7e7;
        }

        .form-control {
            background-color: #0c1421;
            border: 1px solid #26354d;
            color: var(--text);
            min-height: 44px;
            border-radius: 10px;
        }

        .form-control:focus {
            background-color: #0f1a2b;
            border-color: var(--accent);
            box-shadow: 0 0 0 0.2rem rgba(61, 181, 255, 0.2);
            color: var(--text);
        }

        .btn-login {
            border: none;
            width: 100%;
            min-height: 46px;
            border-radius: 10px;
            font-weight: 700;
            color: #04101b;
            background: linear-gradient(135deg, #3db5ff 0%, #27d6a2 100%);
        }

        .btn-login:hover {
            filter: brightness(1.07);
            color: #04101b;
        }

        .alert-box {
            display: none;
            border-radius: 10px;
            margin-bottom: 14px;
            padding: 11px 12px;
            font-size: 0.9rem;
        }

        .alert-box.show {
            display: block;
        }

        .alert-error {
            background: rgba(255, 108, 122, 0.12);
            border: 1px solid rgba(255, 108, 122, 0.42);
            color: #ff9aa5;
        }

        .alert-success {
            background: rgba(39, 214, 162, 0.12);
            border: 1px solid rgba(39, 214, 162, 0.42);
            color: #83f3d5;
        }

        .small-note {
            margin-top: 14px;
            text-align: center;
            color: #8594af;
            font-size: 0.82rem;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h1 class="title">Super User Login</h1>
        <p class="subtitle">Only authorized super users can access this panel.</p>

        <div id="errorBox" class="alert-box alert-error"></div>
        <div id="successBox" class="alert-box alert-success"></div>

        <form id="superLoginForm" novalidate>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter super user email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" required>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="1" id="rememberMe" name="rememberMe">
                <label class="form-check-label" for="rememberMe">Remember email</label>
            </div>
            <button type="submit" class="btn-login" id="submitBtn">Log In</button>
        </form>

        <p class="small-note">Super security gateway</p>
    </div>

    <script>
        const emailInput = document.getElementById('email');
        const remember = document.getElementById('rememberMe');

        const savedEmail = localStorage.getItem('super_email') || '';
        if (savedEmail !== '') {
            emailInput.value = savedEmail;
            remember.checked = true;
        }

        function showBox(target, message) {
            const box = document.getElementById(target);
            box.textContent = message;
            box.classList.add('show');
        }

        function clearBoxes() {
            document.getElementById('errorBox').classList.remove('show');
            document.getElementById('successBox').classList.remove('show');
        }

        document.getElementById('superLoginForm').addEventListener('submit', async (event) => {
            event.preventDefault();
            clearBoxes();

            const form = event.target;
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Checking...';

            const payload = new URLSearchParams(new FormData(form));

            try {
                const response = await fetch('superLoginProcess.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: payload
                });

                const data = await response.json();
                if (!response.ok || !data.success) {
                    showBox('errorBox', data.message || 'Login failed.');
                    return;
                }

                if (remember.checked) {
                    localStorage.setItem('super_email', emailInput.value.trim());
                } else {
                    localStorage.removeItem('super_email');
                }

                showBox('successBox', data.message || 'Login successful.');
                window.setTimeout(() => {
                    window.location.href = 'superIndex.php';
                }, 500);
            } catch (err) {
                showBox('errorBox', 'Network error. Please try again.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Log In';
            }
        });
    </script>
</body>
</html>
