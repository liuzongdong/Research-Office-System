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
</head>
<body>
<div id="panelwrap">

	<div class="header">
    <div class="title"><a href="#"><img src="../uic_logo.png"></img></a></div>

    <div class="header_right">Welcome <?php echo $_SESSION['english_name']; ?><a href="#" onclick="logout()" class="logout">Logout</a> </div>

    <div class="menu">
    	<ul>
			<li><a href="/">Dashboard</a></li>
    		<li><a href="/uic_project">UIC Project</a></li>
    		<li><a href="/external_project">External Project</a></li>
    		<li><a href="/journal" class="selected">Publication</a></li>
    		<li><a href="/patent" >Achievements</a></li>
    		<li><a href="/applications">Applications</a></li>
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
