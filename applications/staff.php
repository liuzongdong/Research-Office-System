<?php
	session_start();
	require("../base.php");
    if (!(isset($_SESSION["staff"]) && $_SESSION["staff"] === true))
    {
		echo '<script type="text/javascript">alert("Please Login");location.href="../../login.html"</script>';
    }
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Application</title>

<?php importFullCss(); ?>

<!-- jQuery file -->

</head>
<body>
<div id="panelwrap">

	<div class="header">
    <div class="title"><a href="/"><img src="/uic_logo.png"></img></a></div>

	<div class="header_right">Welcome <?php echo $_SESSION['english_name']; ?><a href="#" onclick="logout()" class="logout">Logout</a> </div>


    <div class="menu">
    	<ul>
			<li><a href="/">Dashboard</a></li>
    		<li><a href="/uic_project">UIC Project</a></li>
    		<li><a href="/external_project">External Project</a></li>
    		<li><a href="/journal">Publication</a></li>
    		<li><a href="/patent">Achievements</a></li>
    		<li><a href="/applications" class="selected">Applications</a></li>
    	</ul>
    </div>

    </div>

    <div class="submenu">
    <ul>
      <li><a class="selected" href="staff">Application</a></li>
    </ul>
    </div>

    <div>
	</br>


	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">History </div>
				<div class="panel-body">
					<table id="table" data-show-export="true" data-toggle="table" data-url="data_staff.php" data-search="true" data-advanced-search="true" data-id-table="advancedTable" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc" data-show-columns="true" >
						<thead>
							<tr>
								<th data-field="app_title" data-sortable="true" data-halign="center" data-align="center">Title</th>
								<th data-field="english_name" data-sortable="true" data-halign="center" data-align="center">Name</th>
								<th data-field="division" data-sortable="true" data-halign="center" data-align="center">Division</th>
								<th data-field="app_type" data-sortable="true" data-halign="center" data-align="center">Type</th>
								<th data-field="programme" data-sortable="true" data-halign="center" data-align="center">Programme</th>
								<th data-field="app_update_date" data-sortable="true" data-halign="center" data-align="center">Date</th>
								<th data-field="action" data-halign="center" data-align="center" data-width="11%">Action</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div><!--/.row-->

	<div class="clear"></div>
    </div> <!--end of center_content-->
	<div class="footer">©2017 United International College(UIC). All Rights Reserved.</div>

</div>

</body>
</html>
