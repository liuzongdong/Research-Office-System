<?php
    session_start();
    require("../base.php");
    $url = "index.php";
    if( $_SERVER['HTTP_REFERER'] == "" )
    {
        header("Location:".$url); exit;
    }

    // if ($_POST["name"] == "" || $_POST["code"] == "" || $_POST["authorization"] == "")
    // {
    //     header('HTTP/1.1 500 Internal Server...');
    //     header('Content-Type: application/json; charset=UTF-8');
    //     die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
    // }
    //等你修改～

    else
    {
        $personnel_deveplopment_training_category = $_POST["personnel_deveplopment_training_category"];
    	  $personnel_deveplopment_training_person = $_POST["personnel_deveplopment_training_person"];
    	  $personnel_deveplopment_project_name = $_POST["personnel_deveplopment_project_name"];
        $personnel_deveplopment_author = $_POST["personnel_deveplopment_author"];
        $personnel_deveplopment_abstract = $_POST["personnel_deveplopment_abstract"];
        $personnel_deveplopment_start_date = $_POST["personnel_deveplopment_start_date"];
        $personnel_deveplopment_due_date = $_POST["personnel_deveplopment_due_date"];
        $action = "";
        //共八个变量
        $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //Disable Prepared Statements, in case of SQL Injection.
        $sql = "insert into personnel_deveplopment (personnel_deveplopment_author_id, personnel_deveplopment_training_category, personnel_deveplopment_training_person, personnel_deveplopment_project_name, personnel_deveplopment_author, personnel_deveplopment_abstract, personnel_deveplopment_start_date, personnel_deveplopment_due_date, action) values(?, ?, ?, ?, ?, ?, ?, ?, ?)";
        //共九个值
        $prepare = $dbh -> prepare($sql);
        $execute = $prepare -> execute(array($_SESSION['user_id'], $personnel_deveplopment_training_category, $personnel_deveplopment_training_person,  $personnel_deveplopment_project_name, $personnel_deveplopment_author, $personnel_deveplopment_abstract, $personnel_deveplopment_start_date, $personnel_deveplopment_due_date, $action));
        //共九个变量，九个“？”
        if ($execute)
        {
            echo '<script type="text/javascript">alert("Add Suceess!");location.href="index.php"</script>';
        }
        else
        {
            var_dump($prepare->errorInfo());
            //echo '<script type="text/javascript">alert("Add Fail!!");location.href="index.php"</script>';
        }
        $dbh = null;
    }
?>
