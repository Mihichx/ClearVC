<?php

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

    <!--Bootstrap CSS-->
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">

    <!--FontAwesome-->
    <link rel="stylesheet" href="/assets/fontAwesome/css/all.css">

    <!--CSS-->
    <link rel="stylesheet" href="/assets/css/style.css">

    <!--JS общий для всех страниц-->
    <script defer src="/assets/js/script.js"></script>

    <!--Bootstrap JS-->
    <script defer src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- js рендера (подставляется отдельно для каждой страницы) -->
    <?php if (!empty($js)):
        $jsFiles = array_filter(array_map('trim', explode(',', $js)));
        foreach ($jsFiles as $jsItem): ?>
            <script defer src="/assets/js/<?= htmlspecialchars($jsItem, ENT_QUOTES, 'UTF-8') ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

</head>

<body>
    <header>

    </header>

    <main>
        <?= $content ?>
    </main>

    <footer>

    </footer>
</body>

</html>
