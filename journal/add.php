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
<title>Add Journal</title>
<?php importCss(); ?>
</head>
<body>
<div id="panelwrap">

	<div class="header">
    <div class="title"><a href="#"><img src="/uic_logo.png"></img></a></div>

    <div class="header_right">Welcome <?php echo $_SESSION['english_name']; ?> <a href="#" onclick="logout()" class="logout">Logout</a> </div>

    <div class="menu">
    	<ul>
			<li><a href="/index.php">Dashboard</a></li>
    		<li><a href="/profile">Profile</a></li>
    		<li><a href="/uic_project">UIC Project</a></li>
    		<li><a href="/external_project">External Project</a></li>
    		<li><a href="/journal" class="selected">Publication</a></li>
    		<li><a href="/patent" >Achievements</a></li>
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
			<li><a href="index"  class="selected">Journal</a></li>
			<li><a href="/conference_paper">Conference Paper</a></li>
			<li><a href="/academic_monograph">Academic Monograph</a></li>
			<li><a href="/conference_presentation">Conference Presentation</a></li>
    </ul>
    </div>

    <div>

      <div class="row">
        <div class="col-xs-12">
          <div class="panel panel-default">
            <div class="panel-heading">Add Journal
				<div style="float:right">
					<label for="submitForm" class="btn btn-primary"> Submit </label>
					<label for="resetForm" class="btn btn-default"> Reset </label>
				</div>
			</div>
            <div class="panel-body">
              <div class="col-xs-12">
                <form id="data" role="form" method="post">

                  <div class="form-group">
                    <label>Title:</label>
                    <input class="form-control" name="title" required="require">

                  </div>
				  <div class="form-group">
					  <label>Abstract:</label>
					  <textarea class="form-control" rows="6" name="abstract" required="require"></textarea>
				  </div>

                  <div class="form-group">
                    <label>Author(s):</label>
                    <input class="form-control" name="author" required="require">
                  </div>

                  <div class="form-group">
                    <label>Journal Name:</label>
                    <input class="form-control" name="journalname" required="require">
                  </div>

				  <div class="form-group">
					  <label>Publication Time:</label>
					  <div class='input-group date' id='datetimepicker1'>
						  <input name="time" type='text' required="require" readonly class="form-control"/>
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

			<div style="padding-top:4px;">
			  <div class="col-xs-4">
				  <div class="form-group">
                    <label>Journal Indexed by</label>
                  </br>
                    <div class="checkbox-inline">
                      <label>
						  <input type="hidden" name="sci" value="0">
                          <input type="checkbox" name="sci" value="1">SCI
                      </label>
                    </div>
                    <div class="checkbox-inline">
                      <label>
						  <input type="hidden" name="ei" value="0">
                        <input type="checkbox" name="ei" value="1">EI

                      </label>
                    </div>

					<div class="checkbox-inline">
					  <label>
						  <input type="hidden" name="istp" value="0">
						<input type="checkbox" name="istp" value="1">ISTP

					  </label>
					</div>

					<div class="checkbox-inline">
					  <label>
						  <input type="hidden" name="if" value="0">
						<input type="checkbox" name="if" value="1">IF

					  </label>
					</div>
                  </div>
			  </div>

			  <div class="col-xs-4">
				  <div class="form-group">
                    <label>Acknowledged the name of UIC?</label>
                  </br>
                    <div class="radio-inline">
                      <label>
                        <input type="radio" name="acknowledged" value="1">Yes
                      </label>
                    </div>
                    <div class="radio-inline">
                      <label>
                        <input type="radio" name="acknowledged" value="0">No
                      </label>
                    </div>
                  </div>
			  </div>

			  <div class="col-xs-4">
                  <div class="form-group">
                    <label>Published Status of Theses:</label>
                  </br>
                    <div class="radio-inline">
                      <label>
                        <input type="radio" name="published_status" value="1">Published
                      </label>
                    </div>
                    <div class="radio-inline">
                      <label>
                        <input type="radio" name="published_status" value="0">Unpublished
                      </label>
                    </div>
                  </div>
			  </div>
		  </div>
			  </br>
                  <div class="form-group" style="text-align:center">
                    <button id="submitForm" type="submit" class="btn btn-primary hidden">Submit Button</button>
                    <button id="resetForm" type="reset" class="btn btn-default hidden">Reset Button</button>
                  </div>
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
