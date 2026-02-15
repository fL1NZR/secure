<?php
session_start();
$db = new mysqli('localhost', 'root', '', 'csrfbd');

if (isset($_POST['login'])) {
    $_SESSION['user'] = $db->real_escape_string($_POST['user']);
}

if (isset($_POST['buy']) && isset($_SESSION['user'])) {
    $game = $_POST['game'];
    $price = (int)$_POST['price'];
    $user = $_SESSION['user'];

    $res = $db->query("SELECT balance FROM users WHERE username='$user'");
    $data = $res->fetch_assoc();
    if ($data['balance'] >= $price) {
        $db->query("UPDATE users SET balance = balance - $price, {$game}_owned = 1 WHERE username='$user'");
        echo "<p>Куплено!</p>";
    } else {
        echo "<p>Недостаточно средств</p>";
    }
}

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $res = $db->query("SELECT * FROM users WHERE username='$user'");
    $u = $res->fetch_assoc();
}
?>

<h2>Магазин игр (УЯЗВИМАЯ ВЕРСИЯ)</h2>

<?php if (isset($u)): ?>
    <p>Пользователь: <?= $u['username'] ?> | Баланс: <?= $u['balance'] ?></p>
    <p>Игры: <?= $u['cs2_owned']?'CS2 ':'' ?><?= $u['dota2_owned']?'Dota2 ':'' ?><?= $u['pubg_owned']?'PUBG':'' ?></p>
<?php else: ?>
    <form method="post">
        <input type="text" name="user" value="vitya">
        <input type="submit" name="login" value="Войти">
    </form>
<?php endif; ?>

<hr>

<form method="post">
    <input type="hidden" name="game" value="cs2">
    <input type="hidden" name="price" value="300">
    <input type="submit" name="buy" value="Купить CS2 (300)">
</form>

<form method="post">
    <input type="hidden" name="game" value="dota2">
    <input type="hidden" name="price" value="250">
    <input type="submit" name="buy" value="Купить Dota2 (250)">
</form>

<form method="post">
    <input type="hidden" name="game" value="pubg">
    <input type="hidden" name="price" value="400">
    <input type="submit" name="buy" value="Купить PUBG (400)">
</form>