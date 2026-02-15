<?php
$conn = mysqli_connect("localhost", "root", "", "sqldb");

echo "<!DOCTYPE html>
<html>
<head>
    <title>Защищенная версия - SQL Injection</title>
    <link rel='stylesheet' href='style.css'>
</head>
<body>
    <div class='container'>";

if(isset($_POST['login'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE login = ? AND password = ?");
    mysqli_stmt_bind_param($stmt, "ss", $login, $password);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    
    echo "<h1 class='secure-title'>Защищенная форма входа</h1>";
    
    echo "<div class='nav'>
        <a href='vuln.php'>Уязвимая</a> | 
        <a href='secure.php' class='active'>Защищенная</a>
    </div>";
    
    if(mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        echo "<div class='success'>Вход выполнен" . htmlspecialchars($user['login']) . "</div>";
    } else {
        echo "<div class='error'>Неверный логин или пароль</div>";
    }
} else {
    echo "<h1 class='secure-title'>Защищенная форма входа</h1>
    
    <div class='nav'>
        <a href='vuln.php'>Уязвимая</a> | 
        <a href='secure.php' class='active'>Защищенная</a>
    </div>";
}
?>

<form method="POST">
    Логин:<br>
    <input type="text" name="login" required><br>
    Пароль:<br>
    <input type="password" name="password" required><br>
    <input type="submit" value="Войти безопасно" class='secure-btn'>
</form>

<hr>

<h3>Инъекции не работают:</h3>
<pre>
Логин: admin' -- 
Пароль: любой
</pre>

</div>
</body>
</html>