<?php
	session_start();
	require("../base.php");
	if (!(isset($_SESSION["staff"]) && $_SESSION["staff"] === true))
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
	}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View Journal</title>
<?php importCss(); ?>
</head>
<body>
<div id="panelwrap">

	<div class="header">
    <div class="title"><a href="/"><img src="/uic_logo.png"></img></a></div>

    <div class="header_right">Welcome <?php echo $_SESSION['english_name']; ?><a href="#" onclick="logout()" class="logout">Logout</a> </div>

    <div class="menu">
    	<ul>
			<li><a href="/index.php">Dashboard</a></li>
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
            <div class="panel-heading">View Journal
			</div>
            <div class="panel-body">
              <div class="col-xs-6">
                <form id="data" role="form" method="post">

                  <div class="form-group">
                    <label>Title:</label>
                    <input disabled class="form-control" name="title" required="require" value="<?php echo $data['journal_title']; ?>">

                  </div>
				  <div class="form-group">
					  <label>Abstract:</label>
					  <textarea disabled class="form-control" rows="6" name="abstract" required="require"><?php echo $data['journal_abstract']; ?></textarea>
				  </div>

                  <div class="form-group">
                    <label>Author(s):</label>
                    <input disabled class="form-control" name="author" required="require" value="<?php echo $data['journal_authors']; ?>">
                  </div>

                  <div class="form-group">
                    <label>Journal Name:</label>
                    <input disabled class="form-control" name="journalname" required="require" value="<?php echo $data['journal_name']; ?>">
                  </div>

				  <div class="form-group">
					  <label>Publication Time:</label>
					  <div class='input-group date' id='datetimepicker1'>
						  <input disabled value="<?php echo $data['journal_date']; ?>"name="time" type='text' required="require" readonly class="form-control"/>
						  <span class="input-group-addon">
							  <span class="glyphicon glyphicon-calendar"></span>
						  </span>
					  </div>
				  </div>

				  <div class="form-group">
                    <label>Journal Indexed by</label>
                  </br>
                    <div class="checkbox-inline">
                      <label>
						  <input disabled type="hidden" name="sci" value="0">
                          <input disabled type="checkbox" <?php if ($data['sci'] == 1) echo "checked = \"checked\""; ?>name="sci" value="1">SCI
                      </label>
                    </div>
                    <div class="checkbox-inline">
                      <label>
						  <input type="hidden" name="ei" value="0">
                        <input disabled type="checkbox" <?php if ($data['ei'] == "1") echo "checked = \"checked\""; ?>name="ei" value="1">EI

                      </label>
                    </div>

					<div class="checkbox-inline">
					  <label>
						  <input type="hidden" name="istp" value="0">
						<input disabled type="checkbox" <?php if ($data['istp'] == "1") echo "checked = \"checked\""; ?>name="istp" value="1">ISTP

					  </label>
					</div>

					<div class="checkbox-inline">
					  <label>
						  <input type="hidden" name="if" value="0">
						<input disabled type="checkbox" <?php if ($data['iff'] == "1") echo "checked = \"checked\""; ?> name="if" value="1">IF

					  </label>
					</div>
                  </div>

				  <div class="form-group">
                    <label>Acknowledged the name of UIC?</label>
                  </br>
                    <div class="radio-inline">
                      <label>
                        <input disabled type="radio" <?php if ($data['acknowledged'] == "1") echo "checked = \"checked\""; ?>name="acknowledged" value="1">Yes
                      </label>
                    </div>
                    <div class="radio-inline">
                      <label>
                        <input disabled type="radio" <?php if ($data['acknowledged'] == "0") echo "checked = \"checked\""; ?>name="acknowledged" value="0">No
                      </label>
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Published Status of Theses:</label>
                  </br>
                    <div class="radio-inline">
                      <label>
                        <input disabled type="radio" name="published_status" value="1" <?php if ($data['journal_status'] == 1) echo "checked"; ?>>Published
                      </label>
                    </div>
                    <div class="radio-inline">
                      <label>
                        <input disabled type="radio" name="published_status" value="0" <?php if ($data['journal_status'] == 0) echo "checked"; ?>>Accepted but Unpublished
                      </label>
                    </div>
                  </div>

              </div>
			  <div class="col-xs-6" id="pdf" style="padding-top:20px;">
				  <object data='<?php echo "upload/".$data['journal_src']; ?>'
					  type='application/pdf'
					  width='100%'
					  height='630px;'>
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

</body>
</html>
