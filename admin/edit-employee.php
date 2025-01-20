<?php 
    require_once "include/header.php";
?>

<?php  
    $id = $_GET["id"];
    require_once "../connection.php";

    // Fetch employee details
    $sql = "SELECT * FROM employee WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row["name"];
        $email = $row["email"];
        $dob = $row["dob"];
        $gender = $row["gender"];
        $salary = $row["salary"];
        $department = $row["department"];
    }

    $nameErr = $emailErr = $passErr = $salaryErr = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $gender = $_POST["gender"] ?? "";
        $dob = $_POST["dob"] ?? "";
        $department = $_POST["department"] ?? "";

        if (empty($_POST["name"])) {
            $nameErr = "<p style='color:red'> * Name is required</p>";
            $name = "";
        } else {
            $name = $_POST["name"];
        }

        if (empty($_POST["salary"])) {
            $salaryErr = "<p style='color:red'> * Salary is required</p>";
            $salary = "";
        } else {
            $salary = $_POST["salary"];
        }

        if (empty($_POST["email"])) {
            $emailErr = "<p style='color:red'> * Email is required</p>";
            $email = "";
        } else {
            $email = $_POST["email"];
        }

        $new_pass = $_POST["new_pass"] ?? "";
        $confirm_pass = $_POST["confirm_pass"] ?? "";

        if (!empty($new_pass) && ($new_pass !== $confirm_pass)) {
            $passErr = "<p style='color:red'> * Passwords do not match</p>";
        }

        if (!empty($name) && !empty($email) && empty($passErr) && !empty($salary)) {
            // Check for duplicate email
            $sql_select_query = "SELECT email FROM employee WHERE email = '$email' AND id != $id";
            $r = mysqli_query($conn, $sql_select_query);

            if (mysqli_num_rows($r) > 0) {
                $emailErr = "<p style='color:red'> * Email already registered</p>";
            } else {
                // Update query
                $password_update = !empty($new_pass) ? ", password = '" . password_hash($new_pass, PASSWORD_BCRYPT) . "'" : "";
                $sql = "UPDATE employee 
                        SET name = '$name', email = '$email', dob = '$dob', 
                            gender = '$gender', salary = '$salary', department = '$department' 
                            $password_update
                        WHERE id = $id";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    echo "<script>
                    $(document).ready(function(){
                        $('#showModal').modal('show');
                        $('#linkBtn').attr('href', 'manage-employee.php');
                        $('#linkBtn').text('View Employees');
                        $('#addMsg').text('Profile updated successfully!');
                        $('#closeBtn').text('Again');
                    });
                    </script>";
                }
            }
        }
    }
?>

<div class="login-form-bg h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100">
            <div class="col-xl-6">
                <div class="form-input-content">
                    <div class="card login-form mb-0">
                        <div class="card-body pt-4 shadow">                       
                            <h4 class="text-center">Edit Employee Profile</h4>
                            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?id=$id"; ?>">
                                <div class="form-group">
                                    <label>Full Name:</label>
                                    <input type="text" class="form-control" value="<?php echo $name; ?>" name="name">
                                    <?php echo $nameErr; ?>
                                </div>
                                <div class="form-group">
                                    <label>Email:</label>
                                    <input type="email" class="form-control" value="<?php echo $email; ?>" name="email">
                                    <?php echo $emailErr; ?>
                                </div>
                                <div class="form-group">
                                    <label>New Password:</label>
                                    <input type="password" class="form-control" name="new_pass" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password:</label>
                                    <input type="password" class="form-control" name="confirm_pass" autocomplete="off">
                                    <?php echo $passErr; ?>
                                </div>
                                <div class="form-group">
                                    <label>Salary:</label>
                                    <input type="number" class="form-control" value="<?php echo $salary; ?>" name="salary">
                                    <?php echo $salaryErr; ?>
                                </div>
                                <div class="form-group">
                                    <label>Date of Birth:</label>
                                    <input type="date" class="form-control" value="<?php echo $dob; ?>" name="dob">
                                </div>
                                <div class="form-group">
                                    <label>Department:</label>
                                    <select class="form-control" name="department">
                                    <option value="">Select Department</option>
                                        <option value="IT Department" <?php if ($department == "IT Department") echo "selected"; ?>>IT Department</option>
                                        <option value="Accounting Department" <?php if ($department == "Accounting Department") echo "selected"; ?>>Accounting Department</option>
                                        <option value="Marketing Department" <?php if ($department == "Marketing Department") echo "selected"; ?>>Marketing Department</option>
                                        <option value="Human Resources" <?php if ($department == "Human Resources") echo "selected"; ?>>Human Resources</option>
                                        <option value="Sales Department" <?php if ($department == "Sales Department") echo "selected"; ?>>Sales Department</option>
                                        <option value="Customer Support" <?php if ($department == "Customer Support") echo "selected"; ?>>Customer Support</option>
                                        <option value="Operations Department" <?php if ($department == "Operations Department") echo "selected"; ?>>Operations Department</option>
                                        <option value="Finance Department" <?php if ($department == "Finance Department") echo "selected"; ?>>Finance Department</option>
                                        <option value="Legal Department" <?php if ($department == "Legal Department") echo "selected"; ?>>Legal Department</option>
                                        <option value="Research and Development" <?php if ($department == "Research and Development") echo "selected"; ?>>Research and Development</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Gender:</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" value="Male" <?php if ($gender == "Male") echo "checked"; ?>>
                                        <label class="form-check-label">Male</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" value="Female" <?php if ($gender == "Female") echo "checked"; ?>>
                                        <label class="form-check-label">Female</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" value="Other" <?php if ($gender == "Other") echo "checked"; ?>>
                                        <label class="form-check-label">Other</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
    require_once "include/footer.php";
?>
