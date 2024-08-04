<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Main Page</title>
</head>
<body>

<?php
session_start();
if (isset($_SESSION['user_id'])) { ?>

    <h1>Welcome <?php echo htmlspecialchars($_SESSION['name']); ?></h1>
    <button>
        <a href="logout.php">Log out</a>
    </button>
    <button>
        <a href="blogs.php">Go to Blogs</a>
    </button>

<?php
} else {
    ?>
    <button>
        <a style="text-decoration: none;color: black" href="register.php">Register</a>
    </button>
    <button>
        <a style="text-decoration: none;color: black" href="login.php">Login</a>
    </button>
<?php
}
?>

</body>
</html>
