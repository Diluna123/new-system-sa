<?php
session_start();

if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit();
}

$email = "";
$psw = "";

if (isset($_COOKIE["email"])) {
    $email = $_COOKIE["email"];
}
if (isset($_COOKIE["password"])) {
    $psw = $_COOKIE["password"];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SANASA EASY | User Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="com.png">

    <style>
        :root {
            --bg: #f2efe8;
            --ink: #0f1724;
            --muted: #596273;
            --brand: #e36716;
            --brand-deep: #a74910;
            --card: #ffffff;
            --line: #e3d8ca;
            --accent: #143a5a;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 15% 20%, rgba(227, 103, 22, 0.18), transparent 35%),
                radial-gradient(circle at 85% 10%, rgba(20, 58, 90, 0.16), transparent 30%),
                linear-gradient(135deg, #f7f2ea 0%, #efe8dd 100%);
            display: grid;
            place-items: center;
            padding: 24px;
        }

        .login-shell {
            width: 100%;
            max-width: 1040px;
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 24px 60px rgba(15, 23, 36, 0.16);
        }

        .login-visual {
            min-height: 100%;
            background:
                linear-gradient(160deg, rgba(20, 58, 90, 0.92) 0%, rgba(16, 43, 68, 0.95) 55%, rgba(13, 35, 56, 0.98) 100%);
            color: #eef4fb;
            padding: 42px;
            position: relative;
            overflow: hidden;
        }

        .login-visual::before {
            content: "";
            position: absolute;
            width: 280px;
            height: 280px;
            top: -100px;
            right: -90px;
            border-radius: 50%;
            background: rgba(227, 103, 22, 0.35);
            filter: blur(2px);
        }

        .login-visual::after {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            bottom: -80px;
            left: -70px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.12);
        }

        .brand-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.24);
            border-radius: 999px;
            padding: 8px 12px;
            font-size: 0.78rem;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            font-weight: 600;
            position: relative;
            z-index: 2;
        }

        .visual-title {
            margin-top: 22px;
            margin-bottom: 12px;
            font-size: 2rem;
            line-height: 1.2;
            font-weight: 700;
            position: relative;
            z-index: 2;
        }

        .visual-copy {
            margin: 0;
            max-width: 360px;
            font-size: 0.98rem;
            color: rgba(238, 244, 251, 0.84);
            position: relative;
            z-index: 2;
        }

        .visual-points {
            list-style: none;
            margin: 26px 0 0;
            padding: 0;
            display: grid;
            gap: 10px;
            position: relative;
            z-index: 2;
        }

        .visual-points li {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.92rem;
            color: rgba(238, 244, 251, 0.92);
        }

        .visual-points i {
            color: #ffc180;
        }

        .login-form-wrap {
            padding: 36px;
            background: #fffdf9;
        }

        .logo-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }

        .logo-row img {
            height: 42px;
            width: auto;
            object-fit: contain;
        }

        .version-badge {
            font-size: 0.75rem;
            color: var(--muted);
            background: #f1e9de;
            border: 1px solid #e3d7c7;
            border-radius: 999px;
            padding: 5px 10px;
            letter-spacing: 0.4px;
        }

        .form-title {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
            color: #122033;
        }

        .form-subtitle {
            margin-top: 7px;
            margin-bottom: 22px;
            color: var(--muted);
            font-size: 0.95rem;
        }

        .form-label {
            font-size: 0.86rem;
            font-weight: 600;
            color: #374254;
        }

        .form-control {
            border: 1px solid #d5c8b8;
            background: #fff;
            border-radius: 12px;
            min-height: 46px;
            color: #132236;
        }

        .form-control:focus {
            border-color: #db7e39;
            box-shadow: 0 0 0 0.18rem rgba(227, 103, 22, 0.16);
        }

        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 14px 0 20px;
        }

        .form-check-label {
            color: #4a5768;
            font-size: 0.88rem;
        }

        .login-btn {
            border: none;
            min-height: 48px;
            width: 100%;
            border-radius: 12px;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, var(--brand) 0%, var(--brand-deep) 100%);
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }

        .login-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 24px rgba(163, 73, 16, 0.26);
        }

        .support-note {
            margin-top: 14px;
            margin-bottom: 0;
            font-size: 0.8rem;
            color: #647184;
            text-align: center;
        }

        .support-note strong {
            color: #364356;
        }

        @media (max-width: 991.98px) {
            .login-visual {
                padding: 30px;
            }

            .visual-title {
                font-size: 1.7rem;
            }

            .login-form-wrap {
                padding: 26px;
            }
        }

        @media (max-width: 767.98px) {
            body {
                padding: 0;
                background:
                    linear-gradient(180deg, #133653 0%, #102b44 34%, #f7f2ea 34%, #f2ebe0 100%);
            }

            .login-shell {
                border-radius: 0;
                min-height: 100vh;
                border: none;
                box-shadow: none;
            }

            .login-visual {
                padding: 24px 22px 26px;
            }

            .login-form-wrap {
                border-top-left-radius: 20px;
                border-top-right-radius: 20px;
                margin-top: -12px;
                padding: 24px 18px 22px;
                position: relative;
                z-index: 2;
            }

            .logo-row img {
                height: 34px;
            }

            .visual-title {
                font-size: 1.45rem;
                margin-top: 16px;
            }

            .visual-copy {
                font-size: 0.9rem;
            }

            .visual-points {
                margin-top: 18px;
                gap: 8px;
            }
        }
    </style>
</head>

<body>
    <div class="login-shell">
        <div class="row g-0">
            <div class="col-lg-5 login-visual">
                <span class="brand-chip"><i class="bi bi-shield-lock"></i> SANASA EASY</span>
                <h1 class="visual-title">Insurance workflow, simplified and secure.</h1>
                <p class="visual-copy">Sign in to manage onboarding, track policy status, and process documents in one workspace.</p>
                <ul class="visual-points">
                    <li><i class="bi bi-check-circle-fill"></i> Customer profile and policy tracking</li>
                    <li><i class="bi bi-check-circle-fill"></i> Document and NIC workflow management</li>
                    <li><i class="bi bi-check-circle-fill"></i> Daily pending and completed insights</li>
                </ul>
            </div>

            <div class="col-lg-7 login-form-wrap">
                <div class="logo-row">
                    <img src="sansalogo.png" alt="SANASA Logo">
                    <span class="version-badge">Version 3.0.0</span>
                </div>

                <h2 class="form-title">User Login</h2>
                <p class="form-subtitle">Use your account email and password to continue.</p>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" placeholder="name@example.com" value="<?php echo htmlspecialchars($email); ?>">
                </div>

                <div class="mb-1">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Enter your password" value="<?php echo htmlspecialchars($psw); ?>">
                </div>

                <div class="remember-row">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="rpw" <?php if (isset($_COOKIE["password"])) {
                                                                                        echo "checked";
                                                                                    } ?>>
                        <label class="form-check-label" for="rpw">Remember me</label>
                    </div>
                </div>

                <button class="login-btn" onclick="signin();">Login</button>
                <p class="support-note">Developed by <strong>Affinity Software Solutions</strong></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="dashboard.js"></script>
</body>

</html>

