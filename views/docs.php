<div class="container my-5">
    <!-- Кнопка возврата на главную -->
    <div class="mb-4">
        <a href="/" class="btn btn-outline-secondary d-inline-flex align-items-center gap-2 border-0 p-1 shadow-none hover-danger-btn">
            <span>←</span> Вернуться на главную
        </a>
    </div>

    <!-- Шапка документации -->
    <div class="p-5 mb-5 bg-dark text-white rounded-3 shadow-sm position-relative overflow-hidden">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-4 fw-bold">Документация <span class="text-danger">ClearVC</span> <span class="fs-5 text-muted">v4.0.0-alpha</span></h1>
                <p class="lead text-muted mb-1">Ультралёгкий и быстрый PHP-микрофреймворк по архитектуре View-Controller (VC).</p>
                <p class="lead text-muted mb-1">Комбинированное защищённое ядро: контейнер <code class="text-danger">App</code>, Method Injection и XSS-очистка «из коробки».</p>
                <p class="text-muted small mb-0 mt-3">
                    ⚠️ Ветка <code>refactor/core-architecture</code> в активной разработке. Ветка <code>main</code> содержит стабильную 3.x.
                    Продакшен не рекомендуется до релиза 4.0.0-stable.
                </p>
                <p class="lead text-muted mb-0 mt-2">Авторы: Бакулев М., Кириенков М., Фатахова С., Наумов А., Рагазина Е.</p>
            </div>
        </div>
    </div>

    <div class="row g-5">
        <!-- Левое меню (Навигация) -->
        <div class="col-lg-4">
            <div class="position-sticky" style="top: 2rem;">
                <div class="p-4 mb-3 bg-light rounded shadow-sm border border-secondary border-opacity-10">
                    <h4 class="fw-bold mb-3">Навигация</h4>
                    <ol class="list-unstyled mb-0 gap-2 d-grid">
                        <li><a href="#roadmap" class="text-decoration-none text-secondary hover-danger">Roadmap v4.0.0</a></li>
                        <li><a href="#structure" class="text-decoration-none text-secondary hover-danger">Структура проекта</a></li>
                        <li><a href="#how-it-works" class="text-decoration-none text-secondary hover-danger">Описание работы</a></li>
                        <li><a href="#setup" class="text-decoration-none text-secondary hover-danger">Быстрый старт</a></li>
                        <li><a href="#api" class="text-decoration-none text-secondary hover-danger">API ядра</a></li>
                        <li><a href="#database" class="text-decoration-none text-secondary hover-danger">Работа с БД</a></li>
                        <li><a href="#views" class="text-decoration-none text-secondary hover-danger">Работа с представлениями</a></li>
                        <li><a href="#deploy" class="text-decoration-none text-secondary hover-danger">Развёртывание</a></li>
                        <li><a href="#license" class="text-decoration-none text-secondary hover-danger">Лицензия</a></li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Правая часть (Контент) -->
        <div class="col-lg-8">

            <!-- Roadmap -->
            <section id="roadmap" class="mb-5">
                <h3 class="pb-2 border-bottom fw-bold text-dark">Roadmap v4.0.0</h3>
                <div class="row g-3 mt-2">
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm bg-light">
                            <div class="card-body">
                                <h6 class="fw-bold text-primary">Ядро</h6>
                                <ul class="list-unstyled small mb-0">
                                    <li>✅ <code>Core\App</code></li>
                                    <li>✅ <code>Core\Request</code></li>
                                    <li>✅ <code>Core\Router</code></li>
                                    <li>✅ <code>Core\Controller</code></li>
                                    <li>✅ <code>Core\ErrorHandler</code></li>
                                    <li>⏳ <code>Core\Response</code></li>
                                    <li>⏳ <code>Core\Validator</code></li>
                                    <li>⏳ Middleware</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm bg-light">
                            <div class="card-body">
                                <h6 class="fw-bold text-danger">Безопасность</h6>
                                <ul class="list-unstyled small mb-0">
                                    <li>⏳ CSRF Protection</li>
                                    <li>⏳ Flash Messages</li>
                                </ul>
                                <p class="text-muted small mt-2 mb-0">До релиза 4.0.0-stable продакшен не рекомендуется.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm bg-light">
                            <div class="card-body">
                                <h6 class="fw-bold text-success">Инфраструктура</h6>
                                <ul class="list-unstyled small mb-0">
                                    <li>⏳ PHPUnit — smoke-тесты</li>
                                    <li>⏳ CI (GitHub Actions)</li>
                                    <li>🟡 Docker + nginx.conf — в тестовом режиме</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Структура проекта -->
            <section id="structure" class="mb-5">
                <h3 class="pb-2 border-bottom fw-bold text-dark">Структура ClearVC</h3>
                <div class="bg-light p-4 rounded border font-monospace text-secondary fs-7 shadow-sm">
                    <div class="mb-2"><span class="fw-bold">📁 config/</span> — конфигурация системы</div>
                    <div class="ps-3 text-muted">├── 📄 config.example.php — шаблон настроек</div>
                    <div class="ps-3 text-muted">├── 📄 config.php — <span class="text-danger">[игнорируется Git]</span> локальные настройки и debug</div>
                    <div class="ps-3 text-muted">├── 📄 PDO.php — модуль подключения к БД</div>
                    <div class="ps-3 text-muted mb-2">└── 📄 route.php — карта маршрутов</div>

                    <div class="mb-2"><span class="text-primary">📁 controllers/</span> — контроллеры (<span class="text-secondary">namespace App\Controllers</span>)</div>

                    <div class="mb-2"><span class="fw-bold">📁 core/</span> — защищённое ядро (<span class="text-secondary">namespace Core</span>)</div>
                    <div class="ps-3">├── <span class="text-danger">📁 Helpers/</span> — вспомогательные классы</div>
                    <div class="ps-5 text-muted">└── 📄 Avatar.php — управление аватарами</div>
                    <div class="ps-3 text-muted">├── 📄 App.php — контейнер зависимостей</div>
                    <div class="ps-3 text-muted">├── 📄 Controller.php — базовый контроллер</div>
                    <div class="ps-3 text-muted">├── 📄 ErrorHandler.php — перехватчик ошибок</div>
                    <div class="ps-3 text-muted">├── 📄 Request.php — XSS-очистка GET/POST</div>
                    <div class="ps-3 text-muted mb-2">└── 📄 Router.php — маршрутизатор с {id}</div>

                    <div class="mb-2"><span class="fw-bold">📁 public/</span> — <span class="text-danger">ЕДИНСТВЕННАЯ ПУБЛИЧНАЯ ПАПКА (ВЕБ-КОРЕНЬ)</span></div>
                    <div class="ps-3 text-muted">├── 📁 assets/ — статика (js, css, img, шрифты)</div>
                    <div class="ps-5 text-muted">└── 📄 .htaccess — блокировка PHP в статике</div>
                    <div class="ps-3 text-muted">├── 📄 .htaccess — ЧПУ на index.php (Apache)</div>
                    <div class="ps-3 text-muted mb-2">└── 📄 index.php — точка входа</div>

                    <div class="mb-2"><span class="text-success">📁 views/</span> — представления</div>
                    <div class="ps-3 text-muted">├── 📁 layouts/main.php — главный лейаут</div>
                    <div class="ps-3 text-muted">├── 📁 errors/ — шаблоны ошибок (error.php, http.php)</div>
                    <div class="ps-3 text-muted mb-2">└── 📄 *.php — контентные страницы</div>

                    <div class="mb-2">📁 <span class="text-secondary">docker/</span> — конфиги Docker-окружения</div>
                    <div class="ps-3 text-muted mb-2">└── 📄 nginx.conf — Nginx-конфиг для контейнера</div>

                    <div class="mb-2">📄 composer.json — зависимости и автозагрузка PSR-4</div>
                    <div class="mb-2">📄 docker-compose.yml — Docker-окружение <span class="text-warning">[TODO: тест]</span></div>
                    <div class="mb-2">📄 nginx.conf.example — эталонный конфиг Nginx</div>
                    <div class="mt-3 text-muted">📄 README.md — полная документация</div>
                </div>
            </section>

            <!-- Описание работы -->
            <section id="how-it-works" class="mb-5">
                <h3 class="pb-2 border-bottom fw-bold text-dark">Описание работы микрофреймворка</h3>
                <p>ClearVC использует концепцию <strong>изолированного веб-корня</strong>: сервер смотрит строго в <code>/public</code>, поэтому конфиги, ядро и контроллеры физически недоступны снаружи.</p>

                <h5 class="mt-4">Жизненный цикл запроса</h5>
                <ol class="text-muted">
                    <li><code>public/index.php</code> запускает сессии (<code>HttpOnly</code>, <code>SameSite=Lax</code>).</li>
                    <li>Создаётся <code>PDO</code> и регистрируется через <code>App::setDb($db)</code>.</li>
                    <li>Создаётся <code>Core\Request</code> — очистка <code>$_GET</code> и <code>$_POST</code> от XSS.</li>
                    <li><code>ErrorHandler::register($debug)</code> перехватывает все сбои.</li>
                    <li><code>Router::add(require config/route.php)</code> загружает маршруты.</li>
                    <li><code>Router::dispatch($request)</code> находит маршрут и вызывает экшен.</li>
                    <li><strong>Method Injection</strong>: <code>Request</code> — первым аргументом, <code>{id}</code> — следом.</li>
                    <li><code>$this-&gt;render('view', $data)</code> склеивает контент с лейаутом.</li>
                    <li>Любой сбой → <code>ErrorHandler</code> очищает буфер и рендерит ошибку.</li>
                </ol>

                <div class="row g-4 mt-2">
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm bg-light">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-primary">1. Контроллер</h5>
                                <p class="card-text text-muted small">Запросы к БД через <code>App::db()</code>, данные из <code>$request</code>, передача переменных в <code>render()</code>.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm bg-light">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-danger">2. Хелперы</h5>
                                <p class="card-text text-muted small">Готовые инструменты ядра (например, <code>Avatar::load()</code>) — вся рутина внутри.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm bg-light">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-success">3. View</h5>
                                <p class="card-text text-muted small">Чистая HTML-вёрстка. Движок сам подставит шапку, тайтл и подвал.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Быстрый старт -->
            <section id="setup" class="mb-5">
                <h3 class="pb-2 border-bottom fw-bold text-dark">Быстрый старт</h3>

                <h5 class="mt-4">Шаг 1. Установка</h5>
                <pre class="bg-dark text-light p-3 rounded font-monospace small">composer install</pre>
                <p class="text-muted">Composer сгенерирует автозагрузчик PSR-4 и скопирует <code>config.example.php</code> → <code>config.php</code>.</p>

                <h5 class="mt-4">Шаг 2. Создание контроллера</h5>
                <pre class="bg-dark text-light p-3 rounded font-monospace small">
&lt;?php
// Файл: controllers/AboutController.php

namespace App\Controllers;

use Core\Controller;
use Core\Request;
use Core\App;

class AboutController extends Controller
{
    public function about(Request $request): void
    {
        $db = App::db();
        $aboutData = null;

        // Безопасно читаем GET-параметр ?tab=history
        $activeTab = $request->query('tab', 'main');

        if ($db !== null) {
            $stmt = $db->prepare("SELECT * FROM site_info WHERE tab_name = ? LIMIT 1");
            $stmt->execute([$activeTab]);
            $aboutData = $stmt->fetch();
        }

        $this->render('about', [
            'title' => 'О компании',
            'info'  => $aboutData,
        ]);
    }
}</pre>

                <h5 class="mt-4">Шаг 3. Создание представления</h5>
                <pre class="bg-dark text-light p-3 rounded font-monospace small">
&lt;!-- Файл: views/about.php --&gt;
&lt;?php /** @var string $title */ ?&gt;
&lt;?php /** @var array|false $info */ ?&gt;

&lt;div class="container my-5"&gt;
    &lt;h1 class="fw-bold"&gt;&lt;?= htmlspecialchars($title) ?&gt;&lt;/h1&gt;

    &lt;div class="card shadow-sm mt-4"&gt;
        &lt;div class="card-body"&gt;
            &lt;p class="lead"&gt;
                &lt;?= htmlspecialchars($info['description'] ?? 'Контент временно недоступен.') ?&gt;
            &lt;/p&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</pre>

                <h5 class="mt-4">Шаг 4. Настройка лейаута</h5>
                <p class="text-muted">В <code>views/layouts/main.php</code> пропишите общий каркас сайта. Ядро подставит контент страницы в <code>$content</code>, заголовок в <code>$title</code>. <strong>Не удаляйте эти системные переменные!</strong></p>

                <h5 class="mt-4">Шаг 5. Регистрация маршрута</h5>
                <pre class="bg-dark text-light p-3 rounded font-monospace small">
return [
    // ['URL-адрес', 'КлассController@метод', 'HTTP-метод']
    ['/',              'HomeController@index',   'GET'],
    ['/about',         'AboutController@about',  'GET'],
    ['/post/{id}',     'PostController@show',    'GET'],  // show($request, $id)
    ['/avatar/upload', 'AvatarController@index', 'POST'],
];</pre>
                <span class="text-muted small d-block">При наличии <code>{id}</code> объект <code>$request</code> приходит первым аргументом, а параметр — вторым.</span>
            </section>

            <!-- API ядра -->
            <section id="api" class="mb-5">
                <h3 class="pb-2 border-bottom fw-bold text-dark">API ядра</h3>

                <!-- App -->
                <h5 class="mt-4 text-primary">Core\App — глобальный контейнер</h5>
                <p class="text-muted small">Service Locator / Registry. Хранит и отдаёт глобальные системные объекты (PDO).</p>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered align-middle small">
                        <thead class="table-light">
                            <tr><th>Метод</th><th>Принимает</th><th>Возвращает</th><th>Описание</th></tr>
                        </thead>
                        <tbody>
                            <tr><td><code>setDb()</code></td><td><code>PDO $db</code></td><td><code>void</code></td><td>Регистрирует подключение к БД.</td></tr>
                            <tr><td><code>db()</code></td><td>—</td><td><code>PDO</code></td><td>Возвращает активное подключение. <code>RuntimeException</code>, если не инициализировано.</td></tr>
                        </tbody>
                    </table>
                </div>
                <pre class="bg-dark text-light p-3 rounded font-monospace small">
$stmt = App::db()-&gt;prepare("SELECT * FROM users WHERE id = ?");
$stmt-&gt;execute([$userId]);
$user = $stmt-&gt;fetch(PDO::FETCH_ASSOC);</pre>

                <!-- Request -->
                <h5 class="mt-4 text-primary">Core\Request — обработка HTTP-запроса</h5>
                <p class="text-muted small">Автоматически внедряется первым аргументом в экшен контроллера. Заменяет сырые <code>$_GET</code>, <code>$_POST</code>, <code>$_SERVER</code>.</p>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered align-middle small">
                        <thead class="table-light">
                            <tr><th>Метод</th><th>Принимает</th><th>Возвращает</th><th>Пример</th></tr>
                        </thead>
                        <tbody>
                            <tr><td><code>query()</code></td><td><code>string $key</code>, <code>mixed $default = null</code></td><td><code>mixed</code></td><td><code>$request-&gt;query('page', 1)</code></td></tr>
                            <tr><td><code>input()</code></td><td><code>string $key</code>, <code>mixed $default = null</code></td><td><code>mixed</code></td><td><code>$request-&gt;input('password')</code></td></tr>
                            <tr><td><code>getUri()</code></td><td>—</td><td><code>string</code></td><td><code>/profile</code></td></tr>
                            <tr><td><code>getMethod()</code></td><td>—</td><td><code>string</code></td><td><code>POST</code></td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="alert alert-info small">
                    ℹ️ <code>Request</code> очищает данные от нулевых байтов и обрезает пробелы, но <strong>не делает HTML-экранирование</strong>. При выводе во View используйте <code>htmlspecialchars()</code>.
                </div>

                <!-- Router -->
                <h5 class="mt-4 text-primary">Core\Router — маршрутизатор</h5>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered align-middle small">
                        <thead class="table-light">
                            <tr><th>Метод</th><th>Принимает</th><th>Возвращает</th><th>Исключения</th></tr>
                        </thead>
                        <tbody>
                            <tr><td><code>add()</code></td><td><code>array $routesList</code></td><td><code>void</code></td><td><code>InvalidArgumentException</code>, <code>Exception</code> (500)</td></tr>
                            <tr><td><code>dispatch()</code></td><td><code>Request $request</code></td><td><code>void</code></td><td><code>Exception</code> (404, 500)</td></tr>
                        </tbody>
                    </table>
                </div>
                <ul class="text-muted small">
                    <li>Поддерживает динамические сегменты <code>{name}</code> (регулярка <code>([^/]+)</code>).</li>
                    <li>Нормализует слэши: <code>/about/</code> → <code>/about</code>.</li>
                    <li>Проверяет существование класса контроллера при регистрации.</li>
                </ul>

                <!-- Controller -->
                <h5 class="mt-4 text-primary">Core\Controller — базовый контроллер</h5>
                <ul class="text-muted">
                    <li>Константа <code>VERSION = 'v4.0.0-alpha'</code>.</li>
                    <li><code>render(string $view, array $data = [])</code> — собирает страницу-«матрешку» через <code>ob_start()</code>, <code>extract()</code> и подключает <code>views/layouts/main.php</code>.</li>
                </ul>

                <!-- ErrorHandler -->
                <h5 class="mt-4 text-primary">Core\ErrorHandler — обработчик ошибок</h5>
                <ul class="text-muted">
                    <li><code>register(bool $debug = false)</code> — регистрирует обработчики Exception, Warning, Fatal.</li>
                    <li><code>handleException(\Throwable)</code> — рендер исключения.</li>
                    <li><code>handleError(int, string, string, int)</code> — Warning → <code>ErrorException</code>.</li>
                    <li><code>handleFatalError()</code> — ловит <code>E_ERROR</code>, <code>E_PARSE</code>, <code>E_CORE_ERROR</code>, <code>E_COMPILE_ERROR</code>.</li>
                </ul>
                <p class="text-muted small">Коды <code>400, 401, 403, 404, 405</code> берутся из <code>getCode()</code>. <code>InvalidArgumentException</code> и <code>TypeError</code> → <code>400</code>. Остальные → <code>500</code>. При <code>$debug = true</code> — trace, при <code>false</code> — <code>views/errors/http.php</code>.</p>

                <!-- Avatar -->
                <h5 class="mt-4 text-primary">Core\Helpers\Avatar — управление аватарами</h5>
                <p class="text-muted small">
                    Статический хелпер для безопасной загрузки, отдачи и удаления аватаров.
                    Работает с <code>$_SESSION['user']</code> и таблицей <code>avatar</code>.
                    Методы <strong>не принимают аргументов</strong> — PDO берут через <code>App::db()</code>.
                </p>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered align-middle small">
                        <thead class="table-light">
                            <tr><th>Метод</th><th>Принимает</th><th>Возвращает</th><th>Описание</th></tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>load()</code></td>
                                <td>—</td>
                                <td><code>string</code></td>
                                <td>Обрабатывает POST-загрузку. На POST делает <code>redirect+exit</code>; на GET возвращает текст прошлой ошибки.</td>
                            </tr>
                            <tr>
                                <td><code>unload()</code></td>
                                <td>—</td>
                                <td><code>string</code></td>
                                <td>Веб-путь к аватарке с cache-busting <code>?v=filemtime</code>. Fallback — <code>default.svg</code>.</td>
                            </tr>
                            <tr>
                                <td><code>delete()</code></td>
                                <td>—</td>
                                <td><code>void</code></td>
                                <td>Удаляет файл с диска и запись из БД. Безопасен для повторного вызова.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <ul class="text-muted small">
                    <li>Белые списки: расширения <code>jpg</code>, <code>jpeg</code>, <code>png</code>; MIME <code>image/jpeg</code>, <code>image/png</code>.</li>
                    <li>Папка: <code>public/assets/img/avatar/</code>. Имя: <code>{login}.{ext}</code>.</li>
                    <li>Двойная валидация: расширение + <code>finfo</code> (защита от маскировки PHP-скриптов).</li>
                </ul>
                <pre class="bg-dark text-light p-3 rounded font-monospace small">
use Core\Helpers\Avatar;

// Загрузка (обрабатывает POST, redirect+exit)
$error = Avatar::load();

// URL для &lt;img&gt;
$avatarUrl = Avatar::unload();

// Удаление
Avatar::delete();</pre>
                <pre class="bg-dark text-light p-3 rounded font-monospace small">
CREATE TABLE `avatar` (
    `id`      INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT UNSIGNED NOT NULL,
    `name`    VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uniq_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;</pre>
                <div class="alert alert-warning small">
                    <strong>⚠️ Ограничения текущей версии:</strong>
                    <ul class="mb-0 mt-2">
                        <li>Нет лимита размера файла — настройте <code>client_max_body_size</code> (Nginx) и <code>upload_max_filesize</code> (PHP).</li>
                        <li>Нет ресайза/сжатия — файл сохраняется «как есть».</li>
                        <li>Нет проверки <code>getimagesize()</code> на реальные размеры и «бомбу декомпрессии».</li>
                        <li>Имя поля формы жёстко зашито — только <code>avatar</code>.</li>
                    </ul>
                </div>
            </section>

            <!-- Работа с БД -->
            <section id="database" class="mb-5">
                <h3 class="pb-2 border-bottom fw-bold text-dark">Работа с базой данных</h3>
                <p>Все запросы выполняются через <code>App::db()</code>. <strong>Всегда</strong> используйте подготовленные запросы.</p>

                <h5 class="mt-4">SELECT</h5>
                <pre class="bg-dark text-light p-3 rounded font-monospace small">
$stmt = App::db()-&gt;prepare("SELECT * FROM users WHERE id = ?");
$stmt-&gt;execute([$userId]);
$user = $stmt-&gt;fetch(PDO::FETCH_ASSOC);

if (!$user) {
    throw new \Exception('Пользователь не найден', 404);
}</pre>

                <h5 class="mt-4">INSERT</h5>
                <pre class="bg-dark text-light p-3 rounded font-monospace small">
$stmt = App::db()-&gt;prepare("INSERT INTO users (name, email) VALUES (?, ?)");
$stmt-&gt;execute([$name, $email]);
$newId = App::db()-&gt;lastInsertId();</pre>

                <h5 class="mt-4">UPDATE / DELETE</h5>
                <pre class="bg-dark text-light p-3 rounded font-monospace small">
$stmt = App::db()-&gt;prepare("UPDATE users SET name = ? WHERE id = ?");
$stmt-&gt;execute([$newName, $userId]);
$affected = $stmt-&gt;rowCount();

$stmt = App::db()-&gt;prepare("DELETE FROM posts WHERE id = ?");
$stmt-&gt;execute([$postId]);</pre>

                <h5 class="mt-4">Транзакции</h5>
                <pre class="bg-dark text-light p-3 rounded font-monospace small">
$db = App::db();
$db-&gt;beginTransaction();
try {
    $db-&gt;prepare("UPDATE accounts SET balance = balance - ? WHERE id = ?")-&gt;execute([100, $from]);
    $db-&gt;prepare("UPDATE accounts SET balance = balance + ? WHERE id = ?")-&gt;execute([100, $to]);
    $db-&gt;commit();
} catch (\Throwable $e) {
    $db-&gt;rollBack();
    throw $e;
}</pre>

                <div class="alert alert-danger small mt-3">
                    ❌ <strong>Никогда не делайте так:</strong>
                    <pre class="mb-0 mt-2 bg-dark text-light p-2 rounded font-monospace small">$db-&gt;query("SELECT * FROM users WHERE email = '$email'"); // SQL-инъекция!</pre>
                </div>
            </section>

            <!-- Работа с представлениями -->
            <section id="views" class="mb-5">
                <h3 class="pb-2 border-bottom fw-bold text-dark">Работа с представлениями</h3>
                <p>Система рендеринга разделена на общий лейаут и контентную часть.</p>

                <h5 class="mt-4">Структура</h5>
                <ul class="text-muted">
                    <li><code>views/layouts/main.php</code> — общий каркас сайта.</li>
                    <li><code>views/{page}.php</code> — контентная часть.</li>
                    <li><code>views/errors/error.php</code> — debug-экран (при <code>$debug = true</code>).</li>
                    <li><code>views/errors/http.php</code> — безопасная заглушка (при <code>$debug = false</code>).</li>
                </ul>

                <h5 class="mt-4">Пример лейаута</h5>
                <pre class="bg-dark text-light p-3 rounded font-monospace small">
&lt;!DOCTYPE html&gt;
&lt;html lang="ru"&gt;
&lt;head&gt;
    &lt;meta charset="UTF-8"&gt;
    &lt;title&gt;&lt;?= htmlspecialchars($title ?? 'ClearVC') ?&gt;&lt;/title&gt;
    &lt;link rel="stylesheet" href="/assets/css/style.css"&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;header&gt;...&lt;/header&gt;
    &lt;main&gt;&lt;?= $content ?&gt;&lt;/main&gt;
    &lt;footer&gt;© ClearVC&lt;/footer&gt;
&lt;/body&gt;
&lt;/html&gt;</pre>

                <h5 class="mt-4">Защита от XSS при выводе</h5>
                <pre class="bg-dark text-light p-3 rounded font-monospace small">
&lt;?= htmlspecialchars($variable) ?&gt;
&lt;?= htmlspecialchars($variable, ENT_QUOTES, 'UTF-8') ?&gt;

&lt;a href="/user/&lt;?= urlencode($userId) ?&gt;"&gt;Профиль&lt;/a&gt;</pre>
            </section>

            <!-- Развёртывание -->
            <section id="deploy" class="mb-5">
                <h3 class="pb-2 border-bottom fw-bold text-dark">Развёртывание</h3>

                <h5 class="mt-4">Apache</h5>
                <p class="text-muted">Document Root → <code>/public</code>. <code>mod_rewrite</code> включён. <code>.htaccess</code> уже настроен.</p>

                <h5 class="mt-4">Nginx</h5>
                <pre class="bg-dark text-light p-3 rounded font-monospace small">
server {
    listen 80;
    server_name clearvc.test www.clearvc.test;
    root /var/www/ClearVC/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.4-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}</pre>

                <h5 class="mt-4">Docker</h5>
                <pre class="bg-dark text-light p-3 rounded font-monospace small">docker-compose up -d</pre>
                <ul class="text-muted small">
                    <li><strong>web</strong> — Nginx на <code>localhost:8080</code>.</li>
                    <li><strong>app</strong> — PHP 8.4 FPM.</li>
                    <li><strong>db</strong> — MySQL 8.0 на <code>localhost:3306</code>.</li>
                </ul>

                <div class="alert alert-warning small">
                    ⚠️ <code>docker-compose.yml</code> помечен <code>TODO: По тестить</code>. Перед продакшеном проверьте права на запись в <code>public/assets/img/avatar/</code>.
                </div>

                <h5 class="mt-4">Продакшен-чеклист</h5>
                <ul class="text-muted small">
                    <li>Установить <code>'debug' =&gt; false</code> в <code>config/config.php</code>.</li>
                    <li>Настроить HTTPS (Let's Encrypt).</li>
                    <li>Права на запись только для <code>public/assets/</code>.</li>
                    <li>Убедиться, что <code>config/config.php</code> в <code>.gitignore</code>.</li>
                    <li>Включить OPcache в PHP.</li>
                    <li>Логировать ошибки в файл, а не в вывод.</li>
                    <li>Дождаться релиза 4.0.0-stable (CSRF, Flash Messages).</li>
                </ul>
            </section>

            <!-- Лицензия -->
            <section id="license" class="mb-5">
                <h3 class="pb-2 border-bottom fw-bold text-dark">Лицензия</h3>
                <p>ClearVC распространяется под лицензией <strong>MIT</strong>. Код можно свободно использовать в личных и коммерческих проектах, включая закрытые. Единственное требование — сохранить уведомление об авторских правах.</p>
                <p class="text-muted small">MIT выбран как стандарт PHP-экосистемы (Laravel, Symfony, Composer-пакеты) — обеспечивает максимальное распространение и совместимость.</p>
            </section>

        </div>
    </div>
</div>

<style>
    .hover-danger:hover {
        color: #dc3545 !important;
        transition: color 0.15s ease-in-out;
        padding-left: 4px;
    }

    .hover-danger {
        transition: all 0.15s ease-in-out;
    }

    .fs-7 {
        font-size: 0.875rem;
    }
</style>
