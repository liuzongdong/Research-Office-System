<?php
	session_start();
	require("base.php");
    if (!(isset($_SESSION["staff"]) && $_SESSION["staff"] === true))
    {
		session_unset();
		session_destroy();
		header("Location: login.html");
    }
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Welcome to RO System</title>
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
	<body onload="getCount()">
		<div id="panelwrap">

		<div class="header">
    	<div class="title"><a href="/"><img src="uic_logo.png"></img></a></div>

    	<div class="header_right">Welcome <?php echo $_SESSION['english_name']?><a href="#" onclick="logout()" class="logout">Logout</a> </div>

		<div id="menu" class="menu">
		<ul>
			<li id="dashboard"><a href="/" class="selected">Dashboard</a>
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
			<li id="uic-project"><a id="uic_project" href="/uic_project">UIC Research Grant <span class="badge"><?php GetProjectCount(); ?></span></a>
				<div class="dropdown-uic-project">
					<ul>
						<li><a href="/uic_project">Category I - III</a></li>
						<li><a href="/iv_project">Category IV</a></li>
						<li><a href="/project_undertaking">Project Budget & Undertaking</a></li>
						<li><a href="/midterm_progress_report_form">Midterm Progress</a></li>
						<li><a href="/completion_report_form">Completion Report</a></li>
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
		</ul>
	</div>

    </div>

    <div class="submenu">
    <ul>
    <li><a href="/" class="selected">Dashboard</a></li>
    </ul>
    </div>
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">

				<div class="panel-heading">
					Qucik Access

					</div>

				<div class="panel-body">
					<?php
						if (get_browser_name($_SERVER['HTTP_USER_AGENT']) == "Other")
						{
							echo "
							<div class=\"alert alert-danger\">
								Please use <strong>Firefox, Chrome, Safari or Edge</strong>. Current browser can not get the best experience, all functions are disabled now. <button name=\"button\" style=\"float:right;\" class=\"btn btn-xs btn-danger\" >Use it anyway</button>
							</div>
							";
						}
					?>
					<div class="alert alert-success">
						Your last login IP is: <strong><?php echo $_SESSION['ip']; ?></strong>. If there is any question, please contect webmaster and change your password.
					</div>

						<div class="col-xs-12" style="padding-top:15px; padding-bottom:15px;text-align:center;">
							<div class="col-xs-2">
								<a href="journal" style="color:black"><img src="images/publication.jpg" width="55%"></i><h5>Journal</h5></a>
							</div>
							<div class="col-xs-2">
								<a href="patent" style="color:black"><img src="images/patent.jpg" width="55%"></i><h5>Patent</h5></a>
							</div>
							<div class="col-xs-2">
								<a href="uic_project" style="color:black"><img src="images/project.jpg" width="55%"></i><h5>UIC Project</h5></a>
							</div>
							<div class="col-xs-2">
								<a href="software_copyright" style="color:black"><img src="images/software.jpg" width="55%"></i><h5>Software Copyright</h5></a>
							</div>
							<div class="col-xs-2">
								<a href="applications" style="color:black"><img src="images/application.jpg" width="55%"></i><h5>Application</h5></a>
							</div>

						</div>
				</div>
			</div>
		</div>
	</div><!--/.row-->

    <div>


		<div class="clear"></div>
		<div class="footer">©2017 United International College(UIC). All Rights Reserved.</div>
    </div> <!--end of center_content-->

</div>
<?php
	if (get_browser_name($_SERVER['HTTP_USER_AGENT']) == "Other")
	{
		echo "
		<script>
		$('a').addClass('disabled');
		$('button').click(function(){
		    $('a').removeClass('disabled');
		});
		</script>
		";
	}
?>



</body>
</html>
