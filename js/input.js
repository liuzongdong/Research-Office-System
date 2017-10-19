function ForbidInput()
{
	$('input').on('keypress', function (e) {
	    if (/^[a-zA-Z0-9\.\ \-\(\)\:\b]+$/.test(String.fromCharCode(e.keyCode))) {
	        return;
	    } else {
	        e.preventDefault();
	    }
	});
}
