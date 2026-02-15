<?php
$conn = mysqli_connect("localhost", "root", "", "sqldb");

echo "<!DOCTYPE html>
<html>
<head>
    <title>Уязвимая версия - SQL Injection</title>
    <link rel='stylesheet' href='style.css'>
</head>
<body>
    <div class='container'>";

if(isset($_POST['login'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE login = '$login' AND password = '$password'";
    
    $result = mysqli_query($conn, $sql);
    
    echo "<h1 class='vuln-title'>Уязвимая форма входа</h1>";
    
    echo "<div class='nav'>
        <a href='vuln.php' class='active'>Уязвимая</a> | 
        <a href='secure.php'>Защищенная</a>
    </div>";
    
    echo "<div class='sql-query'>SQL запрос: <br><strong>" . htmlspecialchars($sql) . "</strong></div>";
    
    if(mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        echo "<div class='success'>Вход выполнен" . $user['login'] . "</div>";
    } else {
        echo "<div class='error'>Неверный логин или пароль</div>";
    }
} else {
    echo "<h1 class='vuln-title'>Уязвимая форма входа</h1>
    
    <div class='nav'>
        <a href='vuln.php' class='active'>Уязвимая</a> | 
        <a href='secure.php'>Защищенная</a>
    </div>";
}
?>

<form method="POST">
    Логин:<br>
    <input type="text" name="login" required><br>
    Пароль:<br>
    <input type="password" name="password" required><br>
    <input type="submit" value="Войти" class='vuln-btn'>
</form>

<hr>

<h3>SQL:</h3>
<pre>
Логин: admin' -- 
Пароль: любой
</pre>

</div>
</body>
</html>