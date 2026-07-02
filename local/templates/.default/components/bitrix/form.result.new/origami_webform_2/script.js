function sendForm(sid, color)
{
	if ($("form[name='" + sid + "'] input[name='personal']").is(':checked'))
	{
		$("form[name='" + sid + "'] input[type='submit']").trigger('click');
	}
	else
	{
        let checked = document.querySelector('#personal_phone_personal_checked');
        if(!checked.classList.contains('conf_unchecked')){
            $('#personal_phone_personal_checked').toggleClass('conf_unchecked');
        }
	}
}
