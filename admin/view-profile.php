<?php
require_once "../connection.php"; // Include database connection

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch employee details
    $sql = "SELECT * FROM employee WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $employee = mysqli_fetch_assoc($result);
    } else {
        die("Employee not found.");
    }
} else {
    die("Invalid request.");
}

$profile_picture = $employee['profile_picture'] ?: '1.jpg'; // Default to '1.jpg' if no picture
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Profile</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>Employee Profile</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    <img src="uploads/<?php echo $profile_picture; ?>" alt="Profile Picture" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                </div>
                <div class="col-md-8">
                    <p><strong>Name: </strong><?php echo $employee['name']; ?></p>
                    <p><strong>Email: </strong><?php echo $employee['email']; ?></p>
                    <p><strong>Gender: </strong><?php echo $employee['gender'] ?: 'Not Defined'; ?></p>
                    <p><strong>Date of Birth: </strong><?php echo $employee['dob']; ?></p>
                    <p><strong>Salary: </strong><?php echo $employee['salary'] ?: 'Not Defined'; ?></p>
                    <p><strong>Department: </strong><?php echo $employee['department'] ?: 'Not Defined'; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
