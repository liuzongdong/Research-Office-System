function addStatus()
{
	var $rejected_element = $( "td:contains('Rejected')" );
	var $approved_element = $( "td:contains('Approved')" );
	var $waiting_element = $( "td:contains('Waiting Approval')" );
  	$rejected_element.addClass('danger');
	$approved_element.addClass('success');
	$waiting_element.addClass('warning');
}
