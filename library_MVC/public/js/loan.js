document.addEventListener('DOMContentLoaded', function () {
    var container = document.getElementById('bookInputsContainer');
    var addButton = document.getElementById('btnAddBookRow');
    if (!container || !addButton) return;

    function refreshRows() {
        var rows = container.querySelectorAll('.book-input-row');
        rows.forEach(function (row, index) {
            var label = row.querySelector('.input-group-text');
            var remove = row.querySelector('.btn-remove-row');
            if (label) label.textContent = '#' + (index + 1);
            if (remove) remove.style.display = rows.length > 1 ? '' : 'none';
        });
    }

    addButton.addEventListener('click', function () {
        var first = container.querySelector('.book-input-row');
        if (!first) return;
        var row = first.cloneNode(true);
        var input = row.querySelector('.book-code-input');
        if (input) input.value = '';
        container.appendChild(row);
        refreshRows();
        if (input) input.focus();
    });

    container.addEventListener('click', function (event) {
        if (!event.target.classList.contains('btn-remove-row')) return;
        var rows = container.querySelectorAll('.book-input-row');
        if (rows.length > 1) event.target.closest('.book-input-row').remove();
        refreshRows();
    });

    var form = document.getElementById('loanForm');
    if (form) {
        form.addEventListener('submit', function (event) {
            var inputs = Array.prototype.slice.call(form.querySelectorAll('.book-code-input'));
            var codes = inputs.map(function (input) { return input.value.trim().toLowerCase(); });
            if (codes.some(function (code, index) { return code && codes.indexOf(code) !== index; })) {
                event.preventDefault();
                window.alert('Mã tài liệu bị trùng. Vui lòng kiểm tra lại.');
            }
        });
    }
    refreshRows();
});