<?php
    session_start();
    require("../base.php");
    $url = "index.php";
    if( $_SERVER['HTTP_REFERER'] == "" )
    {
        header("Location:".$url); exit;
    }
        $personnel_deveplopment_training_category = $_POST["personnel_deveplopment_training_category"];
        $personnel_deveplopment_training_person = $_POST["personnel_deveplopment_training_person"];
        $personnel_deveplopment_project_name = $_POST["personnel_deveplopment_project_name"];
        $personnel_deveplopment_author = $_POST["personnel_deveplopment_author"];
        $personnel_deveplopment_abstract = $_POST["personnel_deveplopment_abstract"];
        $personnel_deveplopment_start_date = $_POST["personnel_deveplopment_start_date"];
        $personnel_deveplopment_due_date = $_POST["personnel_deveplopment_due_date"];
        $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //Disable Prepared Statements, in case of SQL Injection.
        $sql = "update personnel_deveplopment set personnel_deveplopment_training_category = ?, personnel_deveplopment_training_person = ?, personnel_deveplopment_project_name = ?, personnel_deveplopment_author = ?, personnel_deveplopment_abstract = ?, personnel_deveplopment_start_date = ?, personnel_deveplopment_due_date = ? where personnel_deveplopment_id = ?";
        $prepare = $dbh -> prepare($sql);
        $execute = $prepare -> execute(array($personnel_deveplopment_training_category, $personnel_deveplopment_training_person, $personnel_deveplopment_project_name, $personnel_deveplopment_author, $personnel_deveplopment_abstract, $personnel_deveplopment_start_date, $personnel_deveplopment_due_date, $_POST['id']));
        $dbh = null;
    }
?>
