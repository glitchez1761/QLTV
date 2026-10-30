<?php
$currentController = $_GET['controller'] ?? 'home';
$navItems = [
    ['id' => 'home', 'label' => 'Trang chủ', 'url' => BASE_URL . '/public/index.php?controller=home&action=index'],
    ['id' => 'sach', 'label' => 'Sách', 'url' => BASE_URL . '/public/index.php?controller=sach&action=index'],
    ['id' => 'docgia', 'label' => 'Độc giả', 'url' => BASE_URL . '/public/index.php?controller=docgia&action=index'],
    ['id' => 'loan', 'label' => 'Mượn trả', 'url' => BASE_URL . '/public/index.php?controller=loan&action=index'],
    ['id' => 'admin', 'label' => 'Quản trị', 'url' => BASE_URL . '/public/index.php?controller=admin&action=dashboard'],
];
?>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= BASE_URL ?>/public/index.php?controller=home&action=index">QLTV</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php foreach ($navItems as $item): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $currentController === $item['id'] ? 'active' : '' ?>" href="<?= htmlspecialchars($item['url'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php if (isset($_SESSION['user'])): ?>
                <a class="btn btn-outline-light btn-sm" href="<?= BASE_URL ?>/public/index.php?controller=auth&action=logout">Đăng xuất</a>
            <?php else: ?>
                <a class="btn btn-outline-light btn-sm" href="<?= BASE_URL ?>/public/index.php?controller=auth&action=login">Đăng nhập</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
