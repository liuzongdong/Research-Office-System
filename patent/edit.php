<?php
	session_start();
	require("../base.php");
    if (!(isset($_SESSION["teacher"]) && $_SESSION["teacher"] === true))
    {
		echo '<script type="text/javascript">alert("Please Login");location.href="/login.html"</script>';
    }
	$dbh = new PDO($dbinfo,$dbusername,$dbpassword);
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$sql = "select * from patent where patent_id = ?";
	$prepare = $dbh -> prepare($sql); // Statement is Statement.
	$execute = $prepare -> execute(array($_GET['id']));
	if ($execute)
	{
		$data = $prepare -> fetch(PDO::FETCH_ASSOC);
		if ($data['patent_author_id'] != $_SESSION['user_id'])
		{
			echo '<script type="text/javascript">alert("You are not allow to Edit it!");location.href="index"</script>';
		}
	}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reasearch Teacher</title>
<?php importCss(); ?>
</head>
<body>
<div id="panelwrap">

	<div class="header">
    <div class="title"><a href="/index.php"><img src="/uic_logo.png"></img></a></div>

    <div class="header_right">Welcome <?php echo $_SESSION['english_name']. " ". $_SESSION['last_name']; ?><a href="" onclick="logout()" class="logout">Logout</a> </div>

    <div class="menu">
    	<ul>
			<li><a href="/">Dashboard</a></li>
    		<li><a href="/profile">Profile</a></li>
    		<li><a href="/uic_project">UIC Project</a></li>
    		<li><a href="/external_project">External Project</a></li>
    		<li><a href="/journal">Publication</a></li>
    		<li><a href="/patent" class="selected">Achievements</a></li>
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
		<li><a href="index" class="selected">Patent</a></li>
		<li><a href="/software_copyright" >Software Copyright</a></li>
		<li><a href="/research_award">Research Award</a></li>
		<li><a href="/personnel_development">Personnel Development</a></li>
    </ul>
    </div>

    <div>

		<div class="row">
			<div class="col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">Edit Patent
						<div style="float:right">
						    <label for="submitForm" class="btn btn-primary"> Submit </label>
						    <label for="resetForm" class="btn btn-default"> Reset </label>
						</div>
					</div>
					<div class="panel-body">
						<div class="col-xs-7">
							<form id="data" role="form" method="post" enctype="multipart/form-data">

								<div class="form-group">
									<label>Patent Name:</label>
									<input class="form-control" name="name" required="require" value="<?php echo $data['patent_name']; ?>">
								</div>

								<div class="form-group">
									<label>Code Number:</label>
									<input class="form-control" name="code" required="require" value="<?php echo $data['patent_code']; ?>">
								</div>

								<div class="form-group">
									<label>Authorization Institution:</label>
									<input class="form-control" name="authorization" required="require" value="<?php echo $data['patent_authorization']; ?>">
								</div>

								<div class="form-group">
									<label>Please Upload File Here if any. (PDF Only!)</label>
								</br>
									<input type="file" name="file" class="filestyle" data-buttonText="&nbsp Upload a file" accept="application/pdf">
								</div>
							</br>



							<button id="submitForm" type="submit" class="btn btn-primary hidden">Submit Button</button>
							<button id="resetForm" type="reset" class="btn btn-default hidden">Reset Button</button>

							</div>
							<div class="col-xs-5" id="pdf" style="padding-top:20px;">
								<object data='<?php echo "upload/".$data['patent_src']; ?>'
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
