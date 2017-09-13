<?php
	session_start();
	require("../base.php");
	if (!(isset($_SESSION["teacher"]) && $_SESSION["teacher"] === true))
    {
		echo '<script type="text/javascript">alert("Please Login");location.href="../login.html"</script>';
    }
	if ((isset($_SESSION["staff"]) && $_SESSION["staff"] === true))
    {
		header("Location: staff.php");
    }
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>UIC Project</title>

<?php importFullCss(); ?>
<script>
$(document).ready(function () {
    var $nav = $('#menu > ul > li');
  $nav.hover(
    function() {
        $(this).children('a').addClass('hovered');
    },
    function() {
        $(this).children('a').removeClass('hovered');
    }
);
});
</script>


</head>
<body>
<div id="panelwrap">

	<div class="header">
    <div class="title"><a href="#"><img src="/uic_logo.png"></img></a></div>

    <div class="header_right">Welcome <?php echo $_SESSION['english_name']. " ". $_SESSION['last_name']; ?><a href="#" onclick="logout()" class="logout">Logout</a> </div>

	<div id="menu" class="menu">
	<ul>
		<li id="dashboard"><a href="/">Dashboard</a>
			<div class="dropdown-dashboard">
				<ul>
					<li><a href="/">HomePage</a></li>
					<li><a href="/policy.php">Policy</a></li>
				</ul>
			</div>
		</li>
		<li id="policy"><a href="/policy.php">Policy</a>
			<div class="dropdown-policy">
				<ul>
					<li><a href="/policy.php">Policy</a></li>
				</ul>
			</div>
		</li>
		<li id="profile" ><a href="/profile">Profile</a>
			<div class="dropdown-profile">
				<ul>
					<li><a href="/profile">Profile</a></li>
					<li><a href="/security">Change Password</a></li>
				</ul>
			</div>
		</li>
		<li id="uic-project"><a href="/uic_project" class="selected">UIC Research Grant</a>
			<div class="dropdown-uic-project">
				<ul>
					<li><a href="/uic_project">Category I - III</a></li>
					<li><a href="/iv_project">Category IV</a></li>
					<li><a href="/project_undertaking">Project Budget & Undertaking</a></li>
					<li><a href="/midterm_progress_report_form">Midterm Progress</a></li>
					<li><a href="/complete_report_form">Completion Report</a></li>
				</ul>
			</div>
		</li>
		<li id="external-project"><a href="/external_project">External Project</a>
			<div class="dropdown-external-project">
				<ul>
					<li><a href="/external_project">Government Funded</a></li>
					<li><a href="/industry_project">Industry Funded</a></li>
				</ul>
			</div>
		</li>
		<li id="publication"><a href="/journal">Publication</a>
			<div class="dropdown-publication">
				<ul>
					<li><a href="/journal">Journal</a></li>
					<li><a href="/conference_paper">Conference Paper</a></li>
					<li><a href="/academic_monograph">Academic Monograph</a></li>
					<li><a href="/conference_presentation">Conference Presentation</a></li>
				</ul>
			</div>
		</li>
		<li id="achievements"><a href="/patent">Achievements</a>
			<div class="dropdown-achievements">
				<ul>
					<li><a href="/patent">Patent</a></li>
					<li><a href="/software_copyright">Software Copyright</a></li>
					<li><a href="/research_award">Research Award</a></li>
					<li><a href="/personnel_development">Personnel Development</a></li>
				</ul>
			</div>
		</li>
		<li id="applications"><a href="/applications">Applications</a>
			<div class="dropdown-applications">
				<ul>
					<li><a href="/applications/index.php">Research Assistant</a></li>
					<li><a href="/applications/conference.php">Academic Conference</a></li>
					<li><a href="/applications/visit.php">Visiting Scholar</a></li>
					<li><a href="/applications/fund.php">Publication Fund</a></li>
					<li><a href="/applications/fap.php">FAP</a></li>
				</ul>
			</div>
		</li>
		<?php
		if ($_SESSION['user_type'] == 2)
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
			$dbh = null;
			echo "<li><a href=\"/approval\">Waiting Approval (".$rowCount.")</a></li>";
		}
		?>
	</ul>
</div>

    </div>

    <div class="submenu">
    <ul>
		<li><a href="/uic_project">Category I - III</a></li>
		<li><a href="/iv_project" class="selected">Category IV</a></li>
		<li><a href="/project_undertaking">Project Budget & Undertaking</a></li>
		<li><a href="/midterm_progress_report_form">Midterm Progress Report</a></li>
		<li><a href="/completion_report_form">Completion Report</a></li>
    </ul>
    </div>

    <div>
	</br>


	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">UIC Project (Fund For Institutes and Centers) <a href="add"<button style="float:right; margin-top:5px;" type="button" class="btn btn-primary" name="button">Add Project</button></a></div>
				<div class="panel-body">
					<table id="table" data-show-refresh="true" data-show-export="true" data-toggle="table" data-advanced-search="true" data-id-table="advancedTable" data-url="data.php" data-striped="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc" data-show-columns="true">
						<thead>
						<tr>
							<th data-field="iv_project_name" data-halign="center" data-align="center" data-sortable="true" >Name of Institute or Center</th>
							<th data-field="iv_project_budget" data-halign="center" data-align="center" data-sortable="true">Budget(yuan, RMB)</th>
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
					case 'success':
						swal("Done!", "It was succesfully deleted!", "success");
						$('#table').bootstrapTable('refresh', {silent: true});
						break;
					case 'error' :
						swal("Delete Failed!", "You are not allowed to Delete it", "error");
						break;
					case 'fail' :
						swal("Delete Failed!", "Please check your internet connection!", "error");
						break;
				}

            },
            error: function (xhr, ajaxOptions, thrownError)
			{
                swal("Delete Failed!", "Please check your internet connection.", "error");
            }
        });
    });
}
</script>


</body>
</html>
