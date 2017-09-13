<?php
	session_start();
	require("../base.php");
	if (!(isset($_SESSION["staff"]) && $_SESSION["staff"] === true))
	{
		echo '<script type="text/javascript">alert("Please Login");location.href="../login.html"</script>';
	}
	$dbh = new PDO($dbinfo,$dbusername,$dbpassword);
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$sql = "select * from uic_project where up_id = ?";
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
<title>View UIC Project</title>
<?php importCss(); ?>
<script>
$(document).ready(function () {
    var $nav = $('#menu > ul > li');
  $nav.hover(
    function() {
        $(this).children('a').addClass('hovered');
    },
    function() {
        $(this).children('a').removeClass('hovered');
    }
);
});
</script>
<script>
$(document).ready(function () {
    var $nav = $('#menu > ul > li');
  $nav.hover(
    function() {
        $(this).children('a').addClass('hovered');
    },
    function() {
        $(this).children('a').removeClass('hovered');
    }
);
});
</script>
<script>
$(document).ready(function () {
    var $nav = $('#menu > ul > li');
  $nav.hover(
    function() {
        $(this).children('a').addClass('hovered');
    },
    function() {
        $(this).children('a').removeClass('hovered');
    }
);
});
</script>
</head>
<body>
<div id="panelwrap">

	<div class="header">
    <div class="title"><a href="/"><img src="/uic_logo.png"></img></a></div>

    <div class="header_right">Welcome <?php echo $_SESSION['english_name']?>  <a href="#" onclick="logout()" class="logout">Logout</a> </div>

    <div class="menu">
    	<ul>
			<li><a href="/">Dashboard</a></li>
			<li><a href="/policy.php">Policy</a></li>
    		<li><a href="/uic_project" class="selected">UIC Research Grant</a></li>
    		<li><a href="/external_project">External Project</a></li>
    		<li><a href="/journal">Publication</a></li>
    		<li><a href="/patent">Achievements</a></li>
    		<li><a href="/applications">Applications</a></li>
    	</ul>
    </div>

    </div>

    <div class="submenu">
    <ul>
		<li><a href="/uic_project" class="selected">Category I - III</a></li>
		<li><a href="/iv_project">Category IV</a></li>
		<li><a href="/project_undertaking">Project Budget & Undertaking</a></li>
		<li><a href="/midtern_progress_report_form">Midtern Progress Report Form</a></li>
		<li><a href="/completion_report_form">Completion Report Form</a></li>
    </ul>
    </div>

    <div>

		<div class="row">
			<div class="col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						View UIC Project
					</div>
					<div class="panel-body">
						<div class="col-xs-12">
							<form id="data" role="form" method="post">

								<div class="form-group">
									<label>Project Title:</label>
									<input class="form-control" disabled value="<?php echo $data['up_title']; ?>">
								</div>
								<div class="form-group">
									<label>Duration (From)</label>
                					<div class='input-group date' id='datetimepicker1'>
                    					<input disabled value="<?php echo $data['up_duration_from']; ?>" type='text' required="require" readonly class="form-control"/>
                    					<span class="input-group-addon">
                        					<span class="glyphicon glyphicon-calendar"></span>
                    					</span>
                					</div>
            					</div>

								<div class="form-group">
									<label>Duration (To)</label>
                					<div class='input-group date' id='datetimepicker2'>
                    					<input disabled value="<?php echo $data['up_duration_to']; ?>" type='text' required="require" readonly class="form-control"/>
                    					<span class="input-group-addon">
                        					<span class="glyphicon glyphicon-calendar"></span>
                    					</span>
                					</div>
            					</div>


							</div>
							<div class="col-xs-12" id="pdf" style="padding-top:20px;">
								<object data='<?php echo "upload/".$data['up_file']; ?>'
        							type='application/pdf'
        							width='100%'
        							height='460px'>
										<p>This browser does not support inline PDFs. Please download the PDF to view it: <a href="<?php echo "upload/".$data['up_file']; ?>">Download PDF</a></p>
								</object>
							</div>
						</form>
					</div>
				</div>
			</div><!-- /.col-->
		</div><!-- /.row -->
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
