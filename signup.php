<?php
    require("base.php");
    $url = "login.html";
    if( $_SERVER['HTTP_REFERER'] == "" )
    {
        header("Location:".$url); exit;
    }
    $email = strip_tags($_POST["email"]);
    $password = password_hash(strip_tags($_POST["password"]), PASSWORD_DEFAULT);
    $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sql = "select * from user where user_email = ?";
    $prepare = $dbh -> prepare($sql);
    $execute = $prepare -> execute(array($email));
    if ($execute)
    {
        $row = $prepare -> fetch();
        if (empty($row))
        {
            $sql = "insert into user (user_email, password) values (?, ?)";
            $prepare = $dbh -> prepare($sql);
            $execute = $prepare -> execute(array($email, $password));
            if (!$execute)
            {
                header('HTTP/1.1 500 Internal Server...');
                header('Content-Type: application/json; charset=UTF-8');
                die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
            }
        }
        else
        {
            header('HTTP/1.1 500 Internal Server...');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
        }
    }
        $dbh = null;


?>
