<?php
    session_start();
    if (!(isset($_SESSION["staff"]) && $_SESSION["staff"] === true))
    {
		echo '<script type="text/javascript">alert("Please Login");location.href="../login.html"</script>';
    }
    require("../base.php");
    $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sql = "select user_id, user_email, division, programme, english_name, first_name, last_name, user_action from user where user_type = 1"; // *, select all. '?' and '?', SQL Injection
    $prepare = $dbh -> prepare($sql); // Statement is Statement.
    $execute = $prepare -> execute(); // Var is Var.
    if ($execute)
    {
        $data = $prepare -> fetchall(PDO::FETCH_ASSOC);
        foreach($data as $key => $value)
        {
            $data[$key]['action'] = "<a href=\"detail.php?id=".$data[$key]['user_id']."\"><button type=\"button\" class=\"btn btn-primary btn-xs\">View</button></a> <a onclick = resetPassword(".$data[$key]['user_id'].")><button type=\"button\" class=\"btn btn-danger btn-xs\">Reset Password</button></a>";
        }
        $json = json_encode($data);
    }
    echo $json;
?>
