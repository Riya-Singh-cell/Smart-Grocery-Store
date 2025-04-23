<?php
include 'db.php'; // Your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = $conn->real_escape_string($_POST['name']);
    $email    = $conn->real_escape_string($_POST['email']);
    $gender   = $conn->real_escape_string($_POST['gender']);
    $country  = $conn->real_escape_string($_POST['country']);
    $mobile   = $conn->real_escape_string($_POST['mobile']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // secure hash

    // Check if email already exists
    $check = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if ($check->num_rows > 0) {
        echo "<script>alert('Email already exists!'); window.history.back();</script>";
        exit;
    }

    $sql = "INSERT INTO users (username, email, gender, country, mobile, password) 
            VALUES ('$name', '$email', '$gender', '$country', '$mobile', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Sign-up successful! Please login.'); window.location.href='login.html';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
