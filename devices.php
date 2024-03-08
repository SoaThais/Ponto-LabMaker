<?php
session_start();
if (!isset($_SESSION['Admin-name'])) {
  header("location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Manage Devices</title>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/logo_azul.png">
	<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bitter:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
	<script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>
    <script type="text/javascript" src="js/bootbox.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
	<link rel="stylesheet" type="text/css" href="css/devices.css"/>
	<script src="js/dev_config.js"></script>
	<script>
		$(document).ready(function(){
		    $.ajax({
		      	url: "dev_up.php",
		      	type: 'POST',
		      	data: {
		        'dev_up': 1,
		  		}
	      	}).done(function(data) {
	  			$('#devices').html(data);
    		});
			setInterval(function(){
			$.ajax({
				url: "dev_up.php",
		      	type: 'POST',
		      	data: {
		        'dev_up': 1,
		  		}
				}).done(function(data) {
					$('#devices').html(data);
			}	);
			}, 1000);
		});
	</script>
</head>
<body>
<?php include'header.php';?>
	<div class="below">
		<div class="panel-body">
			<div id="devices"></div>
		</div>
	</div>
	<div class="modal fade" id="new-device" tabindex="-1" role="dialog" aria-labelledby="New Device" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<h3 class="modal-title" id="exampleModalLongTitle">Add New Device</h3>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			</div>
			<form action="" method="POST" enctype="multipart/form-data" id="form_add_device">
				<div class="modal-body">
					<label for="User-mail">Name</label>
					<input type="text" name="dev_name" id="dev_name" placeholder="Name" required/><br>
				</div>
				<div class="alert">
                	<div class="alert-icon"><span id="alert-name-device-icon"></span></div> <div class="alert-text"> <span id="alert-name-device"></span> </div>
            	</div>
				<div class="modal-footer">
					<button type="button" name="dev_add" id="dev_add" class="btn btn-success">Create</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
		</div>
	</div>
</body>
</html>
<script src = "js/menu.js"></script>