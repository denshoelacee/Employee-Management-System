
<?php 
require_once "include/header.php";
?>
<?php

// database connection
require_once "../connection.php";

// Apply Leave counts and other data fetches
$i = 1;


$total_accepted = $total_pending = $total_canceled = $total_applied = 0;
$leave = "SELECT * FROM emp_leave WHERE email = '$_SESSION[email_emp]' ";
$result = mysqli_query($conn , $leave);

if( mysqli_num_rows($result) > 0 ){

    $total_applied = mysqli_num_rows($result);

    while( $leave_info = mysqli_fetch_assoc($result) ){
        $status = $leave_info["status"];

        if( $status == "pending" ){
            $total_pending += 1;
        }elseif( $status == "Accepted" ){
            $total_accepted += 1;
        }elseif( $status = "Canceled"){
            $total_canceled += 1;
        }
    }
}else{
    $total_accepted = $total_pending = $total_canceled = $total_applied = 0;
}

$currentDay = date( 'Y-m-d', strtotime("today") );

$last_leave_status = "No leave applied";
$upcoming_leave_status = "";

// for last leave status
$check_leave = "SELECT * FROM emp_leave WHERE email = '$_SESSION[email_emp]' ";
$s = mysqli_query($conn , $check_leave);
if( mysqli_num_rows($s) > 0 ){
    while( $info = mysqli_fetch_assoc($s) ){
        $last_leave_status =  $info["status"];
    }
}

// for next leave date
$check_ = "SELECT * FROM emp_leave WHERE email = '$_SESSION[email_emp]' ORDER BY start_date ASC ";
$e = mysqli_query($conn , $check_); 
if( mysqli_num_rows($e) > 0 ){
    while( $info = mysqli_fetch_assoc($e) ){
        $date = $info["start_date"];
        $last_leave =  $info["status"];
        if ( $date > $currentDay && $last_leave == "Accepted" ){
            $upcoming_leave_status = date('jS F', strtotime($date));
            break;
        }
    }
}

// total employee
$select_emp = "SELECT * FROM employee";
$total_emp = mysqli_query($conn , $select_emp);

// highest paid employee
$sql_highest_salary =  "SELECT * FROM employee ORDER BY salary DESC";
$emp_ = mysqli_query($conn , $sql_highest_salary);

?>

<div class="container">
    <main class="content px-3 py-4">
        <div class="container-fluid">
            <div class="mb-3">
                <div class="row" style="display: flex; flex-wrap: wrap; gap: 1rem;">
                    <!-- Leave Status Card -->
                    <div class="col-12 col-md-4" style="flex: 1; min-width: 250px;">
                        <div class="card border-2">
                            <div class="card-body py-4 text-center">
                                <h2 class="mr-3 text-center">Upcoming Leave</h2>
                                <p class="mr-3 text-center text-black">Upcoming Leave on: <?php echo  $upcoming_leave_status; ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Applied Leaves Card -->
                    <div class="col-12 col-md-4" style="flex: 1; min-width: 250px;">
                        <div class="card border-2">
                            <div class="card-body py-4 text-center">
                                <h2 class="mr-3 text-center">Applied Leaves</h2>
                                <p class="mr-3 text-center text-black">Total Accepted: <?php echo $total_accepted; ?></p>
                                <p class="mr-3 text-center text-black">Total Canceled: <?php echo $total_canceled; ?></p>
                                <p class="mr-3 text-center text-black">Total Pending: <?php echo $total_pending; ?></p>
                                <p class="mr-3 text-center text-black">Total Applied: <?php echo $total_applied; ?></p>
                            </div>
                        </div>
                    </div>

                   
                    <div class="col-12 col-md-4" style="flex: 1; min-width: 250px;">
                        <div class="card border-2">
                            <div class="card-body py-4 text-center">
                                <h2 class="mr-3 text-center">Leave Status</h2>
                                <p class="mr-3 text-center text-black">Last Leave's Status: <?php echo ucwords($last_leave_status); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
    </main> 
</div>

<?php 
require_once "include/footer.php";
?>
