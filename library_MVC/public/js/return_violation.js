document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('form[data-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!window.confirm(form.getAttribute('data-confirm'))) event.preventDefault();
        });
    });

    var dueDate = document.getElementById('han_tra');
    var condition = document.getElementById('book_condition');
    var bookPrice = document.getElementById('book_price');
    if (!dueDate || !condition || !bookPrice) return;

    function updateEstimate() {
        var due = new Date(dueDate.value + 'T00:00:00');
        var today = new Date();
        today.setHours(0, 0, 0, 0);
        var lateDays = Number.isNaN(due.getTime()) ? 0 : Math.max(0, Math.floor((today - due) / 86400000));
        var fine = lateDays * 2000;
        var compensation = condition.value === 'NGUYEN_VEN' ? 0 : Math.max(0, Number(bookPrice.value) || 0) + 30000;
        var format = function (amount) { return new Intl.NumberFormat('vi-VN').format(amount) + ' VNĐ'; };
        var daysElement = document.getElementById('txtOverdueDays');
        var fineElement = document.getElementById('txtFineOverdue');
        var compensationElement = document.getElementById('txtCompensation');
        var totalElement = document.getElementById('txtTotalPenalty');
        if (daysElement) daysElement.textContent = String(lateDays);
        if (fineElement) fineElement.textContent = format(fine);
        if (compensationElement) compensationElement.textContent = format(compensation);
        if (totalElement) totalElement.textContent = format(fine + compensation);
    }

    [dueDate, condition, bookPrice].forEach(function (element) {
        element.addEventListener('input', updateEstimate);
        element.addEventListener('change', updateEstimate);
    });
    updateEstimate();
});