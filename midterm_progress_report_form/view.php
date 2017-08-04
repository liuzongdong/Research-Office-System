<?php
	session_start();
	require("../base.php");
	if (!(isset($_SESSION["staff"]) && $_SESSION["staff"] === true))
	{
		echo '<script type="text/javascript">alert("Please Login");location.href="../../login.html"</script>';
	}
	$dbh = new PDO($dbinfo,$dbusername,$dbpassword);
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$sql = "select * from midterm_report where midterm_report_id = ?";
	$prepare = $dbh -> prepare($sql); // Statement is Statement.
	$execute = $prepare -> execute(array($_GET['id']));
	if ($execute)
	{
		$data = $prepare -> fetch(PDO::FETCH_ASSOC);
	}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View UIC Project</title>
<?php importFullCss(); ?>
</head>
<body>
<div id="panelwrap">

	<div class="header">
    <div class="title"><a href="/"><img src="/uic_logo.png"></img></a></div>

    <div class="header_right">Welcome <?php echo $_SESSION['english_name']; ?><a href="#" onclick="logout()" class="logout">Logout</a> </div>

    <div class="menu">
    	<ul>
			<li><a href="/">Dashboard</a></li>
    		<li><a href="/uic_project" class="selected">UIC Project</a></li>
    		<li><a href="/external_project">External Project</a></li>
    		<li><a href="/journal">Publication</a></li>
    		<li><a href="/patent">Achievements</a></li>
    		<li><a href="/applications">Applications</a></li>
    	</ul>
    </div>

    </div>

    <div class="submenu">
    <ul>
		<li><a href="/uic_project" >Category I - III</a></li>
  	  <li><a href="/iv_project">Category IV</a></li>
  	  <li><a href="/project_undertaking">UIC Project Budget & Project Undertaking</a></li>
  	  <li><a href="/midterm_progress_report_form" class="selected">Midterm Progress Report Form</a></li>
  	  <li><a href="/completion_report_form">Completion Report Form</a></li>
    </ul>
    </div>

    <div>

		<div class="row">
			<div class="col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						View UIC Project(midterm Progress Report Form)
					</div>
					<div class="panel-body">
						<div class="col-xs-6">
							<form id="data" role="form" method="post">
                <div class="form-group">
                  <label>Title:</label>
                  <input disabled class="form-control" name="midterm_progress_report_form_title" required="require"value="<?php echo $data['midterm_progress_report_form_title']; ?>">
                </div>
              </br>
                  <div class="form-group">
					  <table id="table" data-toggle="table">
						  <thead>
						  <tr>
							  <th data-halign="center" data-align="center">Research Team</th>
							  <th data-halign="center" data-align="center">Name/Post</th>
							  <th data-halign="center" data-align="center">Academic Unit</th>
						  </tr>
						  </thead>
						  <tbody>
							  <tr>
								  <td>Principal Investigator</td>
								  <td> <input disabled class="form-control" name="mp_principal_investigator_name" required="require" value="<?php echo $data['mp_principal_investigator_name']; ?>"></td>
								  <td> <input disabled class="form-control" name="mp_principal_investigator_unit" required="require" value="<?php echo $data['mp_principal_investigator_unit']; ?>"></td>
							  </tr>
							  <tr>
								  <td>Co-investigator(s)</td>
								  <td> <input disabled class="form-control" name="mp_co_investigator_name" required="require" value="<?php echo $data['mp_co_investigator_name']; ?>"></td>
								  <td> <input disabled class="form-control" name="mp_co_investigator_unit" required="require" value="<?php echo $data['mp_co_investigator_unit']; ?>"></td>
							  </tr>
							  <tr>
								  <td>Others</td>
								  <td> <input disabled class="form-control" name="mp_others_name" required="require" value="<?php echo $data['mp_others_name']; ?>"></td>
								  <td> <input disabled class="form-control" name="mp_others_unit" required="require" value="<?php echo $data['mp_others_unit']; ?>"></td>
							  </tr>
						  </tbody>
					  </table>
                </div>

                <div class="form-group">
                  <label>Project Starting Date:</label>
                          <div class='input-group date' id='datetimepicker1'>
                              <input disabled id="startDate" name="midterm_progress_report_form_project_starting_date" type='text' required="require" readonly class="form-control">
                              <span class="input-group-addon">
                                  <span class="glyphicon glyphicon-calendar"></span>
                              </span>
                          </div>
                </div>

                <div class="form-group">
                  <label>Project Completion Date:</label>
                          <div class='input-group date' id='datetimepicker2'>
                              <input disabled id="endDate" name="midterm_progress_report_form_project_completion_date" type='text' required="require" readonly class="form-control">
                              <span class="input-group-addon">
                                  <span class="glyphicon glyphicon-calendar"></span>
                              </span>
                          </div>
                </div>

                <div class="form-group">
                  <label>Duration (Please input Manually):</label>
                  <input disabled id="duration" class="form-control" name="midterm_progress_report_form_duration" required="require" value="<?php echo $data['midterm_progress_report_form_duration']; ?>">
                </div>

				</div>
				<div class="col-xs-6" id="pdf" style="padding-top:20px;">
					<object data='<?php echo "upload/".$data['midterm_report_file']; ?>'
						type='application/pdf'
						width='100%'
						height='500px'>
							<p>This browser does not support inline PDFs. Please download the PDF to view it: <a href="helloworld">Download PDF</a></p>
					</object>
				</div>
						</form>
					</div>
				</div>
			</div><!-- /.col-->
		</div><!-- /.row -->
		<div class="clear"></div>
		<div class="footer">©2017 United International College(UIC). All Rights Reserved.</div>

    </div> <!--end of center_content-->

</div>
<script type="text/javascript">
            $(function () {
                $('#datetimepicker1').datetimepicker({
					useCurrent: false,
                    format: 'YYYY/MM/DD',
					defaultDate: moment('<?php echo $data['midterm_progress_report_form_project_starting_date']; ?>', 'YYYY-MM-DD'),
					showTodayButton: true,
					showClear: true,
					ignoreReadonly: true
                });
				$('#datetimepicker2').datetimepicker({
					useCurrent: false,
                    format: 'YYYY/MM/DD',
					defaultDate: moment('<?php echo $data['midterm_progress_report_form_project_completion_date']; ?>', 'YYYY-MM-DD'),
					showTodayButton: true,
					showClear: true,
					ignoreReadonly: true
                });
            });
</script>
<script>
$("form#data").submit(function(id){
var formData = new FormData(this);
formData.append("id", <?php echo $_GET['id'];?>);
	$.ajax({
	url: "modify.php",
	type: 'POST',
	data: formData,
	async: false,

	success: function (response)
	{
		var answer = JSON.parse(response);
		switch ( answer.status_response )
		{
			case 'success' :
				swal(
					{
					title:"Good job!",
					text: "Edit Succeed!",
					type: "success"
					},
					function()
					{
						setTimeout(function (){
							window.location.href = "index";
						}, 300);

					});
				break;
			case 'empty' :
				swal("Edit Failed!", "Please Complete the Form or There is only Spaces in your submission", "error");
				break;
			case 'error' :
				swal("Edit Failed!", "Please upload a PDF file, PDF File only!", "error");
				break;
			case 'fail' :
				swal("Edit Failed!", "Please check your internet connection!", "error");
				break;

		}
	},
	error: function (xhr, ajaxOptions, thrownError)
	{
		swal("Edit Failed!", "Please check your internet connection.", "error");
	},
	cache: false,
	contentType: false,
	processData: false
});

return false;
});
</script>


</body>
</html>
