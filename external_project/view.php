<?php
	session_start();
	require("../base.php");
	if (!(isset($_SESSION["staff"]) && $_SESSION["staff"] === true))
    {
		echo '<script type="text/javascript">alert("Please Login");location.href="../login.html"</script>';
    }
	$dbh = new PDO($dbinfo,$dbusername,$dbpassword);
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$sql = "select * from external_project where ep_id = ?";
	$prepare = $dbh -> prepare($sql); // Statement is Statement.
    $execute = $prepare -> execute(array($_GET['id']));
	if ($execute)
	{
		$data = $prepare -> fetch(PDO::FETCH_ASSOC);
	}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Government-funded Project</title>
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
    <div class="title"><a href="/"><img src="/uic_logo.png"></img></a></div>

    <div class="header_right">Welcome <?php echo $_SESSION['english_name']?><a href="/logout.php" class="logout">Logout</a> </div>

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
		<li id="uic-project"><a href="/uic_project">UIC Research Grant <span class="badge"><?php GetProjectCount(); ?></a>
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
		<li id="external-project"><a href="/external_project" class="selected">External Project</a>
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
		<li><a href="/external_project" class="selected">Government-funded</a></li>
		<li><a href="/industry_project">Industry-funded</a></li>
    </ul>
    </div>

    <div>

		<div class="row">
			<div class="col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">View Government-funded Project
					</div>
					<div class="panel-body">
						<div class="col-xs-12">
							<form id="data" role="form" method="post">

								<div class="form-group">
									<label>Project Title:</label>
									<input disabled class="form-control" value="<?php echo $data['ep_title']; ?>">
								</div>

								<div class="form-group">
									<label>Project Type:</label>
									<select disabled class="dropdown" name="type">
										<option <?php if($data['ep_type'] == "National Project") echo("selected ");?>value = "National Project"> National Project</option>
										<option <?php if($data['ep_type'] == "Provincial Project") echo("selected ");?>value = "Provincial Project"> Provincial Project</option>
										<option <?php if($data['ep_type'] == "Municipal Project") echo("selected ");?>value = "Municipal Project"> Municipal Project</option>
									</select>
								</div>

								<div class="form-group">
									<label>Role:</label>
									<input disabled class="form-control" name="role" required="require" value="<?php echo $data['ep_role']; ?>">
								</div>

								<div class="form-group">
									<label>Funding Source</label>
									<input disabled class="form-control" name="source" required="require" value="<?php echo $data['ep_fundsource']; ?>">
								</div>
								<div class="form-group">
									<label>Duration: From</label>
                					<div class='input-group date' id='datetimepicker1'>
                    					<input disabled value="<?php echo $data['ep_duration_from']; ?>" class="form-control"/>
                    					<span class="input-group-addon">
                        					<span class="glyphicon glyphicon-calendar"></span>
                    					</span>
                					</div>
            					</div>

								<div class="form-group">
									<label>To</label>
                					<div class='input-group date' id='datetimepicker2'>
                    					<input disabled value="<?php echo $data['ep_duration_to']; ?>" class="form-control"/>
                    					<span class="input-group-addon">
                        					<span class="glyphicon glyphicon-calendar"></span>
                    					</span>
                					</div>
            					</div>

								<div class="form-group">
									<label>Funding Amount</label>
									<input class="form-control" disabled value="<?php echo $data['ep_amount']; ?>" oninput="if (! /^\d+$/ig.test(this.value)){this.value='';}">
								</div>

							</div>
						</form>
					</div>
				</div>
			</div><!-- /.col-->
		</div><!-- /.row -->
		<div class="clear"></div>
		<div class="footer">©2017 United International College(UIC). All Rights Reserved.</div>


    </div> <!--end of center_content-->

</div>


</body>
</html>
