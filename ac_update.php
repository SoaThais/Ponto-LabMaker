<?php 
session_start();
require('connectDB.php');

if (isset($_POST['update']) && $_POST['update'] == 'true') {

    $useremail = $_SESSION['Admin-email'];

    $up_name = $_POST['up_name'];
    $up_email = $_POST['up_email'];
    $up_new_password =$_POST['new_pwd'];

    if (empty($up_name) || empty($up_email) || empty($up_new_password)) {
        $response = array("status" => "error", "message" => "emptyfields");
        echo json_encode($response);
        exit();
    }
    elseif (!filter_var($up_email,FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z 0-9]*$/", $up_name)) {
        $response = array("status" => "error", "message" => "invalidE_N");
        echo json_encode($response);
        exit();
    }
    elseif (!filter_var($up_email,FILTER_VALIDATE_EMAIL)) {
        $response = array("status" => "error", "message" => "invalidE");
        echo json_encode($response);
        exit();
    }
    elseif (!preg_match("/^[a-zA-Z 0-9]*$/", $up_name)) {
        $response = array("status" => "error", "message" => "invalidN");
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
                $sql = "SELECT admin_email FROM admin WHERE admin_email=?";  
                $result = mysqli_stmt_init($conn);
                if ( !mysqli_stmt_prepare($result, $sql)){
                    $response = array("status" => "error", "message" => "sqlerror1");
                    echo json_encode($response);
                    exit();
                }
                else{
                    $hashed_new_password = password_hash($up_new_password, PASSWORD_DEFAULT); 
                    mysqli_stmt_bind_param($result, "s", $up_email);
                    mysqli_stmt_execute($result);
                    $resultl = mysqli_stmt_get_result($result);
                    if ($useremail == $up_email || !$row = mysqli_fetch_assoc($resultl)) {
                        
                        $sql = "UPDATE admin SET admin_name=?, admin_email=?, admin_pwd=? WHERE admin_email=?";
                        $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            $response = array("status" => "error", "message" => "sqlerror1");
                            echo json_encode($response);
                            exit();
                        }
                        else{
                            mysqli_stmt_bind_param($stmt, "ssss", $up_name, $up_email, $hashed_new_password, $useremail);
                            mysqli_stmt_execute($stmt);
                            $_SESSION['Admin-name'] = $up_name;
                            $_SESSION['Admin-email'] = $up_email;
                            $response = array("status" => "success", "message" => "updated");
                            echo json_encode($response);
                            exit();
                        }
                    }
                    else{
                        $response = array("status" => "error", "message" => "nouser2");
                        echo json_encode($response);
                        exit();
                    }
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
else{
    header("location: index.php");
    exit();
}
//*********************************************************************************
?>