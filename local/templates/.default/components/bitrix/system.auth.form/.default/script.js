$(document).on('click', '#auth_review .checkbox label', function() {
	$(this).addClass('checked');
	$(this).closest('.checkbox').find('input').attr('checked', '');
	return false;
});
$(document).on('click', '#auth_review .checkbox label.checked', function() {
	$(this).removeClass('checked');
	$(this).closest('.checkbox').find('input').removeAttr('checked', '');
	return false;
});

$(document).ready(function () {

    //обработчик форм
    $(function () {
        $(document).on('submit', "#auth_comment", function () {
            var _this = $(this);
            var input = _this.serialize();

            var login = document.querySelector('#auth_comment [name="USER_LOGIN"]').value;
            var pass = document.querySelector('#auth_comment [name="USER_PASSWORD"]').value;
            var SiteDir = document.querySelector('#auth_comment [name="SITE_DIR"]').value;
            $.ajax({
                type: 'POST',
                url: SiteDir + 'bitrix/components/sotbit/reviews.anonymregister/ajax/registration.php',
                data: input,
                success: function (data) {
                    document.getElementById('auth_comment').reset();

                    document.querySelector('#auth_comment .anonym_registration_error').style.display = 'block';
                    document.querySelector('#auth_comment .anonym_registration_error').innerText = data;

                },
                error: function (jqXHR, exception) {
                }
            });
        });
    });
});
