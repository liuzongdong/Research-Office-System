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

    	<div class="header_right">Welcome <?php echo $_SESSION['username']; ?>, <a href="#" class="settings">Change Role</a> <a href="../../logout.php" class="logout">Logout</a> </div>

    	<div class="menu">
    	<ul>
			<li><a href="../index.php">Home</a></li>
    		<li><a href="../researcher">Researcher</a></li>
    		<li><a href="../staff">RO Staff</a></li>
				<li><a href="../panel" class="selected">Panel</a></li>
    		<li><a href="../pd" >PD</a></li>
    		<li><a href="../dean" >Dean</a></li>
    		<li><a href="../unit">Add Unit</a></li>
    	</ul>
    </div>

    </div>

    <div class="submenu">
    <ul>
    	<li><a href="change.php">Change page</a></li>
    </ul>
    </div>

    <div>
		<div class="row">
			<div class="col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">Change Page</div>
					<div class="panel-body">
						<div class="col-xs-12">

              <div class="form-group">
                <label>Name:</label>
                <input class="form-control" name="email">
              </div>
              <div class="form-group">
                <label>Email:</label>
                <input class="form-control" name="email">
              </div>
            </br>
                    <div class="form-group" style="text-align:center">
                      <button type="submit" class="btn btn-primary">Save</button>
                      <span style="font-size:20px;">&nbsp;&nbsp;&nbsp;</span>
											<a href = "index.php" ><button class="btn btn-primary">Cancel</button></a>
                    </div>
					</div>
				</div>
			</div><!-- /.col-->
		</div><!-- /.row -->
</div>
		<div class="clear"></div>
		<div class="footer">©2017 United International College(UIC). All Rights Reserved.</div>
    </div> <!--end of center_content-->

</div>

<script src="../../js/jquery.min.js"></script>
<script src="../../js/bootstrap.min.js"></script>
<script src="../../js/bootstrap-table.js"></script>



</body>
</html>
