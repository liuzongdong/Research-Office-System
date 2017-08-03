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
<title>Academic Monograph</title>
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
    		<li><a href="/external_project">External Project</a></li>
    		<li><a href="/journal" class="selected">Publication</a></li>
    		<li><a href="/patent" >Achievements</a></li>
    		<li><a href="/applications">Applications</a></li>
    	</ul>
    </div>

    </div>

    <div class="submenu">
    <ul>
			<li><a href="/journal" >Journal</a></li>
			<li><a href="/conference_paper">Conference Paper</a></li>
			<li><a href="/academic_monograph" class="selected">Academic Monograph</a></li>
			<li><a href="/conference_presentation">Conference Presentation</a></li>
    </ul>
    </div>

    <div>
	</br>


	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">Academic Monograph</div>
				<div class="panel-body">
					<table id="table" data-toggle="table" data-url="data_staff.php" data-show-export="true" data-show-refresh="true"data-advanced-search="true" data-id-table="advancedTable" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc" data-show-columns="true">
						<thead>
						<tr>
							<th data-field="academic_monograph_monograph_title" data-sortable="true" data-halign="center" data-align="center">Monograph Title</th>
							<th data-field="english_name" data-halign="center" data-align="center" data-sortable="true" >Name</th>
							<th data-visible="false" data-field="division" data-halign="center" data-align="center" data-sortable="true" >Division</th>
							<th data-visible="false" data-field="programme" data-halign="center" data-align="center" data-sortable="true" >Programme</th>
							<th data-field="academic_monograph_author" data-sortable="true" data-halign="center" data-align="center">Author(s)</th>
							<th data-field="academic_monograph_isbn_number" data-sortable="true" data-halign="center" data-align="center">ISBN Number</th>
							<th data-field="academic_monograph_press" data-sortable="true" data-halign="center" data-align="center">Press</th>
							<th data-field="academic_monograph_published_date" data-sortable="true" data-halign="center" data-align="center">Published Date</th>
							<th data-field="action" data-searchable="false" data-width="11%" data-halign="center" data-align="center">Action</th>
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
