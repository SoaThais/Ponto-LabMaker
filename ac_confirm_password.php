<?php 
session_start();
require('connectDB.php');

if (isset($_POST['confirm']) && $_POST['confirm'] == 'true') {

    $useremail = $_SESSION['Admin-email'];

    $up_password =$_POST['up_pwd'];

    if (empty($up_password)) {
        $response = array("status" => "error", "message" => "emptyfields");
        echo json_encode($response);
        exit();
    }
    else{
        $sql = "SELECT * FROM admin WHERE admin_email=?";  
        $result = mysqli_stmt_init($conn);
        if ( !mysqli_stmt_prepare($result, $sql)){
            $response = array("status" => "error", "message" => "sqlerror1");
            echo json_encode($response);
            exit();
        }
        else{
            mysqli_stmt_bind_param($result, "s", $useremail);
            mysqli_stmt_execute($result);
            $resultl = mysqli_stmt_get_result($result);
            if ($row = mysqli_fetch_assoc($resultl)) {
                $pwdCheck = password_verify($up_password, $row['admin_pwd']);
                if ($pwdCheck == false) {
                    $response = array("status" => "error", "message" => "wrongpasswordup");
                    echo json_encode($response);
                    exit();
                }
                else if ($pwdCheck == true) {
                    $response = array("status" => "success", "message" => "passwordverified");
                    echo json_encode($response);
                    exit();
                }
            }
            else{
                $response = array("status" => "error", "message" => "nouser1");
                echo json_encode($response);
                exit();
            }
        }
    }
}
else {
    header("location: index.php");
    exit();
}
?>