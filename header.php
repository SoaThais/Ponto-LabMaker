<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel='stylesheet' type='text/css' href="css/bootstrap.css"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/header.css"/>
	<link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">
	<link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bitter:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<header>
	<div class="main">
        <div class="side-navbar">
            <ul>
                <li><a href="#">
					<span class="icon"><i class='bx bx-station'></i></span>
                    <span class="text_name">FreqMaker</span>
                </a></li>
                <!-- <li><a href="index.php">
					<span class="icon"><i class='bx bxs-group'></i></span>
                    <span class="text">Users</span>
                </a></li> -->
                <li><a href="ManageUsers.php">
                    <span class="icon"><i class='bx bxs-group'></i></span>
                    <span class="text">Users</span>
                </a></li>
                <li><a href="UsersLog.php">
                    <span class="icon"><i class='bx bxs-notepad'></i></span>
                    <span class="text">Users Logs</span>
                </a></li>
                <li><a href="devices.php">
                    <span class="icon"><i class='bx bxs-devices'></i></span>
                    <span class="text">Devices</span>
                </a></li>
				<li><a href="logout.php">
                    <span class="icon"><i class='bx bxs-log-out'></i></span>
                    <span class="text">Log Out</span>
                </a></li>
            </ul>
			<div class="side-by-side">
				<img src="images\logoL_branca.png" alt="Imagem" class="logoLab">
				<img src="images\nomeL_branca.png" alt="Imagem" class="nomeLab">
      		</div>
        </div>
        <div class="content">
            <div class="top-navbar">
                <div class="bx bx-menu" id="menu-icon"></div>
                <div class="profile">
				<?php  
					if (isset($_SESSION['Admin-name'])) {
						$adminName = $_SESSION['Admin-name'];
						$initial = strtoupper(substr($adminName, 0, 1)); 
						echo '<a href = "#" data-toggle = "modal" data-target = "#password-confirm"><span class = "user-icon">' . $initial . '</span> </a>' ;
					}
				?>
                </div>
            </div>
        </div>
    </div>
</header>

<div class = "modal fade" id = "password-confirm" tabindex = "-1" role = "dialog" aria-labelledby =  "Admin Update" aria-hidden = "true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLongTitle">Update Admin Access Data</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="b1">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form action="ac_confirm_password.php" method="POST" enctype="multipart/form-data" id =  'password-confirm-form'>
            <div class="modal-body">
                <label for="User-psw">Current Password Required</label>
                <input type="password" name="up_pwd" placeholder="Password" required/><br>  
            </div>
            <div class="alert alert-danger">
                <div class="alert-icon"><span id="alert-password-icon"></span></div> <div class="alert-text"> <span id="alert-password-text"></span> </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="confirm" class="btn btn-success" value="true">Check</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="b2">Cancel</button>
            </div>	
        </form>
    </div>
    </div>
</div>

<div class = "modal fade" id = "admin-account" tabindex = "-1" role = "dialog" aria-labelledby =  "Admin Update" aria-hidden = "true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLongTitle">Update Admin Access Data</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="b3">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form action="ac_update.php" method="POST" enctype="multipart/form-data" id="update_form">
            <div class="modal-body">
                <label for="User-mail">New Admin Name</label>
                <input type="text" name="up_name" placeholder="Name" value="<?php echo $_SESSION['Admin-name']; ?>" required/><br>
                <label for="User-mail">New Admin E-mail</label>
                <input type="email" name="up_email" placeholder="E-mail" value="<?php echo $_SESSION['Admin-email']; ?>" required/><br>
                <label for="User-psw">New Admin Password</label>
                <input type="password" name="new_pwd" placeholder="Password" required/><br>
             </div>
             <div class="alert alert-danger">
                <div class="alert-icon"><span id="alert-password-icon1"></span></div> <div class="alert-text"> <span id="alert-password-text1"></span> </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="update" class="btn btn-success" value="true">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="b4">Cancel</button>
            </div>	
        </form>
    </div>
    </div>
</div>

<script>
$("#password-confirm-form").submit(function(event) {
    event.preventDefault();
    var $form = $(this),
        up_pwd_ = $form.find("input[name='up_pwd']").val(),
        confirm_ = $form.find("button[name='confirm']").val(),
        url = $form.attr("action");

    var posting = $.post(url, {up_pwd: up_pwd_, confirm: confirm_}, 
        function(data, status) {
            if (status == "success"){
                var data = jQuery.parseJSON(data);
                if (data.status == "success" && data.message == "passwordverified") {
                    $('#password-confirm-form')[0].reset();
                    $("#password-confirm").modal("hide");
                    $("#admin-account").modal("show");
                    $("#alert-password-text").hide();
                    $("#alert-password-icon").hide();
                }
                else if (data.status == "error" && data.message == "wrongpasswordup") {
                    $("#alert-password-text").show();
                    $("#alert-password-text").html("Wrong password");
                    $("#alert-password-icon").show();
                    $("#alert-password-icon").html("!");
                    $("#alert-password-icon").css("backgroundColor", "#FF0000");
                    $("#alert-password-icon").css("border-radius", "50%");
                    $("#alert-password-icon").css("width", "16px");
                    $("#alert-password-icon").css("height", "16px");
                    $("#alert-password-icon").css("justify-content", "center");
                    $("#alert-password-icon").css("align-items", "center");
                    $("#alert-password-icon").css("text-align", "center");

                }
                else if (data.status == "error" && data.message == "sqlerror1") {
                    $("#alert-password-text").show();
                    $("#alert-password-text").html("Database Error");
                    $("#alert-password-icon").show();
                    $("#alert-password-icon").html("!");
                    $("#alert-password-icon").css("backgroundColor", "#FF0000");
                    $("#alert-password-icon").css("border-radius", "50%");
                    $("#alert-password-icon").css("width", "16px");
                    $("#alert-password-icon").css("height", "16px");
                    $("#alert-password-icon").css("justify-content", "center");
                    $("#alert-password-icon").css("align-items", "center");
                    $("#alert-password-icon").css("text-align", "center");
                }
                else if (data.status == "error" && data.message == "nouser1") {
                    $("#alert-password-text").show();
                    $("#alert-password-text").html("Invalid Section User");
                    $("#alert-password-icon").show();
                    $("#alert-password-icon").html("!");
                    $("#alert-password-icon").css("backgroundColor", "#FF0000");
                    $("#alert-password-icon").css("border-radius", "50%");
                    $("#alert-password-icon").css("width", "16px");
                    $("#alert-password-icon").css("height", "16px");
                    $("#alert-password-icon").css("justify-content", "center");
                    $("#alert-password-icon").css("align-items", "center");
                    $("#alert-password-icon").css("text-align", "center");
                }
            }
        }
        );
});
</script>

<script>
$("#update_form").submit(function(event) {
    event.preventDefault();
    var $form = $(this),
        up_name_ = $form.find("input[name='up_name']").val(),
        up_email_ = $form.find("input[name='up_email']").val(),
        new_pwd_ = $form.find("input[name='new_pwd']").val(),
        update_ = $form.find("button[name='update']").val(),
        url = $form.attr("action");

    var posting = $.post(url, {up_name: up_name_, up_email: up_email_, new_pwd: new_pwd_, update: update_}, 
        function(data, status) {
            if (status == "success"){
                var data = jQuery.parseJSON(data);
                if (data.status == "success" && data.message == "updated") {
                    $("#password-confirm").modal("hide");
                    $("#admin-account").modal("hide");
                    $("#alert-password-text1").hide();
                    $("#alert-password-icon1").hide();
                    $('#update_form')[0].reset();
                }
                else if (data.status == "error") {
                    $("#alert-password-text1").show();
                    if (data.message == "invalidE_N"){
                        $("#alert-password-text1").html("Invalid Name and Email");
                    }
                    else if (data.message == "invalidE"){
                        $("#alert-password-text1").html("Invalid Email");
                    }
                    else if (data.message == "invalidN"){
                        $("#alert-password-text1").html("Invalid Name");
                    }
                    else if (data.message == "sqlerror1"){
                        $("#alert-password-text1").html("Database Error");
                    }
                    else if (data.message == "nouser2"){
                        $("#alert-password-text1").html("E-mail Already Registered");
                    }
                    else if (data.message == "nouser1"){
                        $("#alert-password-text1").html("Invalid Section User");
                    }
                    $("#alert-password-icon1").show();
                    $("#alert-password-icon1").html("!");
                    $("#alert-password-icon1").css("backgroundColor", "#FF0000");
                    $("#alert-password-icon1").css("border-radius", "50%");
                    $("#alert-password-icon1").css("width", "16px");
                    $("#alert-password-icon1").css("height", "16px");
                    $("#alert-password-icon1").css("justify-content", "center");
                    $("#alert-password-icon1").css("align-items", "center");
                    $("#alert-password-icon1").css("text-align", "center");
                }
            }
        }
        );
});
</script>

<script>
$('#b1').click(function() {
  $('#password-confirm-form')[0].reset();
  $("#alert-password-text").hide();
  $("#alert-password-icon").hide();
});
$('#b2').click(function() {
  $('#password-confirm-form')[0].reset();
  $("#alert-password-text").hide();
  $("#alert-password-icon").hide();
});
$('#b3').click(function() {
  $('#update_form')[0].reset();
  $('#password-confirm-form')[0].reset();
  $("#password-confirm").modal("hide");
  $("#alert-password-text").hide();
  $("#alert-password-icon").hide();
  $("#alert-password-text1").hide();
  $("#alert-password-icon1").hide();
});
$('#b4').click(function() {
  $('#update_form')[0].reset();
  $('#password-confirm-form')[0].reset();
  $("#password-confirm").modal("hide");
  $("#alert-password-text").hide();
  $("#alert-password-icon").hide();
  $("#alert-password-text1").hide();
  $("#alert-password-icon1").hide();
});
</script>