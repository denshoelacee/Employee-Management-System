<?php 
require_once "include/header.php";
require_once "../connection.php";

// Fetch admin details
$sql_command = "SELECT * FROM admin WHERE email = '$_SESSION[email]'";
$result = mysqli_query($conn, $sql_command);

if (mysqli_num_rows($result) > 0) {
    while ($rows = mysqli_fetch_assoc($result)) {
        $name = ucwords($rows["name"]);
        $gender = ucwords($rows["gender"]) ?: "Not Defined";
        $dob = $rows["dob"] ?: "Not Defined";
        $dp = $rows["dp"];
        $age = "Not Defined";
        if ($dob !== "Not Defined") {
            $date1 = date_create($dob);
            $date2 = date_create("now");
            $diff = date_diff($date1, $date2);
            $age = $diff->format("%y Years");
        }
    }
}
?>

<div class="container my-3">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="card shadow border-0">
                <br>
            <img src="upload/<?php echo !empty($dp) ? $dp : '1.jpg'; ?>" 
                alt="Profile Photo" 
                 class="profile-photo rounded-circle mx-auto d-block" 
            style="height: 250px; width: 250px; object-fit: cover;">


                <div class="card-body text-center">
                    <h3 class="card-title mb-3"><?php echo $name; ?></h3>
                    <ul class="list-unstyled mb-4">
                        <li><strong>Email:</strong> <?php echo $_SESSION["email"]; ?></li>
                        <li><strong>Gender:</strong> <?php echo $gender; ?></li>
                        <li><strong>Date of Birth:</strong> <?php echo $dob; ?></li>
                        <li><strong>Age:</strong> <?php echo $age; ?></li>
                    </ul>

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
