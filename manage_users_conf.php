<?php  
require'connectDB.php';

if (isset($_POST['Add'])) {
     
    $user_id = $_POST['user_id'];
    $Uname = $_POST['name'];
    $Email = $_POST['email'];
    $dev_uid = $_POST['dev_uid'];
    
    $sql = "SELECT add_card FROM users WHERE id = ?";
    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {
      echo "Database Error";
      exit();
    }
    else{
        mysqli_stmt_bind_param($result, "i", $user_id);
        mysqli_stmt_execute($result);
        $resultl = mysqli_stmt_get_result($result);
        if ($row = mysqli_fetch_assoc($resultl)) {

            if ($row['add_card'] == 0) {

                if (!empty($Uname) && !empty($Email)) {
                    $sql = "SELECT device_name FROM devices WHERE device_uid=?";
                    $result = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($result, $sql)) {
                        echo "Database Error";
                        exit();
                    }
                    else{
                        mysqli_stmt_bind_param($result, "s", $dev_uid);
                        mysqli_stmt_execute($result);
                        $resultl = mysqli_stmt_get_result($result);
                        if ($row = mysqli_fetch_assoc($resultl)) {
                            $dev_name = $row['device_name'];
                        }
                        else{
                            $dev_name = "All";
                        }
                    }
                    $sql="UPDATE users SET username=?, email=?, user_date=CURDATE(), device_uid=?, device_name=?, add_card=1 WHERE id=?";
                    $result = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($result, $sql)) {
                        echo "Database Error";
                        exit();
                    }
                    else{
                        mysqli_stmt_bind_param($result, "ssssi", $Uname, $Email, $dev_uid, $dev_name, $user_id);
                        mysqli_stmt_execute($result);

                        echo 1;
                        exit();
                    }
                }
                else{
                    echo "Empty Fields";
                    exit();
                }
            }
            else{
                echo "User is already exist";
                exit();
            }    
        }
        else {
            echo "No selected Card";
            exit();
        }
    }
}

if (isset($_POST['Update'])) {

    $user_id = $_POST['user_id'];
    $Uname = $_POST['name'];
    $Email = $_POST['email'];
    $dev_uid = $_POST['dev_uid'];

    $sql = "SELECT add_card FROM users WHERE id=?";
    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {
      echo "Database Error";
      exit();
    }
    else{
        mysqli_stmt_bind_param($result, "i", $user_id);
        mysqli_stmt_execute($result);
        $resultl = mysqli_stmt_get_result($result);
        if ($row = mysqli_fetch_assoc($resultl)) {

            if ($row['add_card'] == 0) {
                echo "User has not yet been added";
                exit();
            }
            else{
                if (empty($Uname) && empty($Email)) {
                    echo "Empty Fields";
                    exit();
                }
                else{
                    $sql = "SELECT device_name FROM devices WHERE device_uid=?";
                    $result = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($result, $sql)) {
                        echo "Database Error";
                        exit();
                    }
                    else{
                        mysqli_stmt_bind_param($result, "s", $dev_uid);
                        mysqli_stmt_execute($result);
                        $resultl = mysqli_stmt_get_result($result);
                        if ($row = mysqli_fetch_assoc($resultl)) {
                            $dev_name = $row['device_name'];
                        }
                        else{
                            $dev_name = "All";
                        }
                    }
                            
                    if (!empty($Uname) && !empty($Email)) {

                        $sql="UPDATE users SET username=?, email=?, device_uid=?, device_name=? WHERE id=?";
                        $result = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($result, $sql)) {
                            echo "Database Error";
                            exit();
                        }
                        else{
                            mysqli_stmt_bind_param($result, "ssssi", $Uname, $Email, $dev_uid, $dev_name, $user_id );
                            mysqli_stmt_execute($result);

                            echo 1;
                            exit();
                        }
                    }
                }
            }    
        }
        else {
            echo "No Selected User";
            exit();
        }
    }
}

if (isset($_GET['select'])) {

    $card_uid = $_GET['card_uid'];

    $sql = "SELECT * FROM users WHERE card_uid = ?";
    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {
        echo "Database Error";
        exit();
    }
    else {
        mysqli_stmt_bind_param($result, "s", $card_uid);
        mysqli_stmt_execute($result);
        $resultl = mysqli_stmt_get_result($result);
        header('Content-Type: application/json');
        $data = array();
        if ($row = mysqli_fetch_assoc($resultl)) {
            foreach ($resultl as $row) {
                $data[] = $row;
            }
        }
        $resultl->close();
        $conn->close();
        print json_encode($data);
    } 
}

if (isset($_POST['delete'])) {

    $user_id = $_POST['user_id'];

    if (empty($user_id)) {
        echo "No Selected User To Remove";
        exit();
    } else {
        $sql = "DELETE FROM users WHERE id=?";
        $result = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($result, $sql)) {
            echo "Database Error";
            exit();
        }
        else{
            mysqli_stmt_bind_param($result, "i", $user_id);
            mysqli_stmt_execute($result);
            echo 1;
            exit();
        }
    }
}
?>