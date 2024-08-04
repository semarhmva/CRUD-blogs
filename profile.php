<?php
require "index.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $sql = "UPDATE users SET name = ? WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->execute([$name, $user_id]);
}

$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $connection->prepare($sql);
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM blogs WHERE user_id = ?";
$stmt = $connection->prepare($sql);
$stmt->execute([$user_id]);
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
</head>
<body>
    <h1>Profile</h1>
    <form method="POST">
        <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
        <button type="submit">Update Name</button>
    </form>
    <h2>My Blogs</h2>
    <?php
    if ($blogs) {
        foreach ($blogs as $blog) {
            echo "<p>" . htmlspecialchars($blog['title']) . "</p>";
        }
    }
    ?>
</body>
</html>
