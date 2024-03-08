<div class="table-responsive"> 
  <table class="table">
    <thead class="table-primary">
      <tr>
        <th>Card UID</th>
        <th>Name</th>
        <th>Registration Date</th>
        <th>Device</th>
        <th> </th>
      </tr>
    </thead>
    <tbody class="table-secondary">
    <?php
      require'connectDB.php';

        $sql = "SELECT * FROM users ORDER BY id DESC";
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
        else {
            mysqli_stmt_execute($result);
            $resultl = mysqli_stmt_get_result($result);
            if (mysqli_num_rows($resultl) > 0){
              while ($row = mysqli_fetch_assoc($resultl)) {
      ?>
                <TR>
                  <?php
                    $card_uid = $row['card_uid'];
                  ?>
                <TD><?php echo $row['card_uid'];?></TD>
                <TD><?php echo $row['username'];?></TD>
                <TD><?php echo $row['user_date'];?></TD>
                <TD><?php echo ($row['device_name'] == "0") ? "All" : $row['device_name'];?></TD>
                <TD>
                  <div class = "buttons">
                    <?php
                      if ($row['add_card'] == 0){
                    ?>
                      <form>
                        <button type="button" class="select_btn2" title="Add User Data" id="<?php echo $card_uid;?>"><span><i class='bx bx-plus'></i></span></button>
                      </form>
                    <?php
                      }
                    ?>
                    <?php
                      if ($row['add_card'] != 0){
                    ?>
                      <form>
                        <button type="button" class="select_btn" title="Update User Data" id="<?php echo $card_uid;?>"><span><i class='bx bx-refresh'></i></span></button>
                      </form>
                    <?php
                      }
                    ?>
                    <form>
                      <button type="button" class="user_rmo" title="Delete User" id="<?php echo $card_uid;?>"><span><i class='bx bxs-trash'></i></span></button>
                    </form>
                  </div>
                </TD>
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