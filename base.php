<?php
    $dbinfo = 'mysql: host=localhost;dbname=ro_dev';
    $dbusername = 'root';
    $dbpassword = '';
    function importCss()
    {
        echo
        "
            <link href=\"/css/style.css\" rel=\"stylesheet\">
            <link href=\"/css/bootstrap.css\" rel=\"stylesheet\">
            <link href=\"/css/bootstrap-table.css\" rel=\"stylesheet\">
            <link href=\"/css/sweetalert.css\" rel=\"stylesheet\">
            <link href=\"/css/bootstrap-datetimepicker.css\" rel=\"stylesheet\">
            <link href=\"/css/easydropdown.css\" rel=\"stylesheet\">
            <script src=\"/js/jquery.js\"></script>
            <script src=\"/js/bootstrap.js\"></script>
            <script src=\"/js/sweetalert.js\"></script>
            <script src=\"/js/logout.js\"></script>
            <script src=\"/js/placeimage.js\"></script>
            <script src=\"/js/easydropdown.js\"></script>
            <script src=\"/js/moment.js\"></script>
            <script src=\"/js/count.js\"></script>
            <script src=\"/js/bootstrap-datetimepicker.min.js\"></script>
            <script src=\"/js/bootstrap-filestyle.js\"></script>
            <script src=\"/js/validator.js\"></script>
        ";
    }


    function importFullCss()
    {
        echo
        "
            <link href=\"/css/style.css\" rel=\"stylesheet\">
            <link href=\"/css/bootstrap.css\" rel=\"stylesheet\">
            <link href=\"/css/bootstrap-table.css\" rel=\"stylesheet\">
            <link href=\"/css/sweetalert.css\" rel=\"stylesheet\">
            <link href=\"/css/bootstrap-datetimepicker.css\" rel=\"stylesheet\">
            <link href=\"/css/easydropdown.css\" rel=\"stylesheet\">
            <script src=\"/js/jquery.js\"></script>
            <script src=\"/js/bootstrap.js\"></script>
            <script src=\"/js/bootstrap-table.js\"></script>
            <script src=\"/js/bootstrap-table-export.js\"></script>
            <script src=\"/js/bootstrap-table-toolbar.js\"></script>
            <script src=\"/js/FileSaver.min.js\"></script>
            <script src=\"/js/xlsx.core.min.js\"></script>
            <script src=\"/js/jspdf.min.js\"></script>
            <script src=\"/js/jspdf.plugin.autotable.js\"></script>
            <script src=\"/js/tableExport.js\"></script>
            <script src=\"/js/sweetalert.js\"></script>
            <script src=\"/js/logout.js\"></script>
            <script src=\"/js/placeimage.js\"></script>
            <script src=\"/js/easydropdown.js\"></script>
            <script src=\"/js/moment.js\"></script>
            <script src=\"/js/download.js\"></script>
            <script src=\"/js/count.js\"></script>
            <script src=\"/js/addstatus.js\"></script>
            <script src=\"/js/bootstrap-datetimepicker.min.js\"></script>
            <script src=\"/js/bootstrap-filestyle.js\"></script>
            <script src=\"/js/validator.js\"></script>
        ";
    }

    function GetProjectCount()
    {
        $dbinfo = 'mysql: host=localhost;dbname=ro_dev';
        $dbusername = 'root';
        $dbpassword = '';
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
        echo $rowCount;
    }

    function get_client_ip()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }


    function get_browser_name($user_agent)
    {
        if (strpos($user_agent, 'Edge')) return 'Edge';
        elseif (strpos($user_agent, 'Chrome')) return 'Chrome';
        elseif (strpos($user_agent, 'Safari')) return 'Safari';
        elseif (strpos($user_agent, 'Firefox')) return 'Firefox';
        return 'Other';
    }
?>
