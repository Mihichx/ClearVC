<?php 

session_start();
/** 
 * Главный шаблон (Layout) сайта.
 * 
 * @var string $content HTML-код конкретной страницы (View)
 * @var array|null $auth_user Массив с данными авторизованного пользователя из сессии
 * @var string|null $title Заголовок страницы (если передан из контроллера)
 */
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Нет названия') ?></title>

    <!--ICON-->
    <link rel="icon" type="image/png" href="/assets/img/ClearVC.svg">
    
    <!--CSS-->
    <link rel="stylesheet" href="/assets/css/style.css">

    <!--Bootstrap CSS-->
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">

    <!--FontAwesome-->
    <link rel="stylesheet" href="/assets/fontAwesome/css/all.css">

    <!--JS общий для всех страниц-->
    <script src="/assets/js/script.js" defer></script>

    <!-- js рендера (подставляется отдельно для каждой страницы) -->
    <?php if (!empty($js)): ?>
        <?php $jsArr = explode(", ", $js); ?>
        <?php foreach ($jsArr as $jsItem): ?>
            <script src="/assets/js/<?= htmlspecialchars($jsItem) ?>" defer></script>
        <?php endforeach; ?>
    <?php endif; ?>
    
</head>
<body>
    <!---------------------------------------------------Шапка--------------------------------------------------->
    <header>

    </header>

    
    <!---------------------------------------------------Основа--------------------------------------------------->
    <main>
        <!-- Сюда подключится представление из папки view -->
        <?= $content ?>
    </main>


    <!---------------------------------------------------Подвал--------------------------------------------------->
    <footer>

    </footer>
    <!--Bootstrap JS-->
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
