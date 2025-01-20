<?php
require_once "include/header.php";
require_once "../connection.php";


// Fetch employee details
$sql_command = "SELECT * FROM employee WHERE email = '$_SESSION[email_emp]'";
$result = mysqli_query($conn, $sql_command);

if ($result && mysqli_num_rows($result) > 0) {
    while ($rows = mysqli_fetch_assoc($result)) {
        $name = ucwords($rows["name"] ?? "Not Defined");
        $gender = ucwords($rows["gender"] ?? "Not Defined");
        $dob = $rows["dob"] ?? "Not Defined";
        $salary = $rows["salary"] ?? "Not Defined";
        $dp = $rows["dp"];
        $id = $rows["id"] ?? "Not Defined";
    }

    if ($dob !== "Not Defined") {
        // Calculate age if date of birth is defined
        $date1 = date_create($dob);
        $date2 = date_create("now");
        $diff = date_diff($date1, $date2);
        $age = $diff->format("%y Years");
    }
}
?>

<div class="container my-3">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="card shadow border-0">
                <br>
                <!-- Profile photo section -->
                <img src="upload/<?php echo !empty($dp) ? $dp : '1.jpg'; ?>" 
                alt="Profile Photo" 
                 class="profile-photo rounded-circle mx-auto d-block" 
            style="height: 250px; width: 250px; object-fit: cover;">

                <!-- Profile information section -->
                <div class="card-body text-center">
                    <h3 class="card-title mb-3"><?php echo htmlspecialchars($name); ?></h3>
                    <ul class="list-unstyled mb-4">
                        <li><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION["email_emp"]); ?></li>
                        <li><strong>Employee Id:</strong> <?php echo htmlspecialchars($id); ?></li>
                        <li><strong>Gender:</strong> <?php echo htmlspecialchars($gender); ?></li>
                        <li><strong>Age:</strong> <?php echo htmlspecialchars($age); ?></li>
                        <li><strong>Date of Birth:</strong> <?php echo htmlspecialchars($dob); ?></li>
                        <li><strong>Salary:</strong> <?php echo htmlspecialchars($salary) . ".00"; ?></li>
                    </ul>

                    <!-- Action buttons -->
                    <div class="d-grid gap-2">
                        <a href="edit-profile.php" class="btn btn-primary btn-sm">Edit Profile</a>
                        <a href="change-password.php" class="btn btn-secondary btn-sm">Change Password</a>
                        <a href="profile-photo.php" class="btn btn-outline-primary btn-sm">Change Profile Photo</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once "include/footer.php";
?>
