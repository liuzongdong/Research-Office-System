<?php
	session_start();
	require("../base.php");
	if (!(isset($_SESSION["teacher"]) && $_SESSION["teacher"] === true))
	{
		echo '<script type="text/javascript">alert("Please Login");location.href="../../login.html"</script>';
	}
	$dbh = new PDO($dbinfo,$dbusername,$dbpassword);
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$sql = "select * from uic_project where up_id = ?";
	$prepare = $dbh -> prepare($sql);
	$execute = $prepare -> execute(array($_GET['id']));
	if ($execute)
	{
		$data = $prepare -> fetch(PDO::FETCH_ASSOC);
		if ($data['up_user_id'] != $_SESSION['user_id'])
		{
			echo '<script type="text/javascript">alert("You are not allow to Edit it!");location.href="index.php"</script>';
		}
	}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit UIC Project</title>
<?php importCss(); ?>
</head>
<body>
<div id="panelwrap">

	<div class="header">
    <div class="title"><a href="#"><img src="../uic_logo.png"></img></a></div>

    <div class="header_right">Welcome <?php echo $_SESSION['english_name']; ?>,  <a href="#" onclick="logout()" class="logout">Logout</a> </div>

    <div class="menu">
    	<ul>
			<li><a href="/">Dashboard</a></li>
    		<li><a href="/profile">Profile</a></li>
    		<li><a href="/uic_project" class="selected">UIC Project</a></li>
    		<li><a href="/external_project">External Project</a></li>
    		<li><a href="/journal">Publication</a></li>
    		<li><a href="/patent">Achievements</a></li>
    		<li><a href="/applications">Applications</a></li>
			<?php if ($_SESSION['user_type'] == 2)
			{
				$dbh = new PDO($dbinfo,$dbusername,$dbpassword);
		        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //Disable Prepared Statements, in case of SQL Injection.
				$sql = "select * from application, user where application.app_user_id = user.user_id AND user.programme = ? and approval = 0"; // *, select all. '?' and '?', SQL Injection
		        $prepare = $dbh -> prepare($sql); // Statement is Statement.
		        $execute = $prepare -> execute(array($_SESSION["programme"])); // Var is Var.
		        if ($execute)
		        {
					$row = $prepare -> fetchall(PDO::FETCH_ASSOC);
					$rowCount = count($row);
				}
				echo "<li><a href=\"/approval\">Waiting Approval (".$rowCount.")</a></li>";
			}
			?>
    	</ul>
    </div>

    </div>

    <div class="submenu">
    <ul>
		<li><a href="/uic_project" >Category I - III</a></li>
  		<li><a href="/iv_project">Category IV</a></li>
  		<li><a href="/project_undertaking">UIC Project Budget & Project Undertaking</a></li>
  		<li><a href="/midtern_progress_report_form" >Midtern Progress Report Form</a></li>
  		<li><a href="/completion_report_form" class="selected">Completion Report Form</a></li>
    </ul>
    </div>

    <div>

		<div class="row">
			<div class="col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						Edit UIC Project(Midtern Progress Report Form)
						<div style="float:right">
						    <label for="submitForm" class="btn btn-primary"> Submit </label>
						    <label for="resetForm" class="btn btn-default"> Reset </label>
						</div>
					</div>
					<div class="panel-body">
						<div class="col-xs-6">
							<form id="data" role="form" method="post">
                <div class="form-group">
                  <label>Title:</label>
                  <input class="form-control" name="midtern_progress_report_form_title" required="require"value="<?php echo $data['midtern_progress_report_form_title']; ?>">
                </div>
              </br>
                  <div class="form-group">
                  <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th> Research Team</th>
                      <th> Name/Post</th>
                      <th> Academic Unit</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Principal Investigator</td>
                      <td> <input class="form-control" name="mp_principal_investigator_name" required="require" value="<?php echo $data['mp_principal_investigator_name']; ?>"></td>
                      <td> <input class="form-control" name="mp_principal_investigator_unit" required="require" value="<?php echo $data['mp_principal_investigator_unit']; ?>"></td>
                    </tr>
                    <tr>
                      <td>Co-investigator(s)</td>
                      <td> <input class="form-control" name="mp_co_investigator_name" required="require" value="<?php echo $data['mp_co_investigator_name']; ?>"></td>
                      <td> <input class="form-control" name="mp_co_investigator_unit" required="require" value="<?php echo $data['mp_co_investigator_unit']; ?>"></td>
                    </tr>
                    <tr>
                      <td>Others</td>
                      <td> <input class="form-control" name="mp_others_name" required="require" value="<?php echo $data['mp_others_name']; ?>"></td>
                      <td> <input class="form-control" name="mp_others_unit" required="require" value="<?php echo $data['mp_others_unit']; ?>"></td>
                    </tr>
                  </body>
                </table>
                </div>

                <div class="form-group">
                  <label>Project Starting Date:</label>
                          <div class='input-group date' id='datetimepicker1'>
                              <input name="midtern_progress_report_form_project_starting_date" type='text' required="require" readonly class="form-control"/ value="<?php echo $data['midtern_progress_report_form_project_starting_date']; ?>">
                              <span class="input-group-addon">
                                  <span class="glyphicon glyphicon-calendar"></span>
                              </span>
                          </div>
                </div>

                <div class="form-group">
                  <label>Project Completion Date:</label>
                          <div class='input-group date' id='datetimepicker2'>
                              <input name="midtern_progress_report_form_project_completion_date" type='text' required="require" readonly class="form-control"/ value="<?php echo $data['midtern_progress_report_form_project_completion_date']; ?>">
                              <span class="input-group-addon">
                                  <span class="glyphicon glyphicon-calendar"></span>
                              </span>
                          </div>
                </div>

                <div class="form-group">
                  <label>Duration (In Month):</label>
                  <input class="form-control" name="midtern_progress_report_form_duration" required="require" value="<?php echo $data['midtern_progress_report_form_duration']; ?>">
                </div>

                <div class="form-group">
                  <label>Please Upload File Here if any. (PDF Only!)</label>
                </br>
                  <input class="filestyle" data-buttonText="&nbsp Upload" type="file" name="file">
                </div>

								<button id="submitForm" type="submit" class="btn btn-primary hidden">Submit Button</button>
								<button id="resetForm" type="reset" class="btn btn-default hidden">Reset Button</button>
							</div>
							<div class="col-xs-6" id="pdf" style="padding-top:20px;">
								<object data='<?php echo "upload/".$data['up_file']; ?>'
        							type='application/pdf'
        							width='100%'
        							height='250px'>
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
                    format: 'YYYY/MM/DD',
					showTodayButton: true,
					showClear: true,
					ignoreReadonly: true
                });
				$('#datetimepicker2').datetimepicker({
                    format: 'YYYY/MM/DD',
					useCurrent: false,
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
