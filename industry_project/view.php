<?php
	session_start();
	require("../base.php");
	if (!(isset($_SESSION["staff"]) && $_SESSION["staff"] === true))
    {
		echo '<script type="text/javascript">alert("Please Login");location.href="../login.html"</script>';
    }
	$dbh = new PDO($dbinfo,$dbusername,$dbpassword);
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$sql = "select * from industry_project where ip_id = ?";
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
<title>View Industry Project</title>
</head>
<?php importCss(); ?>
<body>
<div id="panelwrap">
	<div class="header">
    <div class="title"><a href="/"><img src="/uic_logo.png"></img></a></div>

    <div class="header_right">Welcome <?php echo $_SESSION['english_name']; ?><a href="#" onclick="logout()" class="logout">Logout</a> </div>

    <div class="menu">
    	<ul>
			<li><a href="/">Dashboard</a></li>
    		<li><a href="/profile">Profile</a></li>
    		<li><a href="/uic_project">UIC Project</a></li>
    		<li><a href="/external_project" class="selected">External Project</a></li>
    		<li><a href="/journal">Publication</a></li>
    		<li><a href="/patent">Achievements</a></li>
    		<li><a href="/applications">Applications</a></li>
    	</ul>
    </div>

    </div>

    <div class="submenu">
    <ul>
		<li><a href="/external_project">Government-funded Project</a></li>
		<li><a href="/industry_project" class="selected">Industry-funded Project</a></li>
    </ul>
    </div>

    <div>

		<div class="row">
			<div class="col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">View Industry Project
					</div>
					<div class="panel-body">
						<div class="col-xs-12">
							<form role="form" id="data" method="post">

								<div class="form-group">
									<label>Project Title:</label>
									<input disabled class="form-control" name="title" required="require" value="<?php echo $data['ip_title']; ?>">
								</div>
								<div class="form-group">
									<label>Project Type:</label>
									<select disabled class="dropdown" name="type">
										<option <?php if($data['ip_type'] == "Horizontal Project") echo("selected ");?> value = "Horizontal Project"> Horizontal Project</option>
										<option <?php if($data['ip_type'] == "Vertical Project") echo("selected ");?> value = "Vertical Project"> Vertical Project</option>
									</select>
								</div>

								<div class="form-group">
									<label>Role:</label>
									<input disabled class="form-control" name="role" required="require" value="<?php echo $data['ip_role']; ?>">
								</div>

								<div class="form-group">
									<label>Funding Source</label>
									<input disabled class="form-control" name="source" required="require" value="<?php echo $data['ip_fundsource']; ?>">
								</div>

								<div class="form-group">
									<label>Duration: From</label>
                					<div class='input-group date' id='datetimepicker1'>
                    					<input disabled value="<?php echo $data['ip_duration_from']; ?>"name="from" type='text' required="require" readonly class="form-control"/>
                    					<span class="input-group-addon">
                        					<span class="glyphicon glyphicon-calendar"></span>
                    					</span>
                					</div>
            					</div>

								<div class="form-group">
									<label>To</label>
                					<div class='input-group date' id='datetimepicker2'>
                    					<input disabled value="<?php echo $data['ip_duration_to']; ?>" name="to" type='text' required="require" readonly class="form-control"/>
                    					<span class="input-group-addon">
                        					<span class="glyphicon glyphicon-calendar"></span>
                    					</span>
                					</div>
            					</div>

								<div class="form-group">
									<label>Funding Amount</label>
									<input disabled class="form-control" name="amount" required="require" value="<?php echo $data['ip_amount']; ?>" oninput="if (! /^\d+$/ig.test(this.value)){this.value='';}">
								</div>


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
