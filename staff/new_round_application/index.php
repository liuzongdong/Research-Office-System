<?php
	session_start();
	require("../../base.php");
    if (!(isset($_SESSION["staff"]) && $_SESSION["staff"] === true))
    {
		echo '<script type="text/javascript">alert("Please Login");location.href="../../login.html"</script>';
    }
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reasearch Teacher</title>

<link href="../../css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/style.css" rel="stylesheet">
<link href="../../css/bootstrap-table.css" rel="stylesheet">
<link href="../../css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">

<!-- jQuery file -->
<script src="../../js/jquery.min.js"></script>
</head>
<body>
<div id="panelwrap">

	<div class="header">
    <div class="title"><a href="#"><img src="../../uic_logo.png"></img></a></div>

    <div class="header_right">Welcome <?php echo $_SESSION['english_name']; ?>,  <a href="../../logout.php" class="logout">Logout</a> </div>

    <div class="menu">
    	<ul>
			<li><a href="../index.php">Dashboard</a></li>
    		<li><a href="../uic_project" >UIC Project</a></li>
    		<li><a href="../external_project">External Project</a></li>
    		<li><a href="../publication">Publication</a></li>
    		<li><a href="../patent">Patent</a></li>
    		<li><a href="#">Achievements</a></li>
    		<li><a href="../applications">Applications</a></li>
			<li><a href="../new_round_application " class="selected">New Round Applications</a></li>
    	</ul>
    </div>

    </div>

    <div class="submenu">
    <ul>

		<li><a class="selected">History</a></li>
    </ul>
    </div>

    <div>
	</br>


	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">New Round Application Time Setting</div>
				<div class="panel-body">

					<div class="form-group">
						<label>Publication Time:</label>
						<div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
							<input class="form-control" name="time" size="16" type="text" value="" readonly>
							<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
							<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
						</div>
						<input type="hidden" id="dtp_input2" value="" /><br/>
					</div>


				</div>
			</div>
		</div>
	</div><!--/.row-->

	<div class="clear"></div>
    </div> <!--end of center_content-->
	<div class="footer">©2017 United International College(UIC). All Rights Reserved.</div>

</div>


	<script src="../../js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../js/bootstrap-datetimepicker.js"></script>
	<script type="text/javascript">
		$('.form_date').datetimepicker({
			language:  'en',
			weekStart: 1,
			todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			minView: 2,
			forceParse: 0
		});
	</script>



</body>
</html>
