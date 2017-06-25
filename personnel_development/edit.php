<?php
	session_start();
	require("../base.php");
    if (!(isset($_SESSION["teacher"]) && $_SESSION["teacher"] === true))
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
		if ($data['personnel_deveplopment_author_id'] != $_SESSION['user_id'])
		{
			echo '<script type="text/javascript">alert("You are not allow to Edit it!");location.href="index.php"</script>';
		}
	}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reasearch Teacher</title>
<?php importCss(); ?>
</head>
<body>
<div id="panelwrap">

	<div class="header">
    <div class="title"><a href="#"><img src="../uic_logo.png"></img></a></div>

    <div class="header_right">Welcome <?php echo $_SESSION['english_name']; ?> <a href="../logout.php" class="logout">Logout</a> </div>

    <div class="menu">
    	<ul>
			<li><a href="/index.php">Dashboard</a></li>
    		<li><a href="/profile">Profile</a></li>
    		<li><a href="/uic_project">UIC Project</a></li>
    		<li><a href="/external_project">External Project</a></li>
    		<li><a href="/publication">Publication</a></li>
    		<li><a href="/achievements" class="selected">Achievements</a></li>
    		<li><a href="/applications" >Applications</a></li>
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
            <div class="panel-heading">Edit Personnel Development</div>
            <div class="panel-body">
			<form id="data" role="form" method="post" enctype="multipart/form-data">
              <div class="col-xs-6">
					<div class="form-group">
  					  <label>Reward Category:</label>
  					  <select class="dropdown" name="personnel_deveplopment_training_category">
  						  <option <?php if($data['personnel_deveplopment_training_category'] == "Student Training") echo("selected ");?> value="Student Training">Student Training</option>
  						  <option <?php if($data['personnel_deveplopment_training_category'] == "Young-aged Academic Leaders") echo("selected ");?> value="Young-aged Academic Leaders">Young-aged Academic Leaders</option>
  					  </select>
  				  </div>

                  <div class="form-group">
                    <label>Name of Trained Person:</label>
                    <input class="form-control" name="personnel_deveplopment_training_person" required="require" value="<?php echo $data['personnel_deveplopment_training_person']; ?>">
                  </div>
				  <div class="form-group">
					  <label>Research Topic:</label>
					  <input class="form-control" name="personnel_deveplopment_project_name" required="require" value="<?php echo $data['personnel_deveplopment_project_name']; ?>">
				  </div>

                  <div class="form-group">
                    <label>Collaborative Professor(s):</label>
                    <input class="form-control" name="personnel_deveplopment_author" required="require" value="<?php echo $data['personnel_deveplopment_author']; ?>">
                  </div>
				  <div class="form-group">
					  <label>Abstract:</label>
					  <textarea class="form-control" rows="6" name="personnel_deveplopment_abstract" required="require" ><?php echo $data['personnel_deveplopment_abstract']; ?></textarea>
				  </div>
				  <div class="form-group">
					  <label>Start Date</label>
					  <div class='input-group date' id='datetimepicker1'>
						  <input value="<?php echo $data['personnel_deveplopment_start_date']; ?>" name="personnel_deveplopment_start_date" type='text' required="require" readonly class="form-control"/>
						  <span class="input-group-addon">
							  <span class="glyphicon glyphicon-calendar"></span>
						  </span>
					  </div>
				  </div>

				  <div class="form-group">
					  <label>Due Date</label>
					  <div class='input-group date' id='datetimepicker2'>
						  <input value="<?php echo $data['personnel_deveplopment_due_date']; ?>" name="personnel_deveplopment_due_date" type='text' required="require" readonly class="form-control"/>
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
			  <div class="col-xs-6" id="pdf" style="padding-top:20px;">
				  <object data='<?php echo "upload/".$data['personnel_deveplopment_file']; ?>'
					  type='application/pdf'
					  width='100%'
					  height='660px;'>
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

<script>
$("form#data").submit(function(id){
var formData = new FormData(this);
formData.append("id", <?php echo $_GET['id'];?>);
	$.ajax({
	url: "modify.php",
	type: 'POST',
	data: formData,
	async: false,

	success: function ()
	{
		swal({
			title:"Good job!",
			text: "Edit Succesfully!",
			type: "success"
		},function(){
					window.location.href = "index.php";
			});
	},
	error: function (xhr, ajaxOptions, thrownError)
	{
		swal("Editting Adding!", "Edit Fail.", "error");
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
