<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Ошибка инициализации ClearVC</title>
    <style>
        body { background: #f7fafc; font-family: sans-serif; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .error-card { padding: 30px; background: #fff; border: 1px solid #e2e8f0; border-top: 5px solid #e53e3e; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border-radius: 8px; max-width: 500px; width: 100%; }
        h3 { margin-top: 0; color: #2d3748; display: flex; align-items: center; gap: 10px; }
        p { color: #4a5568; line-height: 1.5; }
        code { background: #edf2f7; padding: 8px 12px; border: 1px solid #cbd5e0; display: block; font-weight: bold; font-family: monospace; border-radius: 4px; margin-top: 15px; color: #2d3748; }
    </style>
</head>
<body>

<div class="error-card">
    <h3>Ошибка инициализации</h3>
    <p>Зависимости фреймворка ClearVC не установлены. Автозагрузчик классов Composer не найден.</p>
    <p><strong>Решение:</strong> Откройте терминал в корне проекта и выполните команду:</p>
    <code>composer install</code>
</div>

</body>
</html>
