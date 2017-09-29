<?php
	session_start();
	require("base.php");
	if (!(isset($_SESSION["staff"]) && $_SESSION["staff"] === true))
    {
		echo '<script type="text/javascript">alert("Please Login");location.href="../login.html"</script>';
    }
	$dbh = new PDO($dbinfo,$dbusername,$dbpassword);
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //Disable Prepared Statements, in case of SQL Injection.
	$sql = "select * from iv_project where iv_project_status = 0"; // *, select all. '?' and '?', SQL Injection
	$prepare = $dbh -> prepare($sql); // Statement is Statement.
	$execute = $prepare -> execute(); // Var is Var.
	if ($execute)
	{
		$row = $prepare -> fetchall(PDO::FETCH_ASSOC);
		$ivCount = count($row);
	}
	$sql = "select * from uic_project where up_status = 0"; // *, select all. '?' and '?', SQL Injection
	$prepare = $dbh -> prepare($sql); // Statement is Statement.
	$execute = $prepare -> execute(); // Var is Var.
	if ($execute)
	{
		$row = $prepare -> fetchall(PDO::FETCH_ASSOC);
		$upCount = count($row);
	}
	$sql = "select * from midterm_report where midterm_report_status = 0"; // *, select all. '?' and '?', SQL Injection
	$prepare = $dbh -> prepare($sql); // Statement is Statement.
	$execute = $prepare -> execute(); // Var is Var.
	if ($execute)
	{
		$row = $prepare -> fetchall(PDO::FETCH_ASSOC);
		$mrCount = count($row);
	}
	$sql = "select * from project_undertaking where project_undertaking_status = 0"; // *, select all. '?' and '?', SQL Injection
	$prepare = $dbh -> prepare($sql); // Statement is Statement.
	$execute = $prepare -> execute(); // Var is Var.
	if ($execute)
	{
		$row = $prepare -> fetchall(PDO::FETCH_ASSOC);
		$puCount = count($row);
	}
	$sql = "select * from completion_report where completion_report_status = 0"; // *, select all. '?' and '?', SQL Injection
	$prepare = $dbh -> prepare($sql); // Statement is Statement.
	$execute = $prepare -> execute(); // Var is Var.
	if ($execute)
	{
		$row = $prepare -> fetchall(PDO::FETCH_ASSOC);
		$crCount = count($row);
	}
	$dbh = null;
	$rowCount = $ivCount + $upCount + $crCount + $mrCount + $puCount;
	echo "UIC Research Grant <span class=\"badge\">".$rowCount."</span>";
?>
