<?php
	session_start();
	require("../base.php");
    if (!(isset($_SESSION["staff"]) && $_SESSION["staff"] === true))
    {
		echo '<script type="text/javascript">alert("Please Login");location.href="../../login.html"</script>';
    }
	$dbh = new PDO($dbinfo,$dbusername,$dbpassword);
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$sql = "select * from research_award where research_award_id = ?";
	$prepare = $dbh -> prepare($sql);
	$execute = $prepare -> execute(array($_GET['id']));
	if ($execute)
	{
		$data = $prepare -> fetch(PDO::FETCH_ASSOC);
	}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View Research Award</title>
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

    <div class="header_right">Welcome <?php echo $_SESSION['english_name']; ?><a href="#" onclick="logout()" class="logout">Logout</a> </div>

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
		<li id="achievements"><a href="/patent" class="selected">Achievements</a>
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
	  <li><a href="/patent">Patent</a></li>
  	  <li><a href="/software_copyright">Software Copyright</a></li>
  	  <li><a href="/research_award" class="selected">Research Award</a></li>
  	  <li><a href="/personnel_development">Personnel Development</a></li>
    </ul>
    </div>

    <div>

      <div class="row">
        <div class="col-xs-12">
          <div class="panel panel-default">
            <div class="panel-heading">View Reasearch Award</div>
            <div class="panel-body">
			<form id="data" role="form" method="post" enctype="multipart/form-data">
              <div class="col-xs-6">
                  <div class="form-group">
                    <label>Achievement Name:</label>
                    <input disabled class="form-control" name="research_award_achievement_name" required="require" value="<?php echo $data['research_award_achievement_name']; ?>">
                  </div>

				  <div class="form-group">
					  <label>Abstract:</label>
					  <textarea disabled class="form-control" rows="6" name="research_award_abstract" required="require"><?php echo $data['research_award_abstract']; ?></textarea>
				  </div>
				  <div class="form-group">
					  <label>Reward Category:</label>
					  <select disabled class="dropdown" name="research_award_reward_category">
						  <option  <?php if($data['research_award_reward_category'] == "Natural Scieces") echo("selected");?> value="Natural Scieces">Natural Scieces</option>
						  <option  <?php if($data['research_award_reward_category'] == "Technological Progress") echo("selected");?> value="Technological Progress">Technological Progress</option>
						  <option  <?php if($data['research_award_reward_category'] == "Invention") echo("selected");?> value="Invention">Invention</option>
						  <option  <?php if($data['research_award_reward_category'] == "Other") echo("selected");?> value="Other">Other</option>
					  </select>
				  </div>

				  <div class="form-group">
					  <label>Reward Grade:</label>
					  <select disabled class="dropdown" name="research_award_reward_grade">
						  <option <?php if($data['research_award_reward_grade'] == "International Scholarship Prize") echo("selected");?> value="International Scholarship Prize">International Scholarship Prize</option>
						  <option <?php if($data['research_award_reward_grade'] == "National First Prize") echo("selected");?> value="National First Prize">National First Prize</option>
						  <option <?php if($data['research_award_reward_grade'] == "National Second Prize") echo("selected");?> value="National Second Prize">National Second Prize</option>
						  <option <?php if($data['research_award_reward_grade'] == "Provincial First Prize") echo("selected");?> value="Provincial First Prize">Provincial First Prize</option>
						  <option <?php if($data['research_award_reward_grade'] == "Provincial Second Prize") echo("selected");?> value="Provincial Second Prize">Provincial Second Prize</option>
						  <option <?php if($data['research_award_reward_grade'] == "Other") echo("selected");?> value="Other">Other</option>
					  </select>
				  </div>

				  <div class="form-group">
					<label>Author(s):</label>
					<input disabled class="form-control" name="research_award_author" required="require" value="<?php echo $data['research_award_author']; ?>">
				  </div>

				  <div class="form-group">
					  <label>Assessment Organization:</label>
					  <input disabled class="form-control" name="research_award_assessment_organization" required="require" value="<?php echo $data['research_award_assessment_organization']; ?>">
				  </div>
				  <div class="form-group">
					  <label>Publication Time</label>
					  <div class='input-group date' id='datetimepicker1'>
						  <input disabled value="<?php echo $data['research_award_publication_time']; ?>" name="research_award_publication_time" type='text' required="require" readonly class="form-control"/>
						  <span class="input-group-addon">
							  <span class="glyphicon glyphicon-calendar"></span>
						  </span>
					  </div>
				  </div>
              </div>
			  <div class="col-xs-6" id="pdf" style="padding-top:20px;">
				  <object data='<?php echo "upload/".$data['research_award_file']; ?>'
					  type='application/pdf'
					  width='100%'
					  height='580px;'>
						  <p>This browser does not support inline PDFs. Please download the PDF to view it: <a href="<?php echo "upload/".$data['research_award_file']; ?>">Download PDF</a></p>
				  </object>
			  </div>
		  </form>
            </div>
          </div>
        </div>
      </div>
		<div class="clear"></div>
		<div class="footer">©2017 United International College(UIC). All Rights Reserved.</div>

	</div> <!--end of center_content-->
</div>

</body>
</html>
