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

<!-- jQuery file -->

</head>
<body>
<div id="panelwrap">

	<div class="header">
    <div class="title"><a href="#"><img src="../../uic_logo.png"></img></a></div>

    <div class="header_right">Welcome <?php echo $_SESSION['englishname']; ?>,  <a href="../../logout.php" class="logout">Logout</a> </div>

    <div class="menu">
    	<ul>
        <li><a href="../index.php">Home</a></li>
      		<li><a href="../researcher">Researcher</a></li>
      		<li><a href="../staff">RO Staff</a></li>
					<li><a href="../panel" class="selected">Panel</a></li>
      		<li><a href="../pd" >PD</a></li>
      		<li><a href="../dean" >Dean</a></li>
      		<li><a href="../unit">Add Unit</a></li>
    	</ul>
    </div>

    </div>

    <div class="submenu">
    <ul>
      <li><a href="index.php" >View</a></li>
    </ul>
    </div>

    <div>
	</br>


	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">UIC Project</div>
				<div class="panel-body">
          <a href="change.php">link to change page</a>  <!-- 还没搞数据库，这个是链接到“PD-Edit-change”的页面，等你弄好数据库直接链接过去 -->
					<table data-toggle="table" data-url="data.php"  data-show-refresh="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc" >
						<thead>
						<tr>
							<th data-visible="false" data-field="upid" data-sortable="true" >Project ID</th>
							<th data-field="name" data-sortable="true" >name</th>
							<th data-field="email" data-sortable="true">email</th>
							<th data-field="action">Action</th>
						</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div><!--/.row-->

	<div class="clear"></div>
    </div> <!--end of center_content-->
	<div class="footer">©2017 United International College(UIC). All Rights Reserved.</div>

</div>


<script src="../../js/jquery.min.js"></script>
<script src="../../js/bootstrap.min.js"></script>
<script src="../../js/bootstrap-table.js"></script>
<script src="../../js/bootstrap-table-export.js"></script>





</body>
</html>
