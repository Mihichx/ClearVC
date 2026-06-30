<div class="container my-4">
    <!-- Кнопка возврата на главную -->
    <div class="mb-4">
        <a href="/" class="btn btn-outline-secondary d-inline-flex align-items-center gap-2 border-0 p-1 shadow-none hover-danger-btn">
            <span>←</span> Вернуться на главную
        </a>
    </div>
    
    <h1 class="mb-4">Карта маршрутов (Роуты)</h1>
    <p class="text-muted">Список всех адресов, которые сейчас обрабатывает <code>Router.php</code>.</p>

    <div class="table-responsive shadow-sm rounded border">
        <table class="table table-striped table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>URL (Адрес)</th>
                    <th>Обработчик (Контроллер @ Метод)</th>
                    <th>Метод запроса</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($routes as $route): ?>
                <tr>
                    <td><code class="text-primary"><?= htmlspecialchars($route[0]) ?></code></td>
                    <td><code><?= htmlspecialchars($route[1]) ?></code></td>
                    <td><span class="badge bg-success"><?= htmlspecialchars($route[2] ?? 'GET') ?></span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
