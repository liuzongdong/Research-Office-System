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
<title>Reasearch Teacher</title>
<link href="../../css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="../../css/style.css" />
<link href="../../css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<!-- jQuery file -->
<script src="../js/jquery.min.js"></script>
</head>
<body>
<div id="panelwrap">

	<div class="header">
    <div class="title"><a href="#"><img src="../../uic_logo.png"></img></a></div>

    <div class="header_right">Welcome <?php echo $_SESSION['englishname']; ?>,  <a href="../../logout.php" class="logout">Logout</a> </div>

    <div class="menu">
    	<ul>
        <li><a href="../index.php">Home</a></li>
      		<li><a href="../researcher">Researcher</a></li>
      		<li><a href="../staff">RO Staff</a></li>
					 <li><a href="../panel">Panel</a></li>
      		<li><a href="../pd" >PD</a></li>
      		<li><a href="../dean">Dean</a></li>
      		<li><a href="../unit" class="selected">Add Unit</a></li>

    	</ul>
    </div>

    </div>

    <div class="submenu">
    <ul>
		<li><a href="index.php" class="selected">Add</a></li>
    </ul>
    </div>

    <div>

		<div class="row">
			<div class="col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">Add Unit</div>
					<div class="panel-body">
						<div class="form-group">
							<label>Name:</label>
							<input class="form-control" name="name">
						</div>
			</br>

						<div class="form-group">
							<label>Email:</label>
							<input class="form-control" name="email">
						</div>
			</br>
							<div class="form-group" style="text-align:center">
								<button type="submit" class="btn btn-primary">Submit Button</button>
								<span style="font-size:20px;">&nbsp;&nbsp;&nbsp;</span>
								<button type="reset" class="btn btn-default">Reset Button</button>
							</div>
					</div>
				</div>
			</div>
		</div>
		<div class="clear"></div>
		<div class="footer">©2017 United International College(UIC). All Rights Reserved.</div>


    </div> <!--end of center_content-->

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
