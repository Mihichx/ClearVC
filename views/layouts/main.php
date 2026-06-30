<?php session_start();?>
<!-- ОБРАТИТЕ ВНИМАНИЕ!  
 Данный файл является шаблоном, при редактировании не удаляйте следующие части кода:
    <Title> 
    js рендера
    $content
-->
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--НЕ УДАЛЯТЬ, прописывается название странички-->
    <title><?= htmlspecialchars($title ?? 'Нет названия') ?></title>
    
    <!--CSS-->
    <link rel="stylesheet" href="/assets/css/style.css">

    <!--Bootstrap CSS-->
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">

    <!--FontAwesome-->
    <link rel="stylesheet" href="/assets/fontAwesome/css/all.css">

    <!--JS общий для всех страниц-->
    <script src="/assets/js/script.js" defer></script>

    <!-- js рендера (подставляется отдельно для каждой страницы)-->
    <?if (!empty($js)){
        $jsArr = explode(", ", $js);
        foreach($jsArr as $jsItem){?>
        <script src="/assets/js/<?= htmlspecialchars($jsItem) ?>" defer></script>
    <?}
    }?>
    
</head>
<body>
    
    <!---------------------------------------------------Шапка--------------------------------------------------->
    <header>
    <!-- прописываем здесь свой хедер, путь прописывать без расширения-->
        <div class="mini-header">
            <a href="/">Главная</a>
            <a href="/about">О нас</a>
        </div>
    </header>

    
    <!---------------------------------------------------Основа--------------------------------------------------->
    <main>
        <!-- сюда подключится представление из папки view, НЕ УДАЛЯТЬ-->
        <?= $content ?>
    </main>


    <!---------------------------------------------------Подвал--------------------------------------------------->
    <footer>
    <!-- тут разместить подвал -->
    </footer>

    <!--Bootstrap JS-->
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
