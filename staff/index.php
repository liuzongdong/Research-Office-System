<?php
	session_start();
	require("../base.php");
		if (!(isset($_SESSION["staff"]) && $_SESSION["staff"] === true))
	    {
			echo '<script type="text/javascript">alert("Please Login");location.href="../login.html"</script>';
	    }
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Staff Page</title>

	</head>
	<?php importCss(); ?>
	<body>
		<div id="panelwrap">

		<div class="header">
    	<div class="title"><a href="#"><img src="../uic_logo.png"></img></a></div>

    	<div class="header_right">Welcome <?php echo $_SESSION['english_name']; ?>,  <a href="../logout.php" class="logout">Logout</a> </div>

    	<div class="menu">
    	<ul>
    		<li><a href="index.php" class="selected">Dashboard</a></li>
    		<li><a href="uic_project">UIC Project</a></li>
    		<li><a href="external_project">External Project</a></li>
    		<li><a href="publication">Publication</a></li>
    		<li><a href="patent">Patent</a></li>
    		<li><a href="#">Achievements</a></li>
    		<li><a href="applications">Applications</a></li>
			<li><a href="new_round_application">New Round Applications</a></li>
    	</ul>
    </div>

    </div>

    <div class="submenu">
    <ul>
    <li><a href="#" class="selected">Dashboard</a></li>
    <li><a href="#">Policy</a></li>
    </ul>
    </div>

    <div>
		<div class="row">
			<div class="col-xs-12" style="padding-left:40px; padding-top:50px; padding-bottom: 50px; text-align:center;">
				<div class="col-xs-2">
					<a href="uic_project" style="color:black"><img src="../images/apply.gif"></img><h5>UIC Project</h5></a>
				</div>
				<div class="col-xs-2">
					<a href="publication" style="color:black"><img src="../images/publication.gif"></img><h5>Publication</h5></a>
				</div>
				<div class="col-xs-2">
					<a href="patent" style="color:black"><img src="../images/patent.gif"></img><h5>Patent</h5></a>
				</div>


			</div>
		</div>

		<div class="clear"></div>
		<div class="footer">©2017 United International College(UIC). All Rights Reserved.</div>
    </div> <!--end of center_content-->

</div>



</body>
</html>
