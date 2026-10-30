    </div>
</main>
<footer class="border-top bg-white mt-5">
    <div class="container py-3 text-center text-secondary small">
        QLTV © <?= date('Y') ?> · Hệ thống quản lý thư viện
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.querySelector('.admin-sidebar');
        const toggleBtn = document.querySelector('.mobile-sidebar-toggle');
        if (sidebar && toggleBtn) {
            toggleBtn.addEventListener('click', function () {
                sidebar.classList.toggle('show');
            });
        }
    });
</script>
</body>
</html>
