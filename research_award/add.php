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
<title>Add Research Award</title>
<?php importCss(); ?>
</head>
<body>
<div id="panelwrap">

	<div class="header">
    <div class="title"><a href="/"><img src="/uic_logo.png"></img></a></div>

    <div class="header_right">Welcome <?php echo $_SESSION['english_name']; ?> <a href="#" onclick="logout()" class="logout">Logout</a> </div>

    <div class="menu">
    	<ul>
			<li><a href="/">Dashboard</a></li>
    		<li><a href="/profile">Profile</a></li>
    		<li><a href="/uic_project">UIC Project</a></li>
    		<li><a href="/external_project">External Project</a></li>
    		<li><a href="/journal">Publication</a></li>
    		<li><a href="/patent" class="selected">Achievements</a></li>
    		<li><a href="/applications">Applications</a></li>
    	</ul>
    </div>

    </div>

    <div class="submenu">
    <ul>
	  <li><a href="/patent">Patent</a></li>
  	  <li><a href="/software_copyright">Software Copyright</a></li>
  	  <li><a href="/research_award" class="selected">Research Award</a></li>
  	  <li><a href="/personnel_development">Personnel Development</a></li>
    </ul>
    </div>

    <div>

      <div class="row">
        <div class="col-xs-12">
          <div class="panel panel-default">
            <div class="panel-heading">Add Reasearch Award
				<div style="float:right">
					<label for="submitForm" class="btn btn-primary"> Submit </label>
					<label for="resetForm" class="btn btn-default"> Reset </label>
				</div>
			</div>
            <div class="panel-body">
			<form role="form" id="data" method="post">
              <div class="col-xs-12">

 			  	  <div class="form-group">
                    <label>Achievement Name:</label>
                    <input class="form-control" name="research_award_achievement_name" required="require">
                  </div>

				  <div class="form-group">
					  <label>Abstract:</label>
					  <textarea class="form-control" rows="6" name="research_award_abstract" required="require"></textarea>
				  </div>
				  <div class="form-group">
					  <label>Reward Category:</label>
					  <select class="dropdown" name="research_award_reward_category">
						  <option value="Natural Scieces">Natural Scieces</option>
						  <option value="Technological Progress">Technological Progress</option>
						  <option value="invention">Invention</option>
						  <option value="other">Other</option>
					  </select>
				  </div>
				  <div class="form-group">
					  <label>Reward Grade:</label>
					  <select class="dropdown" name="research_award_reward_grade">
						  <option value="International Scholarship Prize">International Scholarship Prize</option>
						  <option value="National First Prize">National First Prize</option>
						  <option value="National Second Prize">National Second Prize</option>
						  <option value="Provincial First Prize">Provincial First Prize</option>
						  <option value="Provincial Second Prize">Provincial Second Prize</option>
						  <option value="Other">Other</option>
					  </select>
				  </div>

                  <div class="form-group">
                    <label>Author(s):</label>
                    <input class="form-control" name="research_award_author" required="require">
                  </div>

				  <div class="form-group">
					  <label>Assessment Organization:</label>
					  <input class="form-control" name="research_award_assessment_organization" required="require">
				  </div>
				  <div class="form-group">
					  <label>Publication Time</label>
					  <div class='input-group date' id='datetimepicker1'>
						  <input name="research_award_publication_time" type='text' required="require" readonly class="form-control"/>
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
		  </form>
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
