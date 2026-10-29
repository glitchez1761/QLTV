document.addEventListener('DOMContentLoaded', function () {
    var typeSelect = document.querySelector('[name="doi_tuong_dang_ky"]');
    var guardianFields = document.querySelector('[data-guardian-fields]');
    var guardianName = document.querySelector('[name="guardian_name"]');
    var guardianPhone = document.querySelector('[name="guardian_phone"]');

    function syncGuardianFields() {
        if (!typeSelect || !guardianFields) return;
        var required = typeSelect.value === 'TRE_EM';
        guardianFields.hidden = !required;
        if (guardianName) guardianName.required = required;
        if (guardianPhone) guardianPhone.required = required;
    }

    if (typeSelect) {
        typeSelect.addEventListener('change', syncGuardianFields);
        syncGuardianFields();
    }

    document.querySelectorAll('form[data-validate-form]').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            var password = form.querySelector('[name="new_password"]');
            var confirmation = form.querySelector('[name="confirm_password"]');
            if (password && confirmation && password.value !== confirmation.value) {
                event.preventDefault();
                confirmation.setCustomValidity('Mật khẩu xác nhận không khớp.');
                confirmation.reportValidity();
                confirmation.setCustomValidity('');
            }
        });
    });
});