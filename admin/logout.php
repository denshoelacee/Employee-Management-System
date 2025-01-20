<?php
session_start();

// Check if the user has confirmed to log out
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    // Destroy the session
    session_unset();
    session_destroy();

    // Clear session cookies
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Redirect to login form in the EMP folder
    header("Location: /EMP/login-form.php?logout=success");

    exit;
} else {

    echo "
    <script>
        if (confirm('Are you sure you want to log out?')) {
            window.location.href = 'logout.php?logout=true';
        } else {
            window.history.back();
        }
    </script>
    ";
}
?>
