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
<title>Industry-funded Project</title>

<?php importFullCss(); ?>


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
    		<li><a href="/external_project" class="selected">External Project</a></li>
    		<li><a href="/journal">Publication</a></li>
    		<li><a href="/patent">Achievements</a></li>
    		<li><a href="/applications">Applications</a></li>
    	</ul>
    </div>

    </div>

    <div class="submenu">
    <ul>
		<li><a href="/external_project">Government-funded Project</a></li>
		<li><a href="/industry_project" class="selected">Industry-funded Project</a></li>
    </ul>
    </div>

    <div>
	</br>


	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">Industry-funded Project</div>
				<div class="panel-body">
					<table id="table" data-toggle="table" data-url="data_staff.php" data-show-export="true" data-advanced-search="true" data-id-table="advancedTable" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc" data-show-columns="true">
						<thead>
						<tr>
							<th data-field="ip_title" data-sortable="true" data-halign="center" data-align="center">Project Title</th>
							<th data-field="english_name" data-halign="center" data-align="center" data-sortable="true" >Name</th>
							<th data-visible="false" data-field="division" data-halign="center" data-align="center" data-sortable="true" >Division</th>
							<th data-visible="false" data-field="programme" data-halign="center" data-align="center" data-sortable="true" >Programme</th>
							<th data-field="ip_type" data-sortable="true" data-halign="center" data-align="center">Project Type</th>
							<th data-field="ip_role" data-sortable="true" data-halign="center" data-align="center">Role</th>
							<th data-field="ip_duration_from" data-sortable="true" data-halign="center" data-align="center">Duration</th>
							<th data-field="ip_amount"  data-sortable="true" data-halign="center" data-align="center">Funding Amount</th>
							<th data-field="action" data-searchable="false" data-width="13%" data-halign="center" data-align="center">Action</th>
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