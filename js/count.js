function getCount()
{
	$.get( "/count.php", function( data )
	{
	  $('#uic_project').html(data);
	});
}
