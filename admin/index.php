<?php
	session_start();
	require("../base.php");
    if (!(isset($_SESSION["admin"]) && $_SESSION["admin"] === true))
    {
		echo '<script type="text/javascript">alert("Please Login");location.href="../login.html"</script>';
    }
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Panel</title>
<?php importFullCss(); ?>
</head>
<body onload="getCount()">
<div id="panelwrap">

	<div class="header">
    <div class="title"><a href="index.php"><img src="/uic_logo.png"></img></a></div>

    <div class="header_right">Welcome <?php echo $_SESSION['english_name']; ?><a href="#" onclick="logout()" class="logout">Logout</a> </div>

    </div>

    <div class="submenu">
    <ul>
    <li><a href="index.php" class="selected">User Profile</a></li>
    </ul>
    </div>

    <div>

<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-default">
			<div class="panel-heading">User Profile
			<a href="sync.php"<button style="float:right; margin-top:5px;" type="button" class="btn btn-primary" name="button">Sync from Server</button></a>
		</div>
			<div class="panel-body">
				<table id="table" data-toggle="table" data-url="data.php" data-show-refresh="true" data-show-export="true" data-advanced-search="true" data-id-table="advancedTable" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc" data-show-columns="true">
					<thead>
					<tr>
						<th data-field="user_email" data-sortable="true" data-halign="center" data-align="center">Email</th>
						<th data-field="last_name" data-sortable="true" data-halign="center" data-align="center">Last Name</th>
						<th data-field="first_name" data-sortable="true" data-halign="center" data-align="center">First Name</th>
						<th data-field="english_name" data-sortable="true" data-halign="center" data-align="center">English Name</th>
						<th data-visible="false" data-field="division" data-sortable="true" data-halign="center" data-align="center">Division</th>
						<th data-visible="false" data-field="programme" data-sortable="true" data-halign="center" data-align="center">Programme</th>
						<th data-field="user_type" data-sortable="true" data-halign="center" data-align="center">Access Level</th>
						<th data-field="action" data-searchable="false" data-width="17%" data-halign="center" data-align="center">Action</th>
					</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div><!--/.row-->
		<div class="clear"></div>
		<div class="footer">©2017 United International College(UIC). All Rights Reserved.</div>


    </div> <!--end of center_content-->

</div>

<script>
function setTeacher(id) {
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this record!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, Set it!",
        closeOnConfirm: false
    }, function (isConfirm) {
        if (!isConfirm) return;
        $.ajax({
            url: "set_teacher.php",
            type: "POST",
            data: {
                id: id
            },
            dataType: "html",
            success: function (response)
			{
				var answer = JSON.parse(response);
				switch ( answer.status_response )
				{
					case 'success':
						swal("Done!", "Set Succeed", "success");
						$('#table').bootstrapTable('refresh', {silent: true});
						break;
					case 'error' :
						swal("Reset Failed!", "You are not allowed to Set it", "error");
						break;
					case 'fail' :
						swal("Reset Failed!", "Please check your internet connection!", "error");
						break;
				}

            },
            error: function (xhr, ajaxOptions, thrownError)
			{
                swal("Reset Failed!", "Please check your internet connection.", "error");
            }
        });
    });
}
</script>

<script>
function setStaff(id) {
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this record!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, reset it!",
        closeOnConfirm: false
    }, function (isConfirm) {
        if (!isConfirm) return;
        $.ajax({
            url: "set_staff.php",
            type: "POST",
            data: {
                id: id
            },
            dataType: "html",
            success: function (response)
			{
				var answer = JSON.parse(response);
				switch ( answer.status_response )
				{
					case 'success':
						swal("Done!", "Reset Succeed", "success");
						$('#table').bootstrapTable('refresh', {silent: true});
						break;
					case 'error' :
						swal("Reset Failed!", "You are not allowed to Reset it", "error");
						break;
					case 'fail' :
						swal("Reset Failed!", "Please check your internet connection!", "error");
						break;
				}

            },
            error: function (xhr, ajaxOptions, thrownError)
			{
                swal("Reset Failed!", "Please check your internet connection.", "error");
            }
        });
    });
}
</script>



</body>
</html>
