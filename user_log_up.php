<?php  
session_start();
?>
<div class="table-responsive"> 
  <table class="table" id="table" >
    <thead class="table-primary">
      <tr>
        <th>Name</th>
        <th>Card UID</th>
        <th>Device Name</th>
        <th>Date</th>
        <th>Time In</th>
        <th>Time Out</th>
      </tr>
    </thead>
    <tbody class="table-secondary">
      <?php
        require'connectDB.php';
        $searchQuery = " ";
        $Start_date = " ";
        $End_date = " ";
        $Start_time = " ";
        $End_time = " ";
        $Card_sel = " ";


        if (isset($_POST['log_date'])) {
          if (!empty($_POST['date_sel_start'])) {
              $Start_date = $_POST['date_sel_start'];
              $_SESSION['searchQuery'] = "checkindate >= '".$Start_date."'";
          }
          else{
              $Start_date = date("Y-m-d");
              $_SESSION['searchQuery'] = "checkindate ='".date("Y-m-d")."'";
          }
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
              $Card_sel = $_POST['card_sel'];
              $_SESSION['searchQuery'] .= " AND card_uid='".$Card_sel."'";
          }
          if (!empty($_POST['dev_uid'])) {
              $dev_uid = $_POST['dev_uid'];
              $_SESSION['searchQuery'] .= " AND device_uid='".$dev_uid."'";
          }
        }
        
        if ($_POST['select_date'] == 1) {
            // $Start_date = date("Y-m-d");
            // $_SESSION['searchQuery'] = "checkindate='".$Start_date."'";
            $_SESSION['searchQuery'] = "1";
        }

        echo "<script>";
        echo "var sessionData = " . json_encode($_SESSION) . ";";
        echo "console.log(sessionData);";
        echo "</script>";

        $sql = "SELECT * FROM users_logs WHERE ".$_SESSION['searchQuery']." ORDER BY id DESC";
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
            if (mysqli_num_rows($resultl) > 0){
                while ($row = mysqli_fetch_assoc($resultl)){
        ?>
                  <TR>
                  <TD><?php echo $row['username'];?></TD>
                  <TD><?php echo $row['card_uid'];?></TD>
                  <TD><?php echo $row['device_name'];?></TD>
                  <TD><?php echo $row['checkindate'];?></TD>
                  <TD><?php echo $row['timein'];?></TD>
                  <TD><?php echo $row['timeout'];?></TD>
                  </TR>
      <?php
                }
            }
        }
      ?>
    </tbody>
  </table>
</div>
<div id="pagination"></div>

<script>
    let itemsPerPage;
    let currentPage = localStorage.getItem('currentPage') || 1;

    function calculateItemsPerPage() {
        const windowHeight = $('.below').height() - 10;
        console.log(windowHeight);
        const rowHeight = 50; 
        return Math.floor(windowHeight / rowHeight);
    }

    function updateTableDisplay() {
        itemsPerPage = calculateItemsPerPage(); 
        const $table = $('table');
        const $pagination = $('#pagination');

        const numRows = $table.find('tr').length;
        const numPages = Math.ceil(numRows / itemsPerPage);

        $pagination.empty(); 

        for (let i = 1; i <= numPages; i++) {
            $pagination.append(`<a href="#" data-page="${i}">${i}</a>`);
        }
        
        showPage(currentPage);
    }

    function showPage(page) {
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        $('table tr').hide().slice(start, end).show();
    }

    $(document).on('click', '#pagination a', function(e) {
        e.preventDefault();
        const page = parseInt($(this).data('page'));
        currentPage = page;
        localStorage.setItem('currentPage', currentPage); 
        showPage(page);
    });

    updateTableDisplay();
</script>