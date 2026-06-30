<div class="container">
    <h1>Главная</h1>
    <?
    // в render передали 'content' => $content, 
    // поэтому здесь есть переменная $content соответствующая ключу 'content'
    foreach ($content as $block) { ?>
        <p><?= htmlspecialchars($block);?></p>
    <?}?>
</div>