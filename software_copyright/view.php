<?php
	session_start();
	require("../base.php");
    if (!(isset($_SESSION["staff"]) && $_SESSION["staff"] === true))
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
	}
?>


<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View Software Copyright</title>
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
    		<li><a href="/uic_project">UIC Project</a></li>
    		<li><a href="/external_project">External Project</a></li>
    		<li><a href="/journal">Publication</a></li>
    		<li><a href="/patent" class="selected">Achievements</a></li>
    		<li><a href="/applications">Applications</a></li>
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
            <div class="panel-heading">View Software Copyright</div>
            <div class="panel-body">
			<form id="data" role="form" method="post" enctype="multipart/form-data">
              <div class="col-xs-6">
                  <div class="form-group">
                    <label>Dynacomm:</label>
                    <input disabled class="form-control" name="software_copyright_dynacomm" required="require" value="<?php echo $data['software_copyright_dynacomm']; ?>">
                  </div>

				  <div class="form-group">
						<label>Author(s):</label>
					  <input disabled class="form-control" name="software_copyright_author" required="require" value="<?php echo $data['software_copyright_author']; ?>">
				  </div>
				  <div class="form-group">
					  <label>The Ways to Get it</label>
					  <select disabled class="dropdown" name="software_copyright_way">
						  <option <?php if($data['software_copyright_way'] == "Original Acquistition") echo("selected ");?> value = "Original Acquistition"> Original Acquistition</option>
						  <option <?php if($data['software_copyright_way'] == "Acquisition Cession") echo("selected ");?>value = "Acquisition Cession"> Acquisition Cession</option>
					  </select>
				  </div>

				  <div class="form-group">
					  <label>The Scope of the Right</label>
					  <select disabled class="dropdown" name="software_copyright_scope">
						  <option <?php if($data['software_copyright_scope'] == "Invited Report") echo("checked ");?> value = "Invited Report"> Full Right</option>
						  <option <?php if($data['software_copyright_scope'] == "Group Report") echo("checked ");?> value = "Group Report"> Partial Right</option>
					  </select>
				  </div>

                  <div class="form-group">
                    <label>Registration Number:</label>
                    <input disabled class="form-control" name="software_copyright_registration_number" required="require" value="<?php echo $data['software_copyright_registration_number']; ?>">
                  </div>
				  <div class="form-group">
					  <label>Completion Time</label>
					  <div class='input-group date' id='datetimepicker1'>
						  <input disabled value="<?php echo $data['software_copyright_completion_time']; ?>" name="software_copyright_completion_time" type='text' required="require" readonly class="form-control"/>
						  <span class="input-group-addon">
							  <span class="glyphicon glyphicon-calendar"></span>
						  </span>
					  </div>
				  </div>

              </div>
			  <div class="col-xs-6" id="pdf" style="padding-top:20px;">
				  <object data='<?php echo "upload/".$data['software_copyright_file']; ?>'
					  type='application/pdf'
					  width='100%'
					  height='410px;'>
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


</body>
</html>
