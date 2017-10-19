<?php
    session_start();
    require("base.php");
    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) )
    {
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
        die( header( 'location:login.html' ) );
    }
    $email = $_POST["email"];
	$password = $_POST["password"];
    $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sql = "select * from user where user_email = ?";
    $prepare = $dbh -> prepare($sql);
    $execute = $prepare -> execute(array($email));
    if ($execute)
    {
        $row = $prepare -> fetch();
        if (password_verify($password, $row['password']))
        {
            if ($row['user_type'] == 4)
            {
                $_SESSION['user_type'] = $row['user_type'];
                $_SESSION["ip"] = $row['ip_address'];
                $_SESSION['admin'] = true;
                $_SESSION["english_name"] = $row['english_name'];
                $ip_address = get_client_ip();
                $sql = "update user set ip_address = ? where user_id = ?";
                $prepare = $dbh -> prepare($sql);
                $execute = $prepare -> execute(array($ip_address, $_SESSION["user_id"]));
                header("Location: admin/index.php");
                $dbh = null;
            }
            if ($row['user_type'] == 3)
            {
                $_SESSION['user_type'] = $row['user_type'];
                $_SESSION["ip"] = $row['ip_address'];
                $_SESSION['staff'] = true;
                $_SESSION["user_id"] = $row["user_id"];
                $_SESSION["english_name"] = $row['english_name'];
                $ip_address = get_client_ip();
                $sql = "update user set ip_address = ? where user_id = ?";
                $prepare = $dbh -> prepare($sql);
                $execute = $prepare -> execute(array($ip_address, $_SESSION["user_id"]));
                header("Location: staff.php");
                $dbh = null;
            }
                if($row['user_type'] == 1 || $row['user_type'] == 2)
    			{
                    $_SESSION["user_id"] = $row["user_id"];
                    $_SESSION["english_name"] = $row['english_name'];
                    $_SESSION["ip"] = $row['ip_address'];
                    $_SESSION['user_type'] = $row['user_type'];
                    $_SESSION['teacher'] = true;
                    $_SESSION["last_name"] = $row['last_name'];
                    $_SESSION["programme"] = $row["programme"];
                    $ip_address = get_client_ip();
                    $sql = "update user set ip_address = ? where user_id = ?";
                    $prepare = $dbh -> prepare($sql);
                    $execute = $prepare -> execute(array($ip_address, $_SESSION["user_id"]));
                    header("Location: index.php");
                    $dbh = null;
                }
        }
        else
        {
            echo '<script type="text/javascript">alert("Lgoin Fail!");location.href="login.html"</script>';
        }

        }
        $dbh = null;


?>
