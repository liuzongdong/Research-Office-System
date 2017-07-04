<?php
	session_start();
	require("../base.php");
    if (!(isset($_SESSION["teacher"]) && $_SESSION["teacher"] === true))
    {
		echo '<script type="text/javascript">alert("Please Login");location.href="../../login.html"</script>';
    }
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>UIC Project</title>

<?php importFullCss(); ?>


</head>
<body>
<div id="panelwrap">

	<div class="header">
    <div class="title"><a href="#"><img src="/uic_logo.png"></img></a></div>

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
		<li><a href="">UIC Project Budget & Project Undertaking</a></li>
		<li><a href="/midtern_progress_report_form" class="selected">Midtern Progress Report Form</a></li>
		<li><a href="/completion_report_form">Completion Report Form</a></li>
    </ul>
    </div>

    <div>
	</br>


	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">New UIC Porject（Midtern Progress Report Form）
					<div style="float:right">
						<label for="submitForm" class="btn btn-primary"> Submit </label>
						<label for="resetForm" class="btn btn-default"> Reset </label>
					</div>
				</div>
				<div class="panel-body">
					<div class="col-xs-12">
						<form role="form" id="data" method="post" enctype="multipart/form-data">
							<div class="form-group">
								<label>File Download:</label>
							</br>
								<a href="files/#.docx" class="btn btn-default">
									<span class="glyphicon glyphicon-download-alt"></span>
									Download Application Form Here
								</a>
							</div>

							<div class="form-group">
								<label>Title:</label>
								<input class="form-control" name="midtern_progress_report_form_title" required="require">
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
												<td> <input class="form-control" name="mp_principal_investigator_name" required="require"></td>
												<td> <input class="form-control" name="mp_principal_investigator_unit" required="require"></td>
											</tr>
											<tr>
												<td>Co-investigator(s)</td>
												<td> <input class="form-control" name="mp_co_investigator_name" required="require"></td>
												<td> <input class="form-control" name="mp_co_investigator_unit" required="require"></td>
											</tr>
											<tr>
												<td>Others</td>
												<td> <input class="form-control" name="mp_others_name" required="require"></td>
												<td> <input class="form-control" name="mp_others_unit" required="require"></td>
											</tr>
										</tbody>
									</table>
							</div>
							<div class="form-group">
								<label>Project Starting Date:</label>
								<div class='input-group date' id='datetimepicker1'>
										<input id="startDate" name="midtern_progress_report_form_project_starting_date" type='text' required="require" readonly class="form-control"/>
										<span class="input-group-addon">
												<span class="glyphicon glyphicon-calendar"></span>
										</span>
								</div>
							</div>

							<div class="form-group">
								<label>Project Completion Date:</label>
								<div class='input-group date' id='datetimepicker2'>
										<input id="endDate" name="midtern_progress_report_form_project_completion_date" type='text' required="require" readonly class="form-control"/>
										<span class="input-group-addon">
												<span class="glyphicon glyphicon-calendar"></span>
										</span>
								</div>
							</div>

							<div class="form-group">
								<label>Duration:</label>
								<input id="duration" class="form-control" name="midtern_progress_report_form_duration" required="require" readonly>
							</div>

							<div class="form-group">
								<label>Please Upload File Here</label>
							</br>
								<input type="file" name="file" class="filestyle" data-buttonText="&nbsp Upload" accept="application/pdf" required="require">
							</div>

							<div class="form-group" style="text-align:center">
													<button id="submitForm" type="submit" class="btn btn-primary hidden">Submit Button</button>
													<button id="resetForm" type="reset" class="btn btn-default hidden">Reset Button</button>
												</div>

						</div>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->

	<div class="clear"></div>
    </div> <!--end of center_content-->
	<div class="footer">©2017 United International College(UIC). All Rights Reserved.</div>
</div>

<script>

	function getDuration()
	{
		var startDate = $("#datetimepicker1").data("DateTimePicker").date();
		var endDate = $("#datetimepicker2").data("DateTimePicker").date();
		return ((moment.duration(endDate - startDate)).humanize());
	}
</script>

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
			$("#datetimepicker1").on("dp.change", function (e) {
            $('#datetimepicker2').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker2").on("dp.change", function (e) {
            $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
			$('#duration').val(getDuration());
        });
</script>

<script>
function confirmDelete(id) {
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this record!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    }, function (isConfirm) {
        if (!isConfirm) return;
        $.ajax({
            url: "delete.php",
            type: "POST",
            data: {
                id: id
            },
            dataType: "html",
            success: function (response)
			{
				var answer = JSON.parse(response);
				switch ( answer.status_response )
				{
					case 'success':
						swal("Done!", "It was succesfully deleted!", "success");
						$('#table').bootstrapTable('refresh', {silent: true});
						break;
					case 'error' :
						swal("Delete Failed!", "You are not allowed to Delete it", "error");
						break;
					case 'fail' :
						swal("Delete Failed!", "Please check your internet connection!", "error");
						break;
				}

            },
            error: function (xhr, ajaxOptions, thrownError)
			{
                swal("Delete Failed!", "Please check your internet connection.", "error");
            }
        });
    });
}
</script>


</body>
</html>
