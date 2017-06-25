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
<link rel="stylesheet" type="text/css" href="../../css/style.css" />
<link href="../../css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<link href="../../css/bootstrap-table.css" rel="stylesheet">


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
    		<li><a href="../uic_project">UIC Project</a></li>
    		<li><a href="../external_project">External Project</a></li>
    		<li><a href="../publication">Publication</a></li>
    		<li><a href="../patent">Patent</a></li>
    		<li><a href="#">Achievements</a></li>
    		<li><a href="../applications" class="selected">Applications</a></li>
				<li><a href="../new_round_application">New Round Applications</a></li>
    	</ul>
    </div>

    </div>

    <div class="submenu">
    <ul>
		<li><a href="index.php" class="selected">RA</a></li>
		<li><a href="conference.php">Conference</a></li>
		<li><a href="visit.php">Visiting Scholar</a></li>
	    <li><a href="fund.php">Publication Fund</a></li>
		<li><a href="history.php">History</a></li>
    </ul>
    </div>

    <div>

		<div class="row">
			<div class="col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">Application For Research Assistant</div>
					<div class="panel-body">
							<table id="table" data-show-export="true" data-toggle="table" data-url="data_index.php" data-search="true" data-advanced-search="true" data-id-table="advancedTable" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc" data-show-columns="true" >
								<thead>
								<tr>
									<th data-field="english_name" data-sortable="true" data-halign="center" data-align="center">Name</th>
									<th data-field="app_title" data-sortable="true" data-halign="center" data-align="center">Title</th>
									<th data-field="app_type" data-sortable="true" data-halign="center" data-align="center">Type</th>
									<th data-field="programme" data-sortable="true" data-halign="center" data-align="center">Unit</th>
									<th data-field="division" data-sortable="true" data-halign="center" data-align="center">Division</th>
									<th data-field="app_update_date" data-sortable="true" data-halign="center" data-align="center">Date</th>
									<th data-field="action" data-halign="center" data-align="center" data-width="11%">Action</th>
								</tr>
								</thead>
							</table>
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
<script src="../../js/bootstrap-table-export.js"></script>
<script src="../../js/bootstrap-table-toolbar.js"></script>
<script src="../../js/FileSaver.min.js"></script>
<script src="../../js/xlsx.core.min.js"></script>
<script src="../../js/jspdf.min.js"></script>
<script src="../../js/jspdf.plugin.autotable.js"></script>
<script src="../../js/tableExport.js"></script>



</body>
</html>
