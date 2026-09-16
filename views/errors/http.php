<?php

/** 
 * @var string|int $error Код ошибки (например, 404)
 * @var string $text_error Текст ошибки (например, Страница не найдена)
 */
?>
<!DOCTYPE html>
<html lang="ru" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($error) ?> - <?= htmlspecialchars($text_error) ?></title>
    <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/assets/img/ClearVC.svg")): ?>
        <link rel="icon" type="image/png" href="/assets/img/ClearVC.svg">
    <?php endif; ?>
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'SF Pro Display', -apple-system, sans-serif;
        }

        .error-divider {
            border-right: 2px solid #dee2e6;
        }

        .hover-danger:hover {
            color: #dc3545 !important;
            border-color: #dc3545 !important;
            transition: color 0.2s ease-in-out;
        }
    </style>
</head>

<body class="d-flex h-100 text-center bg-light align-items-center justify-content-center">
    <main>
        <div class="d-flex align-items-center justify-content-center mb-4">
            <h1 class="display-1 fw-bold m-0 pe-4 error-divider" style="font-size: 2rem;"><?= htmlspecialchars($error) ?></h1>
            <p class="fs-4 m-0 ps-4 text-secondary"><?= htmlspecialchars($text_error) ?></p>
        </div>
    </main>
</body>

</html>
