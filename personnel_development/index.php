<?php
	session_start();
	require("../base.php");
    if (!(isset($_SESSION["teacher"]) && $_SESSION["teacher"] === true))
    {
		echo '<script type="text/javascript">alert("Please Login");location.href="../login.html"</script>';
    }
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Personnel Development</title>
<?php importFullCss(); ?>

<!-- jQuery file -->

</head>
<body>
<div id="panelwrap">

	<div class="header">
    <div class="title"><a href="../index.php"><img src="../uic_logo.png"></img></a></div>

    <div class="header_right">Welcome <?php echo $_SESSION['english_name']; ?>,  <a href="#" onclick="logout()" class="logout">Logout</a> </div>

    <div class="menu">
    	<ul>
			<li><a href="/">Dashboard</a></li>
    		<li><a href="/profile">Profile</a></li>
    		<li><a href="/uic_project">UIC Project</a></li>
    		<li><a href="/external_project">External Project</a></li>
    		<li><a href="/journal">Publication</a></li>
    		<li><a href="/patent" class="selected">Achievements</a></li>
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
				echo "<li><a href=\"../approval\">Waiting Approval (".$rowCount.")</a></li>";
			}
			?>
    	</ul>
    </div>

    </div>

    <div class="submenu">
    <ul>
		<li><a href="/patent">Patent</a></li>
		<li><a href="/software_copyright" >Software Copyright</a></li>
		<li><a href="/research_award">Research Award</a></li>
		<li><a href="/personnel_development" class="selected">Personnel Development</a></li>
    </ul>
    </div>

    <div>
	</br>


	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">Personnel Development <a href="add.php"<button style="float:right; margin-top:5px;" type="button" class="btn btn-primary" name="button">Add Personnel Development</button></a></div>
				<div class="panel-body">
					<table id="table" data-toggle="table" data-show-refresh="true" data-url="data.php" data-show-export="true" data-advanced-search="true" data-id-table="advancedTable" data-striped="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc" data-show-columns="true">
						<thead>
						<tr>
							<th data-field="personnel_deveplopment_training_person" data-sortable="true" data-halign="center" data-align="center">Name of Trained Person</th>
							<th data-field="personnel_deveplopment_training_category" data-sortable="true" data-halign="center" data-align="center">Training Category</th>
							<th data-field="personnel_deveplopment_project_name" data-sortable="true" data-halign="center" data-align="center">Research Topic</th>
							<th data-field="personnel_deveplopment_author" data-sortable="true" data-halign="center" data-align="center">Collaborative Professor(s)</th>
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
<script>
function confirmDelete(id) {
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this record!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    }, function (isConfirm) {
        if (!isConfirm) return;
        $.ajax({
            url: "delete.php",
            type: "POST",
            data: {
                id: id
            },
            dataType: "html",
            success: function (response)
			{
				var answer = JSON.parse(response);
				switch ( answer.status_response )
				{
					case 'success' :
						swal("Done!", "It was succesfully deleted!", "success")
						break;
					case 'error' :
						swal("Error deleting!", "You are not allowed to Delete it.", "error");
						break;
					case 'fail' :
						swal("Unknown Error!", "Please check your internet connection.", "error");
						break;
				}
				$('#table').bootstrapTable('refresh', {silent: true});
            },
        });
    });
}
</script>

</body>
</html>
