<?php 
    $email_err = $pass_err = $login_Err = "";
    $email = $pass = "";
    
    // Admin login logic
    if( isset($_POST['admin_email']) && isset($_POST['admin_password']) ){
        if( empty($_POST["admin_email"]) ){
            $email_err = " <p style='color:red'> * Email Can Not Be Empty</p> ";
        } else {
            $email = $_POST["admin_email"];
        }

        if( empty($_POST["admin_password"]) ){
            $pass_err = " <p style='color:red'> * Password Can Not Be Empty</p> ";
        } else {
            $pass = $_POST["admin_password"];
        }

        if( !empty($email) && !empty($pass) ){
            require_once "C:/xampp/htdocs/EMP/connection.php"; 


            $sql_query = "SELECT * FROM admin WHERE email='$email' && password = '$pass' ";
            $result = mysqli_query($conn, $sql_query);

            if( mysqli_num_rows($result) > 0 ){
                while( $rows = mysqli_fetch_assoc($result) ){
                    session_start();
                    session_unset();
                    $_SESSION["email"] = $rows["email"];
                    header("Location: admin/dashboard.php?login-success");
                }
            } else {
                $login_Err = "<div class='alert alert-warning alert-dismissible fade show'>
                    <strong>Invalid Email/Password</strong>
                    <button type='button' class='close' data-dismiss='alert' >
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
            }
        }
    }

    // Employee login logic
    if( isset($_POST['emp_email']) && isset($_POST['emp_password']) ){
        if( empty($_POST["emp_email"]) ){
            $email_err = " <p style='color:red'> * Email Can Not Be Empty</p> ";
        } else {
            $email = $_POST["emp_email"];
        }

        if( empty($_POST["emp_password"]) ){
            $pass_err = " <p style='color:red'> * Password Can Not Be Empty</p> ";
        } else {
            $pass = $_POST["emp_password"];
        }

        if( !empty($email) && !empty($pass) ){
            // database connection
            require_once "C:/xampp/htdocs/EMP/connection.php"; 

            $sql_query = "SELECT * FROM employee WHERE email='$email' && password = '$pass' ";
            $result = mysqli_query($conn, $sql_query);

            if( mysqli_num_rows($result) > 0 ){
                while( $rows = mysqli_fetch_assoc($result) ){
                    session_start();
                    session_unset();
                    $_SESSION["email_emp"] = $rows["email"];
                    header("Location: employee/dashboard.php?login-success");
                }
            } else {
                $login_Err = "<div class='alert alert-warning alert-dismissible fade show'>
                    <strong>Invalid Email/Password</strong>
                    <button type='button' class='close' data-dismiss='alert' >
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <title>LOGIN</title>
</head>
<body>
    <div class="container" id="container">
        <!-- Employee login form -->
        <div class="form-container sign-up">
            <form action="" method="POST">
                <h1>EMPLOYEE</h1>

                <div class="input-container">
                    <ion-icon name="mail-outline"></ion-icon>
                    <input type="email" name="emp_email" placeholder="Email" required>
                </div>
                <?php echo $email_err; ?>

                <div class="input-container">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                    <input type="password" name="emp_password" placeholder="Password" required>
                </div>
                <?php echo $pass_err; ?>

                <button type="submit">Login</button>
            </form>
        </div>

        <!-- Admin login form -->
        <div class="form-container sign-in">
            <form action="" method="POST">
                <h1>ADMIN</h1>

                <div class="input-container">
                    <ion-icon name="mail-outline"></ion-icon>
                    <input type="email" name="admin_email" placeholder="Email" required>
                </div>
                <?php echo $email_err; ?>

                <div class="input-container">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                    <input type="password" name="admin_password" placeholder="Password" required>
                </div>
                <?php echo $pass_err; ?>

                <button type="submit">Login</button>
            </form>
        </div>

        <!-- Show login error message -->
        <?php echo $login_Err; ?>

        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Hello!</h1>
                    <p>Admin? Log in now!</p>
                    <button class="hidden" id="login">Login Admin</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Welcome</h1>
                    <p>Employee? Log in now!</p>
                    <button class="hidden" id="register">Login Employee</button>
                </div>
            </div>
        </div>
    </div>

    <script src="register.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
