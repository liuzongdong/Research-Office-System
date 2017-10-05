<?php
	session_start();
	require("../base.php");
    if (!(isset($_SESSION["staff"]) && $_SESSION["staff"] === true))
    {
		echo '<script type="text/javascript">alert("Please Login");location.href="../../login.html"</script>';
    }
	$dbh = new PDO($dbinfo,$dbusername,$dbpassword);
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$sql = "select * from personnel_deveplopment where personnel_deveplopment_id = ?";
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
<title>View Personnel Development</title>
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
    <div class="title"><a href="/"><img src="../uic_logo.png"></img></a></div>

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
  	  <li><a href="/software_copyright" >Software Copyright</a></li>
  	  <li><a href="/research_award">Research Award</a></li>
  	  <li><a href="/personnel_development" class="selected">Personnel Development</a></li>
    </ul>
    </div>

    <div>

      <div class="row">
        <div class="col-xs-12">
          <div class="panel panel-default">
            <div class="panel-heading">View Personnel Development
			</div>
            <div class="panel-body">
			<form id="data" role="form" method="post" enctype="multipart/form-data">
              <div class="col-xs-6">
					<div class="form-group">
  					  <label>Training Category:</label>
  					  <select disabled class="dropdown" name="personnel_deveplopment_training_category">
  						  <option <?php if($data['personnel_deveplopment_training_category'] == "Student Training") echo("selected ");?> value="Student Training">Student Training</option>
  						  <option <?php if($data['personnel_deveplopment_training_category'] == "Young-aged Academic Leaders") echo("selected ");?> value="Young-aged Academic Leaders">Young-aged Academic Leaders</option>
  					  </select>
  				  </div>

                  <div class="form-group">
                    <label>Name of Trained Person:</label>
                    <input disabled class="form-control" name="personnel_deveplopment_training_person" required="require" value="<?php echo $data['personnel_deveplopment_training_person']; ?>">
                  </div>
				  <div class="form-group">
					  <label>Research Topic:</label>
					  <input disabled class="form-control" name="personnel_deveplopment_project_name" required="require" value="<?php echo $data['personnel_deveplopment_project_name']; ?>">
				  </div>

                  <div class="form-group">
                    <label>Collaborative Professor(s):</label>
                    <input disabled class="form-control" name="personnel_deveplopment_author" required="require" value="<?php echo $data['personnel_deveplopment_author']; ?>">
                  </div>
				  <div class="form-group">
					  <label>Abstract:</label>
					  <textarea disabled class="form-control" rows="6" name="personnel_deveplopment_abstract" required="require" ><?php echo $data['personnel_deveplopment_abstract']; ?></textarea>
				  </div>
				  <div class="form-group">
					  <label>Start Date</label>
					  <div class='input-group date' id='datetimepicker1'>
						  <input disabled value="<?php echo $data['personnel_deveplopment_start_date']; ?>" name="personnel_deveplopment_start_date" type='text' required="require" readonly class="form-control"/>
						  <span class="input-group-addon">
							  <span class="glyphicon glyphicon-calendar"></span>
						  </span>
					  </div>
				  </div>

				  <div class="form-group">
					  <label>Due Date</label>
					  <div class='input-group date' id='datetimepicker2'>
						  <input disabled value="<?php echo $data['personnel_deveplopment_due_date']; ?>" name="personnel_deveplopment_due_date" type='text' required="require" readonly class="form-control"/>
						  <span class="input-group-addon">
							  <span class="glyphicon glyphicon-calendar"></span>
						  </span>
					  </div>
				  </div>
              </div>
			  <div class="col-xs-6" id="pdf" style="padding-top:20px;">
				  <object data='<?php echo "upload/".$data['personnel_deveplopment_file']; ?>'
					  type='application/pdf'
					  width='100%'
					  height='580px;'>
						  <p>This browser does not support inline PDFs. Please download the PDF to view it: <a href="<?php echo "upload/".$data['personnel_deveplopment_file']; ?>">Download PDF</a></p>
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
