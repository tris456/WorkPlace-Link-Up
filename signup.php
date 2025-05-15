<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "workwebsite";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password_input = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    if ($password_input !== $confirm_password) {
        echo "⚠️ Passwords do not match. <a href='index.html'>Go back</a>";
        exit;
    }
    $hashed_password = password_hash($password_input, PASSWORD_DEFAULT);
    $check_email = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($check_email);
    if ($result->num_rows > 0) {
        echo "⚠️ Email already exists. <a href='index.html'>Go back</a>";
        exit;
    }
    $sql = "INSERT INTO users (full_name, email, password) VALUES ('$full_name', '$email', '$hashed_password')";
    if ($conn->query($sql) === TRUE) {
        header("Location: welcome.html");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
    $conn->close();
} else {
    echo "<h2>⚠️ Invalid Access</h2><p>Please use the form to sign up.</p><a href='index.html'>Go to Home</a>";
    exit;
}
?>
