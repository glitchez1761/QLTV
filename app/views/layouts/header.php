<?php
$pageTitle = $pageTitle ?? 'QLTV';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> | QLTV</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/library_MVC/public/css/bootstrap.min.css">
    <style>
        body { background: #f4f7fb; }
        .navbar-brand { letter-spacing: 0.04em; }
        .card { border: 0; border-radius: 14px; box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06); }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; }
        .page-header h2 { margin: 0; font-weight: 700; }
    </style>
</head>
<body>
<?php require __DIR__ . '/navbar.php'; ?>
<main class="container py-4">
