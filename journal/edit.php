<?php
	session_start();
	require("../base.php");
	if (!(isset($_SESSION["teacher"]) && $_SESSION["teacher"] === true))
	{
		echo '<script type="text/javascript">alert("Please Login");location.href="../login.html"</script>';
	}
	$dbh = new PDO($dbinfo,$dbusername,$dbpassword);
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$sql = "select * from journal where journal_id = ?";
	$prepare = $dbh -> prepare($sql); // Statement is Statement.
	$execute = $prepare -> execute(array($_GET['id']));
	if ($execute)
	{
		$data = $prepare -> fetch(PDO::FETCH_ASSOC);
		if ($data['journal_user_id'] != $_SESSION['user_id'])
		{
			echo '<script type="text/javascript">alert("You are not allow to Edit it!");location.href="index"</script>';
		}
	}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Journal</title>
<?php importCss(); ?>
</head>
<body>
<div id="panelwrap">

	<div class="header">
    <div class="title"><a href="#"><img src="../uic_logo.png"></img></a></div>

    <div class="header_right">Welcome <?php echo $_SESSION['english_name']. " ". $_SESSION['last_name']; ?><a href="#" onclick="logout()" class="logout">Logout</a> </div>

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
		<li><a href="/journal" class="selected">Journal</a></li>
		<li><a href="/conference_paper">Conference Paper</a></li>
		<li><a href="/academic_monograph">Academic Monograph</a></li>
		<li><a href="/conference_presentation">Conference Presentation</a></li>
    </ul>
    </div>

    <div>

      <div class="row">
        <div class="col-xs-12">
          <div class="panel panel-default">
            <div class="panel-heading">Edit Journal
				<div style="float:right">
				    <label for="submitForm" class="btn btn-primary"> Submit </label>
				    <label for="resetForm" class="btn btn-default"> Reset </label>
				</div>
			</div>
            <div class="panel-body">
              <div class="col-xs-6">
                <form id="data" role="form" method="post">

                  <div class="form-group">
                    <label>Title:</label>
                    <input class="form-control" name="title" required="require" value="<?php echo $data['journal_title']; ?>">

                  </div>
				  <div class="form-group">
					  <label>Abstract:</label>
					  <textarea class="form-control" rows="6" name="abstract" required="require"><?php echo $data['journal_abstract']; ?></textarea>
				  </div>

                  <div class="form-group">
                    <label>Author(s):</label>
                    <input class="form-control" name="author" required="require" value="<?php echo $data['journal_authors']; ?>">
                  </div>

                  <div class="form-group">
                    <label>Journal Name:</label>
                    <input class="form-control" name="journalname" required="require" value="<?php echo $data['journal_name']; ?>">
                  </div>

				  <div class="form-group">
					  <label>Publication Time:</label>
					  <div class='input-group date' id='datetimepicker1'>
						  <input value="<?php echo $data['journal_date']; ?>"name="time" type='text' required="require" readonly class="form-control"/>
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

				  <div class="form-group">
                    <label>Journal Indexed by</label>
                  </br>
                    <div class="checkbox-inline">
                      <label>
						  <input type="hidden" name="sci" value="0">
                          <input type="checkbox" <?php if ($data['sci'] == 1) echo "checked = \"checked\""; ?>name="sci" value="1">SCI
                      </label>
                    </div>
                    <div class="checkbox-inline">
                      <label>
						  <input type="hidden" name="ei" value="0">
                        <input type="checkbox" <?php if ($data['ei'] == "1") echo "checked = \"checked\""; ?>name="ei" value="1">EI

                      </label>
                    </div>

					<div class="checkbox-inline">
					  <label>
						  <input type="hidden" name="istp" value="0">
						<input type="checkbox" <?php if ($data['istp'] == "1") echo "checked = \"checked\""; ?>name="istp" value="1">ISTP

					  </label>
					</div>

					<div class="checkbox-inline">
					  <label>
						  <input type="hidden" name="if" value="0">
						<input type="checkbox" <?php if ($data['iff'] == "1") echo "checked = \"checked\""; ?> name="if" value="1">IF

					  </label>
					</div>
                  </div>

				  <div class="form-group">
                    <label>Acknowledged the name of UIC?</label>
                  </br>
                    <div class="radio-inline">
                      <label>
                        <input type="radio" <?php if ($data['acknowledged'] == "1") echo "checked = \"checked\""; ?>name="acknowledged" value="1">Yes
                      </label>
                    </div>
                    <div class="radio-inline">
                      <label>
                        <input type="radio" <?php if ($data['acknowledged'] == "0") echo "checked = \"checked\""; ?>name="acknowledged" value="0">No
                      </label>
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Published Status of Theses:</label>
                  </br>
                    <div class="radio-inline">
                      <label>
                        <input type="radio" name="published_status" value="1" <?php if ($data['journal_status'] == 1) echo "checked"; ?>>Published
                      </label>
                    </div>
                    <div class="radio-inline">
                      <label>
                        <input type="radio" name="published_status" value="0" <?php if ($data['journal_status'] == 0) echo "checked"; ?>>Accepted but Unpublished
                      </label>
                    </div>
                  </div>

				  <div class="form-group" style="text-align:center">
					<button id="submitForm" type="submit" class="btn btn-primary hidden">Submit Button</button>
  					<button id="resetForm" type="reset" class="btn btn-default hidden">Reset Button</button>
                  </div>
              </div>
			  <div class="col-xs-6" id="pdf" style="padding-top:20px;">
				  <object data='<?php echo "upload/".$data['journal_src']; ?>'
					  type='application/pdf'
					  width='100%'
					  height='700px;'>
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
