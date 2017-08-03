<?php
	session_start();
	require("../base.php");
    if (!(isset($_SESSION["staff"]) && $_SESSION["staff"] === true))
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
	}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View Patent</title>
<?php importCss(); ?>
</head>
<body>
<div id="panelwrap">

	<div class="header">
    <div class="title"><a href="/index.php"><img src="/uic_logo.png"></img></a></div>

    <div class="header_right">Welcome <?php echo $_SESSION['english_name'];?><a href="" onclick="logout()" class="logout">Logout</a> </div>

    <div class="menu">
    	<ul>
			<li><a href="/">Dashboard</a></li>
    		<li><a href="/uic_project">UIC Project</a></li>
    		<li><a href="/external_project">External Project</a></li>
    		<li><a href="/journal">Publication</a></li>
    		<li><a href="/patent" class="selected">Achievements</a></li>
    		<li><a href="/applications">Applications</a></li>
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
					<div class="panel-heading">View Patent
					</div>
					<div class="panel-body">
						<div class="col-xs-12">
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
							</div>
							<div class="col-xs-12" id="pdf" style="padding-top:20px;">
								<object data='<?php echo "upload/".$data['patent_src']; ?>'
        							type='application/pdf'
        							width='100%'
        							height='600px'>
										<p>This browser does not support inline PDFs. Please download the PDF to view it: <a href="<?php echo "upload/".$data['patent_src']; ?>">Download PDF</a></p>
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

</body>
</html>
