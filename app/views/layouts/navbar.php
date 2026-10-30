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
            --primary-soft: #eaf1ff;
            --secondary: #1f2937;
            --muted: #6b7280;
            --border: rgba(148, 163, 184, 0.24);
            --surface: #ffffff;
            --bg: #f3f6fb;
            --success: #18a957;
            --warning: #f59e0b;
            --danger: #dc3545;
        }

        * { box-sizing: border-box; }
        body {
            background: linear-gradient(180deg, #edf3ff 0%, #f5f7fb 18%, #f7f9fc 100%);
            color: var(--secondary);
            font-family: Arial, Helvetica, sans-serif;
        }
        a { text-decoration: none; }
        .navbar {
            background: linear-gradient(90deg, #0d1b2a 0%, #102847 100%) !important;
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
            padding: 0.6rem 1rem;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), #4d7ef7);
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
        .page-shell {
            padding: 1.5rem 0 2rem;
        }
        .card {
            border: 1px solid var(--border);
            border-radius: 18px;
            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.05);
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
        .admin-shell {
            display: flex;
            gap: 1.25rem;
            align-items: flex-start;
        }
        .admin-sidebar {
            width: 260px;
            flex-shrink: 0;
            background: linear-gradient(180deg, #0f172a 0%, #13233d 100%);
            border-radius: 18px;
            box-shadow: 0 18px 36px rgba(15, 23, 42, 0.12);
            padding: 1rem 0.75rem;
        }
        .admin-sidebar .brand {
            color: #fff;
            display: block;
            padding: 0.7rem 0.9rem 1rem;
            font-weight: 800;
            letter-spacing: 0.04em;
        }
        .admin-sidebar .nav-link {
            display: block;
            color: rgba(255,255,255,0.8) !important;
            padding: 0.75rem 0.9rem;
            border-radius: 12px;
            margin-bottom: 0.35rem;
            font-weight: 600;
        }
        .admin-sidebar .nav-link.active, .admin-sidebar .nav-link:hover {
            background: rgba(255,255,255,0.08);
            color: #fff !important;
        }
        .admin-content {
            flex: 1;
            min-width: 0;
        }
        .stats-card {
            border: 1px solid var(--border);
            background: linear-gradient(180deg, #fff 0%, #f8fbff 100%);
            border-radius: 18px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
            height: 100%;
        }
        .stats-card .card-body {
            padding: 1.25rem;
        }
        .stats-label {
            color: var(--muted);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
        }
        .stats-value {
            font-size: clamp(1.8rem, 3vw, 2.5rem);
            font-weight: 800;
            letter-spacing: -0.04em;
        }
        @media (max-width: 991.98px) {
            .admin-shell { display: block; }
            .admin-sidebar { width: 100%; margin-bottom: 1rem; }
            .page-header { flex-direction: column; align-items: flex-start; }
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
