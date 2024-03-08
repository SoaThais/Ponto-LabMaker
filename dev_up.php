<?php 
session_start();
?>
<div class="table-responsive">          
	<table class="table">
		<thead>
	      <tr>
	        <th>Name</th>
	        <th>UID</th>
	        <th>Registration Date</th>
	        <th>Mode</th>
	        <th> </th>
	      </tr>
    	</thead>
    	<tbody>
			<?php  
		    	require'connectDB.php';
		    	$sql = "SELECT * FROM devices ORDER BY id DESC";
				$result = mysqli_stmt_init($conn);
				if (!mysqli_stmt_prepare($result, $sql)) {
				    echo 'Database Error';
				} 
				else{
				    mysqli_stmt_execute($result);
				    $resultl = mysqli_stmt_get_result($result);
				    echo '<form action="" method="POST" enctype="multipart/form-data">';
					    while ($row = mysqli_fetch_assoc($resultl)){

					      	$radio1 = ($row["device_mode"] == 0) ? "checked" : "" ;
					      	$radio2 = ($row["device_mode"] == 1) ? "checked" : "" ;

					      	$de_mode = '<div class="mode_select">
					      	<input type="radio" id="' . $row["id"] . '-one" name="' . $row["id"] . '" class="mode_sel" data-id="' . $row["id"] . '" value = "0" ' . $radio1 . '/>
					                    <label for="' . $row["id"] . '-one"><i class="bx bxs-user-plus" title="Register New Users"></i></label>
		                    <input type="radio" id="' . $row["id"] . '-two" name="' . $row["id"] . '" class="mode_sel" data-id="' . $row["id"] . '" value="1" ' . $radio2 . '/>
					                    <label for="' . $row["id"] . '-two"><i class="bx bxs-user-detail" title="Check User Attendance"></i></label>
					                    </div>';

					    	echo '<tr>
							        <td>'.$row["device_name"].'</td>
							        <td><button type="button" class="dev_uid_up btn btn-warning" id="del_'.$row["id"].'" data-id="'.$row["id"].'" title="Update Device Token"><i class="bx bx-refresh"></i></button>
							        	'.$row["device_uid"].'
							        </td>
							        <td>'.$row["device_date"].'</td>
							        <td>'.$de_mode.'</td>
							        <td>
								    	<button type="button" class="dev_del btn btn-danger" id="del_'.$row["id"].'" data-id="'.$row["id"].'" title="Delete Device"><i class="bx bxs-trash"></i></button>
								    </td>
							      </tr>';
					    }
				    echo '</form>';
				}
		    ?>
		<tr>
			<td> </td>
			<td> </td>
			<td> </td>
			<td> </td>
			<td> 
				<button type="button" id="add_device" class="btn btn-success" data-toggle="modal" data-target="#new-device" title="Add Device"><i class='bx bx-plus'></i></button>
			</td>
		</tr>
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