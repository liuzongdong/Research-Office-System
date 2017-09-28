function findPDF()
{
	var links = document.getElementsByTagName('a');
	// Do this selection based on table
	var arr = [];
	for(var count = 0; count <links.length; count++)
	{

		var url = links[count].getAttribute('href');
		if(url && url.endsWith('.pdf'))
		{
			arr.push(url);
		}
	}
	//JSON.stringify(arr);
	elements = JSON.stringify(arr);
	post('downloadall.php', {elements: elements})
}

function post(path, params, method) {
    method = method || "post"; // Set method to post by default if not specified.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
         }
    }

    document.body.appendChild(form);
    form.submit();
}
