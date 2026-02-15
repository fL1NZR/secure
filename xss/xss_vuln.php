<?php
include 'index.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['comment'])) {
    $name = $_POST['name'];
    $comment = $_POST['comment'];
    
    $sql = "INSERT INTO comments (name, comment) VALUES ('$name', '$comment')";
    $conn->query($sql);
}

$comments = [];
$result = $conn->query("SELECT name, comment, created_at FROM comments ORDER BY created_at DESC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Уязвимая XSS</title>
    <style>
        body { font-family: Arial; max-width: 800px; margin: 20px auto; padding: 20px; }
        .vuln { background: #fff0f0; padding: 20px; border-radius: 5px; border: 2px solid #ff9999; }
        .comment { border-bottom: 1px solid #ccc; padding: 10px; }
        input, textarea { width: 100%; padding: 8px; margin: 5px 0; }
        button { background: #ff9999; border: 0; padding: 10px 20px; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Уязвимая страница</h1>
    <p><a href="index.php">На главную</a></p>

    <div class="vuln">
        <h2>Добавить комментарий</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Ваше имя" required>
            <textarea name="comment" rows="4" placeholder="Комментарий" required></textarea>
            <button type="submit">Отправить</button>
        </form>
    </div>

    <h2>Все комментарии (НЕБЕЗОПАСНЫЙ вывод!)</h2>
    <?php foreach ($comments as $c): ?>
        <div class="comment">
            <strong><?php echo $c['name']; ?></strong> 
            <small>(<?php echo $c['created_at']; ?>)</small>
            <p><?php echo $c['comment']; ?></p>
        </div>
    <?php endforeach; ?>
</body>
</html>