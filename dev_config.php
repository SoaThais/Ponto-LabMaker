<?php 
session_start();
require('connectDB.php');

if (isset($_POST['dev_add'])) {

    $dev_name = $_POST['dev_name'];

    if (empty($dev_name)) {
        echo 'Empty Name Field';
    }
    else{
        $token = random_bytes(8);
        $dev_token = bin2hex($token);

        $sql = "INSERT INTO devices (device_name, device_uid, device_date) VALUES(?, ?, CURDATE())";
        $result = mysqli_stmt_init($conn);
        if ( !mysqli_stmt_prepare($result, $sql)){
            echo 'Database Error';
        }
        else{
            mysqli_stmt_bind_param($result, "ss", $dev_name, $dev_token);
            mysqli_stmt_execute($result);
            echo 1;
        }
        mysqli_stmt_close($result); 
        mysqli_close($conn);
    }
}
elseif (isset($_POST['dev_del'])) {

    $dev_del = $_POST['dev_sel'];

    $sql = "DELETE FROM devices WHERE id=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo 'Database Error';
    }
    else{
        mysqli_stmt_bind_param($stmt, "i", $dev_del);
        mysqli_stmt_execute($stmt);
        echo 1;
        mysqli_stmt_close($stmt); 
        mysqli_close($conn);
    }
}
elseif (isset($_POST['dev_uid_up'])) {
    
    $dev_id = $_POST['dev_id_up'];

    $token = random_bytes(8);
    $dev_token = bin2hex($token);

    $sql = "UPDATE devices SET device_uid=? WHERE id=?";
    $result = mysqli_stmt_init($conn);
    if ( !mysqli_stmt_prepare($result, $sql)){
        echo 'Database Error';
    }
    else{
        mysqli_stmt_bind_param($result, "si", $dev_token, $dev_id);
        mysqli_stmt_execute($result);
        echo 1;
    }
    mysqli_stmt_close($result); 
    mysqli_close($conn);
}
elseif (isset($_POST['dev_mode_set'])) {

    $dev_mode = $_POST['dev_mode'];
    $dev_id = $_POST['dev_id'];
    
    $sql = "UPDATE devices SET device_mode=? WHERE id=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo 'Database Error';
    }
    else{
        mysqli_stmt_bind_param($stmt, "ii", $dev_mode, $dev_id);
        mysqli_stmt_execute($stmt);
        echo 1;
    }
}
else{
    header("location: index.php");
    exit();
}
//*********************************************************************************
?>