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
<title>Profile</title>
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
    <div class="title"><a href="/"><img src="/uic_logo.png"></img></a></div>

    <div class="header_right">Welcome <?php echo $_SESSION['english_name']?><a href="#" onclick="logout()" class="logout">Logout</a> </div>

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
		<li id="profile" ><a href="/profile" class="selected">Profile</a>
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
    <li><a href="/profile" class="selected">Profile</a></li>
	<li><a href="/security" >Change Password</a></li>
    </ul>
    </div>

    <div>
<?php
	$dbh = new PDO($dbinfo,$dbusername,$dbpassword);
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$sql = "select * from user where user_id = ?";
	$prepare = $dbh -> prepare($sql); // Statement is Statement.
	$execute = $prepare -> execute(array($_GET['id']));
	if ($execute)
	{
		$row = $prepare -> fetch();
	}
?>

		<div class="row">
			<div class="col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">View Profile
					</div>
					<div class="panel-body">
						<div class="col-xs-7">
							<form role="form" id="data" method="post"enctype="multipart/form-data">

								<div class="form-group">
									<label>First Name:</label>
									<input disabled class="form-control" name="firstname" required="require"<?php echo "value=".$row['first_name']; ?>>
								</div>

								<div class="form-group">
									<label>Last Name:</label>
									<input disabled class="form-control" name="lastname" required="require"<?php echo "value=".$row['last_name']; ?>>
								</div>

								<div class="form-group">
									<label>English Name:</label>
									<input disabled class="form-control" name="englishname" required="require"<?php echo "value=".$row['english_name']; ?>>
								</div>

								<div class="form-group">
									<label>Email:</label>
									<input disabled class="form-control" readonly="readonly" <?php echo "value=".$row['user_email']; ?>>
								</div>

								<div class="form-group">
									<label>Highest Degree:</label>
									<select disabled class="dropdown" name="degree">
										<option <?php if($row['degree'] == "Scholar") echo("selected");?> value = "Scholar">Scholar</option>
										<option <?php if($row['degree'] == "Master") echo("selected");?> value = "Master">Master</option>
										<option <?php if($row['degree'] == "PhD") echo("selected");?> value = "PhD">PhD</option>
										<option <?php if($row['degree'] == "Prof") echo("selected");?> value = "Prof">Prof</option>
									</select>
								</div>

								<div class="form-group">
									<label>Phone Number:</label>
									<input disabled class="form-control" name="phone" required="require"<?php echo "value=".$row['phone']; ?>>
								</div>

								<div class="form-group">
									<label>Education</label>
									<textarea disabled class="form-control" rows="6" name="education" required="require"><?php echo $row['education_desc']; ?></textarea>
								</div>

								<div class="form-group">
									<label>Division/Centre:</label>
									<select disabled class="dropdown" name="division">
										<option <?php if($row['division'] == "DST") echo("selected");?> value="DST">DST</option>
										<option <?php if($row['division'] == "DCC") echo("selected");?> value="DCC">DCC</option>
										<option <?php if($row['division'] == "DHSS") echo("selected");?> value="DHSS">DHSS</option>
										<option <?php if($row['division'] == "DBM") echo("selected");?> value="DBM">DBM</option>
									</select>
								</div>

								<div class="form-group">
									<label>Programme:</label>
									<select disabled class="dropdown" name="programme">
										<option <?php if($row['programme'] == "CST") echo("selected");?> value="CST">CST</option>
										<option <?php if($row['programme'] == "CTV") echo("selected");?> value="CTV">CTV</option>
										<option <?php if($row['programme'] == "ACCT") echo("selected");?> value="ACCT">ACCT</option>
										<option <?php if($row['programme'] == "TESL") echo("selected");?> value="TESL">TESL</option>
										<option <?php if($row['programme'] == "FST") echo("selected");?> value="FST">FST</option>
										<option <?php if($row['programme'] == "FST") echo("selected");?> value="FST">APSY</option>
										<option <?php if($row['programme'] == "FST") echo("selected");?> value="FST">ENVS</option>
										<option <?php if($row['programme'] == "FST") echo("selected");?> value="FST">FST</option>
										<option <?php if($row['programme'] == "FST") echo("selected");?> value="FST">FST</option>
										<option <?php if($row['programme'] == "FST") echo("selected");?> value="FST">FST</option>
										<option <?php if($row['programme'] == "FST") echo("selected");?> value="FST">FST</option>
										<option <?php if($row['programme'] == "FST") echo("selected");?> value="FST">FST</option>
										<option <?php if($row['programme'] == "FST") echo("selected");?> value="FST">FST</option>
									</select>
								</div>

							</br>

								<div class="form-group" style="text-align:center;">
									<button id="submitForm" type="submit" class="btn btn-primary hidden">Submit Button</button>
									<button id="resetForm" type="reset" class="btn btn-default hidden">Reset Button</button>
								</div>

							</div>
							<div class="col-xs-5" style="text-align:center">
							</br>
								<div class="form-group">
								<img src="upload/<?php echo $row['image_src']?>" id="preview" alt="" name="pic" width="80%"/>

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
