<?php
require "index.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 if (isset($_POST['create'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $sql = "INSERT INTO blogs (user_id, title, content) VALUES (?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->execute([$user_id, $title, $content]);
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $sql = "UPDATE blogs SET title = ?, content = ? WHERE id = ? AND user_id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->execute([$title, $content, $id, $user_id]);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM blogs WHERE id = ? AND user_id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->execute([$id, $user_id]);
    }
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
  

    <h2>My Blogs</h2>
    <form method="POST">
        <input type="text" name="title" placeholder="Title" required>
        <textarea name="content" placeholder="Content" required></textarea>
        <button type="submit" name="create">Create</button>
    </form>
   <?php
   if($blogs) {
    foreach ($blogs as $blog) {
        echo "<p>" . htmlspecialchars($blog['title']) . " - " . htmlspecialchars($blog['content']) . "</p>";
        echo "<form method='POST'>";
        echo "<input type='hidden' name='id' value='" . htmlspecialchars($blog['id']) . "'>";
        echo "<input type='text' name='title' value='" . htmlspecialchars($blog['title']) . "'>";
        echo "<textarea name='content'>" . htmlspecialchars($blog['content']) . "</textarea>";
        echo "<button type='submit' name='update'>Update</button>";
        echo "<button type='submit' name='delete'>Delete</button>";
        echo "</form>";
    }
}

   ?>
</body>
</html>
