function sendForm(sid, color, prefix) {
    let form = $('#form_' + sid).parent().parent().parent();

    if (form.find("input[name='personal']").is(':checked')) {
        form.find('input#submit_' + sid).trigger('click');
    } else {
        let checked = document.querySelector('#personal_checked'+prefix);
        if (!checked.classList.contains('conf_unchecked')) {
            $('#personal_checked'+prefix).toggleClass('conf_unchecked');
        }
    }
}
