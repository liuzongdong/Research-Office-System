<?php
	session_start();
	require("../base.php");
	if (!(isset($_SESSION["teacher"]) && $_SESSION["teacher"] === true))
	{
		echo '<script type="text/javascript">alert("Please Login");location.href="../login.html"</script>';
	}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Academic Monograph</title>
<?php importCss(); ?>
</head>
<body>
<div id="panelwrap">

	<div class="header">
    <div class="title"><a href="/"><img src="/uic_logo.png"></img></a></div>

    <div class="header_right">Welcome <?php echo $_SESSION['english_name']; ?> <a href="../logout.php" class="logout">Logout</a> </div>

    <div class="menu">
    	<ul>
			<li><a href="/">Dashboard</a></li>
    		<li><a href="/profile">Profile</a></li>
    		<li><a href="/uic_project">UIC Project</a></li>
    		<li><a href="/external_project">External Project</a></li>
    		<li><a href="/journal" class="selected">Publication</a></li>
    		<li><a href="/patent" >Achievements</a></li>
    		<li><a href="/applications">Applications</a></li>
    	</ul>
    </div>

    </div>

    <div class="submenu">
    <ul>
		<li><a href="/journal" >Journal</a></li>
		<li><a href="/conference_paper">Conference Paper</a></li>
		<li><a href="/academic_monograph" class="selected">Academic Monograph</a></li>
		<li><a href="/conference_presentation">Conference Presentation</a></li>
    </ul>
    </div>

    <div>
			<div class="row">
				<div class="col-xs-12">
					<div class="panel panel-default">
						<div class="panel-heading">Add Academic Monograph
							<div style="float:right">
								<label for="submitForm" class="btn btn-primary"> Submit </label>
								<label for="resetForm" class="btn btn-default"> Reset </label>
							</div>
						</div>
						<div class="panel-body">
							<div class="col-xs-12">
								<form role="form" id="data" method="post">

									<div class="form-group">
										<label>Monograph Title:</label>
										<input class="form-control" name="academic_monograph_monograph_title" required="require">
									</div>

									<div class="form-group">
										<label>Abstract:</label>
										<textarea class="form-control" rows="6" name="academic_monograph_abstract" required="require"></textarea>
									</div>

									<div class="form-group">
										<label>Author(s):</label>
										<input class="form-control" name="academic_monograph_author" required="require">
									</div>

									<div class="form-group">
										<label>ISBN Number:</label>
										<input class="form-control" name="academic_monograph_isbn_number" required="require">
									</div>

									<div class="form-group">
										<label>Country/Region:</label>
										<input class="form-control" name="academic_monograph_country" required="require">
									</div>

									<div class="form-group">
										<label>City:</label>
										<input class="form-control" name="academic_monograph_city" required="require">
									</div>

									<div class="form-group">
										<label>Total Word:</label>
										<input class="form-control" name="academic_monograph_total_word" required="require">
									</div>

									<div class="form-group">
										<label>Press:</label>
										<input class="form-control" name="academic_monograph_press" required="require">
									</div>

									<div class="form-group">
				  					  <label>Publication Time:</label>
				  					  <div class='input-group date' id='datetimepicker1'>
				  						  <input name="academic_monograph_published_date" type='text' required="require" readonly class="form-control"/>
				  						  <span class="input-group-addon">
				  							  <span class="glyphicon glyphicon-calendar"></span>
				  						  </span>
				  					  </div>
				  				  </div>
								  <div class="form-group">
									  <label>Please Upload File Here (PDF Only!)</label>
								  </br>
									  <input type="file" name="file" class="filestyle" data-buttonText="&nbsp Upload" accept="application/pdf" required="require">
								  </div>
								  <div class="form-group" style="text-align:center">
								    <button id="submitForm" type="submit" class="btn btn-primary hidden">Submit Button</button>
								    <button id="resetForm" type="reset" class="btn btn-default hidden">Reset Button</button>
								  </div>
								</div>
						</div>
					</div>
				</div>
			</div>


		<div class="clear"></div>
		<div class="footer">©2017 United International College(UIC). All Rights Reserved.</div>


    </div> <!--end of center_content-->

</div>

<script type="text/javascript">
            $(function () {
                $('#datetimepicker1').datetimepicker({
                    format: 'YYYY/MM/DD',
					showTodayButton: true,
					showClear: true,
					ignoreReadonly: true
                });
        });
</script>
<script>
$("form#data").submit(function(){
var formData = new FormData(this);
	$.ajax({
	url: "new.php",
	type: 'POST',
	data: formData,
	async: false,

	success: function (response)
	{
		var answer = JSON.parse(response);
		switch ( answer.status_response )
		{
			case 'success' :
				swal(
					{
					title:"Good job!",
					text: "Add Succeed!",
					type: "success"
					},
					function()
					{
						setTimeout(function (){
							window.location.href = "index";
						}, 300);

					});
				break;
			case 'empty' :
				swal("Add Failed!", "Please Complete the Form or There is only Spaces in your submission", "error");
				break;
			case 'error' :
				swal("Add Failed!", "Please upload a PDF file, PDF File only!", "error");
				break;
			case 'fail' :
				swal("Add Failed!", "Please check your internet connection!", "error");
				break;

		}
	},
	error: function (xhr, ajaxOptions, thrownError)
	{
		swal("Add Failed!", "Please check your internet connection!", "error");
	},
	cache: false,
	contentType: false,
	processData: false
});

return false;
});
</script>



</body>
</html>
