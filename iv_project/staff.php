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
<title>UIC Project</title>

<?php importFullCss(); ?>


</head>
<body>
<div id="panelwrap">

	<div class="header">
    <div class="title"><a href="#"><img src="/uic_logo.png"></img></a></div>

    <div class="header_right">Welcome <?php echo $_SESSION['english_name']; ?><a href="#" onclick="logout()" class="logout">Logout</a> </div>

    <div class="menu">
    	<ul>
			<li><a href="/">Dashboard</a></li>
    		<li><a href="/uic_project" class="selected">UIC Project</a></li>
    		<li><a href="/external_project">External Project</a></li>
    		<li><a href="/journal">Publication</a></li>
    		<li><a href="/patent">Achievements</a></li>
    		<li><a href="/applications">Applications</a></li>
    	</ul>
    </div>

    </div>

    <div class="submenu">
    <ul>
		<li><a href="/uic_project">Category I - III</a></li>
		<li><a href="/iv_project" class="selected">Category IV</a></li>
		<li><a href="/project_undertaking">UIC Project Budget & Project Undertaking</a></li>
		<li><a href="/midterm_progress_report_form">Midterm Progress Report Form</a></li>
		<li><a href="/completion_report_form">Completion Report Form</a></li>
    </ul>
    </div>

    <div>
	</br>


	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">UIC Project (Fund For Institutes and Centers)</div>
				<div class="panel-body">
					<table id="table" data-show-refresh="true"data-show-export="true" data-toggle="table" data-advanced-search="true" data-id-table="advancedTable" data-url="data_staff.php" data-striped="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc" data-show-columns="true">
						<thead>
						<tr>
							<th data-field="english_name" data-halign="center" data-align="center" data-sortable="true" >Name</th>
							<th data-visible="true" data-field="division" data-halign="center" data-align="center" data-sortable="true" >Division</th>
							<th data-visible="true" data-field="programme" data-halign="center" data-align="center" data-sortable="true" >Programme</th>
							<th data-field="iv_project_name" data-halign="center" data-align="center" data-sortable="true" >Name of Institute or Center</th>
							<th data-field="iv_project_budget" data-halign="center" data-align="center" data-sortable="true">Budget(yuan, RMB)</th>
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
