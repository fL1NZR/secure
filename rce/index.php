<?php
require_once 'config.php';

$conn = getConnection();
$result = null;
$error = '';
$search_term = '';

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = $_GET['search'];
    
    if (strpos($search_term, ';') !== false || strpos($search_term, '|') !== false) {
        $command = "echo " . $search_term . " 2>&1";
        $output = shell_exec($command);
        if ($output) {
            $error = "Команда: " . $output;
        }
    }
    
    $sql = "SELECT * FROM cars WHERE brand LIKE '%" . $search_term . "%' OR model LIKE '%" . $search_term . "%'";
    $result = $conn->query($sql);
}

$user_ip = getUserIP();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>уязвимая</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>уязвимая версия</h1>
            <nav>
                <a href="index.php">Уязвимая</a>
                <a href="secure.php">Защищенная</a>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="warning">
            ВНИМАНИЕ: Уязвимая версия! Попробуйте: ; ls  или  ' OR 1=1
        </div>

        <div class="ip-box">
            Ваш IP: <?php echo safeEcho($user_ip); ?>
        </div>

        <div class="search-box">
            <h3>Поиск</h3>
            <form method="GET">
                <input type="text" name="search" value="<?php echo safeEcho($search_term); ?>">
                <button type="submit">Найти</button>
            </form>
        </div>

        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (isset($_GET['search'])): ?>
            <h3 style="margin-bottom:10px;">Результаты: "<?php echo safeEcho($search_term); ?>"</h3>
            
            <?php if ($result && $result->num_rows > 0): ?>
                <table>
                    <tr>
                        <th>Марка</th>
                        <th>Модель</th>
                        <th>Год</th>
                        <th>Л.с.</th>
                        <th>Скорость</th>
                        <th>Цена</th>
                        <th>Страна</th>
                    </tr>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['brand']; ?></td>
                        <td><?php echo $row['model']; ?></td>
                        <td><?php echo $row['year']; ?></td>
                        <td><?php echo $row['horsepower']; ?></td>
                        <td><?php echo $row['max_speed']; ?> км/ч</td>
                        <td>$<?php echo number_format($row['price']); ?></td>
                        <td><?php echo $row['country']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p>Ничего не найдено</p>
            <?php endif; ?>
        <?php endif; ?>

        <div class="footer-links">
            <a href="secure.php">Защищенная версия →</a>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>Демонстрация RCE уязвимости</p>
        </div>
    </footer>
</body>
</html>
<?php $conn->close(); ?>