<?php 
require_once "include/header.php";
require_once "../connection.php";

// Set timezone to Asia/Manila
date_default_timezone_set('Asia/Manila');

// Get today's date in the format YYYY-MM-DD
$currentDay = date('Y-m-d');

// Initialize counter for accepted leaves today
$today_leave = 0;

// Fetch total admins
$select_admins = "SELECT COUNT(*) AS total_admins FROM admin";
$result_admins = mysqli_query($conn, $select_admins);
$total_admins = $result_admins ? mysqli_fetch_assoc($result_admins)['total_admins'] : 0;

// Fetch total employees
$select_employees = "SELECT COUNT(*) AS total_employees FROM employee";
$result_employees = mysqli_query($conn, $select_employees);
$total_employees = $result_employees ? mysqli_fetch_assoc($result_employees)['total_employees'] : 0;

// Fetch employees who have accepted leaves today
$emp_leave_query = "
    SELECT id, email, start_date, last_date 
    FROM emp_leave 
    WHERE LOWER(status) = 'accepted' 
    AND '$currentDay' BETWEEN start_date AND last_date
";

$leave_result = mysqli_query($conn, $emp_leave_query);

// Check if the query executed successfully and returned results
if ($leave_result) {
    $today_leave = mysqli_num_rows($leave_result); 
} else {
    echo "Query failed: " . mysqli_error($conn);
}

$sql_highest_salary = "SELECT id, name, email, salary FROM employee ORDER BY salary DESC LIMIT 10";
$highest_paid_employees = mysqli_query($conn, $sql_highest_salary);
?>

<div class="container-fluid my-5">
    <div class="row" style="display: flex; flex-wrap: wrap; gap: 1rem;">

        <!-- Admin Card -->
        <div class="col-12 col-md-4" style="flex: 1; min-width: 250px;">
            <div class="card border-2 shadow-sm">
                <div class="card-body py-4 text-center">
                    <h2 class="mr-3 text-center">Admin</h2>
                    <p class="mr-3 text-center text-black"><?php echo $total_admins; ?></p>
                    <a href="manage-admin.php" class="text-decoration-none">View All</a>
                </div>
            </div>
        </div>

        <!-- Employee Card -->
        <div class="col-12 col-md-4" style="flex: 1; min-width: 250px;">
            <div class="card border-2 shadow-sm">
                <div class="card-body py-4 text-center">
                    <h2 class="mr-3 text-center">Employees</h2>
                    <p class="mr-3 text-center text-black"><?php echo $total_employees; ?></p>
                    <a href="manage-employee.php" class="text-decoration-none">View All</a>
                </div>
            </div>
        </div>

        <!-- Leave Card -->
        <div class="col-12 col-md-4" style="flex: 1; min-width: 250px;">
            <div class="card border-2 shadow-sm">
                <div class="card-body py-4 text-center">
                    <h2 class="mr-3 text-center">Leaves</h2>
                    <p class="mr-3 text-center text-black">
                        <?php echo $today_leave > 0 ? $today_leave : 'No leaves for today'; ?>
                    </p>
                    <a href="record-leave.php" class="text-decoration-none">View All</a>
                </div>
            </div>
        </div>

    </div>
</div>

<?php 
require_once "include/footer.php";
?>
