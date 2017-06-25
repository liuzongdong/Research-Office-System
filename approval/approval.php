<?php
    session_start();
    require("../base.php");
    if (!(isset($_SESSION["teacher"]) && $_SESSION["teacher"] === true && $_SESSION['user_type'] === 2))
    {
        header("Location: ../index.php");
    }
    $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //Disable Prepared Statements, in case of SQL Injection.
    $sql = "update application set approval = 1 where app_id = ?";
    $prepare = $dbh -> prepare($sql);
    $execute = $prepare -> execute(array($_GET['id']));
    $dbh = null;
    echo '<script type="text/javascript">alert("Approval Suceess!");location.href="index.php"</script>';
?>
