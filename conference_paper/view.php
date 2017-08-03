<?php
	session_start();
	require("../base.php");
	if (!(isset($_SESSION["staff"]) && $_SESSION["staff"] === true))
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
	}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View Conference Paper</title>
<?php importCss(); ?>
</head>
<body>
<div id="panelwrap">

	<div class="header">
    <div class="title"><a href="/"><img src="/uic_logo.png"></img></a></div>

    <div class="header_right">Welcome <?php echo $_SESSION['english_name']; ?><a href="#" onclick="logout()" class="logout">Logout</a> </div>

    <div class="menu">
    	<ul>
			<li><a href="/">Dashboard</a></li>
    		<li><a href="/uic_project">UIC Project</a></li>
    		<li><a href="/external_project">External Project</a></li>
    		<li><a href="/journal" class="selected">Publication</a></li>
    		<li><a href="/patent">Achievements</a></li>
    		<li><a href="/applications" >Applications</a></li>
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
            <div class="panel-heading">View Conference Paper</div>
            <div class="panel-body">
              <div class="col-xs-6">
                <form role="form" id="data" method="post">

					<div class="form-group">
						<label>Report Name:</label>
						<input disabled class="form-control" name="report_name" required="require" value="<?php echo $data['report_name']; ?>">
					</div>

					<div class="form-group">
						<label>Abstract:</label>
						<textarea disabled class="form-control" rows="6" name="abstract" required="require"><?php echo $data['conference_paper_abstract'];?></textarea>
					</div>

					<div class="form-group">
						<label>Author(s):</label>
						<input disabled class="form-control" name="author" required="require" value="<?php echo $data['conference_paper_authors']; ?>">
					</div>

				  <div class="form-group">
                    <label>Report Type:</label>
					<select disabled class="dropdown" name="report_type">
					  <option <?php if ($data['report_type'] == "Invited Report") echo "selected" ; ?> value = "Invited Report"> Invited Report</option>
					  <option <?php if ($data['report_type'] == "Group Report") echo "selected" ; ?> value = "Group Report"> Group Report</option>
					  <option <?php if ($data['report_type'] == "Poster Presentation") echo "selected" ; ?> value = "Poster Presentation"> Poster Presentation</option>
				  </select>
                  </div>

                  <div class="form-group">
                    <label>Conference Name:</label>
                    <input disabled class="form-control" name="conference_name" required="require" value="<?php echo $data['conference_paper_name']; ?>">
                  </div>

				  <div class="form-group">
					  <label>Conference Organizer:</label>
					  <input disabled class="form-control" name="conference_addressorganizer" required="require" value="<?php echo $data['conference_paper_organizer']; ?>">
				  </div>

				  <div class="form-group">
					  <label>Country/Region:</label>
					  <input disabled class="form-control" name="country" required="require" value="<?php echo $data['region']; ?>">
				  </div>

				  <div class="form-group">
					  <label>City:</label>
					  <input disabled class="form-control" name="city" required="require" value="<?php echo $data['city']; ?>">
				  </div>

                  <div class="form-group">
                    <label>Conference Address:</label>
                    <input disabled class="form-control" name="conference_address" required="require" value="<?php echo $data['address']; ?>">
                  </div>

				  <div class="form-group">
					  <label>Page Number:</label>
					  <input disabled class="form-control" name="page_number" required="require" value="<?php echo $data['page_number']; ?>">
				  </div>

				  <div class="form-group">
				    <label>Start Date:</label>
				    <div class='input-group date' id='datetimepicker1'>
				  	  <input disabled name="start_date" type='text' required="require" value="<?php echo $data['start_date']; ?>" readonly class="form-control"/>
				  	  <span class="input-group-addon">
				  		  <span class="glyphicon glyphicon-calendar"></span>
				  	  </span>
				    </div>
				  </div>


				  <div class="form-group">
				    <label>Due Date:</label>
				    <div class='input-group date' id='datetimepicker2'>
				  	  <input disabled name="due_date" type='text' required="require" value="<?php echo $data['due_date']; ?>" readonly class="form-control"/>
				  	  <span class="input-group-addon">
				  		  <span class="glyphicon glyphicon-calendar"></span>
				  	  </span>
				    </div>
				  </div>


				  <div class="form-group">
				  	<label>Published Date:</label>
				  	<div class='input-group date' id='datetimepicker3'>
				  		<input disabled name="published_date" type='text' required="require" value="<?php echo $data['published_date']; ?>" readonly class="form-control"/>
				  		<span class="input-group-addon">
				  			<span class="glyphicon glyphicon-calendar"></span>
				  		</span>
				  	</div>
				  </div>

			  </form>
              </div>
			  <div class="col-xs-6" id="pdf" style="padding-top:20px;">
				  <object data='<?php echo "upload/".$data['conference_paper_file']; ?>'
					  type='application/pdf'
					  width='100%'
					  height='1030px;'>
						  <p>This browser does not support inline PDFs. Please download the PDF to view it: <a href="<?php echo "upload/".$data['conference_paper_file']; ?>">Download PDF</a></p>
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


</body>
</html>
