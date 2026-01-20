<?php
include "../config/database.php";

$name     = $_POST['name'];
$email    = $_POST['email'];
$phone    = $_POST['phone'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$query = "INSERT INTO users (name, email, phone, password_hash, role)
          VALUES ('$name', '$email', '$phone', '$password', 'user')";

mysqli_query($conn, $query);

header("Location: ../views/auth/login.php");
