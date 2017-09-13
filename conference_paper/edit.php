<?php
	session_start();
	require("../base.php");
	if (!(isset($_SESSION["teacher"]) && $_SESSION["teacher"] === true))
	{
		echo '<script type="text/javascript">alert("Please Login");location.href="../login.html"</script>';
	}
	$dbh = new PDO($dbinfo,$dbusername,$dbpassword);
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$sql = "select * from conference_paper where conference_paper_id = ?";
	$prepare = $dbh -> prepare($sql); // Statement is Statement.
	$execute = $prepare -> execute(array($_GET['id']));
	if ($execute)
	{
		$data = $prepare -> fetch(PDO::FETCH_ASSOC);
		if ($data['conference_paper_user_id'] != $_SESSION['user_id'])
		{
			echo '<script type="text/javascript">alert("You are not allow to Edit it!");location.href="conference_paper.php"</script>';
		}
	}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Conference Paper</title>
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
    <div class="title"><a href="/"><img src="../uic_logo.png"></img></a></div>

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
		<li><a href="/journal" >Journal</a></li>
		<li><a href="/conference_paper" class="selected">Conference Paper</a></li>
		<li><a href="/academic_monograph">Academic Monograph</a></li>
		<li><a href="/conference_presentation">Conference Presentation</a></li>
    </ul>
    </div>
    <div>

			<div class="row">
        <div class="col-xs-12">
          <div class="panel panel-default">
            <div class="panel-heading">Edit Conference Paper
				<div style="float:right">
					<label for="submitForm" class="btn btn-primary"> Submit </label>
					<label for="resetForm" class="btn btn-default"> Reset </label>
				</div>
			</div>
            <div class="panel-body">
              <div class="col-xs-6">
                <form role="form" id="data" method="post">

					<div class="form-group">
						<label>Report Name:</label>
						<input class="form-control" name="report_name" required="require" value="<?php echo $data['report_name']; ?>">
					</div>

					<div class="form-group">
						<label>Abstract:</label>
						<textarea class="form-control" rows="6" name="abstract" required="require"><?php echo $data['conference_paper_abstract'];?></textarea>
					</div>

					<div class="form-group">
						<label>Author(s):</label>
						<input class="form-control" name="author" required="require" value="<?php echo $data['conference_paper_authors']; ?>">
					</div>

				  <div class="form-group">
                    <label>Report Type:</label>
					<select class="dropdown" name="report_type">
					  <option <?php if ($data['report_type'] == "Invited Report") echo "selected" ; ?> value = "Invited Report"> Invited Report</option>
					  <option <?php if ($data['report_type'] == "Group Report") echo "selected" ; ?> value = "Group Report"> Group Report</option>
					  <option <?php if ($data['report_type'] == "Poster Presentation") echo "selected" ; ?> value = "Poster Presentation"> Poster Presentation</option>
				  </select>
                  </div>

                  <div class="form-group">
                    <label>Conference Name:</label>
                    <input class="form-control" name="conference_name" required="require" value="<?php echo $data['conference_paper_name']; ?>">
                  </div>

				  <div class="form-group">
					  <label>Conference Organizer:</label>
					  <input class="form-control" name="conference_addressorganizer" required="require" value="<?php echo $data['conference_paper_organizer']; ?>">
				  </div>

				  <div class="form-group">
					  <label>Country/Region:</label>
					  <input class="form-control" name="country" required="require" value="<?php echo $data['region']; ?>">
				  </div>

				  <div class="form-group">
					  <label>City:</label>
					  <input class="form-control" name="city" required="require" value="<?php echo $data['city']; ?>">
				  </div>

                  <div class="form-group">
                    <label>Conference Address:</label>
                    <input class="form-control" name="conference_address" required="require" value="<?php echo $data['address']; ?>">
                  </div>

				  <div class="form-group">
					  <label>Page Number:</label>
					  <input class="form-control" name="page_number" required="require" value="<?php echo $data['page_number']; ?>">
				  </div>

				  <div class="form-group">
				    <label>Start Date:</label>
				    <div class='input-group date' id='datetimepicker1'>
				  	  <input name="start_date" type='text' required="require" value="<?php echo $data['start_date']; ?>" readonly class="form-control"/>
				  	  <span class="input-group-addon">
				  		  <span class="glyphicon glyphicon-calendar"></span>
				  	  </span>
				    </div>
				  </div>


				  <div class="form-group">
				    <label>Due Date:</label>
				    <div class='input-group date' id='datetimepicker2'>
				  	  <input name="due_date" type='text' required="require" value="<?php echo $data['due_date']; ?>" readonly class="form-control"/>
				  	  <span class="input-group-addon">
				  		  <span class="glyphicon glyphicon-calendar"></span>
				  	  </span>
				    </div>
				  </div>


				  <div class="form-group">
				  	<label>Published Date:</label>
				  	<div class='input-group date' id='datetimepicker3'>
				  		<input name="published_date" type='text' required="require" value="<?php echo $data['published_date']; ?>" readonly class="form-control"/>
				  		<span class="input-group-addon">
				  			<span class="glyphicon glyphicon-calendar"></span>
				  		</span>
				  	</div>
				  </div>

				  <div class="form-group">
					  <label>Please Upload File Here if any. (PDF Only!)</label>
				  </br>
					  <input type="file" name="file" class="filestyle" data-buttonText="&nbsp Upload" accept="application/pdf">
				  </div>
				  <div class="form-group" style="text-align:center">
                    <button id="submitForm" type="submit" class="btn btn-primary hidden">Submit Button</button>
                    <button id="resetForm" type="reset" class="btn btn-default hidden">Reset Button</button>
                  </div>

			  </form>
              </div>
			  <div class="col-xs-6" id="pdf" style="padding-top:20px;">
				  <object data='<?php echo "upload/".$data['conference_paper_file']; ?>'
					  type='application/pdf'
					  width='100%'
					  height='1100px;'>
						  <p>This browser does not support inline PDFs. Please download the PDF to view it: <a href="helloworld">Download PDF</a></p>
				  </object>
			  </div>
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
				$('#datetimepicker3').datetimepicker({
                    format: 'YYYY/MM/DD',
					useCurrent: false,
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
							window.location.href = "index";
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
