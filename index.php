<?php
	session_start();
	require("base.php");
    if (!(isset($_SESSION["teacher"]) && $_SESSION["teacher"] === true))
    {
		session_unset();
		session_destroy();
		header("Location: login.html");
    }
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Welcome to RO System</title>
		<?php importCss(); ?>
	</head>
	<body>
		<div id="panelwrap">

		<div class="header">
    	<div class="title"><a href="/"><img src="uic_logo.png"></img></a></div>

    	<div class="header_right">Welcome,  <?php echo $_SESSION['english_name']; ?><a href="#" onclick="logout()" class="logout">Logout</a> </div>

    	<div class="menu">
    	<ul>
    		<li><a href="/" class="selected">Dashboard</a></li>
    		<li><a href="/profile">Profile</a></li>
    		<li><a href="/uic_project">UIC Project</a></li>
    		<li><a href="/external_project">External Project</a></li>
    		<li><a href="/journal">Publication</a></li>
    		<li><a href="/patent">Achievements</a></li>
    		<li><a href="/applications">Applications</a></li>
			<?php
			if ($_SESSION['user_type'] == 2)
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
				$dbh = null;
				echo "<li><a href=\"/approval\">Waiting Approval (".$rowCount.")</a></li>";
			}
			?>
    	</ul>
    </div>

    </div>

    <div class="submenu">
    <ul>
    <li><a href="/" class="selected">Dashboard</a></li>
    <li><a href="policy">Policy</a></li>
    </ul>
    </div>
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">

				<div class="panel-heading">
					Qucik Access

					</div>

				<div class="panel-body">
					<?php
						if (get_browser_name($_SERVER['HTTP_USER_AGENT']) == "Other")
						{
							echo "
							<div class=\"alert alert-danger\">
								Please use <strong>Firefox, Chrome, Safari or Edge</strong>. Current browser can not get the best experience, all functions are disabled now. <button name=\"button\" style=\"float:right;\" class=\"btn btn-xs btn-danger\" >Use it anyway</button>
							</div>
							";
						}
					?>
					<div class="alert alert-success">
						Your last login IP is: <strong><?php echo $_SESSION['ip']; ?></strong>. If there is any question, please contect webmaster and change your password.
					</div>

						<div class="col-xs-12" style="padding-top:15px; padding-bottom:15px;text-align:center;">
							<div class="col-xs-2">
								<a href="journal" style="color:black"><img src="images/publication.jpg" width="55%"></i><h5>Journal</h5></a>
							</div>
							<div class="col-xs-2">
								<a href="patent" style="color:black"><img src="images/patent.jpg" width="55%"></i><h5>Patent</h5></a>
							</div>
							<div class="col-xs-2">
								<a href="uic_project" style="color:black"><img src="images/project.jpg" width="55%"></i><h5>UIC Project</h5></a>
							</div>
							<div class="col-xs-2">
								<a href="software_copyright" style="color:black"><img src="images/software.jpg" width="55%"></i><h5>Software Copyright</h5></a>
							</div>
							<div class="col-xs-2">
								<a href="profile" style="color:black"><img src="images/profile.png" width="55%"></i><h5>Profile</h5></a>
							</div>
							<div class="col-xs-2">
								<a href="applications" style="color:black"><img src="images/application.jpg" width="55%"></i><h5>Application</h5></a>
							</div>

						</div>
				</div>
			</div>
		</div>
	</div><!--/.row-->

    <div>


		<div class="clear"></div>
		<div class="footer">©2017 United International College(UIC). All Rights Reserved.</div>
    </div> <!--end of center_content-->

</div>
<?php
	if (get_browser_name($_SERVER['HTTP_USER_AGENT']) == "Other")
	{
		echo "
		<script>
		$('a').addClass('disabled');
		$('button').click(function(){
		    $('a').removeClass('disabled');
		});
		</script>
		";
	}
?>



</body>
</html>
