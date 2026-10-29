document.addEventListener('DOMContentLoaded', function () {
    var searchForm = document.querySelector('form[data-card-search]');
    if (searchForm) {
        searchForm.addEventListener('submit', function (event) {
            var fields = searchForm.querySelectorAll('input[type="search"], input[name="keyword"]');
            fields.forEach(function (field) { field.value = field.value.trim(); });
        });
    }

    document.querySelectorAll('[data-renew-card]').forEach(function (button) {
        button.addEventListener('click', function (event) {
            if (!window.confirm('Gia hạn thẻ này thêm một năm?')) event.preventDefault();
        });
    });
});