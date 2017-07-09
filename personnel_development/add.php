<?php
	session_start();
	require("../base.php");
	if (!(isset($_SESSION["teacher"]) && $_SESSION["teacher"] === true))
	{
		echo '<script type="text/javascript">alert("Please Login");location.href="../login.html"</script>';
	}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Personnel Development</title>
<?php importCss(); ?>
</head>
<body>
<div id="panelwrap">

	<div class="header">
    <div class="title"><a href="#"><img src="../uic_logo.png"></img></a></div>

    <div class="header_right">Welcome <?php echo $_SESSION['english_name']. " ". $_SESSION['last_name']; ?><a href="#" onclick="logout()" class="logout">Logout</a> </div>

    <div class="menu">
    	<ul>
			<li><a href="/">Dashboard</a></li>
    		<li><a href="/profile">Profile</a></li>
    		<li><a href="/uic_project">UIC Project</a></li>
    		<li><a href="/external_project">External Project</a></li>
    		<li><a href="/journal">Publication</a></li>
    		<li><a href="/patent" class="selected">Achievements</a></li>
    		<li><a href="/applications">Applications</a></li>
				<?php if ($_SESSION['user_type'] == 2)
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
					echo "<li><a href=\"/approval\">Waiting Approval (".$rowCount.")</a></li>";
				}
				?>
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
            <div class="panel-heading">New Personnel Development
				<div style="float:right">
					<label for="submitForm" class="btn btn-primary"> Submit </label>
					<label for="resetForm" class="btn btn-default"> Reset </label>
				</div>
			</div>
            <div class="panel-body">
			<form id="data" role="form" method="post">
              <div class="col-xs-12">
				  <div class="form-group">
					  <label>Reward Category:</label>
					  <select class="dropdown" name="personnel_deveplopment_training_category">
						  <option value="Student Training">Student Training</option>
						  <option value="Young-aged Academic Leaders">Young-aged Academic Leaders</option>
					  </select>
				  </div>
				  <div class="form-group">
	                <label>Name of Trained Person:</label>
	                <input class="form-control" name="personnel_deveplopment_training_person" required="require">
	              </div>
				  <div class="form-group">
					  <label>Research Topic:</label>
					  <input class="form-control" name="personnel_deveplopment_project_name" required="require">
				  </div>
				  <div class="form-group">
	                <label>Collaborative Professor(s):</label>
	                <input class="form-control" name="personnel_deveplopment_author" required="require">
	              </div>
				  <div class="form-group">
					  <label>Abstract:</label>
					  <textarea class="form-control" rows="6" name="personnel_deveplopment_abstract" required="require"></textarea>
				  </div>
				  <div class="form-group">
					  <label>Start Date</label>
					  <div class='input-group date' id='datetimepicker1'>
						  <input name="personnel_deveplopment_start_date" type='text' required="require" readonly class="form-control"/>
						  <span class="input-group-addon">
							  <span class="glyphicon glyphicon-calendar"></span>
						  </span>
					  </div>
				  </div>

				  <div class="form-group">
					  <label>Due Date</label>
					  <div class='input-group date' id='datetimepicker2'>
						  <input name="personnel_deveplopment_due_date" type='text' required="require" readonly class="form-control"/>
						  <span class="input-group-addon">
							  <span class="glyphicon glyphicon-calendar"></span>
						  </span>
					  </div>
				  </div>
				  <div class="form-group">
					  <label>Please Upload File Here (PDF Only!)</label>
				  </br>
					  <input type="file" name="file" class="filestyle" data-buttonText="&nbsp Upload" accept="application/pdf" required="require">
				  </div>
				  <div class="form-group" style="text-align:center">
					  <button id="submitForm" type="submit" class="btn btn-primary hidden">Submit Button</button>
					  <button id="resetForm" type="reset" class="btn btn-default hidden">Reset Button</button>
				  </div>
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
				$("#datetimepicker1").on("dp.change", function (e) {
	            $('#datetimepicker2').data("DateTimePicker").minDate(e.date);
	        });
	        $("#datetimepicker2").on("dp.change", function (e) {
	            $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
	        });
	</script>
	<script>
	$("form#data").submit(function(){
	var formData = new FormData(this);
		$.ajax({
		url: "new.php",
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
						text: "Add Succeed!",
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
					swal("Add Failed!", "Please Complete the Form or There is only Spaces in your submission", "error");
					break;
				case 'error' :
					swal("Add Failed!", "Please upload a PDF file, PDF File only!", "error");
					break;
				case 'fail' :
					swal("Add Failed!", "Please check your internet connection!", "error");
					break;

			}
		},
		error: function (xhr, ajaxOptions, thrownError)
		{
			swal("Add Failed!", "Please check your internet connection!", "error");
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
