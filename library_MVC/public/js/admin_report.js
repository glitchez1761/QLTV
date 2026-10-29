document.addEventListener('DOMContentLoaded', function () {
    var form = document.querySelector('form[action$="/admin/reports/generate"]');
    if (!form) return;
    var from = form.querySelector('[name="from_date"]');
    var to = form.querySelector('[name="to_date"]');
    if (!from || !to) return;

    from.addEventListener('change', function () {
        to.min = from.value;
        if (to.value && to.value < from.value) to.value = from.value;
    });
    form.addEventListener('submit', function (event) {
        if (from.value && to.value && from.value > to.value) {
            event.preventDefault();
            to.setCustomValidity('Ngày kết thúc phải bằng hoặc sau ngày bắt đầu.');
            to.reportValidity();
            to.setCustomValidity('');
        }
    });
});