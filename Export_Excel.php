<?php
//Connect to database
require'connectDB.php';

$output = '';

echo "<script>";
echo "console.log('hello');";
echo "</script>";

echo "<script>";
echo "var sessionData = " . json_encode($_POST) . ";";
echo "console.log(sessionData);";
echo "</script>";

if(isset($_POST["To_Excel"]) && $_POST['To_Excel'] == 'Export'){

    echo "<script>";
    echo "console.log('entro');";
    echo "</script>";
  
    $searchQuery = " ";
    $Start_date = " ";
    $End_date = " ";
    $Start_time = " ";
    $End_time = " ";
    $card_sel = " ";

    if (!empty($_POST['date_sel_start'])) {
        $Start_date = $_POST['date_sel_start'];
        $_SESSION['searchQuery'] = "checkindate >='".$Start_date."'";
    }
    // else{
    //     $Start_date = date("Y-m-d");
    //     $_SESSION['searchQuery'] = "checkindate ='".date("Y-m-d")."'";
    // }
    if (!empty($_POST['date_sel_end'])) {
        $End_date = $_POST['date_sel_end'];
        $_SESSION['searchQuery'] = "checkindate BETWEEN '".$Start_date."' AND '".$End_date."'";
    }
    if ($_POST['time_sel'] == "Time_in") {
      if (!empty($_POST['time_sel_start']) && empty($_POST['time_sel_end'])) {
          $Start_time = $_POST['time_sel_start'];
          $_SESSION['searchQuery'] .= " AND timein >= '".$Start_time."'";
      }
      elseif (!empty($_POST['time_sel_start']) && !empty($_POST['time_sel_end'])) {
          $Start_time = $_POST['time_sel_start'];
      }
      if (!empty($_POST['time_sel_end'])) {
          $End_time = $_POST['time_sel_end'];
          $_SESSION['searchQuery'] .= " AND timein BETWEEN '".$Start_time."' AND '".$End_time."'";
      }
    }
    if ($_POST['time_sel'] == "Time_out") {
      if (!empty($_POST['time_sel_start']) && empty($_POST['time_sel_end'])) {
          $Start_time = $_POST['time_sel_start'];
          $_SESSION['searchQuery'] .= " AND timeout <= '".$Start_time."'";
      }
      elseif (!empty($_POST['time_sel_start']) && !empty($_POST['time_sel_end'])) {
          $Start_time = $_POST['time_sel_start'];
      }
      if (!empty($_POST['time_sel_end'])) {
          $End_time = $_POST['time_sel_end'];
          $_SESSION['searchQuery'] .= " AND timeout BETWEEN '".$Start_time."' AND '".$End_time."'";
      }
    }
    if (!empty($_POST['card_sel'])) {
        $card_sel = $_POST['card_sel'];
        $_SESSION['searchQuery'] .= " AND card_uid='".$card_sel."'";
    }
    if (!empty($_POST['dev_uid'])) {
      $dev_uid = $_POST['dev_uid'];
      $_SESSION['searchQuery'] .= " AND device_uid='".$dev_uid."'";
    }

    if (!isset($_SESSION['searchQuery'])) {
      echo "<script>";
      echo "console.log('entro2');";
      echo "</script>";
      $_SESSION['searchQuery'] = "1";
    }

    echo "<script>";
    echo "var sessionData = " . json_encode($_SESSION) . ";";
    echo "console.log(sessionData);";
    echo "</script>";


    $sql = "SELECT * FROM users_logs WHERE ".$_SESSION['searchQuery']." ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);
    if($result->num_rows > 0){
      $output .= '
              <table class="table" bordered="1">  
              <TR>
                <TH>Name</TH>
                <TH>Card UID</TH>
                <TH>Device Name</TH>
                <TH>Date log</TH>
                <TH>Time In</TH>
                <TH>Time Out</TH>
              </TR>';
        while($row=$result->fetch_assoc()) {
        $output .= '
          <TR> 
              <TD> '.$row['username'].'</TD>
              <TD> '.$row['card_uid'].'</TD>
              <TD> '.$row['device_name'].'</TD>
              <TD> '.$row['checkindate'].'</TD>
              <TD> '.$row['timein'].'</TD>
              <TD> '.$row['timeout'].'</TD>
          </TR>';
        }
        $output .= '</table>';
        header('Content-Type:application/xls');
        header('Content-Disposition:attachment;filename=User_Log'.$Start_date.'.xls');
        
        echo $output;
        exit();
    }
    // else{
    //   header( "location: UsersLog.php" );
    //   exit();
    // }
}
?>