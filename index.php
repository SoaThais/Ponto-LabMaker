<?php
session_start();
if (!isset($_SESSION['Admin-name'])) {
  header("location: login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>FreqMaker</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/logo_azul.png">
    <script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <link rel="stylesheet" type="text/css" href="css/Users.css">
    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bitter:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
<?php include'header.php'; ?> 
  <!-- <div class="below" id="below">
    <div class="table-responsive slideInRight animated"> 
      <table class="table">
        <thead class="table-primary">
          <tr>
            <th>ID | Name</th>
            <th>Card UID</th>
            <th>Registration Date</th>
            <th>Device</th>
          </tr>
        </thead>
        <tbody class="table-secondary">
          <?php
              // require'connectDB.php';
              // $sql = "SELECT * FROM users WHERE add_card = 1 ORDER BY id DESC";
              // $result = mysqli_stmt_init($conn);
              // if (!mysqli_stmt_prepare($result, $sql)) {
              //     echo '<p class="error">SQL Error</p>';
              // }
              // else{
              //     mysqli_stmt_execute($result);
              //     $resultl = mysqli_stmt_get_result($result); 
              //   if (mysqli_num_rows($resultl) > 0){
              //       while ($row = mysqli_fetch_assoc($resultl)){
          ?>
                      <TR>
                      <TD><?php
                      //  echo $row['id']; echo" | "; echo $row['username'];?></TD>
                      <TD><?php
                      //  echo $row['card_uid'];?></TD>
                      <TD><?php
                      //  echo $row['user_date'];?></TD>
                      <TD><?php
                      //  echo $row['device_name'];?></TD>
                      </TR>
          <?php
            //     }   
            //   }
            // }
          ?>
        </tbody>
      </table>
    </div>
  </div> -->
</body>
</html>
<script src = "js/menu.js"></script>