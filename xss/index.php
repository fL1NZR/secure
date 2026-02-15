<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'xssbd';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Главная</title>
    <style>
        body { font-family: Arial; max-width: 800px; margin: 20px auto; padding: 20px; }
        .menu { background: #f0f0f0; padding: 15px; border-radius: 5px; }
        .menu a { display: inline-block; margin-right: 20px; color: #333; }
        .warning { background: #ffecec; padding: 15px; border-left: 4px solid red; margin-top: 20px; }
    </style>
</head>
<body>
    <h1>XSS</h1>
    
    <div class="menu">
        <a href="index.php">Главная</a>
        <a href="xss_vuln.php">Уязвимая страница</a>
        <a href="xss_secure.php">Защищенная страница</a>
    </div>

    <h2>Последние комментарии</h2>
    <?php
    $result = $conn->query("SELECT name, comment, created_at FROM comments ORDER BY created_at DESC LIMIT 5");
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div style='border-bottom:1px solid #ddd; padding:10px 0;'>";
            echo "<strong>" . htmlspecialchars($row['name']) . "</strong> ";
            echo "<small>(" . $row['created_at'] . ")</small><br>";
            echo nl2br(htmlspecialchars($row['comment']));
            echo "</div>";
        }
    } else {
        echo "<p>Пока нет комментариев.</p>";
    }
    ?>
</body>
</html>