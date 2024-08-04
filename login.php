<?php
require "index.php";
session_start();
if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != null){
    header('location:main.php');
}

require "index.php";
require "help.php";


if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = post("email");
    $password = post("password");
    $sql = "SELECT * FROM users WHERE email = ?";
    $loginQuery = $connection->prepare($sql);
    $loginQuery->execute([$email]);
    $user = $loginQuery->fetch(PDO::FETCH_ASSOC);
   if($user && password_verify($password, $user['password'])){
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];

        header('Location: main.php');
    }
}

?>
<form method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>
