<?php
	session_start();
	require("../base.php");
	if (!(isset($_SESSION["staff"]) && $_SESSION["staff"] === true))
	{
		echo '<script type="text/javascript">alert("Please Login");location.href="../../login.html"</script>';
	}
	$dbh = new PDO($dbinfo,$dbusername,$dbpassword);
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$sql = "select * from midterm_report where midterm_report_id = ?";
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
<title>View UIC Project</title>
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
		<li id="uic-project"><a href="/uic_project" class="selected">UIC Research Grant</a>
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
		<li><a href="/uic_project" >Category I - III</a></li>
  	  <li><a href="/iv_project">Category IV</a></li>
  	  <li><a href="/project_undertaking">Project Budget & Undertaking</a></li>
  	  <li><a href="/midterm_progress_report_form" class="selected">Midterm Progress Report</a></li>
  	  <li><a href="/completion_report_form">Completion Report</a></li>
    </ul>
    </div>

    <div>

		<div class="row">
			<div class="col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						View UIC Project(midterm Progress Report Form)
					</div>
					<div class="panel-body">
						<div class="col-xs-6">
							<form id="data" role="form" method="post">
                <div class="form-group">
                  <label>Title:</label>
                  <input disabled class="form-control" name="midterm_progress_report_form_title" required="require"value="<?php echo $data['midterm_progress_report_form_title']; ?>">
                </div>
              </br>
                  <div class="form-group">
					  <table id="table" data-toggle="table">
						  <thead>
						  <tr>
							  <th data-halign="center" data-align="center">Research Team</th>
							  <th data-halign="center" data-align="center">Name/Post</th>
							  <th data-halign="center" data-align="center">Academic Unit</th>
						  </tr>
						  </thead>
						  <tbody>
							  <tr>
								  <td>Principal Investigator</td>
								  <td> <input disabled class="form-control" name="mp_principal_investigator_name" required="require" value="<?php echo $data['mp_principal_investigator_name']; ?>"></td>
								  <td> <input disabled class="form-control" name="mp_principal_investigator_unit" required="require" value="<?php echo $data['mp_principal_investigator_unit']; ?>"></td>
							  </tr>
							  <tr>
								  <td>Co-investigator(s)</td>
								  <td> <input disabled class="form-control" name="mp_co_investigator_name" required="require" value="<?php echo $data['mp_co_investigator_name']; ?>"></td>
								  <td> <input disabled class="form-control" name="mp_co_investigator_unit" required="require" value="<?php echo $data['mp_co_investigator_unit']; ?>"></td>
							  </tr>
							  <tr>
								  <td>Others</td>
								  <td> <input disabled class="form-control" name="mp_others_name" required="require" value="<?php echo $data['mp_others_name']; ?>"></td>
								  <td> <input disabled class="form-control" name="mp_others_unit" required="require" value="<?php echo $data['mp_others_unit']; ?>"></td>
							  </tr>
						  </tbody>
					  </table>
                </div>

                <div class="form-group">
                  <label>Project Starting Date:</label>
                          <div class='input-group date' id='datetimepicker1'>
                              <input disabled id="startDate" name="midterm_progress_report_form_project_starting_date" type='text' required="require" readonly class="form-control">
                              <span class="input-group-addon">
                                  <span class="glyphicon glyphicon-calendar"></span>
                              </span>
                          </div>
                </div>

                <div class="form-group">
                  <label>Project Completion Date:</label>
                          <div class='input-group date' id='datetimepicker2'>
                              <input disabled id="endDate" name="midterm_progress_report_form_project_completion_date" type='text' required="require" readonly class="form-control">
                              <span class="input-group-addon">
                                  <span class="glyphicon glyphicon-calendar"></span>
                              </span>
                          </div>
                </div>

                <div class="form-group">
                  <label>Duration (Please input Manually):</label>
                  <input disabled id="duration" class="form-control" name="midterm_progress_report_form_duration" required="require" value="<?php echo $data['midterm_progress_report_form_duration']; ?>">
                </div>

				</div>
				<div class="col-xs-6" id="pdf" style="padding-top:20px;">
					<object data='<?php echo "upload/".$data['midterm_report_file']; ?>'
						type='application/pdf'
						width='100%'
						height='500px'>
							<p>This browser does not support inline PDFs. Please download the PDF to view it: <a href="helloworld">Download PDF</a></p>
					</object>
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
<script type="text/javascript">
            $(function () {
                $('#datetimepicker1').datetimepicker({
					useCurrent: false,
                    format: 'YYYY/MM/DD',
					defaultDate: moment('<?php echo $data['midterm_progress_report_form_project_starting_date']; ?>', 'YYYY-MM-DD'),
					showTodayButton: true,
					showClear: true,
					ignoreReadonly: true
                });
				$('#datetimepicker2').datetimepicker({
					useCurrent: false,
                    format: 'YYYY/MM/DD',
					defaultDate: moment('<?php echo $data['midterm_progress_report_form_project_completion_date']; ?>', 'YYYY-MM-DD'),
					showTodayButton: true,
					showClear: true,
					ignoreReadonly: true
                });
            });
</script>
<script>
$("form#data").submit(function(id){
var formData = new FormData(this);
formData.append("id", <?php echo $_GET['id'];?>);
	$.ajax({
	url: "modify.php",
	type: 'POST',
	data: formData,
	async: false,

	success: function (response)
	{
		var answer = JSON.parse(response);
		switch ( answer.status_response )
		{
			case 'success' :
				swal(
					{
					title:"Good job!",
					text: "Edit Succeed!",
					type: "success"
					},
					function()
					{
						setTimeout(function (){
							window.location.href = "index.php";
						}, 300);

					});
				break;
			case 'empty' :
				swal("Edit Failed!", "Please Complete the Form or There is only Spaces in your submission", "error");
				break;
			case 'error' :
				swal("Edit Failed!", "Please upload a PDF file, PDF File only!", "error");
				break;
			case 'fail' :
				swal("Edit Failed!", "Please check your internet connection!", "error");
				break;

		}
	},
	error: function (xhr, ajaxOptions, thrownError)
	{
		swal("Edit Failed!", "Please check your internet connection.", "error");
	},
	cache: false,
	contentType: false,
	processData: false
});

return false;
});
</script>


</body>
</html>
