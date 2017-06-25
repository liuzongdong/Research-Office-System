<?php
    header('Content-type:text/json');
    session_start();

    $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sql = "select upid, division, name, eamli, action from #"; // *, select all. '?' and '?', SQL Injection
    $prepare = $dbh -> prepare($sql); // Statement is Statement.
    $execute = $prepare -> execute(array()); // Var is Var.
    if ($execute)
    {
        $row = $prepare -> fetchall();
        $json = json_encode($row);
    }
    echo $json;
?>
