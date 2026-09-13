<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($exception->getMessage()) ?></title>
    <style>
        body { 
            font-family: 'SF Pro Display', -apple-system, sans-serif; 
            background-color: #f8f9fa;
            color: #212529;
            padding: 40px; 
            margin: 0; 
        }
        .container { max-width: 1000px; margin: 0 auto; }
        .error-header { 
            background: #ffffff; 
            padding: 24px; 
            border-radius: 8px; 
            border-left: 6px solid #dc3545;
            margin-bottom: 20px; 
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border-top: 1px solid #dee2e6;
            border-right: 1px solid #dee2e6;
            border-bottom: 1px solid #dee2e6;
        }
        .exception-name { 
            color: #dc3545;
            font-size: 14px; 
            text-transform: uppercase; 
            letter-spacing: 1px; 
            font-weight: bold; 
        }
        .message { font-size: 24px; font-weight: 700; margin: 8px 0; color: #212529; }
        .file-info { font-family: monospace; color: #6c757d; font-size: 14px; }
        .stack-trace { 
            background: #ffffff; 
            padding: 24px; 
            border-radius: 8px; 
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border: 1px solid #dee2e6;
        }
        .stack-title { font-size: 18px; font-weight: bold; margin-bottom: 16px; color: #212529; }
        .trace-item { 
            font-family: monospace; 
            padding: 10px 0; 
            border-bottom: 1px solid #dee2e6; 
            color: #495057; 
            font-size: 14px;
        }
        .trace-item:last-child { border-bottom: none; }
        .trace-item span { color: #dc3545; font-weight: bold; }
        .trace-file { color: #212529; font-weight: 600; }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-header">
            <div class="exception-name"><?= (new \ReflectionClass($exception))->getShortName() ?></div>
            <div class="message"><?= htmlspecialchars($exception->getMessage()) ?></div>
            <div class="file-info">В файле: <?= $exception->getFile() ?> (строка <?= $exception->getLine() ?>)</div>
        </div>
        
        <div class="stack-trace">
            <div class="stack-title">Стек вызовов (Stack Trace):</div>
            <?php foreach ($exception->getTrace() as $index => $trace): ?>
                <div class="trace-item">
                    #<?= $index ?> 
                       <span class="trace-file"><?= $trace['file'] ?? 'Core' ?></span>(<span><?= $trace['line'] ?? '?' ?></span>): 
                    <?= ($trace['class'] ?? '') . ($trace['type'] ?? '') . $trace['function'] ?>()
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
