<?php
	session_start();
    if (!(isset($_SESSION["admin"]) && $_SESSION["admin"] === true))
    {
		echo '<script type="text/javascript">alert("Please Login");location.href="../../login.html"</script>';
    }
?>
<html>
	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>RO Admin</title>
		<link href="../../css/bootstrap.min.css" rel="stylesheet">
		<link href="../../css/style.css" rel="stylesheet">
		<link href="../../css/bootstrap-table.css" rel="stylesheet">

	</head>
	<body>
		<div id="panelwrap">

		<div class="header">
    	<div class="title"><a href="index.php"><img src="../../uic_logo.png"></img></a></div>

    	<div class="header_right">Welcome <?php echo $_SESSION['username']; ?>,  <a href="../../logout.php" class="logout">Logout</a> </div>

    	<div class="menu">
    	<ul>
			<li><a href="../index.php">Home</a></li>
    		<li><a href="../researcher">Researcher</a></li>
    		<li><a href="../staff">RO Staff</a></li>
				 <li><a href="../panel">Panel</a></li>
    		<li><a href="index.php" class="selected">PD</a></li>
    		<li><a href="../dean">Dean</a></li>
    		<li><a href="../unit">Add Unit</a></li>
    	</ul>
    </div>

    </div>

    <div class="submenu">
    <ul>
    	<li><a href="index.php" >Import</a></li>
    	<li><a href="edit.php">Edit</a></li>
		<li><a href="new.php" class="selected">New</a></li>
    </ul>
    </div>

    <div>
		<div class="row">
			<div class="col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">Import New PD</div>
					<div class="panel-body">
						<div class="col-xs-12">
              <div class="form-group" style="text-align:left">
              <div class="form-group">
        </br>
           <label>Institution/Division:</label>
           <select class="form-control" runat="server" name="inv_div" id="division" onchange="selectdivision(this);">
           </select>
          </div>
        </div>
        </br>
          <div class="form-group">
           <label>Programme:</label>
           <select class="form-control" runat="server" name="inv_prog" id="program">
           </select>
          </div>
        </br>
              <div class="form-group">
                <label>Name:</label>
                <input class="form-control" name="name">
              </div>
        </br>

              <div class="form-group">
                <label>Email:</label>
                <input class="form-control" name="email">
              </div>
        </br>
                <div class="form-group" style="text-align:center">
                  <button type="submit" class="btn btn-primary">Submit Button</button>
                  <span style="font-size:20px;">&nbsp;&nbsp;&nbsp;</span>
                  <button type="reset" class="btn btn-default">Reset Button</button>
                </div>
                </div>



					</div>
				</div>
			</div><!-- /.col-->
		</div><!-- /.row -->

		<div class="clear"></div>
		<div class="footer">©2017 United International College(UIC). All Rights Reserved.</div>
    </div> <!--end of center_content-->

</div>

<script src="../../js/jquery.min.js"></script>
<script src="../../js/bootstrap.min.js"></script>
<script src="../../js/bootstrap-table.js"></script>
<script type="text/javascript">
    var list1 = new Array;
    var list2 = new Array;
    list1[list1.length] = "DST";
    list1[list1.length] = "DBM";
    list1[list1.length] = "DHSS";
    list1[list1.length] = "DCC";


    list2[list2.length] = new Array("APSY", "CST", "ENVS", "FM", "FST", "STAT", "DS");
    list2[list2.length] = new Array("ACCT", "FIN", "AE", "MHR", "MKT", "BMIS");
    list2[list2.length] = new Array("ATS", "CELL", "ELLS", "GIR", "IJ", "PRA", "SWSA", "TESL");
    list2[list2.length] = new Array("CCM", "CTV", "MAD", "CMP", "MUSIC");

    var ddldivision = document.getElementById("division");
    var ddlprogram = document.getElementById("program");
    for(var i =0;i<list1.length; i++)
    {
        var option = document.createElement("option");
        option.appendChild(document.createTextNode(list1[i]));
        option.value = list1[i];
        ddldivision.appendChild(option);
        //program initialize
        var firstdivision = list2[0];
        for (var j = 0; j < firstdivision.length; j++) {
            var optionprogram = document.createElement("option");
            optionprogram.appendChild(document.createTextNode(firstdivision[j]));
            optionprogram.value = firstdivision[j];
            ddlprogram.appendChild(optionprogram);
        }
    }
    function indexof(obj,value)
    {
        var k=0;
        for(;k<obj.length;k++)
        {
            if(obj[k] == value)
            return k;
        }
        return k;
    }
    function selectdivision(obj) {
        ddlprogram.options.length = 0;//clear
        var index = indexof(list1,obj.value);
        var list2element = list2[index];
        for(var i =0;i<list2element.length; i++)
        {
            var option = document.createElement("option");
            option.appendChild(document.createTextNode(list2element[i]));
            option.value = list2element[i];
            ddlprogram.appendChild(option);
        }
    }
</script>


</body>
</html>
