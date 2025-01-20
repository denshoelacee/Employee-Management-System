<?php
require_once "../connection.php"; // Database connection

$records_per_page = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start_from = ($page - 1) * $records_per_page;

$search_query = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : "";

// Check if the search query is a valid date in MM-DD-YYYY format
$is_date = DateTime::createFromFormat('m-d-Y', $search_query) !== false;

// Convert MM-DD-YYYY to YYYY-MM-DD if valid
if ($is_date) {
    $formatted_date = DateTime::createFromFormat('m-d-Y', $search_query)->format('Y-m-d');
}

if ($is_date) {
    $sql = "SELECT * FROM emp_leave WHERE status = 'accepted' 
            AND (start_date = '$formatted_date' OR last_date = '$formatted_date')
            LIMIT $start_from, $records_per_page";
} else {
    $sql = "SELECT * FROM emp_leave WHERE status = 'accepted' 
            AND (email LIKE '%$search_query%' 
            OR reason LIKE '%$search_query%' 
            OR start_date LIKE '%$search_query%' 
            OR last_date LIKE '%$search_query%' 
            OR (DATEDIFF(CAST(last_date AS DATE), CAST(start_date AS DATE)) LIKE '%$search_query%')) 
            LIMIT $start_from, $records_per_page";
}

$result = mysqli_query($conn, $sql);

// Fetch total number of records for pagination
if ($is_date) {
    $total_records_sql = "SELECT COUNT(*) AS total FROM emp_leave WHERE status = 'accepted' 
                          AND (start_date = '$formatted_date' OR last_date = '$formatted_date')";
} else {
    $total_records_sql = "SELECT COUNT(*) AS total FROM emp_leave WHERE status = 'accepted' 
                          AND (email LIKE '%$search_query%' 
                          OR reason LIKE '%$search_query%' 
                          OR start_date LIKE '%$search_query%' 
                          OR last_date LIKE '%$search_query%' 
                          OR (DATEDIFF(CAST(last_date AS DATE), CAST(start_date AS DATE)) LIKE '%$search_query%'))";
}

$total_records_result = mysqli_query($conn, $total_records_sql);
$total_records = mysqli_fetch_assoc($total_records_result)['total'];

$total_pages = ceil($total_records / $records_per_page);

if (mysqli_num_rows($result) > 0) {
    echo "<table class='table-hover'>
            <thead>
                <tr class='bg-dark'>
                    <th>Order</th>
                    <th>Employee Email</th>
                    <th>Starting Date</th>
                    <th>Ending Date</th> 
                    <th>Total Days</th>
                    <th>Reason</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>";
    $i = $start_from + 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $start_date = $row["start_date"];
        $last_date = $row["last_date"];
        $email = $row["email"];
        $reason = $row["reason"];
        $status = $row["status"];
        $total_days = date_diff(date_create($start_date), date_create($last_date))->format("%a days");

        echo "<tr>
                <td>{$i}</td>
                <td>{$email}</td>
                <td>" . date("jS F", strtotime($start_date)) . "</td>
                <td>" . date("jS F", strtotime($last_date)) . "</td>
                <td>{$total_days}</td>
                <td>{$reason}</td>
                <td>{$status}</td>
            </tr>";
        $i++;
    }
    echo "</tbody></table>";
} else {
    echo "<div class='no-results'>No results found.</div>";
}

// Pagination
echo "<nav><ul class='pagination justify-content-center'>";
for ($p = 1; $p <= $total_pages; $p++) {
    echo "<li class='page-item'><a href='#' class='page-link' data-page='{$p}'>{$p}</a></li>";
}
echo "</ul></nav>";
?>
