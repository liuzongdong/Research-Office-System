<?php
	session_start();
	require("../base.php");
    if (!(isset($_SESSION["teacher"]) && $_SESSION["teacher"] === true))
    {
		echo '<script type="text/javascript">alert("Please Login");location.href="../../login.html"</script>';
    }
	$dbh = new PDO($dbinfo,$dbusername,$dbpassword);
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$sql = "select * from software_copyright where software_copyright_id = ?";
	$prepare = $dbh -> prepare($sql); // Statement is Statement.
	$execute = $prepare -> execute(array($_GET['id']));
	if ($execute)
	{
		$data = $prepare -> fetch(PDO::FETCH_ASSOC);
		if ($data['software_copyright_author_id'] != $_SESSION['user_id'])
		{
			echo '<script type="text/javascript">alert("You are not allow to Edit it!");location.href="index.php"</script>';
		}
	}
?>


<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Software Copyright</title>
<?php importCss(); ?>
</head>
<body>
<div id="panelwrap">

	<div class="header">
    <div class="title"><a href="/index.php"><img src="../uic_logo.png"></img></a></div>

    <div class="header_right">Welcome <?php echo $_SESSION['english_name']; ?> <a href="#" onclick="logout()" class="logout">Logout</a> </div>

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
		<li><a href="/software_copyright" class="selected">Software Copyright</a></li>
		<li><a href="/research_award">Research Award</a></li>
		<li><a href="/personnel_development">Personnel Development</a></li>
    </ul>
    </div>

    <div>

      <div class="row">
        <div class="col-xs-12">
          <div class="panel panel-default">
            <div class="panel-heading">Edit Software Copyright
				<div style="float:right">
					<label for="submitForm" class="btn btn-primary"> Submit </label>
					<label for="resetForm" class="btn btn-default"> Reset </label>
				</div>
			</div>
            <div class="panel-body">
			<form id="data" role="form" method="post" enctype="multipart/form-data">
              <div class="col-xs-6">
                  <div class="form-group">
                    <label>Dynacomm:</label>
                    <input class="form-control" name="software_copyright_dynacomm" required="require" value="<?php echo $data['software_copyright_dynacomm']; ?>">
                  </div>

				  <div class="form-group">
						<label>Author(s):</label>
					  <input class="form-control" name="software_copyright_author" required="require" value="<?php echo $data['software_copyright_author']; ?>">
				  </div>
				  <div class="form-group">
					  <label>The Ways to Get it</label>
					  <select class="dropdown" name="software_copyright_way">
						  <option <?php if($data['software_copyright_way'] == "Original Acquistition") echo("selected ");?> value = "Original Acquistition"> Original Acquistition</option>
						  <option <?php if($data['software_copyright_way'] == "Acquisition Cession") echo("selected ");?>value = "Acquisition Cession"> Acquisition Cession</option>
					  </select>
				  </div>

				  <div class="form-group">
					  <label>The Scope of the Right</label>
					  <select class="dropdown" name="software_copyright_scope">
						  <option <?php if($data['software_copyright_scope'] == "Invited Report") echo("checked ");?> value = "Invited Report"> Full Right</option>
						  <option <?php if($data['software_copyright_scope'] == "Group Report") echo("checked ");?> value = "Group Report"> Partial Right</option>
					  </select>
				  </div>

                  <div class="form-group">
                    <label>Registration Number:</label>
                    <input class="form-control" name="software_copyright_registration_number" required="require" value="<?php echo $data['software_copyright_registration_number']; ?>">
                  </div>
				  <div class="form-group">
					  <label>Completion Time</label>
					  <div class='input-group date' id='datetimepicker1'>
						  <input value="<?php echo $data['software_copyright_completion_time']; ?>" name="software_copyright_completion_time" type='text' required="require" readonly class="form-control"/>
						  <span class="input-group-addon">
							  <span class="glyphicon glyphicon-calendar"></span>
						  </span>
					  </div>
				  </div>
				  <div class="form-group">
					  <label>Please Upload File Here (PDF Only!)</label>
				  </br>
					  <input type="file" name="file" class="filestyle" data-buttonText="&nbsp Upload" accept="application/pdf">
				  </div>
				  <div class="form-group" style="text-align:center">
					<button id="submitForm" type="submit" class="btn btn-primary hidden">Submit Button</button>
					<button id="resetForm" type="reset" class="btn btn-default hidden">Reset Button</button>
				</div>
              </div>
			  <div class="col-xs-6" id="pdf" style="padding-top:20px;">
				  <object data='<?php echo "upload/".$data['software_copyright_file']; ?>'
					  type='application/pdf'
					  width='100%'
					  height='480px;'>
						  <p>This browser does not support inline PDFs. Please download the PDF to view it: <a href="<?php echo "upload/".$data['software_copyright_file']; ?>">Download PDF</a></p>
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
