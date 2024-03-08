<?php
session_start();
if (!isset($_SESSION['Admin-name'])) {
  header("location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Users Logs</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/logo_azul.png">
    <link rel="stylesheet" type="text/css" href="css/userslog.css">
    <script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>
    <script type="text/javascript" src="js/bootbox.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bitter:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="js/user_log.js"></script>
    <script src = "js/menu.js"></script>
    <script>
      $(document).ready(function(){
        $.ajax({
          url: "user_log_up.php",
          type: 'POST',
          data: {
              'select_date': 1,
          }
          }).done(function(data) {
            $('#userslog').html(data);
        });

      setInterval(function(){
        $.ajax({
          url: "user_log_up.php",
          type: 'POST',
          data: {
              'select_date': 0,
          }
          }).done(function(data) {
            $('#userslog').html(data);
          });
      }, 5000);
      });
    </script>
</head>
<body>
<?php include'header.php'; ?> 
    <div class="below">
        <div class="panel-body">
          <button type="button" data-toggle="modal" data-target="#Filter-export" id="filter_button">Filter | Export</button>
          <div id ="userslog"></div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="Filter-export" tabindex="-1" role="dialog" aria-labelledby="Filter/Export" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg animate" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLongTitle">Filter Users Log</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="exportForm" method="POST" action="Export_Excel.php" enctype="multipart/form-data">
            <div class="modal-body">
              <input type="hidden" name="To_Excel" value="Export">
              <label for="Start-Date">From the Date</label>
              <input type="date" name="date_sel_start" id="date_sel_start">
              <label for="End-Date">Until The Date</label>
              <input type="date" name="date_sel_end" id="date_sel_end">
              <div class="time">
                  <label for="radio-one">Time In</label>
                  <input type="radio" id="radio-one" name="time_sel" class="time_sel" value="Time_in" checked/>
                  <label for="radio-two">Time Out</label>
                  <input type="radio" id="radio-two" name="time_sel" class="time_sel" value="Time_out" />
              </div>
              <label for="Start-Time">From The Time</label>
              <input type="time" name="time_sel_start" id="time_sel_start">
              <label for="End-Time">Until The Time</label>
              <input type="time" name="time_sel_end" id="time_sel_end">
              <label for="Fingerprint">User</label>
              <div class="sel_css">
              <select class="card_sel" name="card_sel" id="card_sel">
                <option value="0">All Users</option>
                <?php
                  require'connectDB.php';
                  $sql = "SELECT * FROM users WHERE add_card=1 ORDER BY id ASC";
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
                        <option value="<?php echo $row['card_uid'];?>"><?php echo $row['username']; ?></option>
                <?php
                      }
                  }
                ?>
              </select>
              </div>
              <label for="Device">Device</label>
              <div class="sel_css">
              <select class="dev_sel" name="dev_sel" id="dev_sel">
                <option value="0">All Devices</option>
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
                        <option value="<?php echo $row['device_uid'];?>"><?php echo $row['device_name']; ?></option>
                <?php
                      }
                  }
                ?>
              </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" name="To_Excel" id="To_Excel" value="Export" class="btn btn-success">Export</button>
              <button type="button" name="user_log" id="user_log" class="btn btn-success">Filter</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>    
</body>
</html>