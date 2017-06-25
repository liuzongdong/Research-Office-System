<?php
	session_start();
    if (!(isset($_SESSION["admin"]) && $_SESSION["admin"] === true))
    {
		echo '<script type="text/javascript">alert("Please Login");location.href="../../login.html"</script>';
    }
?>
<html>
	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>RO Admin</title>
		<link href="../../css/bootstrap.min.css" rel="stylesheet">
		<link href="../../css/style.css" rel="stylesheet">
		<link href="../../css/bootstrap-table.css" rel="stylesheet">

	</head>
	<body>
		<div id="panelwrap">

		<div class="header">
    	<div class="title"><a href="index.php"><img src="../../uic_logo.png"></img></a></div>

    	<div class="header_right">Welcome <?php echo $_SESSION['username']; ?>,  <a href="../../logout.php" class="logout">Logout</a> </div>

    	<div class="menu">
    	<ul>
			<li><a href="../index.php">Home</a></li>
    		<li><a href="../researcher" >Researcher</a></li>
    		<li><a href="../staff">RO Staff</a></li>
				 <li><a href="../panel">Panel</a></li>
    		<li><a href="../pd">PD</a></li>
    		<li><a href="../dean" class="selected">Dean</a></li>
    		<li><a href="../unit" >Add Unit</a></li>
    	</ul>
    </div>

    </div>

    <div class="submenu">
    <ul>
    <li><a href="#" class="selected">Import</a></li>
    <li><a href="edit.php">Edit</a></li>
	<li><a href="new.php">New</a></li>
    </ul>
    </div>

    <div>
		<div class="row">
			<div class="col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">Import Researchers</div>
					<div class="panel-body">
						<div class="col-xs-12">
							<form role="form" action="new.php" method="post">
								<h4>Import From File</h4>
								<div class="form-group">
									<input type="file">
								</div>


								<div class="form-group" style="text-align:center">
									<button type="submit" class="btn btn-primary">Submit Button</button>
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

<script src="../../js/jquery.min.js"></script>
<script src="../../js/bootstrap.min.js"></script>
<script src="../../js/bootstrap-table.js"></script>



</body>
</html>
