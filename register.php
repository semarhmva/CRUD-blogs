<?php
require "index.php";
session_start();
if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != null) {
    header('location:main.php');
}
require "index.php";
require "help.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = post('name');
    $email = post('email');
    $password = post('password');
    $password_confirmation = post('password_confirmation');

    if ($password == $password_confirmation) {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name,email,password) VALUE (?,?,?)";

        try {
            $loginQuery = $connection->prepare($sql);

            $check = $loginQuery->execute([
                $name,
                $email,
                $password
            ]);

            if ($check) {
                header("location: login.php");
            }
        } catch (PDOException $e) {
            if ($e->errorInfo[1] === 1062) {
                echo "Email already exists";
            } else {
                echo $e->getMessage();
            }
        }
    } else {
        echo 'Passwords do not match';
    }
}
?>
<form method="POST">
    <input type="text" name="name" placeholder="Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="password_confirmation" placeholder="Password Confirmation" required>
    <button type="submit">Register</button>
</form>