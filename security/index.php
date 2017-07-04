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
<title>Profile</title>
<?php importCss(); ?>
</head>
<body>
<div id="panelwrap">

	<div class="header">
    <div class="title"><a href="../index.php"><img src="../uic_logo.png"></img></a></div>

    <div class="header_right">Welcome <?php echo $_SESSION['english_name']; ?>,  <a href="#" onclick="logout()" class="logout">Logout</a> </div>

    <div class="menu">
    	<ul>
    		<li><a href="/">Dashboard</a></li>
    		<li><a href="/profile" class="selected">Profile</a></li>
    		<li><a href="/uic_project">UIC Project</a></li>
    		<li><a href="/external_project">External Project</a></li>
    		<li><a href="/journal">Publication</a></li>
    		<li><a href="/patent">Achievements</a></li>
    		<li><a href="/applications">Applications</a></li>
			<?php if ($_SESSION['user_type'] == 2)
			{
				$dbh = new PDO($dbinfo,$dbusername,$dbpassword);
				$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //Disable Prepared Statements, in case of SQL Injection.
				$sql1 = "select * from application, user where application.app_user_id = user.user_id AND user.programme = ? and approval = 0"; // *, select all. '?' and '?', SQL Injection
				$prepare = $dbh -> prepare($sql1); // Statement is Statement.
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
    <li><a href="/profile">Profile</a></li>
	<li><a href="/security" class="selected">Change Password</a></li>
    </ul>
    </div>

    <div>

		<div class="row">
			<div class="col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">Change Password
						<div style="float:right">
						    <label for="submitForm" class="btn btn-primary"> Submit </label>
						    <label for="resetForm" class="btn btn-default"> Reset </label>
						</div>
					</div>
					<div class="panel-body">
						<div class="col-xs-12">
							<form data-toggle="validator" role="form" id="data" method="post">

								<div class="form-group">
									<label>Old Password</label>
									<input type="password" class="form-control" name="password" required="require">
								</div>

								<div class="form-group">
									<label>New Password</label>
									<input id="new_password" type="password" class="form-control" name="new_password" required="require">
								</div>

								<div id="confirm" class="form-group">
									<label>Confirm Password</label>
									<input id="confirm_password" type="password" class="form-control" name="confirm_password" data-match="#new_password" data-match-error="Whoops, Password doesn't match" required="require">
									<div class="help-block with-errors"></div>
								</div>
								<p id="validate-status"></p>

								<div class="form-group" style="text-align:center;">
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
	url: "update.php",
	type: 'POST',
	data: formData,
	async: false,
	success: function (response)
	{
		var answer = JSON.parse(response);
		switch ( answer.status_response )
		{
			case 'success' :
				swal("Good job!", "Update Succesfully!", "success");
				break;
			case 'empty' :
				swal("Edit Failed!", "Please Complete the Form or There is only Spaces in your submission", "error");
				break;
			case 'error' :
				swal("Edit Failed!", "Please upload a image file, PDF File only!", "error");
				break;
			case 'fail' :
				swal("Add Failed!", "Please check your internet connection!", "error");
				break;
		}
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
