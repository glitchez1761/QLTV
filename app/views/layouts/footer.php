<?php
$pageTitle = $pageTitle ?? 'QLTV';
$breadcrumbs = $breadcrumbs ?? [];
$currentController = $_GET['controller'] ?? 'home';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?> | QLTV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #2f6fed;
            --primary-2: #4d7ef7;
            --primary-soft: #eaf1ff;
            --secondary: #1f2937;
            --muted: #6b7280;
            --border: rgba(148, 163, 184, 0.24);
            --surface: #ffffff;
            --bg: #f3f6fb;
            --success: #18a957;
            --warning: #f59e0b;
            --danger: #dc3545;
            --purple: #7c5cff;
            --teal: #13b5b1;
            --info: #0ea5e9;
            --shadow-soft: 0 10px 28px rgba(15, 23, 42, 0.05);
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            background: linear-gradient(180deg, #edf3ff 0%, #f5f7fb 18%, #f7f9fc 100%);
            color: var(--secondary);
            font-family: Arial, Helvetica, sans-serif;
        }
        a { text-decoration: none; }

        .navbar {
            background: linear-gradient(90deg, #0b1a2b 0%, #102847 100%) !important;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            box-shadow: 0 8px 22px rgba(15, 23, 42, 0.12);
        }
        .navbar-brand {
            font-weight: 800;
            letter-spacing: 0.06em;
            color: #fff !important;
        }
        .nav-link {
            font-weight: 600;
            color: rgba(255,255,255,0.8) !important;
            padding: 0.7rem 0.9rem !important;
            border-radius: 10px;
            transition: all 0.2s ease;
        }
        .nav-link:hover, .nav-link.active {
            color: #fff !important;
            background: rgba(255,255,255,0.08);
        }

        .btn {
            border-radius: 10px;
            font-weight: 600;
            padding: 0.62rem 1rem;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-2));
            border: none;
            box-shadow: 0 10px 24px rgba(47, 111, 237, 0.22);
        }
        .btn-outline-primary {
            border-color: var(--primary);
            color: var(--primary);
        }
        .btn-secondary {
            background: #eef2ff;
            color: #374151;
            border: 0;
        }
        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            border-radius: 10px;
            font-weight: 700;
        }
        .action-btn.icon-only {
            width: 38px;
            height: 38px;
            padding: 0;
        }
        .btn-warning { color: #1f2937; }

        .page-shell { padding: 1.5rem 0 2.25rem; }
        .card {
            border: 1px solid var(--border);
            border-radius: 18px;
            box-shadow: var(--shadow-soft);
            background: var(--surface);
        }
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.25rem;
        }
        .page-header h2 {
            margin: 0;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: var(--secondary);
        }

        .breadcrumb {
            background: rgba(255,255,255,0.8);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 0.7rem 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.03);
        }
        .breadcrumb-item + .breadcrumb-item::before {
            content: "/";
            color: var(--muted);
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1rem;
            margin-bottom: 1.25rem;
        }
        .summary-card {
            background: linear-gradient(180deg, #fff 0%, #f9fbff 100%);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-soft);
            border-radius: 18px;
            padding: 1rem 1.1rem;
            display: flex;
            align-items: center;
            gap: 0.9rem;
        }
        .summary-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--primary-soft);
            color: var(--primary);
            font-size: 1.25rem;
            font-weight: 800;
        }
        .summary-card.success .summary-icon { background: rgba(24,169,87,0.12); color: var(--success); }
        .summary-card.warning .summary-icon { background: rgba(245,158,11,0.12); color: var(--warning); }
        .summary-card.info .summary-icon { background: rgba(14,165,233,0.12); color: var(--info); }
        .summary-card .label {
            color: var(--muted);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
        }
        .summary-card .value {
            font-size: 1.6rem;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -.04em;
        }

        .table {
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid var(--border);
        }
        .table thead th {
            background: #0f172a;
            color: white;
            border-color: #0f172a;
            font-weight: 700;
        }
        .table td, .table th {
            vertical-align: middle;
            padding: 0.9rem 0.8rem;
        }
        .badge {
            border-radius: 999px;
            padding: 0.45rem 0.8rem;
            font-weight: 700;
        }

        .form-panel {
            background: linear-gradient(180deg, #fff 0%, #fbfdff 100%);
            border: 1px solid var(--border);
            border-radius: 20px;
            box-shadow: var(--shadow-soft);
            padding: 1.5rem;
        }
        .field-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
        }
        .form-label {
            font-weight: 700;
            color: var(--secondary);
            margin-bottom: 0.5rem;
        }
        .form-control, .form-select {
            border-radius: 12px;
            border: 1px solid rgba(148, 163, 184, 0.32);
            min-height: 46px;
            padding: 0.75rem 0.9rem;
            box-shadow: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: rgba(47, 111, 237, 0.6);
            box-shadow: 0 0 0 0.2rem rgba(47,111,237,0.12);
        }

        .admin-shell { display: flex; gap: 1.25rem; align-items: flex-start; }
        .admin-sidebar {
            width: 260px;
            flex-shrink: 0;
            background: linear-gradient(180deg, #0f172a 0%, #13233d 100%);
            border-radius: 18px;
            box-shadow: 0 18px 36px rgba(15, 23, 42, 0.12);
            padding: 1rem 0.75rem;
            transition: width 0.25s ease, transform 0.25s ease;
        }
        .admin-sidebar.collapsed { width: 90px; }
        .admin-sidebar .brand {
            color: #fff;
            display: block;
            padding: 0.7rem 0.9rem 1rem;
            font-weight: 800;
            letter-spacing: 0.04em;
        }
        .admin-sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            color: rgba(255,255,255,0.8) !important;
            padding: 0.8rem 0.9rem;
            border-radius: 12px;
            margin-bottom: 0.35rem;
            font-weight: 600;
        }
        .admin-sidebar .nav-link .label { white-space: nowrap; }
        .admin-sidebar.collapsed .nav-link .label,
        .admin-sidebar.collapsed .brand { display: none; }
        .admin-sidebar .nav-link.active, .admin-sidebar .nav-link:hover {
            background: rgba(255,255,255,0.08);
            color: #fff !important;
        }
        .admin-content { flex: 1; min-width: 0; }

        .chart-card { background: linear-gradient(180deg, #fff 0%, #f9fbff 100%); }
        .chart-bars {
            display: flex;
            align-items: end;
            gap: 0.75rem;
            height: 180px;
            padding-top: 1rem;
        }
        .chart-bar-wrap {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: end;
            gap: 0.75rem;
            height: 100%;
        }
        .chart-bar {
            width: 100%;
            max-width: 48px;
            border-radius: 12px 12px 0 0;
            background: linear-gradient(180deg, var(--primary) 0%, var(--purple) 100%);
            min-height: 18px;
            box-shadow: 0 10px 18px rgba(47, 111, 237, 0.16);
        }
        .chart-bar.alt {
            background: linear-gradient(180deg, var(--teal) 0%, #52d2c1 100%);
        }
        .chart-label { font-size: 0.74rem; color: var(--muted); font-weight: 700; }

        .mobile-sidebar-toggle {
            display: none;
        }

        @media (max-width: 991.98px) {
            .admin-shell { display: block; }
            .admin-sidebar {
                width: 100%;
                margin-bottom: 1rem;
                display: none;
            }
            .admin-sidebar.show { display: block; }
            .mobile-sidebar-toggle {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 42px;
                height: 42px;
                border-radius: 12px;
                background: var(--primary-soft);
                color: var(--primary);
                border: 1px solid rgba(47,111,237,0.15);
                margin-right: 0.5rem;
            }
            .field-grid { grid-template-columns: 1fr; }
            .page-header { flex-direction: column; align-items: flex-start; }
            .summary-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 576px) {
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            .table {
                min-width: 760px;
            }
            .form-panel { padding: 1rem; }
            .btn { width: 100%; }
            .action-btn { width: auto; }
            .page-header .d-flex { width: 100%; }
        }
    </style>
</head>
<body>
<?php require __DIR__ . '/navbar.php'; ?>
<main class="page-shell">
    <div class="container">
        <?php if (!empty($breadcrumbs)): ?>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-3">
                    <?php foreach ($breadcrumbs as $index => $crumb): ?>
                        <?php if (!empty($crumb['url']) && $index < count($breadcrumbs) - 1): ?>
                            <li class="breadcrumb-item"><a href="<?= htmlspecialchars($crumb['url'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($crumb['label'], ENT_QUOTES, 'UTF-8') ?></a></li>
                        <?php else: ?>
                            <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($crumb['label'], ENT_QUOTES, 'UTF-8') ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ol>
            </nav>
        <?php endif; ?>
