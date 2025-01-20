<?php 
require_once "include/header.php";
require_once "../connection.php";

// Fetch highest-paid employees
$sql_highest_salary = "SELECT id, name, department, salary FROM employee ORDER BY salary DESC LIMIT 10";
$highest_paid_employees = mysqli_query($conn, $sql_highest_salary);
?>

<div class="container my-5">
    <div class="row mt-5">
        <div class="col-12">
            <div class="text-center mb-4">
                <h4>Employee Leadership Board</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Rank</th>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Salary</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($highest_paid_employees && mysqli_num_rows($highest_paid_employees) > 0): ?>
                            <?php $i = 1; ?>
                            <?php while ($emp_info = mysqli_fetch_assoc($highest_paid_employees)): ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo htmlspecialchars($emp_info['id']); ?></td>
                                    <td><?php echo htmlspecialchars($emp_info['name']); ?></td>
                                    <td><?php echo htmlspecialchars($emp_info['department']); ?></td>
                                    <td><?php echo htmlspecialchars(number_format($emp_info['salary'], 2)); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No data available.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php 
require_once "include/footer.php";
?>
