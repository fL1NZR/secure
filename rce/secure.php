<?php
require_once 'config.php';

$conn = getConnection();
$results = [];
$search_term = '';

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = $_GET['search'];
    
    $search_term_clean = preg_replace('/[^a-zA-Z0-9\s]/', '', $search_term);
    
    $sql = "SELECT * FROM cars WHERE brand LIKE ? OR model LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_param = "%" . $search_term_clean . "%";
    $stmt->bind_param("ss", $search_param, $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }
    $stmt->close();
}

$user_ip = getUserIP();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>защищенная</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>защищенная версия</h1>
            <nav>
                <a href="index.php">Уязвимая</a>
                <a href="secure.php">Защищенная</a>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="info">
            ЗАЩИТА: SQL injection и RCE заблокированы
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

        <?php if (isset($_GET['search'])): ?>
            <h3 style="margin-bottom:10px;">Результаты: "<?php echo safeEcho($search_term); ?>"</h3>
            
            <?php if (!empty($results)): ?>
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
                    <?php foreach($results as $row): ?>
                    <tr>
                        <td><?php echo safeEcho($row['brand']); ?></td>
                        <td><?php echo safeEcho($row['model']); ?></td>
                        <td><?php echo safeEcho($row['year']); ?></td>
                        <td><?php echo safeEcho($row['horsepower']); ?></td>
                        <td><?php echo safeEcho($row['max_speed']); ?> км/ч</td>
                        <td>$<?php echo safeEcho(number_format($row['price'])); ?></td>
                        <td><?php echo safeEcho($row['country']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>Ничего не найдено</p>
            <?php endif; ?>
        <?php endif; ?>

        <div class="footer-links">
            <a href="index.php">← Уязвимая версия</a>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>Демонстрация защиты от RCE</p>
        </div>
    </footer>
</body>
</html>
<?php $conn->close(); ?>