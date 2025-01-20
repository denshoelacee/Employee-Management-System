<?php
require_once "../connection.php"; // Database connection

$records_per_page = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start_from = ($page - 1) * $records_per_page;

$search_query = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : "";

// SQL Query with search filter
$sql = "SELECT * FROM employee 
        WHERE id LIKE '%$search_query%' 
        OR name LIKE '%$search_query%' 
        OR email LIKE '%$search_query%' 
        OR department LIKE '%$search_query%' 
        OR gender LIKE '%$search_query%' 
        LIMIT $start_from, $records_per_page";

$result = mysqli_query($conn, $sql);

// Fetch total number of records for pagination
$total_records_sql = "SELECT COUNT(*) AS total FROM employee 
                      WHERE id LIKE '%$search_query%' 
                      OR name LIKE '%$search_query%' 
                      OR email LIKE '%$search_query%' 
                      OR department LIKE '%$search_query%' 
                      OR gender LIKE '%$search_query%'";
$total_records_result = mysqli_query($conn, $total_records_sql);
$total_records = mysqli_fetch_assoc($total_records_result)['total'];

$total_pages = ceil($total_records / $records_per_page);

if (mysqli_num_rows($result) > 0) {
    echo "<table class='table-hover'>
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Employee Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Date of Birth</th>
                    <th>Department</th>
                    <th>Salary</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>";
    $i = $start_from + 1;
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$i}</td>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['gender']}</td>
                <td>{$row['dob']}</td>
                <td>{$row['department']}</td>
                <td>{$row['salary']}.00</td>
                <td class='action-buttons'>
                    <a href='edit-employee.php?id={$row['id']}' class='btn-sm btn-primary'><i class='fa fa-edit'></i> Edit</a>
                    <a href='delete-employee.php?id={$row['id']}' class='btn-sm btn-danger'><i class='fa fa-trash'></i> Delete</a>
                </td>
            </tr>";
        $i++;
    }
    echo "</tbody></table>";
} else {
    echo "<center><h4>No records found.</h4></center>";
}

// Pagination
echo "<nav><ul class='pagination justify-content-center'>";
for ($p = 1; $p <= $total_pages; $p++) {
    echo "<li class='page-item'><a href='#' class='page-link' data-page='{$p}'>{$p}</a></li>";
}
echo "</ul></nav>";
?>
