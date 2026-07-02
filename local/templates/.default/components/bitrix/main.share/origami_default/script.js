function ShowShareDialog(counter)
{
	var div = document.getElementById("share-dialog"+counter);
	if (!div)
		return;

	if (div.style.display == "block")
	{
		div.style.display = "none";
	}
	else
	{
		div.style.display = "block";
	}
	return false;
}

function CloseShareDialog(counter)
{
	var div = document.getElementById("share-dialog"+counter);

	if (!div)
		return;

	div.style.display = "none";
	return false;
}

function __function_exists(function_name)
{
	if (typeof function_name == 'string')
	{
		return (typeof window[function_name] == 'function');
	}
	else
	{
		return (function_name instanceof Function);
	}
}

function CenterShareDialog()
{
    const dualScreenLeft = window.screenLeft !==  undefined ? window.screenLeft : window.screenX;
    const dualScreenTop = window.screenTop !==  undefined   ? window.screenTop  : window.screenY;

    const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    const systemZoom = width / window.screen.availWidth;
    const left = (width - 626) / 2 / systemZoom + dualScreenLeft;
    const top = (height - 436) / 2 / systemZoom + dualScreenTop;

    return 'toolbar=0,status=0,width='+626 / systemZoom+',height='+436 / systemZoom+',top='+top+',left='+left;
}

