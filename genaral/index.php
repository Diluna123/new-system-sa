<!doctype html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" href="../com.png">
    <?php include '../connection.php'; ?>
    <?php include './authGuard.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0f1115">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Sanasa Easy">
    <title>Admin Panel</title>
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
            --bg-panel-soft: #1e232c;
            --line: #2d3440;
            --text-main: #f1f5f9;
            --text-soft: #9aa4b2;
            --accent: #00c2ff;
            --accent-soft: rgba(0, 194, 255, 0.15);
        }

        body {
            min-height: 100vh;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-main);
            background:
                radial-gradient(circle at 10% 10%, rgba(0, 194, 255, 0.08), transparent 35%),
                radial-gradient(circle at 90% 90%, rgba(0, 255, 179, 0.08), transparent 30%),
                var(--bg-main);
        }

        .app-shell {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .app-main {
            flex: 1;
        }

        .sidebar {
            background: linear-gradient(180deg, #11151d 0%, #0d1118 100%);
            border-right: 1px solid var(--line);
        }

        .brand {
            border-bottom: 1px solid var(--line);
        }

        .brand h5 {
            letter-spacing: 0.6px;
        }

        .side-link {
            color: var(--text-soft);
            border: 1px solid transparent;
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .side-link:hover {
            color: var(--text-main);
            border-color: var(--line);
            background-color: rgba(255, 255, 255, 0.03);
        }

        .side-link.active {
            color: var(--text-main) !important;
            background-color: var(--accent-soft) !important;
            border-color: rgba(0, 194, 255, 0.4);
            box-shadow: 0 0 0 1px rgba(0, 194, 255, 0.2) inset;
        }

        .content-wrap {
            background-color: transparent;
        }

        .mobile-topbar {
            position: sticky;
            top: 0;
            z-index: 1030;
            background: rgba(15, 17, 21, 0.9);
            backdrop-filter: blur(6px);
            border-bottom: 1px solid var(--line);
        }

        .mobile-menu-btn {
            border: 1px solid var(--line);
            color: var(--text-main);
            background-color: #171b22;
            border-radius: 10px;
        }

        .mobile-menu-btn:hover {
            color: var(--text-main);
            background-color: #1d232d;
            border-color: #3b4552;
        }

        .panel-card {
            background: var(--bg-panel);
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: 0 14px 30px rgba(0, 0, 0, 0.25);
        }

        .panel-title {
            font-weight: 600;
        }

        .form-control,
        .form-select {
            background-color: var(--bg-panel-soft);
            border-color: var(--line);
            color: var(--text-main);
            border-radius: 10px;
            min-height: 44px;
        }

        .form-control::placeholder {
            color: #7c8797;
        }

        .form-control:focus,
        .form-select:focus {
            background-color: #222833;
            color: var(--text-main);
            border-color: var(--accent);
            box-shadow: 0 0 0 0.2rem rgba(0, 194, 255, 0.2);
        }

        .btn-accent {
            background: linear-gradient(135deg, #00c2ff 0%, #17b26a 120%);
            border: none;
            color: #051018;
            font-weight: 600;
            border-radius: 10px;
            min-height: 44px;
        }

        .btn-accent:hover {
            filter: brightness(1.06);
            color: #051018;
        }

        .status-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 0.85rem;
            border: 1px solid var(--line);
            color: var(--text-soft);
            background: #151922;
        }

        .form-subsection {
            margin-top: 6px;
            padding: 14px;
            border: 1px solid var(--line);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.01);
        }

        .form-subsection-title {
            font-size: 0.9rem;
            letter-spacing: 0.4px;
            color: #c8d2de;
        }

        .pending-card {
            background:
                radial-gradient(circle at 90% 0%, rgba(0, 194, 255, 0.14), transparent 45%),
                linear-gradient(180deg, #1a1f28 0%, #141923 100%);
            border: 1px solid #314055;
            border-radius: 16px;
            padding: 16px;
            height: 100%;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.28);
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
        }

        .pending-card:hover {
            transform: translateY(-3px);
            border-color: #3f5e7c;
            box-shadow: 0 14px 34px rgba(0, 0, 0, 0.35);
        }

        .pending-card-header {
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px dashed #334152;
        }

        .pending-status-badge {
            display: inline-block;
            font-size: 0.72rem;
            letter-spacing: 0.7px;
            text-transform: uppercase;
            color: #8de9ff;
            background: rgba(11, 88, 106, 0.4);
            border: 1px solid #35677b;
            padding: 3px 9px;
            border-radius: 999px;
            margin-bottom: 8px;
        }

        .pending-card-title {
            font-size: 1.1rem;
            font-weight: 800;
            letter-spacing: 0.7px;
            margin-bottom: 4px;
            color: #eaffff;
            text-shadow: 0 0 12px rgba(0, 194, 255, 0.35);
        }

        .pending-customer-name {
            margin: 0;
            color: #a9bbcf;
            font-size: 0.9rem;
        }

        .pending-meta {
            display: grid;
            grid-template-columns: 1fr;
            gap: 8px;
        }

        .pending-meta-item {
            font-size: 0.92rem;
            line-height: 1.25rem;
            color: #d5dde8;
        }

        .pending-meta-item span {
            color: #9fb0c5;
            margin-right: 6px;
        }

        .pending-docs {
            margin-top: 12px;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .pending-doc-link {
            font-size: 0.82rem;
            color: #0fd5ff;
            border: 1px solid #2f4a5a;
            border-radius: 999px;
            padding: 4px 10px;
            text-decoration: none;
        }

        .pending-doc-link:hover {
            color: #8de9ff;
            border-color: #3b6f87;
        }

        .completed-card {
            background:
                radial-gradient(circle at 90% 0%, rgba(23, 178, 106, 0.14), transparent 45%),
                linear-gradient(180deg, #18231f 0%, #121b17 100%);
            border: 1px solid #2f5748;
            border-radius: 16px;
            padding: 16px;
            height: 100%;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.28);
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
        }

        .completed-card:hover {
            transform: translateY(-3px);
            border-color: #3f7c66;
            box-shadow: 0 14px 34px rgba(0, 0, 0, 0.35);
        }

        .completed-status-badge {
            display: inline-block;
            font-size: 0.72rem;
            letter-spacing: 0.7px;
            text-transform: uppercase;
            color: #98ffd0;
            background: rgba(8, 97, 62, 0.45);
            border: 1px solid #3c745f;
            padding: 3px 9px;
            border-radius: 999px;
            margin-bottom: 8px;
        }

        .developer-hero {
            background:
                radial-gradient(circle at 85% 0%, rgba(0, 194, 255, 0.18), transparent 42%),
                linear-gradient(135deg, #1e2633 0%, #141b26 100%);
            border: 1px solid #344356;
            border-radius: 16px;
            padding: 20px;
            position: relative;
        }

        .developer-hero-logo {
            position: absolute;
            top: -5px;
            right: 12px;
            width: 200px;
            height: 200px;
            opacity: 0.85;
            object-fit: contain;
        }

        .developer-kicker {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.75rem;
            letter-spacing: 0.7px;
            text-transform: uppercase;
            color: #98e6ff;
            border: 1px solid #2d5c72;
            background: rgba(0, 194, 255, 0.12);
            border-radius: 999px;
            padding: 5px 10px;
            margin-bottom: 10px;
        }

        .developer-title {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .developer-subtitle {
            color: #9fb0c5;
            margin: 8px 0 0 0;
            max-width: 760px;
        }

        .developer-grid {
            margin-top: 16px;
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 12px;
        }

        .developer-card {
            grid-column: span 12;
            background: linear-gradient(180deg, #1a202b 0%, #141a23 100%);
            border: 1px solid #2e3848;
            border-radius: 14px;
            padding: 14px;
        }

        .developer-card h6 {
            margin: 0 0 10px 0;
            font-size: 0.92rem;
            font-weight: 700;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            color: #a8d8e7;
        }

        .developer-row {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            padding: 8px 0;
            border-bottom: 1px dashed #2f3947;
        }

        .developer-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .developer-label {
            color: #8ea0b7;
            font-size: 0.9rem;
        }

        .developer-value {
            color: #e8eef7;
            font-size: 0.94rem;
            text-align: right;
            word-break: break-word;
        }

        .developer-chip-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .developer-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 999px;
            border: 1px solid #324051;
            color: #b9cbde;
            background: rgba(255, 255, 255, 0.03);
            font-size: 0.82rem;
        }

        .account-box {
            margin-top: 12px;
            background: linear-gradient(180deg, #121825 0%, #101622 100%);
            border: 1px solid #2e3a4d;
            border-radius: 14px;
            padding: 14px;
        }

        .account-email {
            color: #9fb0c5;
            margin-bottom: 0;
        }

        .timeline-wrap {
            position: relative;
            padding-left: 26px;
        }

        .timeline-wrap::before {
            content: "";
            position: absolute;
            left: 9px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(180deg, rgba(0, 194, 255, 0.45), rgba(23, 178, 106, 0.35));
        }

        .timeline-item {
            position: relative;
            margin-bottom: 14px;
            padding: 14px;
            border: 1px solid #2f3d4e;
            background: linear-gradient(180deg, #1a202b 0%, #141a23 100%);
            border-radius: 12px;
        }

        .timeline-item::before {
            content: "";
            position: absolute;
            left: -23px;
            top: 18px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #00c2ff;
            box-shadow: 0 0 0 3px rgba(0, 194, 255, 0.2);
        }

        .timeline-item.completed::before {
            background: #17b26a;
            box-shadow: 0 0 0 3px rgba(23, 178, 106, 0.2);
        }

        .timeline-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
            flex-wrap: wrap;
        }

        .timeline-title {
            margin: 0;
            font-size: 1rem;
            font-weight: 700;
            color: #e8f6ff;
        }

        .timeline-sub {
            margin: 0;
            font-size: 0.85rem;
            color: #98a8bb;
        }

        .timeline-tag {
            display: inline-block;
            border-radius: 999px;
            padding: 4px 10px;
            font-size: 0.72rem;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            border: 1px solid #365067;
            color: #8de9ff;
            background: rgba(11, 88, 106, 0.35);
        }

        .timeline-tag.done {
            border-color: #2f7f58;
            color: #98f3bf;
            background: rgba(23, 110, 67, 0.35);
        }

        .timeline-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 8px;
            margin-top: 8px;
        }

        .timeline-meta-item {
            font-size: 0.88rem;
            color: #d4deea;
        }

        .timeline-meta-item span {
            color: #8ea0b7;
            margin-right: 6px;
        }

        .billing-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .billing-box {
            border: 1px solid #2f3d4e;
            border-radius: 12px;
            background: linear-gradient(180deg, #1a202b 0%, #141a23 100%);
            padding: 14px;
        }

        .billing-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
            gap: 8px;
            margin-top: 10px;
        }

        .billing-meta-item {
            font-size: 0.88rem;
            color: #d4deea;
        }

        .billing-meta-item span {
            color: #8ea0b7;
            margin-right: 6px;
        }

        .billing-controls {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 10px;
            margin-top: 12px;
        }

        .billing-summary {
            margin-top: 12px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 8px;
        }

        .billing-summary-card {
            border: 1px solid #2f3d4e;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.02);
            padding: 10px;
        }

        .billing-summary-label {
            font-size: 0.74rem;
            color: #8ea0b7;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .billing-summary-value {
            margin-top: 4px;
            font-size: 1.02rem;
            font-weight: 700;
            color: #e9f3ff;
        }

        .table-elegant {
            --bs-table-bg: transparent;
            --bs-table-color: #e5ecf7;
            --bs-table-border-color: #2b3647;
            margin-bottom: 0;
        }

        .table-elegant thead th {
            border-bottom: 1px solid #3b4a5f;
            color: #9fd6ff;
            font-size: 0.82rem;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            font-weight: 700;
            background: rgba(26, 35, 49, 0.75);
        }

        .table-elegant tbody td {
            border-color: #2b3647;
            color: #d7e1ef;
            vertical-align: middle;
        }

        .table-elegant tbody tr {
            transition: background-color 0.15s ease;
        }

        .table-elegant tbody tr:hover {
            background: rgba(0, 194, 255, 0.08);
        }


        .desktop-menu-note {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid #2f3948;
            border-radius: 14px;
            padding: 12px;
        }

        .desktop-menu-note .menu-note-title {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.9px;
            color: #9fb0c5;
        }

        .desktop-menu-note .menu-note-value {
            font-size: 1.15rem;
            font-weight: 700;
            color: #f1f5f9;
        }

        .status-split {
            margin-top: 10px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .status-col {
            border: 1px solid #2f3948;
            border-radius: 10px;
            padding: 10px;
            background: rgba(255, 255, 255, 0.02);
        }

        .status-col-label {
            font-size: 0.72rem;
            letter-spacing: 0.7px;
            text-transform: uppercase;
            color: #8ea0b7;
            margin-bottom: 4px;
        }

        .status-col-value {
            font-size: 1.2rem;
            line-height: 1.1;
            font-weight: 700;
        }

        .status-col.pending .status-col-value {
            color: #8de9ff;
        }

        .status-col.success .status-col-value {
            color: #98ffd0;
        }

        @media (min-width: 992px) {
            .developer-card.span-6 {
                grid-column: span 6;
            }
        }

        .toast-container-custom {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            pointer-events: none;
        }

        .toast-custom {
            background: linear-gradient(135deg, #17b26a 0%, #00c2ff 100%);
            border: 1px solid #1a8a5a;
            border-radius: 12px;
            padding: 14px 18px;
            color: #051018;
            font-weight: 600;
            font-size: 0.95rem;
            box-shadow: 0 8px 24px rgba(0, 194, 255, 0.25);
            animation: slideInRight 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            pointer-events: auto;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(400px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }

        .toast-custom.hiding {
            animation: slideOutRight 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        .page-footer {
            border-top: 1px solid var(--line);
            color: #a7b2c2;
            background: rgba(10, 13, 18, 0.7);
            font-size: 0.9rem;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                border-right: none;
                border-bottom: none;
            }

            .offcanvas.offcanvas-start {
                width: min(85vw, 320px);
                background: linear-gradient(180deg, #11151d 0%, #0d1118 100%);
                border-right: 1px solid var(--line);
            }

            .offcanvas-backdrop.show {
                opacity: 0.6;
            }

            .developer-hero-logo {
                width: 70px !important;
                height: 70px !important;
                top: 12px !important;
                right: 12px !important;
            }
        }

        @media (min-width: 992px) {
            .sidebar {
                background:
                    radial-gradient(circle at 18% 12%, rgba(0, 194, 255, 0.16), transparent 38%),
                    linear-gradient(180deg, #10141c 0%, #0b0f15 100%);
                border-right: 1px solid #293242;
                box-shadow: inset -1px 0 0 rgba(255, 255, 255, 0.03);
            }

            .sidebar .offcanvas-body {
                display: flex;
                flex-direction: column;
                min-height: 100vh;
            }

            .desktop-menu-note {
                background: rgba(255, 255, 255, 0.02);
                border: 1px solid #2f3948;
                border-radius: 14px;
                padding: 12px;
            }

            .desktop-menu-note .menu-note-title {
                font-size: 0.8rem;
                text-transform: uppercase;
                letter-spacing: 0.9px;
                color: #9fb0c5;
            }

            .desktop-menu-note .menu-note-value {
                font-size: 1.15rem;
                font-weight: 700;
                color: #f1f5f9;
            }

            .status-split {
                margin-top: 10px;
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 8px;
            }

            .status-col {
                border: 1px solid #2f3948;
                border-radius: 10px;
                padding: 10px;
                background: rgba(255, 255, 255, 0.02);
            }

            .status-col-label {
                font-size: 0.72rem;
                letter-spacing: 0.7px;
                text-transform: uppercase;
                color: #8ea0b7;
                margin-bottom: 4px;
            }

            .status-col-value {
                font-size: 1.2rem;
                line-height: 1.1;
                font-weight: 700;
            }

            .status-col.pending .status-col-value {
                color: #8de9ff;
            }

            .status-col.success .status-col-value {
                color: #98ffd0;
            }

            #sidebar-tabs {
                gap: 10px !important;
            }

            .side-link {
                position: relative;
                display: flex;
                align-items: center;
                gap: 8px;
                min-height: 48px;
                padding: 0.7rem 0.95rem;
                border-radius: 14px;
                border: 1px solid #2b3442;
                background: linear-gradient(180deg, rgba(255, 255, 255, 0.02), rgba(255, 255, 255, 0));
            }

            .side-link::before {
                content: "";
                position: absolute;
                left: -1px;
                top: 9px;
                bottom: 9px;
                width: 3px;
                border-radius: 999px;
                background: transparent;
                transition: background-color 0.2s ease;
            }

            .side-link:hover {
                transform: translateX(2px);
                border-color: #3a475b;
                background-color: rgba(255, 255, 255, 0.04);
            }

            .side-link.active {
                background: linear-gradient(90deg, rgba(0, 194, 255, 0.2), rgba(0, 194, 255, 0.05)) !important;
                border-color: rgba(0, 194, 255, 0.48);
                box-shadow: none;
            }

            .side-link.active::before {
                background: #00c2ff;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid app-shell">
        <div class="mobile-topbar d-lg-none px-3 py-2">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-0">Sansa Genaral</h6>
                    <small class="text-secondary">Customer Workflow</small>
                </div>
                <button
                    class="btn mobile-menu-btn"
                    type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#adminSidebar"
                    aria-controls="adminSidebar">
                    <i class="bi bi-list fs-5"></i>
                </button>
            </div>
        </div>

        <div class="row min-vh-100 app-main">
            <aside
                class="offcanvas-lg offcanvas-start col-lg-3 col-xxl-2 p-0 sidebar"
                tabindex="-1"
                id="adminSidebar"
                aria-labelledby="adminSidebarLabel">
                <div class="offcanvas-header d-lg-none border-bottom border-secondary-subtle">
                    <h5 class="offcanvas-title" id="adminSidebarLabel">Menu</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <div class="offcanvas-body p-0">
                    <?php
                    $sessionPointId = (int) ($_SESSION['point_id'] ?? 0);
                    $sessionUserId = (int) ($_SESSION['user_id'] ?? 0);
                    $statusPointFilter = '';
                    $customerPointFilter = '';

                    if ($sessionPointId > 0) {
                        $statusPointFilter = " AND `Points_point_id` = '{$sessionPointId}'";
                        $customerPointFilter = " AND vc.`Points_point_id` = '{$sessionPointId}'";
                    } elseif ($sessionUserId > 0) {
                        $statusPointFilter = " AND `Points_point_id` IN (SELECT `point_id` FROM `points` WHERE `users_u_id` = '{$sessionUserId}')";
                        $customerPointFilter = " AND vc.`Points_point_id` IN (SELECT `point_id` FROM `points` WHERE `users_u_id` = '{$sessionUserId}')";
                    }

                    $statusCount = Database::search("SELECT COALESCE(SUM(CASE WHEN `v_status_cs_id` = '1'{$statusPointFilter} THEN 1 ELSE 0 END), 0) AS pending_count, COALESCE(SUM(CASE WHEN `v_status_cs_id` = '2'{$statusPointFilter} THEN 1 ELSE 0 END), 0) AS success_count FROM `v_customers`");
                    $statusCountData = ($statusCount && $statusCount->num_rows > 0)
                        ? $statusCount->fetch_assoc()
                        : ["pending_count" => 0, "success_count" => 0];

                    $todayPendingCount = (int) ($statusCountData["pending_count"] ?? 0);
                    $todaySuccessCount = (int) ($statusCountData["success_count"] ?? 0);

                    $pendingBillingCustomers = Database::search("SELECT vc.`vh_cid`, vc.`vc_name`, vc.`v_number`, vc.`vc_contact`, vc.`date_issued`, vc.`date_expere`, vt.`v_type`, vt.`price`, p.`shop_name` FROM `v_customers` vc LEFT JOIN `vehical_typs` vt ON vc.`vehical_typs_vty_id` = vt.`vty_id` LEFT JOIN `points` p ON vc.`Points_point_id` = p.`point_id` WHERE vc.`v_status_cs_id` = '1'{$customerPointFilter} ORDER BY vc.`vh_cid` DESC");

                    $billingScopeFilter = "";
                    if ($sessionPointId > 0) {
                        $billingScopeFilter = " AND bm.`point_id` = '{$sessionPointId}'";
                    } elseif ($sessionUserId > 0) {
                        $billingScopeFilter = " AND bm.`point_id` IN (SELECT `point_id` FROM `points` WHERE `users_u_id` = '{$sessionUserId}')";
                    }

                    $billingHistory = false;
                    $billingHistoryTableCheck = Database::search("SHOW TABLES LIKE 'billing_master'");
                    if ($billingHistoryTableCheck && $billingHistoryTableCheck->num_rows > 0) {
                        $billingMasterColumns = [];
                        $billingColumnsRs = Database::search("SHOW COLUMNS FROM `billing_master`");
                        if ($billingColumnsRs && $billingColumnsRs->num_rows > 0) {
                            while ($billingColumn = $billingColumnsRs->fetch_assoc()) {
                                $billingMasterColumns[] = $billingColumn['Field'];
                            }
                        }

                        $billingInvoiceColumn = in_array('invoice_no', $billingMasterColumns, true)
                            ? ', bm.`invoice_no`'
                            : '';
                        $billingMethodColumn = in_array('payment_method', $billingMasterColumns, true)
                            ? ', bm.`payment_method`'
                            : '';

                        $billingHistory = Database::search("SELECT bm.`bill_id`, bm.`point_id`, bm.`user_id`, bm.`total_amount`, bm.`completed_at`{$billingInvoiceColumn}{$billingMethodColumn}, p.`shop_name`, (SELECT COUNT(*) FROM `billing_items` bi WHERE bi.`bill_id` = bm.`bill_id`) AS item_count FROM `billing_master` bm LEFT JOIN `points` p ON bm.`point_id` = p.`point_id` WHERE 1=1 {$billingScopeFilter} ORDER BY bm.`completed_at` DESC LIMIT 200");
                    }
                    ?>

                    <div class="brand p-4 d-none d-lg-block">
                        <h5 class="mb-1">Sansa Genaral</h5>
                        <small class="text-secondary">Customer Workflow</small>
                    </div>

                    <div class="desktop-menu-note d-lg-none mx-3 mt-3 mb-2">
                        <div class="menu-note-title">Today Status</div>
                        <div class="status-split">
                            <div class="status-col pending">
                                <div class="status-col-label">Pendings</div>
                                <div class="status-col-value"><?php echo $todayPendingCount; ?></div>
                            </div>
                            <div class="status-col success">
                                <div class="status-col-label">Success</div>
                                <div class="status-col-value"><?php echo $todaySuccessCount; ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="desktop-menu-note d-none d-lg-block mx-4 mt-4 mb-2">
                        <div class="menu-note-title">Today Status</div>
                        <div class="status-split">
                            <div class="status-col pending">
                                <div class="status-col-label">Pendings</div>
                                <div class="status-col-value"><?php echo $todayPendingCount; ?></div>
                            </div>
                            <div class="status-col success">
                                <div class="status-col-label">Success</div>
                                <div class="status-col-value"><?php echo $todaySuccessCount; ?></div>
                            </div>
                        </div>
                    </div>

                    <nav class="p-3 p-lg-4">
                        <div class="nav nav-pills flex-column gap-2" id="sidebar-tabs" role="tablist">
                            <button
                                class="nav-link side-link text-start active"
                                id="new-customer-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#new-customer"
                                type="button"
                                role="tab"
                                aria-controls="new-customer"
                                aria-selected="true">
                                <i class="bi bi-person-plus me-2"></i>New Customer
                            </button>
                            <button
                                class="nav-link side-link text-start"
                                id="pendings-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#pendings"
                                type="button"
                                role="tab"
                                aria-controls="pendings"
                                aria-selected="false">
                                <i class="bi bi-hourglass-split me-2"></i>Pendings
                            </button>
                            <button
                                class="nav-link side-link text-start"
                                id="completed-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#completed"
                                type="button"
                                role="tab"
                                aria-controls="completed"
                                aria-selected="false">
                                <i class="bi bi-check2-circle me-2"></i>Completed
                            </button>
                            <button
                                class="nav-link side-link text-start"
                                id="billing-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#billing"
                                type="button"
                                role="tab"
                                aria-controls="billing"
                                aria-selected="false">
                                <i class="bi bi-receipt-cutoff me-2"></i>Billing
                            </button>
                            <button
                                class="nav-link side-link text-start"
                                id="timeline-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#timeline"
                                type="button"
                                role="tab"
                                aria-controls="timeline"
                                aria-selected="false">
                                <i class="bi bi-clock-history me-2"></i>Customer Timeline
                            </button>
                            <button
                                class="nav-link side-link text-start"
                                id="developer-info-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#developer-info"
                                type="button"
                                role="tab"
                                aria-controls="developer-info"
                                aria-selected="false">
                                <i class="bi bi-code-slash me-2"></i>Developer Details
                            </button>
                        </div>
                    </nav>
                </div>
            </aside>

            <main class="col-12 col-lg-9 col-xxl-10 p-3 p-md-4 p-xl-5 content-wrap">
                <div class="tab-content" id="sidebar-tabs-content">
                    <section
                        class="tab-pane fade show active"
                        id="new-customer"
                        role="tabpanel"
                        aria-labelledby="new-customer-tab"
                        tabindex="0">
                        <div class="panel-card p-3 p-md-4 p-xl-5">
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                                <h3 class="panel-title mb-0">New Customer</h3>
                                <span class="status-chip"><i class="bi bi-car-front"></i>Motor Insurance</span>
                            </div>

                            <form id="newCustomerForm" class="row g-3" novalidate>
                                <div class="col-12 col-md-6">
                                    <label class="form-label">Customer Name</label>
                                    <input id="customerName" name="customerName" type="text" class="form-control" placeholder="Enter customer name" required>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label">Vehicle Number</label>
                                    <input id="vehicleNumber" name="vehicleNumber" type="text" class="form-control" placeholder="Enter vehicle number" required>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label">Chassis Number</label>
                                    <input id="chassisNumber" name="chassisNumber" type="text" class="form-control" placeholder="Enter chassis number" required>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label">Contact</label>
                                    <input id="contactNumber" name="contactNumber" type="text" class="form-control" placeholder="Enter contact number" inputmode="tel" maxlength="15" required>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label">Vehicle Type</label>
                                    <select id="vehicleType" name="vehicleType" class="form-select" aria-label="Select vehicle type" onchange="previewPrice(this.options[this.selectedIndex].dataset.price);" required>
                                        <option value="" selected disabled>Select vehicle type</option>

                                        <?php

                                        $vtypes = Database::search("SELECT * FROM `vehical_typs`");
                                        $vtypes_num = $vtypes->num_rows;
                                        for ($i = 0; $i < $vtypes_num; $i++) {
                                            $vtypes_data = $vtypes->fetch_assoc();
                                        ?>
                                            <option value="<?php echo $vtypes_data['vty_id']; ?>" data-price="<?php echo $vtypes_data['price']; ?>"><?php echo $vtypes_data['v_type']; ?></option>

                                        <?php

                                        }




                                        ?>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label">NIC</label>
                                    <input id="nic" name="nic" type="text" class="form-control" placeholder="Enter NIC" maxlength="12" required>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label">Premium</label>
                                    <input id="premium_v" name="premium" type="text" class="form-control" placeholder="Auto generate " readonly required>
                                </div>

                                <div class="col-12">
                                    <div class="form-subsection">
                                        <div class="d-flex align-items-center gap-2 mb-3">
                                            <i class="bi bi-file-earmark-text"></i>
                                            <h6 class="form-subsection-title mb-0">Documentation</h6>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-12 col-md-4">
                                                <label class="form-label">Upload CR</label>
                                                <input id="uploadCr" name="uploadCr" type="file" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label class="form-label">Upload NIC</label>
                                                <input id="uploadNic" name="uploadNic" type="file" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label class="form-label">Upload Experied I.card</label>
                                                <input id="uploadExpiredCard" name="uploadExpiredCard" type="file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button id="submitBtn" type="submit" class="btn btn-accent px-4">Submit</button>
                                </div>
                            </form>
                        </div>
                    </section>

                    <section
                        class="tab-pane fade"
                        id="pendings"
                        role="tabpanel"
                        aria-labelledby="pendings-tab"
                        tabindex="0">
                        <div class="panel-card p-3 p-md-4 p-xl-5">
                            <h3 class="panel-title mb-3">Pendings</h3>
                            <div class="row g-3">
                                <?php
                                $pendingCustomers = Database::search("SELECT vc.*, vt.`v_type` FROM `v_customers` vc LEFT JOIN `vehical_typs` vt ON vc.`vehical_typs_vty_id` = vt.`vty_id` WHERE vc.`v_status_cs_id` = '1'{$customerPointFilter} ORDER BY vc.`vh_cid` DESC");

                                if ($pendingCustomers && $pendingCustomers->num_rows > 0) {
                                    while ($pending = $pendingCustomers->fetch_assoc()) {
                                        $customerName = htmlspecialchars($pending["vc_name"]);
                                        $vehicleNumber = htmlspecialchars($pending["v_number"]);
                                        $chassisNumber = htmlspecialchars($pending["ch_number"]);
                                        $vehicleTypeName = htmlspecialchars($pending["v_type"] ?? "N/A");
                                        $contact = htmlspecialchars($pending["vc_contact"]);
                                        $issueDate = htmlspecialchars($pending["date_issued"]);
                                        $expireDate = htmlspecialchars($pending["date_expere"]);
                                        $crCopy = trim((string) ($pending["cr_copy"] ?? ""));
                                        $nicCopy = trim((string) ($pending["nic_copy"] ?? ""));
                                        $exICopy = trim((string) ($pending["ex_i"] ?? ""));
                                ?>
                                        <div class="col-12 col-md-6 col-xl-4">
                                            <div class="pending-card">
                                                <div class="pending-card-header">
                                                    <span class="pending-status-badge">Pending</span>
                                                    <h4 class="pending-card-title"><?php echo $vehicleNumber; ?></h4>
                                                    <p class="pending-customer-name"><?php echo $customerName; ?></p>
                                                </div>
                                                <div class="pending-meta">
                                                    <div class="pending-meta-item"><span>Chassis:</span><?php echo $chassisNumber; ?></div>
                                                    <div class="pending-meta-item"><span>Type:</span><?php echo $vehicleTypeName; ?></div>
                                                    <div class="pending-meta-item"><span>Contact:</span><?php echo $contact; ?></div>
                                                    <div class="pending-meta-item"><span>Issue Date:</span><?php echo $issueDate; ?></div>
                                                    <div class="pending-meta-item"><span>Ex Date:</span><?php echo $expireDate; ?></div>
                                                </div>

                                                <div class="pending-docs">
                                                    <?php if ($crCopy !== "") { ?>
                                                        <a class="pending-doc-link" href="../<?php echo htmlspecialchars($crCopy); ?>" target="_blank">CR Copy</a>
                                                    <?php } ?>
                                                    <?php if ($nicCopy !== "") { ?>
                                                        <a class="pending-doc-link" href="../<?php echo htmlspecialchars($nicCopy); ?>" target="_blank">NIC Copy</a>
                                                    <?php } ?>
                                                    <?php if ($exICopy !== "") { ?>
                                                        <a class="pending-doc-link" href="../<?php echo htmlspecialchars($exICopy); ?>" target="_blank">Ex I.card</a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <div class="col-12">
                                        <p class="text-secondary mb-0">No pending customers found.</p>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </section>

                    <section
                        class="tab-pane fade"
                        id="completed"
                        role="tabpanel"
                        aria-labelledby="completed-tab"
                        tabindex="0">
                        <div class="panel-card p-3 p-md-4 p-xl-5">
                            <h3 class="panel-title mb-3">Completed</h3>
                            <div class="row g-3">
                                <?php
                                $completedCustomers = Database::search("SELECT vc.*, vt.`v_type` FROM `v_customers` vc LEFT JOIN `vehical_typs` vt ON vc.`vehical_typs_vty_id` = vt.`vty_id` WHERE vc.`v_status_cs_id` = '2'{$customerPointFilter} ORDER BY vc.`vh_cid` DESC");

                                if ($completedCustomers && $completedCustomers->num_rows > 0) {
                                    while ($completed = $completedCustomers->fetch_assoc()) {
                                        $customerName = htmlspecialchars($completed["vc_name"]);
                                        $vehicleNumber = htmlspecialchars($completed["v_number"]);
                                        $chassisNumber = htmlspecialchars($completed["ch_number"]);
                                        $vehicleTypeName = htmlspecialchars($completed["v_type"] ?? "N/A");
                                        $contact = htmlspecialchars($completed["vc_contact"]);
                                        $issueDate = htmlspecialchars($completed["date_issued"]);
                                        $expireDate = htmlspecialchars($completed["date_expere"]);
                                        $crCopy = trim((string) ($completed["cr_copy"] ?? ""));
                                        $nicCopy = trim((string) ($completed["nic_copy"] ?? ""));
                                        $exICopy = trim((string) ($completed["ex_i"] ?? ""));
                                ?>
                                        <div class="col-12 col-md-6 col-xl-4">
                                            <div class="completed-card">
                                                <div class="pending-card-header">
                                                    <span class="completed-status-badge">Completed</span>
                                                    <h4 class="pending-card-title"><?php echo $vehicleNumber; ?></h4>
                                                    <p class="pending-customer-name"><?php echo $customerName; ?></p>
                                                </div>
                                                <div class="pending-meta">
                                                    <div class="pending-meta-item"><span>Chassis:</span><?php echo $chassisNumber; ?></div>
                                                    <div class="pending-meta-item"><span>Type:</span><?php echo $vehicleTypeName; ?></div>
                                                    <div class="pending-meta-item"><span>Contact:</span><?php echo $contact; ?></div>
                                                    <div class="pending-meta-item"><span>Issue Date:</span><?php echo $issueDate; ?></div>
                                                    <div class="pending-meta-item"><span>Ex Date:</span><?php echo $expireDate; ?></div>
                                                </div>

                                                <div class="pending-docs">
                                                    <?php if ($crCopy !== "") { ?>
                                                        <a class="pending-doc-link" href="../<?php echo htmlspecialchars($crCopy); ?>" target="_blank">CR Copy</a>
                                                    <?php } ?>
                                                    <?php if ($nicCopy !== "") { ?>
                                                        <a class="pending-doc-link" href="../<?php echo htmlspecialchars($nicCopy); ?>" target="_blank">NIC Copy</a>
                                                    <?php } ?>
                                                    <?php if ($exICopy !== "") { ?>
                                                        <a class="pending-doc-link" href="../<?php echo htmlspecialchars($exICopy); ?>" target="_blank">Ex I.card</a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <div class="col-12">
                                        <p class="text-secondary mb-0">No completed customers found.</p>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </section>

                    <section
                        class="tab-pane fade"
                        id="billing"
                        role="tabpanel"
                        aria-labelledby="billing-tab"
                        tabindex="0">
                        <div class="panel-card p-3 p-md-4 p-xl-5">
                            <div class="d-flex justify-content-between align-items-center gap-2 mb-3 flex-wrap">
                                <h3 class="panel-title mb-0">Billing</h3>
                                <span class="status-chip"><i class="bi bi-cash-stack"></i>Draft & Complete</span>
                            </div>

                            <div class="billing-grid mb-3">
                                <div class="billing-box">
                                    <label class="form-label">Select Pending Customer</label>
                                    <select id="billingCustomerSelect" class="form-select" aria-label="Select pending customer">
                                        <option value="">Choose pending customer</option>
                                        <?php
                                        if ($pendingBillingCustomers && $pendingBillingCustomers->num_rows > 0) {
                                            while ($billingPending = $pendingBillingCustomers->fetch_assoc()) {
                                                $billCustomerId = (int) ($billingPending['vh_cid'] ?? 0);
                                                $billCustomerName = htmlspecialchars((string) ($billingPending['vc_name'] ?? ''), ENT_QUOTES, 'UTF-8');
                                                $billVehicleNo = htmlspecialchars((string) ($billingPending['v_number'] ?? ''), ENT_QUOTES, 'UTF-8');
                                                $billContact = htmlspecialchars((string) ($billingPending['vc_contact'] ?? ''), ENT_QUOTES, 'UTF-8');
                                                $billVType = htmlspecialchars((string) ($billingPending['v_type'] ?? 'N/A'), ENT_QUOTES, 'UTF-8');
                                                $billPointName = htmlspecialchars((string) ($billingPending['shop_name'] ?? 'N/A'), ENT_QUOTES, 'UTF-8');
                                                $billIssued = htmlspecialchars((string) ($billingPending['date_issued'] ?? ''), ENT_QUOTES, 'UTF-8');
                                                $billExpire = htmlspecialchars((string) ($billingPending['date_expere'] ?? ''), ENT_QUOTES, 'UTF-8');
                                                $billPrice = (float) ($billingPending['price'] ?? 0);
                                        ?>
                                                <option
                                                    value="<?php echo $billCustomerId; ?>"
                                                    data-cname="<?php echo $billCustomerName; ?>"
                                                    data-vno="<?php echo $billVehicleNo; ?>"
                                                    data-contact="<?php echo $billContact; ?>"
                                                    data-vtype="<?php echo $billVType; ?>"
                                                    data-point="<?php echo $billPointName; ?>"
                                                    data-issued="<?php echo $billIssued; ?>"
                                                    data-expire="<?php echo $billExpire; ?>"
                                                    data-price="<?php echo number_format($billPrice, 2, '.', ''); ?>">
                                                    <?php echo $billVehicleNo; ?> - <?php echo $billCustomerName; ?>
                                                </option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>

                                    <div class="billing-meta mt-3">
                                        <div class="billing-meta-item"><span>Name:</span><strong id="billName">-</strong></div>
                                        <div class="billing-meta-item"><span>Vehicle:</span><strong id="billVehicle">-</strong></div>
                                        <div class="billing-meta-item"><span>Type:</span><strong id="billType">-</strong></div>
                                        <div class="billing-meta-item"><span>Contact:</span><strong id="billContact">-</strong></div>
                                        <div class="billing-meta-item"><span>Point:</span><strong id="billPoint">-</strong></div>
                                        <div class="billing-meta-item"><span>Issued:</span><strong id="billIssued">-</strong></div>
                                        <div class="billing-meta-item"><span>Expires:</span><strong id="billExpire">-</strong></div>
                                        <div class="billing-meta-item"><span>Price:</span><strong id="billPrice">0.00</strong></div>
                                    </div>

                                    <button id="addToBillingBtn" class="btn btn-accent mt-3" type="button" disabled>
                                        <i class="bi bi-plus-circle me-1"></i>Add To Billing
                                    </button>
                                </div>
                            </div>

                            <div class="billing-box">
                                <div class="d-flex justify-content-between align-items-center gap-2 mb-3 flex-wrap">
                                    <h5 class="mb-0">Billing Draft Table</h5>
                                    <span class="status-chip">Total: <strong id="billingGrandTotal" class="ms-1">0.00</strong></span>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-elegant table-hover align-middle mb-0" id="billingDraftTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Customer</th>
                                                <th>Vehicle</th>
                                                <th>Contact</th>
                                                <th>Type</th>
                                                <th>Price</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="billingDraftBody">
                                            <tr id="billingDraftEmptyRow">
                                                <td colspan="7" class="text-secondary">No customers added to billing draft.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-end mt-3">
                                    <button id="completeBillingBtn" class="btn btn-accent" type="button" disabled>
                                        <i class="bi bi-check2-square me-1"></i>Complete Billing
                                    </button>
                                </div>

                                <div class="billing-controls">
                                    <div>
                                        <label class="form-label">Discount (LKR)</label>
                                        <input type="number" min="0" step="0.01" id="billingDiscount" class="form-control" value="0">
                                    </div>
                                    <div>
                                        <label class="form-label">Tax (%)</label>
                                        <input type="number" min="0" max="100" step="0.01" id="billingTaxPercent" class="form-control" value="0">
                                    </div>
                                    <div>
                                        <label class="form-label">Service Charge (LKR)</label>
                                        <input type="number" min="0" step="0.01" id="billingServiceCharge" class="form-control" value="0">
                                    </div>
                                    <div>
                                        <label class="form-label">Payment Method</label>
                                        <select id="billingPaymentMethod" class="form-select">
                                            <option value="cash">Cash</option>
                                            <option value="card">Card</option>
                                            <option value="bank_transfer">Bank Transfer</option>
                                            <option value="cheque">Cheque</option>
                                        </select>
                                    </div>
                                    <div style="grid-column: 1 / -1;">
                                        <label class="form-label">Bill Note</label>
                                        <textarea id="billingNote" class="form-control" rows="2" placeholder="Optional note for this bill"></textarea>
                                    </div>
                                </div>

                                <div class="billing-summary">
                                    <div class="billing-summary-card">
                                        <div class="billing-summary-label">Sub Total</div>
                                        <div class="billing-summary-value" id="billingSubTotal">0.00</div>
                                    </div>
                                    <div class="billing-summary-card">
                                        <div class="billing-summary-label">Discount</div>
                                        <div class="billing-summary-value" id="billingDiscountAmount">0.00</div>
                                    </div>
                                    <div class="billing-summary-card">
                                        <div class="billing-summary-label">Tax Amount</div>
                                        <div class="billing-summary-value" id="billingTaxAmount">0.00</div>
                                    </div>
                                    <div class="billing-summary-card">
                                        <div class="billing-summary-label">Final Total</div>
                                        <div class="billing-summary-value" id="billingFinalTotal">0.00</div>
                                    </div>
                                </div>
                            </div>

                            <div class="billing-box mt-3">
                                <h5 class="mb-3">Bill History</h5>
                                <div class="table-responsive">
                                    <table class="table table-elegant table-hover align-middle mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Invoice</th>
                                                <th>Point</th>
                                                <th>Items</th>
                                                <th>Total</th>
                                                <th>Method</th>
                                                <th>Completed At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($billingHistory && $billingHistory->num_rows > 0) {
                                                $billNo = 1;
                                                while ($billRow = $billingHistory->fetch_assoc()) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo $billNo++; ?></td>
                                                        <td><?php echo htmlspecialchars((string) (($billRow['invoice_no'] ?? '') !== '' ? $billRow['invoice_no'] : ('BILL-' . (int) ($billRow['bill_id'] ?? 0)))); ?></td>
                                                        <td><?php echo htmlspecialchars((string) ($billRow['shop_name'] ?? 'N/A')); ?></td>
                                                        <td><?php echo (int) ($billRow['item_count'] ?? 0); ?></td>
                                                        <td><?php echo number_format((float) ($billRow['total_amount'] ?? 0), 2); ?></td>
                                                        <td><?php echo htmlspecialchars((string) ($billRow['payment_method'] ?? 'N/A')); ?></td>
                                                        <td><?php echo htmlspecialchars((string) ($billRow['completed_at'] ?? 'N/A')); ?></td>
                                                    </tr>
                                            <?php
                                                }
                                            } else {
                                            ?>
                                                <tr>
                                                    <td colspan="7" class="text-secondary">No completed bill history found yet.</td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section
                        class="tab-pane fade"
                        id="timeline"
                        role="tabpanel"
                        aria-labelledby="timeline-tab"
                        tabindex="0">
                        <div class="panel-card p-3 p-md-4 p-xl-5">
                            <div class="d-flex justify-content-between align-items-center gap-2 mb-3 flex-wrap">
                                <h3 class="panel-title mb-0">Customer Timeline</h3>
                                <span class="status-chip"><i class="bi bi-activity"></i>Recent Customer Events</span>
                            </div>

                            <div class="timeline-wrap">
                                <?php
                                $timelineCustomers = Database::search("SELECT vc.`vh_cid`, vc.`vc_name`, vc.`v_number`, vc.`ch_number`, vc.`vc_contact`, vc.`date_issued`, vc.`date_expere`, vc.`v_status_cs_id`, vt.`v_type`, p.`shop_name` FROM `v_customers` vc LEFT JOIN `vehical_typs` vt ON vc.`vehical_typs_vty_id` = vt.`vty_id` LEFT JOIN `points` p ON vc.`Points_point_id` = p.`point_id` WHERE 1=1 {$customerPointFilter} ORDER BY vc.`vh_cid` DESC LIMIT 50");

                                if ($timelineCustomers && $timelineCustomers->num_rows > 0) {
                                    while ($t = $timelineCustomers->fetch_assoc()) {
                                        $isCompleted = ((int) ($t['v_status_cs_id'] ?? 0) === 2);
                                        $statusText = $isCompleted ? 'Completed' : 'Pending';
                                        $vehicleNo = htmlspecialchars($t['v_number'] ?? 'N/A');
                                        $name = htmlspecialchars($t['vc_name'] ?? 'N/A');
                                        $type = htmlspecialchars($t['v_type'] ?? 'N/A');
                                        $chassis = htmlspecialchars($t['ch_number'] ?? 'N/A');
                                        $contact = htmlspecialchars($t['vc_contact'] ?? 'N/A');
                                        $pointName = htmlspecialchars($t['shop_name'] ?? 'N/A');
                                        $issued = htmlspecialchars($t['date_issued'] ?? 'N/A');
                                        $expire = htmlspecialchars($t['date_expere'] ?? 'N/A');
                                ?>
                                        <article class="timeline-item <?php echo $isCompleted ? 'completed' : ''; ?>">
                                            <div class="timeline-head">
                                                <div>
                                                    <h4 class="timeline-title"><?php echo $vehicleNo; ?> - <?php echo $name; ?></h4>
                                                    <p class="timeline-sub">Customer ID #<?php echo (int) ($t['vh_cid'] ?? 0); ?></p>
                                                </div>
                                                <span class="timeline-tag <?php echo $isCompleted ? 'done' : ''; ?>"><?php echo $statusText; ?></span>
                                            </div>

                                            <div class="timeline-meta">
                                                <div class="timeline-meta-item"><span>Type:</span><?php echo $type; ?></div>
                                                <div class="timeline-meta-item"><span>Chassis:</span><?php echo $chassis; ?></div>
                                                <div class="timeline-meta-item"><span>Contact:</span><?php echo $contact; ?></div>
                                                <div class="timeline-meta-item"><span>Point:</span><?php echo $pointName; ?></div>
                                                <div class="timeline-meta-item"><span>Issued:</span><?php echo $issued; ?></div>
                                                <div class="timeline-meta-item"><span>Expires:</span><?php echo $expire; ?></div>
                                            </div>
                                        </article>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <p class="text-secondary mb-0">No timeline events found for your points.</p>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </section>

                    <section
                        class="tab-pane fade"
                        id="developer-info"
                        role="tabpanel"
                        aria-labelledby="developer-info-tab"
                        tabindex="0">
                        <div class="panel-card p-3 p-md-4 p-xl-5">
                            <div class="developer-hero">
                                <img src="../com.png" alt="Logo" class="developer-hero-logo">
                                <span class="developer-kicker"><i class="bi bi-stars"></i> Developer Desk</span>
                                <h3 class="developer-title">Developer Details</h3>
                                <p class="developer-subtitle">This web system is designed for insurance customer workflow management, including onboarding, documentation, status tracking, and policy processing support.</p>
                            </div>

                            <div class="developer-grid">
                                <div class="developer-card span-6">
                                    <h6><i class="bi bi-person-badge me-1"></i>Profile</h6>
                                    <div class="developer-row">
                                        <div class="developer-label">Developer</div>
                                        <div class="developer-value">Diluna Sithija</div>
                                    </div>
                                    <div class="developer-row">
                                        <div class="developer-label">Company</div>
                                        <div class="developer-value">Affinity Software Solutions</div>
                                    </div>
                                    <div class="developer-row">
                                        <div class="developer-label">Version</div>
                                        <div class="developer-value">1.0.0</div>
                                    </div>
                                </div>

                                <div class="developer-card span-6">
                                    <h6><i class="bi bi-envelope-at me-1"></i>Contact</h6>
                                    <div class="developer-row">
                                        <div class="developer-label">Company Email</div>
                                        <div class="developer-value">affinitysoft.solutions@gmail.com</div>
                                    </div>
                                    <div class="developer-row">
                                        <div class="developer-label">Email</div>
                                        <div class="developer-value">dilunasithija111@gmail.com</div>
                                    </div>
                                    <div class="developer-row">
                                        <div class="developer-label">Phone</div>
                                        <div class="developer-value">+94 72 690 2971</div>
                                    </div>

                                </div>

                                <div class="developer-card">
                                    <h6><i class="bi bi-tools me-1"></i>Core Modules</h6>
                                    <div class="developer-chip-list">
                                        <span class="developer-chip"><i class="bi bi-person-plus"></i>Customer Onboarding</span>
                                        <span class="developer-chip"><i class="bi bi-folder2-open"></i>Document Collection</span>
                                        <span class="developer-chip"><i class="bi bi-activity"></i>Status Tracking</span>
                                        <span class="developer-chip"><i class="bi bi-shield-check"></i>Policy Processing</span>
                                    </div>
                                </div>
                            </div>

                            <div class="account-box">
                                <p class="mb-1"><strong>Logged in as:</strong> <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Unknown'); ?></p>
                                <p class="account-email"><small><?php echo htmlspecialchars($_SESSION['user_email'] ?? 'unknown@email.com'); ?></small></p>
                                <a href="./logoutProcess.php" class="btn btn-sm btn-outline-danger mt-2"><i class="bi bi-box-arrow-right me-1"></i>Logout</a>
                            </div>

                        </div>
                    </section>
                </div>
            </main>
        </div>

        <footer class="page-footer py-3 text-center">
            Copyright &copy; 2026 Affinity Soft. All Rights Reserved.
        </footer>
    </div>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <div class="toast-container-custom" id="toastContainer"></div>

    <script>
        function showSuccessToast(message) {
            const container = document.getElementById('toastContainer');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = 'toast-custom';
            toast.textContent = message;
            container.appendChild(toast);

            setTimeout(() => {
                toast.classList.add('hiding');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 3000);
        }

        document.querySelectorAll('#sidebar-tabs .side-link').forEach(function(tabButton) {
            tabButton.addEventListener('click', function() {
                if (window.innerWidth < 992) {
                    var sidebarElement = document.getElementById('adminSidebar');
                    var offcanvasInstance = bootstrap.Offcanvas.getInstance(sidebarElement);
                    if (offcanvasInstance) {
                        offcanvasInstance.hide();
                    }
                }
            });
        });

        // Billing fallback handler: keeps billing actions working even if cached gscript.js is stale.
        document.addEventListener('DOMContentLoaded', function() {
            const billingSelect = document.getElementById('billingCustomerSelect');
            const addButton = document.getElementById('addToBillingBtn');
            const completeButton = document.getElementById('completeBillingBtn');
            const draftBody = document.getElementById('billingDraftBody');
            const draftEmptyRow = document.getElementById('billingDraftEmptyRow');
            const totalEl = document.getElementById('billingGrandTotal');
            const discountEl = document.getElementById('billingDiscount');
            const taxEl = document.getElementById('billingTaxPercent');
            const serviceEl = document.getElementById('billingServiceCharge');
            const paymentMethodEl = document.getElementById('billingPaymentMethod');
            const noteEl = document.getElementById('billingNote');
            const subTotalEl = document.getElementById('billingSubTotal');
            const discountAmountEl = document.getElementById('billingDiscountAmount');
            const taxAmountEl = document.getElementById('billingTaxAmount');
            const finalTotalEl = document.getElementById('billingFinalTotal');

            if (!billingSelect || !addButton || !completeButton || !draftBody || !totalEl || !discountEl || !taxEl || !serviceEl || !paymentMethodEl || !subTotalEl || !discountAmountEl || !taxAmountEl || !finalTotalEl) {
                return;
            }

            const billingDraft = [];

            function setBillingPreview(option) {
                const selected = option || null;
                const emptyState = !selected || !selected.value;

                document.getElementById('billName').textContent = emptyState ? '-' : (selected.dataset.cname || '-');
                document.getElementById('billVehicle').textContent = emptyState ? '-' : (selected.dataset.vno || '-');
                document.getElementById('billType').textContent = emptyState ? '-' : (selected.dataset.vtype || '-');
                document.getElementById('billContact').textContent = emptyState ? '-' : (selected.dataset.contact || '-');
                document.getElementById('billPoint').textContent = emptyState ? '-' : (selected.dataset.point || '-');
                document.getElementById('billIssued').textContent = emptyState ? '-' : (selected.dataset.issued || '-');
                document.getElementById('billExpire').textContent = emptyState ? '-' : (selected.dataset.expire || '-');
                document.getElementById('billPrice').textContent = emptyState ? '0.00' : (Number(selected.dataset.price || 0).toFixed(2));

                addButton.disabled = emptyState;
            }

            function recalculateDraftTotal() {
                const subTotal = billingDraft.reduce(function(sum, item) {
                    return sum + Number(item.price || 0);
                }, 0);

                let discountValue = Number(discountEl.value || 0);
                let taxPercent = Number(taxEl.value || 0);
                let serviceCharge = Number(serviceEl.value || 0);

                if (discountValue < 0) discountValue = 0;
                if (taxPercent < 0) taxPercent = 0;
                if (serviceCharge < 0) serviceCharge = 0;
                if (discountValue > subTotal) discountValue = subTotal;
                if (taxPercent > 100) taxPercent = 100;

                discountEl.value = discountValue.toFixed(2);
                taxEl.value = taxPercent.toFixed(2);
                serviceEl.value = serviceCharge.toFixed(2);

                const taxableBase = (subTotal - discountValue) + serviceCharge;
                const taxAmount = taxableBase * (taxPercent / 100);
                const finalTotal = taxableBase + taxAmount;

                subTotalEl.textContent = subTotal.toFixed(2);
                discountAmountEl.textContent = discountValue.toFixed(2);
                taxAmountEl.textContent = taxAmount.toFixed(2);
                finalTotalEl.textContent = finalTotal.toFixed(2);

                totalEl.textContent = finalTotal.toFixed(2);
                completeButton.disabled = billingDraft.length === 0;
            }

            function renderDraftTable() {
                if (draftEmptyRow) {
                    draftEmptyRow.style.display = billingDraft.length > 0 ? 'none' : '';
                }

                const rows = draftBody.querySelectorAll('tr[data-draft-row="1"]');
                rows.forEach(function(row) {
                    row.remove();
                });

                billingDraft.forEach(function(item, index) {
                    const row = document.createElement('tr');
                    row.setAttribute('data-draft-row', '1');
                    row.innerHTML =
                        '<td>' + (index + 1) + '</td>' +
                        '<td>' + item.customerName + '</td>' +
                        '<td>' + item.vehicleNo + '</td>' +
                        '<td>' + item.contact + '</td>' +
                        '<td>' + item.vehicleType + '</td>' +
                        '<td>' + Number(item.price || 0).toFixed(2) + '</td>' +
                        '<td><button type="button" class="btn btn-sm btn-outline-danger" data-remove-id="' + item.customerId + '"><i class="bi bi-trash"></i></button></td>';
                    draftBody.appendChild(row);
                });

                draftBody.querySelectorAll('button[data-remove-id]').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        const removeId = Number(this.getAttribute('data-remove-id'));
                        const idx = billingDraft.findIndex(function(item) { return item.customerId === removeId; });
                        if (idx >= 0) {
                            billingDraft.splice(idx, 1);
                            renderDraftTable();
                            recalculateDraftTotal();
                        }
                    });
                });
            }

            setBillingPreview(billingSelect.options[billingSelect.selectedIndex]);

            billingSelect.addEventListener('change', function() {
                setBillingPreview(billingSelect.options[billingSelect.selectedIndex]);
            });

            [discountEl, taxEl, serviceEl].forEach(function(inputEl) {
                inputEl.addEventListener('input', function() {
                    recalculateDraftTotal();
                });
            });

            addButton.addEventListener('click', async function() {
                const customerId = Number(billingSelect.value || 0);
                if (!customerId) {
                    alert('Please select a pending customer.');
                    return;
                }

                const selected = billingSelect.options[billingSelect.selectedIndex];
                const alreadyAdded = billingDraft.some(function(item) {
                    return item.customerId === customerId;
                });

                if (alreadyAdded) {
                    alert('This customer is already in billing draft table.');
                    return;
                }

                billingDraft.push({
                    customerId: customerId,
                    customerName: selected.dataset.cname || '-',
                    vehicleNo: selected.dataset.vno || '-',
                    contact: selected.dataset.contact || '-',
                    vehicleType: selected.dataset.vtype || '-',
                    price: Number(selected.dataset.price || 0)
                });

                renderDraftTable();
                recalculateDraftTotal();
            });

            completeButton.addEventListener('click', async function() {
                if (billingDraft.length === 0) {
                    alert('Please add at least one customer to billing table.');
                    return;
                }

                const originalText = completeButton.innerHTML;
                completeButton.disabled = true;
                completeButton.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Completing...';

                try {
                    const customerIds = billingDraft.map(function(item) { return item.customerId; });
                    const response = await fetch('completeBillingProcess.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            customerIds: customerIds,
                            discountAmount: Number(discountEl.value || 0),
                            taxPercent: Number(taxEl.value || 0),
                            serviceCharge: Number(serviceEl.value || 0),
                            paymentMethod: paymentMethodEl.value || 'cash',
                            note: noteEl ? (noteEl.value || '') : ''
                        })
                    });

                    let data = {};
                    try {
                        data = await response.json();
                    } catch (error) {
                        data = { success: false, message: 'Invalid server response.' };
                    }

                    if (!response.ok || !data.success) {
                        throw new Error(data.message || 'Failed to complete billing.');
                    }

                    if (typeof showSuccessToast === 'function') {
                        showSuccessToast(data.message || 'Billing completed successfully.');
                    } else {
                        alert(data.message || 'Billing completed successfully.');
                    }

                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                } catch (error) {
                    alert(error.message || 'Failed to complete billing.');
                    completeButton.disabled = false;
                    completeButton.innerHTML = originalText;
                }
            });
        });
    </script>
    <script src="gscript.js"></script>
</body>

</html>
