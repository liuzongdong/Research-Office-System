<?php
	session_start();
	require("base.php");

    if (!(isset($_SESSION["teacher"]) && $_SESSION["teacher"] === true))
    {
		header("Location: logout.php");
    }
	if ((isset($_SESSION["staff"]) && $_SESSION["staff"] === true))
    {
		header("Location: policy_staff.php");
    }
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Policy</title>
		<?php importCss(); ?>
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
    	<div class="title"><a href="/"><img src="uic_logo.png"></img></a></div>

    	<div class="header_right">Welcome <?php echo $_SESSION['english_name']. " ". $_SESSION['last_name']; ?><a href="#" onclick="logout()" class="logout">Logout</a> </div>

		<div id="menu" class="menu">
    	<ul>
    		<li id="dashboard"><a href="/">Dashboard</a>
				<div class="dropdown-dashboard">
					<ul>
						<li><a href="/">HomePage</a></li>
						<li><a href="policy.php">Policy</a></li>
					</ul>
				</div>
			</li>
			<li id="policy"><a href="policy.php" class="selected">Policy</a>
				<div class="dropdown-policy">
					<ul>
						<li><a href="policy.php">Policy</a></li>
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
    		<li id="uic-project"><a href="/uic_project">UIC Research Grant</a>
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
    <li><a href="policy" class="selected">Policy</a></li>
    </ul>
    </div>
	<div class="row policy">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading"> Policy </div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-4">
							<div class="panel panel-default">
								<div class="panel-heading">
									Default Panel
								</div>
								<div class="panel-body">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ut ante in sapien blandit luctus sed ut lacus. Phasellus urna est, faucibus nec ultrices placerat, feugiat et ligula. Donec vestibulum magna a dui pharetra molestie. Fusce et dui urna.</p>
								</div>
							</div>
						</div>

						<div class="col-xs-4">
							<div class="panel panel-primary">
								<div class="panel-heading">
									Primary Panel
								</div>
								<div class="panel-body">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ut ante in sapien blandit luctus sed ut lacus. Phasellus urna est, faucibus nec ultrices placerat, feugiat et ligula. Donec vestibulum magna a dui pharetra molestie. Fusce et dui urna.</p>
								</div>
							</div>
						</div>

						<div class="col-xs-4">
							<div class="panel panel-success">
								<div class="panel-heading">
									Success Panel
								</div>
								<div class="panel-body">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ut ante in sapien blandit luctus sed ut lacus. Phasellus urna est, faucibus nec ultrices placerat, feugiat et ligula. Donec vestibulum magna a dui pharetra molestie. Fusce et dui urna.</p>
								</div>
							</div>
						</div>

					</div><!-- /.row -->

					<div class="row">
						<div class="col-xs-4">
							<div class="panel panel-info">
								<div class="panel-heading">
									Info Panel
								</div>
								<div class="panel-body">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ut ante in sapien blandit luctus sed ut lacus. Phasellus urna est, faucibus nec ultrices placerat, feugiat et ligula. Donec vestibulum magna a dui pharetra molestie. Fusce et dui urna.</p>
								</div>
							</div>
						</div>

						<div class="col-xs-4">
							<div class="panel panel-warning">
								<div class="panel-heading">
									Warning Panel
								</div>
								<div class="panel-body">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ut ante in sapien blandit luctus sed ut lacus. Phasellus urna est, faucibus nec ultrices placerat, feugiat et ligula. Donec vestibulum magna a dui pharetra molestie. Fusce et dui urna.</p>
								</div>
							</div>
						</div>

						<div class="col-xs-4">
							<div class="panel panel-danger">
								<div class="panel-heading">
									Danger Panel
								</div>
								<div class="panel-body">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ut ante in sapien blandit luctus sed ut lacus. Phasellus urna est, faucibus nec ultrices placerat, feugiat et ligula. Donec vestibulum magna a dui pharetra molestie. Fusce et dui urna.</p>
								</div>
							</div>
						</div>

					</div><!-- /.row -->
				</div>
			</div>
		</div>
	</div><!--/.row-->

    <div>


		<div class="clear"></div>
		<div class="footer">©2017 United International College(UIC). All Rights Reserved.</div>
    </div> <!--end of center_content-->

</div>



</body>
</html>
