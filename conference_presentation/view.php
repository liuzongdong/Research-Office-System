<?php
	session_start();
	require("../base.php");
    if (!(isset($_SESSION["staff"]) && $_SESSION["staff"] === true))
    {
		echo '<script type="text/javascript">alert("Please Login");location.href="/login.html"</script>';
    }
	$dbh = new PDO($dbinfo,$dbusername,$dbpassword);
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$sql = "select * from conference_presentation where conference_presentation_id = ?";
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
<title>Cinference Presentation</title>
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
		<li id="publication"><a href="/journal" class="selected">Publication</a>
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
		<li><a href="/journal" >Journal</a></li>
		<li><a href="/conference_paper">Conference Paper</a></li>
		<li><a href="/academic_monograph">Academic Monograph</a></li>
		<li><a href="/conference_presentation" class="selected">Conference Presentation</a></li>

		</ul>
    </div>

    <div>

      <div class="row">
        <div class="col-xs-12">
          <div class="panel panel-default">
            <div class="panel-heading">View Conference Presentation
			</div>
            <div class="panel-body">
				<form id="data" role="form" method="post" enctype="multipart/form-data">
              <div class="col-xs-6">
					<div class="form-group">
						<label>Report Type:</label>
						<select disabled class="dropdown" name="conference_presentation_report_type">
							<option <?php if($data['conference_presentation_report_type'] == "Invited Report") echo("selected ");?> value = "Invited Report">Invited Report</option>
							<option <?php if($data['conference_presentation_report_type'] == "Group Report") echo("selected ");?> value = "Group Report">Group Report</option>
							<option <?php if($data['conference_presentation_report_type'] == "Poster Presentation") echo("selected ");?> value = "Poster Presentation">Poster Presentation</option>
						</select>
					</div>
					<div class="form-group">
						<label>Meeting Type:</label>
						<select disabled class="dropdown" name="conference_presentation_type_of_meeting">
							<option <?php if($data['conference_presentation_type_of_meeting'] == "International Seminars") echo("selected ");?> value = "International Seminars">International Seminars</option>
							<option <?php if($data['conference_presentation_type_of_meeting'] == "National Seminars") echo("selected ");?> value = "National Seminars">National Seminars</option>
						</select>
					</div>
                  <div class="form-group">
                    <label>Report Name:</label>
                    <input disabled class="form-control" name="conference_presentation_report_name" required="require" value="<?php echo $data['conference_presentation_report_name']; ?>">
                  </div>
				  <div class="form-group">
					  <label>Author(s):</label>
					  <input disabled class="form-control" name="conference_presentation_author" required="require" value="<?php echo $data['conference_presentation_author']; ?>">
				  </div>
				  <div class="form-group">
					  <label>Abstract:</label>
					  <textarea disabled class="form-control" rows="6" name="conference_presentation_abstract" required="require" ><?php echo $data['conference_presentation_abstract']; ?></textarea>
				  </div>
				  <div class="form-group">
  			  		<label>Conference Name:</label>
  					<input disabled class="form-control" name="conference_presentation_conference_name" required="require" value="<?php echo $data['conference_presentation_conference_name']; ?>">
				 </div>
				 <div class="form-group">
					 <label>Country/Region:</label>
					 <input disabled class="form-control" name="conference_presentation_country" required="require" value="<?php echo $data['conference_presentation_country']; ?>">
				 </div>
				 <div class="form-group">
				   <label>Conference Address:</label>
				   <input disabled class="form-control" name="conference_presentation_conference_address" required="require" value="<?php echo $data['conference_presentation_conference_address']; ?>">
				 </div>
			   <div class="form-group">
				   <label>Start Date</label>
				   <div class='input-group date' id='datetimepicker1'>
					   <input disabled name="conference_presentation_start_date" type='text' required="require" value="<?php echo $data['conference_presentation_start_date']; ?>" readonly class="form-control"/>
					   <span class="input-group-addon">
						   <span class="glyphicon glyphicon-calendar"></span>
					   </span>
				   </div>
			   </div>

			   <div class="form-group">
				   <label>Due Date</label>
				   <div class='input-group date' id='datetimepicker2'>
					   <input disabled name="conference_presentation_due_date" type='text' required="require" value="<?php echo $data['conference_presentation_due_date']; ?>" readonly class="form-control"/>
					   <span class="input-group-addon">
						   <span class="glyphicon glyphicon-calendar"></span>
					   </span>
				   </div>
			   </div>

              </div>
			  <div class="col-xs-6" id="pdf" style="padding-top:20px;">
				  <object data='<?php echo "upload/".$data['conference_presentation_file']; ?>'
					  type='application/pdf'
					  width='100%'
					  height='800px;'>
						  <p>This browser does not support inline PDFs. Please download the PDF to view it: <a href="helloworld">Download PDF</a></p>
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
<script type="text/javascript">
            $(function () {
                $('#datetimepicker1').datetimepicker({
                    format: 'YYYY/MM/DD',
					showTodayButton: true,
					showClear: true,
					ignoreReadonly: true
                });
				$('#datetimepicker2').datetimepicker({
                    format: 'YYYY/MM/DD',
					useCurrent: false,
					showTodayButton: true,
					showClear: true,
					ignoreReadonly: true
                });
            });
</script>

</body>
</html>
