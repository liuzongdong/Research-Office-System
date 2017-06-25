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
			<li><a href="../index.php">Dashboard</a></li>
    		<li><a href="../profile">Profile</a></li>
    		<li><a href="../uic_project">UIC Project</a></li>
    		<li><a href="../external_project">External Project</a></li>
    		<li><a href="../publication">Publication</a></li>
    		<!-- <li><a href="../patent">Patent</a></li> -->
    		<li><a href="../achievements" class="selected">Achievements</a></li>
    		<li><a href="../applications" >Applications</a></li>
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
            <div class="panel-heading">New Personnel Development</div>
            <div class="panel-body">
              <div class="col-xs-12">
							<form id="data" role="form" method="post">

							<div class="form-group">
									 <label>Training Category:</label>
									</br>
										<div class="radio-inline">
						 		 <label>
						  			<input type="radio" name="personnel_deveplopment_training_category" value="1">Student Training
		         		 </label>
		          		</div>
                   	<div class="radio-inline">
			          	<label>
				      			<input type="radio" name="personnel_deveplopment_training_category" value="0">Young-aged Academic Leaders
					        </label>
				      		</div>
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
								<label>Start Date:</label>
								<div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
										<input class="form-control" name="personnel_deveplopment_start_date" size="16" required="require" type="text" value="" readonly>
										<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>

							<div class="form-group">
								<label>Due Date:</label>
								<div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
										<input class="form-control" name="personnel_deveplopment_due_date" size="16" required="require" type="text" value="" readonly>
										<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>

              <div class="form-group" style="text-align:center">
                <button type="submit" class="btn btn-primary">Submit Button</button>
                <button type="reset" class="btn btn-default">Reset Button</button>
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

		<script>
		$("form#data").submit(function(){
		var formData = new FormData(this);
			$.ajax({
			url: "new.php",
			type: 'POST',
			data: formData,
			async: false,

			success: function ()
			{
				swal({
					title:"Good job!",
					text: "Add Succesfully!",
					type: "success"
				},function()
				{
					setTimeout(function (){
						window.location.href = "index.php";
					}, 300);

	    		});
			},
			error: function (xhr, ajaxOptions, thrownError)
			{
				swal("Error Adding!", "Add Fail.", "error");
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
