<?php
	session_start();
	require("../base.php");
	if (!(isset($_SESSION["staff"]) && $_SESSION["staff"] === true))
    {
		echo '<script type="text/javascript">alert("Please Login");location.href="../login.html"</script>';
    }
	$dbh = new PDO($dbinfo,$dbusername,$dbpassword);
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$sql = "select * from external_project where ep_id = ?";
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
<title>Edit Government-funded Project</title>
<?php importCss(); ?>
</head>
<body>
<div id="panelwrap">
	<div class="header">
    <div class="title"><a href="/"><img src="/uic_logo.png"></img></a></div>

    <div class="header_right">Welcome <?php echo $_SESSION['english_name']?><a href="/logout.php" class="logout">Logout</a> </div>

    <div class="menu">
    	<ul>
			<li><a href="/">Dashboard</a></li>
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
		<li><a href="/external_project" class="selected">Government-funded Project</a></li>
		<li><a href="/industry_project">Industry-funded Project</a></li>
    </ul>
    </div>

    <div>

		<div class="row">
			<div class="col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">View Government-funded Project
					</div>
					<div class="panel-body">
						<div class="col-xs-12">
							<form id="data" role="form" method="post">

								<div class="form-group">
									<label>Project Title:</label>
									<input disabled class="form-control" value="<?php echo $data['ep_title']; ?>">
								</div>

								<div class="form-group">
									<label>Project Type:</label>
									<select disabled class="dropdown" name="type">
										<option <?php if($data['ep_type'] == "National Project") echo("selected ");?>value = "National Project"> National Project</option>
										<option <?php if($data['ep_type'] == "Provincial Project") echo("selected ");?>value = "Provincial Project"> Provincial Project</option>
										<option <?php if($data['ep_type'] == "Municipal Project") echo("selected ");?>value = "Municipal Project"> Municipal Project</option>
									</select>
								</div>

								<div class="form-group">
									<label>Role:</label>
									<input disabled class="form-control" name="role" required="require" value="<?php echo $data['ep_role']; ?>">
								</div>

								<div class="form-group">
									<label>Funding Source</label>
									<input disabled class="form-control" name="source" required="require" value="<?php echo $data['ep_fundsource']; ?>">
								</div>
								<div class="form-group">
									<label>Duration: From</label>
                					<div class='input-group date' id='datetimepicker1'>
                    					<input disabled value="<?php echo $data['ep_duration_from']; ?>" class="form-control"/>
                    					<span class="input-group-addon">
                        					<span class="glyphicon glyphicon-calendar"></span>
                    					</span>
                					</div>
            					</div>

								<div class="form-group">
									<label>To</label>
                					<div class='input-group date' id='datetimepicker2'>
                    					<input disabled value="<?php echo $data['ep_duration_to']; ?>" class="form-control"/>
                    					<span class="input-group-addon">
                        					<span class="glyphicon glyphicon-calendar"></span>
                    					</span>
                					</div>
            					</div>

								<div class="form-group">
									<label>Funding Amount</label>
									<input class="form-control" disabled value="<?php echo $data['ep_amount']; ?>" oninput="if (! /^\d+$/ig.test(this.value)){this.value='';}">
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


</body>
</html>
