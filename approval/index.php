<?php
	session_start();
	require("../base.php");
    if (!(isset($_SESSION["teacher"]) && $_SESSION["teacher"] === true && $_SESSION['user_type'] === 2))
    {
        header("Location: /");
    }
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Approval</title>
		<?php importCss(); ?>
	</head>
	<body>
		<div id="panelwrap">

		<div class="header">
    	<div class="title"><a href="#"><img src="../uic_logo.png"></img></a></div>

    	<div class="header_right">Welcome <?php echo $_SESSION['english_name']; ?>,  <a href="../logout.php" class="logout">Logout</a> </div>

    	<div class="menu">
    	<ul>
    		<li><a href="/index.php">Dashboard</a></li>
    		<li><a href="/profile">Profile</a></li>
    		<li><a href="/uic_project">UIC Project</a></li>
    		<li><a href="/external_project">External Project</a></li>
    		<li><a href="/journal">Publication</a></li>
    		<li><a href="/patent">Achievements</a></li>
    		<li><a href="/applications">Applications</a></li>
			<?php if ($_SESSION['user_type'] == 2)
			{
				$dbh = new PDO($dbinfo,$dbusername,$dbpassword);
		        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //Disable Prepared Statements, in case of SQL Injection.
				$sql = "select * from application, user where application.app_user_id = user.user_id AND user.programme = ? and approval = 0"; // *, select all. '?' and '?', SQL Injection
		        $prepare = $dbh -> prepare($sql); // Statement is Statement.
		        $execute = $prepare -> execute(array($_SESSION["programme"])); // Var is Var.
		        if ($execute)
		        {
					$row = $prepare -> fetchall(PDO::FETCH_ASSOC);
					$rowCount = count($row);
				}
				echo "<li><a class=\"selected\" href=\"/approval\">Waiting Approval (".$rowCount.")</a></li>";
			}
			?>
    	</ul>
    </div>

    </div>

    <div class="submenu">
    <ul>
    <li><a href="index" class="selected">Approval</a></li>
    </ul>
    </div>

    <div>

		<div class="row">
			<div class="col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">Waiting Approval</div>
					<div class="panel-body">
						<table data-toggle="table" data-url="data.php" data-show-export="true" data-advanced-search="true" data-id-table="advancedTable" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc" data-show-columns="true">
							<thead>
							<tr>
								<th data-field="english_name" data-sortable="true" data-halign="center" data-align="center">Applicant</th>
								<th data-field="app_type"  data-sortable="true" data-halign="center" data-align="center">Type</th>
								<th data-field="app_title" data-sortable="true" data-halign="center" data-align="center">Title</th>
								<th data-field="app_update_date" data-sortable="true" data-halign="center" data-align="center">Date</th>
								<th data-field="file_src" data-searchable="false" data-width="12%" data-halign="center" data-align="center">File</th>
								<th data-field="action" data-searchable="false" data-width="9%" data-halign="center" data-align="center">Action</th>
							</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div><!--/.row-->


		<div class="clear"></div>
		<div class="footer">©2017 United International College(UIC). All Rights Reserved.</div>
    </div> <!--end of center_content-->

</div>

</body>
</html>
