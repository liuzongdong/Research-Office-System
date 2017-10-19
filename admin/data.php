<?php
    session_start();
    if (!(isset($_SESSION["admin"]) && $_SESSION["admin"] === true))
    {
		echo '<script type="text/javascript">alert("Please Login");location.href="../login.html"</script>';
    }
    require("../base.php");
    $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sql = "select user_id, user_email, user_type, division, programme, english_name, first_name, last_name, user_action from user where user_type = 1 OR user_type = 2 OR user_type = 3"; // *, select all. '?' and '?', SQL Injection
    $prepare = $dbh -> prepare($sql); // Statement is Statement.
    $execute = $prepare -> execute(); // Var is Var.
    if ($execute)
    {
        $data = $prepare -> fetchall(PDO::FETCH_ASSOC);
        foreach($data as $key => $value)
        {
            if ($data[$key]['user_type'] == 1 || $data[$key]['user_type'] == 2)
            {
                $data[$key]['user_type'] = "Teacher";
            }
            else if ($data[$key]['user_type'] == 3)
            {
                $data[$key]['user_type'] = "Staff";
            }
            $data[$key]['action'] = "<a onclick = setTeacher(".$data[$key]['user_id'].")><button type=\"button\" class=\"btn btn-primary btn-xs\">Set As Teacher</button></a> <a onclick = setStaff(".$data[$key]['user_id'].")><button type=\"button\" class=\"btn btn-danger btn-xs\">Set As Staff</button></a>";
        }
        $json = json_encode($data);
    }
    echo $json;
?>
