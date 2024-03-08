<?php
session_start();
if (isset($_SESSION['Admin-name'])) {
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>FreqMaker</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/logo_azul.png">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bitter:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body> 
  <div class="container">
    <div class="esq">
      <img src="images\telaLogin_branca.png" alt="Imagem" class="name">
      <div class="side-by-side">
        <img src="images\logoL_branca.png" alt="Imagem" class="logoLab">
        <img src="images\nomeL_branca.png" alt="Imagem" class="nomeLab">
      </div>
    </div>
    <div class="dir">
      <div class="page-login">
        <form class="login-form" action="ac_login.php" method="post" enctype="multipart/form-data">
          <input type="email" name="email" id="email" placeholder="E-mail" required/>
          <input type="password" name="pwd" id="pwd" placeholder="Password" required/>
          <button type="submit" name="login" id="login">login</button>
        </form>
        <div class="alert">
          <?php  
            if (isset($_GET['error'])) {
              if ($_GET['error'] == "invalidEmail") {
                  echo '<div class="alert alert-danger">
                          <div class="alert-icon">!</div> <div class="alert-text"> Invalid E-mail </div>
                        </div>';
              }
              elseif ($_GET['error'] == "sqlerror") {
                  echo '<div class="alert alert-danger">
                          <div class="alert-icon">! </div>  <div class="alert-text"> Database Error </div>
                        </div>';
              }
              elseif ($_GET['error'] == "wrongpassword") {
                  echo '<div class="alert alert-danger">
                          <div class="alert-icon">!</div>  <div class="alert-text"> Wrong password </div>
                        </div>';
              }
              elseif ($_GET['error'] == "nouser") {
                  echo '<div class="alert alert-danger">
                          <div class="alert-icon">! </div>  <div class="alert-text"> Invalid E-mail </div>
                        </div>';
              }
            }
          ?>
        </div>
      </div>
    </div>
  </div>
</body>
</html>