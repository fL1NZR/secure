<?php
$consent = $_COOKIE['consent'] ?? '';
$theme = $_COOKIE['theme'] ?? 'light';

if (isset($_POST['accept'])) {
    setcookie('consent', 'yes', time()+86400*30);
    setcookie('theme', 'light', time()+86400*30);
    $consent = 'yes';
    header('Location: ?');
    exit;
}
if (isset($_POST['decline'])) {
    setcookie('consent', 'no', time()+86400*30);
    $consent = 'no';
    header('Location: ?');
    exit;
}
if (isset($_GET['theme'])) {
    setcookie('theme', $_GET['theme'], time()+86400*30);
    $theme = $_GET['theme'];
    header('Location: ?');
    exit;
}
if (isset($_POST['clear'])) {
    foreach ($_COOKIE as $name => $value) {
        setcookie($name, '', time()-3600);
    }
    header('Location: ?');
    exit;
}
if (isset($_GET['set'])) {
    $name = $_GET['name'] ?? 'test';
    $val = $_GET['val'] ?? date('H:i:s');
    setcookie($name, $val, time()+86400);
    header('Location: ?');
    exit;
}
if (isset($_GET['accept'])) {
    setcookie('consent', 'yes', time()+86400*30);
    setcookie('theme', 'light', time()+86400*30);
    header('Location: ?');
    exit;
}
?>
<html>
<head>
    <title>Cookies</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            background: <?= $theme == 'dark' ? '#1a1a1a' : '#f0f2f5' ?>; 
            font-family: system-ui; 
            padding: 20px;
            transition: 0.3s;
        }
        .box { 
            background: <?= $theme == 'dark' ? '#2d2d2d' : 'white' ?>; 
            max-width: 500px; 
            margin: 40px auto; 
            padding: 30px; 
            border-radius: 12px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
            color: <?= $theme == 'dark' ? '#fff' : '#1a1a1a' ?>;
        }
        h1 { font-size: 24px; margin-bottom: 20px; }
        .info { 
            background: <?= $theme == 'dark' ? '#3d3d3d' : '#e8f4fd' ?>; 
            padding: 15px; 
            border-radius: 8px; 
            margin: 20px 0; 
            color: <?= $theme == 'dark' ? '#fff' : '#0369a1' ?>;
        }
        .badge { 
            background: #4CAF50; 
            color: white; 
            padding: 4px 12px; 
            border-radius: 20px; 
            font-size: 14px; 
            display: inline-block; 
            margin: 10px 0; 
        }
        .btn { 
            border: none; 
            padding: 12px 24px; 
            border-radius: 6px; 
            font-size: 16px; 
            cursor: pointer; 
            margin: 5px; 
            text-decoration: none;
            display: inline-block;
        }
        .btn-green { background: #4CAF50; color: white; }
        .btn-red { background: #f44336; color: white; }
        .btn-grey { background: #9e9e9e; color: white; }
        .btn-blue { background: #2196F3; color: white; }
        .list { list-style: none; margin: 15px 0; }
        .list li { 
            padding: 10px; 
            background: <?= $theme == 'dark' ? '#3d3d3d' : '#f8f9fa' ?>; 
            margin: 5px 0; 
            border-radius: 4px; 
            font-family: monospace;
            color: <?= $theme == 'dark' ? '#fff' : '#1a1a1a' ?>;
        }
        .banner { 
            position: fixed; 
            bottom: 20px; 
            left: 20px; 
            right: 20px; 
            background: <?= $theme == 'dark' ? '#000' : '#2d3748' ?>; 
            color: white; 
            padding: 20px; 
            border-radius: 10px; 
            display: flex; 
            gap: 20px; 
            align-items: center; 
            max-width: 600px; 
            margin: 0 auto; 
        }
        .theme-btn {
            display: inline-block;
            padding: 8px 16px;
            background: <?= $theme == 'dark' ? '#fff' : '#333' ?>;
            color: <?= $theme == 'dark' ? '#000' : '#fff' ?>;
            text-decoration: none;
            border-radius: 20px;
            margin: 5px;
            font-size: 14px;
        }
        .reset-link {
            display: inline-block;
            margin-top: 20px;
            color: <?= $theme == 'dark' ? '#4CAF50' : '#2196F3' ?>;
            text-decoration: none;
            font-size: 16px;
        }
    </style>
</head>
<body>

<div class="box">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h1>Простые cookies</h1>
        <div>
            <a href="?theme=light" class="theme-btn">Светлая</a>
            <a href="?theme=dark" class="theme-btn">Тёмная</a>
        </div>
    </div>
    
    <?php if ($consent == 'yes'): ?>
        <span class="badge">Cookies приняты</span>
        <div style="margin: 10px 0;">Тема: <strong><?= $theme == 'dark' ? 'Тёмная' : 'Светлая' ?></strong></div>
        
        <div class="info">
            <strong>Все cookies на сайте:</strong>
        </div>
        
        <ul class="list">
        <?php 
        if (count($_COOKIE) > 0) {
            foreach ($_COOKIE as $name => $value): ?>
                <li><strong><?= htmlspecialchars($name) ?>:</strong> <?= htmlspecialchars($value) ?></li>
            <?php endforeach; 
        } else { ?>
            <li>Нет cookies</li>
        <?php } ?>
        </ul>
        
        <form method="post">
            <button class="btn btn-grey" type="submit" name="clear" value="1">Очистить cookies</button>
        </form>
        
    <?php elseif ($consent == 'no'): ?>
        <span class="badge" style="background: #f44336;">Cookies отклонены</span>
        <p style="margin: 20px 0;">Вы отклонили cookies. Тема работает без cookies.</p>
        <p>Тема: <strong><?= $theme == 'dark' ? 'Тёмная' : 'Светлая' ?></strong></p>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="?accept=1" class="btn btn-green" style="font-size: 18px; padding: 15px 30px;">Принять cookies сейчас</a>
        </div>
        
    <?php else: ?>
        <p style="margin: 20px 0;">Нажмите "Принять", чтобы сохранить cookies</p>
    <?php endif; ?>
</div>

<?php if (!$consent): ?>
<div class="banner">
    <div style="flex: 1;">
        <strong style="font-size: 18px;">Этот сайт использует cookies</strong>
        <p style="margin-top: 5px; opacity: 0.9;">Мы сохраняем ваши настройки и посещения</p>
    </div>
    <form method="post" style="display: flex; gap: 10px;">
        <button class="btn btn-green" name="accept" value="1">Принять</button>
        <button class="btn btn-red" name="decline" value="1">Отклонить</button>
    </form>
</div>
<?php endif; ?>

<div class="box" style="text-align: center;">
    <h2>Действия</h2>
    <a href="?set=1&name=visit&val=<?= time() ?>" class="btn btn-green">Добавить cookie</a>
    <a href="?set=1&name=lang&val=ru" class="btn btn-green">Язык ru</a>
    <a href="?set=1&name=city&val=moscow" class="btn btn-green">Город Москва</a>
</div>

</body>
</html>