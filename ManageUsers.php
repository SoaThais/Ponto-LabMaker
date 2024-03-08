<?php
session_start();
if (!isset($_SESSION['Admin-name'])) {
  header("location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8">
	<title>Users</title>
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/manageusers.css">
	<link rel="icon" type="image/png" href="images/logo_azul.png">
	<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bitter:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>
	<link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <script type="text/javascript" src="js/bootbox.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script src="js/manage_users.js"></script>
	<script>
	  $(document).ready(function(){
	  	  $.ajax({
	        url: "manage_users_up.php"
	        }).done(function(data) {
	        $('#manage_users').html(data);
	      });
	    setInterval(function(){
	      $.ajax({
	        url: "manage_users_up.php"
	        }).done(function(data) {
	        $('#manage_users').html(data);
	      });
	    }, 1000);
	  });
	</script>
</head>
<body>
<?php include'header.php';?>
	<div class = "below">
		<div class = "panel-body">
			<div id = "manage_users"></div>
		</div>
	</div>

	<div class="modal fade" id="add_user" tabindex="-1" role="dialog" aria-labelledby="Add User" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="exampleModalLongTitle">Add User Data</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="b7">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="" method="POST" enctype="multipart/form-data" id="form_add_user" >
				<div class="modal-body">
						<input type = "hidden" name = "user_id" id = "user_id2">
						<label for="User-mail">Name</label>
						<input type = "text" name = "name" id = "name2" placeholder = "Name">
						<label for="User-mail">E-mail</label>
						<input type = "email" name = "email" id = "email2" placeholder = "E-mail">
						<label for = "Device">Device</label>
						<div class="sel_css">
							<select class = "dev_sel" name = "dev_sel" id = "dev_sel2">
							<option value = "0"> All Devices </option>
							<?php
								require'connectDB.php';
								$sql = "SELECT * FROM devices ORDER BY device_name ASC";
								$result = mysqli_stmt_init($conn);
								if (!mysqli_stmt_prepare($result, $sql)) {
									?>
									<script>
										bootbox.alert({
											message: "Database Error",
											closeButton: false,
											buttons: {
											ok: {
												label: 'OK',
												className: 'btn-success'
											}
											}
										}).find('.modal-dialog').addClass('modal-dialog-centered');
									</script>
									<?php
								} 
								else{
									mysqli_stmt_execute($result);
									$resultl = mysqli_stmt_get_result($result);
									while ($row = mysqli_fetch_assoc($resultl)){
							?>
									<option value="<?php 
									echo $row['device_uid'];?>"><?php
									echo $row['device_name']; 
									?></option>
							<?php
									}
								}
							?>
							</select>
						</div>
				</div>
				<div class="alert alert-danger">
					<div class="alert-icon"><span id="alert-password-icon3"></span></div> <div class="alert-text"> <span id="alert-password-text3"></span> </div>
				</div>
				<div class="modal-footer">
					<button type="button" name="user_add" id="user_add" class="btn btn-success">Save</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal" id="b8">Cancel</button>
				</div>
			</form>
		</div>
		</div>
	</div>

	<div class="modal fade" id="update_user" tabindex="-1" role="dialog" aria-labelledby="Update User" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="exampleModalLongTitle">Update User Data</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="b5">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="" method="POST" enctype="multipart/form-data" id="form_update_user" >
				<div class="modal-body">
						<input type = "hidden" name = "user_id" id = "user_id">
						<label for="User-mail">Name</label>
						<input type = "text" name = "name" id = "name" placeholder = "Name">
						<label for="User-mail">E-mail</label>
						<input type = "email" name = "email" id = "email" placeholder = "E-mail">
						<label for = "Device">Device</label>
						<div class="sel_css">
							<select class = "dev_sel" name = "dev_sel" id = "dev_sel">
							<option value = "0"> All Devices </option>
							<?php
								require'connectDB.php';
								$sql = "SELECT * FROM devices ORDER BY device_name ASC";
								$result = mysqli_stmt_init($conn);
								if (!mysqli_stmt_prepare($result, $sql)) {
									?>
									<script>
										bootbox.alert({
											message: "Database Error",
											closeButton: false,
											buttons: {
											ok: {
												label: 'OK',
												className: 'btn-success'
											}
											}
										}).find('.modal-dialog').addClass('modal-dialog-centered');
									</script>
									<?php
								} 
								else{
									mysqli_stmt_execute($result);
									$resultl = mysqli_stmt_get_result($result);
									while ($row = mysqli_fetch_assoc($resultl)){
							?>
									<option value="<?php 
									echo $row['device_uid'];?>"><?php
									echo $row['device_name']; 
									?></option>
							<?php
									}
								}
							?>
							</select>
						</div>
				</div>
				<div class="alert alert-danger">
					<div class="alert-icon"><span id="alert-password-icon2"></span></div> <div class="alert-text"> <span id="alert-password-text2"></span> </div>
				</div>
				<div class="modal-footer">
					<button type="button" name="user_upd" id="user_upd" class="btn btn-success">Save</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal" id="b6">Cancel</button>
				</div>
			</form>
		</div>
		</div>
	</div>
</body>
</html>
<script src = "js/menu.js"></script>
<script>
	$('#b5').click(function() {
	$("#alert-password-text2").hide();
	$("#alert-password-icon2").hide();
  });
  	$('#b6').click(function() {
    $("#update_user").modal("hide");
    $("#alert-password-text2").hide();
    $("#alert-password-icon2").hide();
  });
  	$('#b7').click(function() {
    $("#alert-password-text3").hide();
    $("#alert-password-icon3").hide();
  });
  	$('#b8').click(function() {
    $("#add_user").modal("hide");
    $("#alert-password-text3").hide();
    $("#alert-password-icon3").hide();
  });
</script>