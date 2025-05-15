<?php
session_start();
require_once "database.php"; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login_email = $_POST['login_email'];
    $login_password = $_POST['login_password'];
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $login_email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($login_password, $user['password'])) {
            $full_name = urlencode($user['full_name']);
            $email = urlencode($user['email']);
            header("Location: profile.html?name=$full_name&email=$email");
            exit();
        } else {
            echo "Invalid email or password.";
        }
    } else {
        echo "Invalid email or password.";
    }
    mysqli_close($conn);
}
?>
