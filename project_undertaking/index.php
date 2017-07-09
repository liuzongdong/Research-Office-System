<?php
	session_start();
	require("../base.php");
	if (!(isset($_SESSION["teacher"]) && $_SESSION["teacher"] === true))
	{
		echo '<script type="text/javascript">alert("Please Login");location.href="../login.html"</script>';
	}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>UIC Project Budget & Project Undertaking</title>
<?php importCss(); ?>
</head>
<body>
<div id="panelwrap">

	<div class="header">
    <div class="title"><a href="#"><img src="/uic_logo.png"></img></a></div>

    <div class="header_right">Welcome <?php echo $_SESSION['english_name']. " ". $_SESSION['last_name']; ?><a href="#" onclick="logout()" class="logout">Logout</a> </div>

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
					$data = $prepare -> fetchall(PDO::FETCH_ASSOC);
					$rowCount = count($data);
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
			<li><a href="/project_undertaking"  class="selected">UIC Project Budget & Project Undertaking</a></li>
			<li><a href="/midterm_progress_report_form" >Midterm Progress Report Form</a></li>
			<li><a href="/completion_report_form">Completion Report Form</a></li>
    </ul>
    </div>

    <div>

		<div class="row">
			<div class="col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">UIC Project Budget & Project Undertaking
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
									<a href="files/UIC-Project budget-formEn.xls" class="btn btn-default">
										<span class="glyphicon glyphicon-download-alt"></span>
										Download UIC Project Budget Form
									</a>
									<a href="files/UICRG-Project Undertaking Form.doc" class="btn btn-default">
										<span class="glyphicon glyphicon-download-alt"></span>
										Download Project Undertaking Form
									</a>
								</div>

								<div class="form-group">
									<label>Project Type:</label>
									<select class="dropdown" name="type">
										<option value = "UIC Project Budget"> UIC Project Budget </option>
										<option value = "Project Undertaking"> Project Undertaking </option>
									</select>
								</div>

								<div class="form-group">
									<label>Title:</label>
									<input class="form-control" name="title" required="require">
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
		<div class="footer">©2017 United International College(UIC). All Rights Reserved.</div>


    </div> <!--end of center_content-->

</div>
<script>
$("form#data").submit(function(){
var formData = new FormData(this);
	$.ajax({
	url: "add.php",
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
					text: "Apply Succeed!",
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
				swal("Apply Failed!", "1. Please Complete the Form. \n 2. There is only spaces in your submission.", "error");
				break;
			case 'error' :
				swal("Apply Failed!", "Please upload a PDF file, PDF File only!", "error");
				break;
			case 'fail' :
				swal("Apply Failed!", "Please check your internet connection!", "error");
				break;

		}
	},
	error: function (xhr, ajaxOptions, thrownError)
	{
		swal("Apply Failed!", "Please check your internet connection!", "error");
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
