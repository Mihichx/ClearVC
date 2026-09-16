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
                <h1 class="display-4 fw-bold">Документация <span class="text-danger">ClearVC</span></h1>
                <p class="lead text-muted mb-0">Ультра-легкий и быстрый PHP-микрофреймворк по архитектуре View-Controller (VC).</p>
                <p class="lead text-muted mb-0">Авторы: Бакулев М, Кириенков М, Фатахова С, Наумов А, Рагазина Е.</p>
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
                        <li><a href="#structure" class="text-decoration-none text-secondary hover-danger">Структура проекта</a></li>
                        <li><a href="#how-it-works" class="text-decoration-none text-secondary hover-danger">Описание работы</a></li>
                        <li><a href="#setup" class="text-decoration-none text-secondary hover-danger">Алгоритм настройки</a></li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Правая часть (Контент) -->
        <div class="col-lg-8">
            <!-- Структура проекта -->
            <section id="structure" class="mb-5">
                <h3 class="pb-2 border-bottom fw-bold text-dark">Структура ClearVC</h3>
                <div class="bg-light p-4 rounded border font-monospace text-secondary fs-7 shadow-sm">
                    <div class="mb-2"><span class="fw-bold">📁 assets/</span> — статические файлы приложения (js, css, картинки, шрифты)</div>
                    <div class="ps-3 text-muted mb-2">└── 📁 js / css / img / fontAwesome / bootstrap</div>

                    <div class="mb-2"><span class="fw-bold">📁 config/</span> — конфигурация системы</div>
                    <div class="ps-3 text-muted">├── 📄 config.example.php — шаблон настроек окружения и доступов к БД</div>
                    <div class="ps-3 text-muted">├── 📄 config.php — <span class="text-danger">[игнорируется Git]</span> локальные настройки окружения и режима debug</div>
                    <div class="ps-3 text-muted">├── 📄 PDO.php — модуль безопасного подключения к БД через PDO</div>
                    <div class="ps-3 text-muted mb-2">└── 📄 route.php — строгая карта маршрутов API и страниц сайта</div>

                    <div class="mb-2"><span class="text-primary">📁 controllers/</span> — контроллеры сайта (<span class="text-secondary">namespace App\Controllers</span>)</div>

                    <div class="mb-2"><span class="fw-bold">📁 core/</span> — служебное ядро фреймворка (<span class="text-secondary">namespace Core</span>)</div>
                    <div class="ps-3">├── <span class="text-danger">📁 Helpers/</span> — вспомогательные функции фреймворка (<span class="text-secondary">namespace Core\Helpers</span>)</div>
                    <div class="ps-5 text-muted">└── 📄 Image.php — загрузка, выгрузка и удаление аватара</div>
                    <div class="ps-3 text-muted">├── 📄 Controller.php — базовый контроллер ядра</div>
                    <div class="ps-3 text-muted">├── 📄 ErrorHandler.php — единый перехватчик исключений и ошибок ядра</div>
                    <div class="ps-3 text-muted mb-2">└── 📄 Router.php — системный маршрутизатор со строгой REST-валидацией</div>

                    <div class="mb-2"><span class="text-success">📁 views/</span> — представления (HTML-вёрстка и отображение данных)</div>
                    <div class="ps-3 text-muted">└── 📁 layouts/main.php — основной макет (Head, Header, Footer)</div>
                    <div class="ps-3 text-muted mb-2">└── 📁 errors/ — шаблоны системных ошибок (composer_error, config_error, error, http)</div>

                    <div class="mb-2"><span class="fw-bold">📁 vendor/</span> — автозагрузчик и сторонние зависимости Composer</div>

                    <div class="mb-2">📄 .gitignore — список игнорируемых файлов (<code>/vendor/</code> и <code>config.php</code> скрыты)</div>
                    <div class="mb-2">📄 .htaccess — перенаправление всех запросов на единую точку входа</div>
                    <div class="mb-2">📄 composer.json / composer.lock — зависимости и правила автозагрузки PSR-4</div>
                    <div class="mb-2">📄 index.php — главный инициализационный файл (точка входа)</div>
                    <div class="mt-3 text-muted">📄 README.md — документация проекта</div>
                </div>
            </section>

            <!-- Описание работы -->
            <section id="how-it-works" class="mb-5">
                <h3 class="pb-2 border-bottom fw-bold text-dark">Описание работы микрофреймворка</h3>
                <p>ClearVC работает по принципу единой точки входа (<code>index.php</code>), куда <code>.htaccess</code> направляет все входящие URL-адреса. Фреймворк разделяет логику (работу с БД) и отображение (HTML) по классическому паттерну VC.</p>
                <div class="row g-4 mt-2">
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm bg-light">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-primary">1. Создаёшь контроллер</h5>
                                <p class="card-text text-muted small">В нём пишешь запросы к базе данных, обрабатываешь логику, используешь готовые утилиты ядра и отдаёшь переменные через <code>render</code> виду.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm bg-light">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-danger">2. Используешь хелперы</h5>
                                <p class="card-text text-muted small">Вызываешь глобальные инструменты ядра (например, <code>Image::load()</code>) в одну строчку кода, полностью избавляясь от рутины.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm bg-light">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-success">3. Создаёшь вид (view)</h5>
                                <p class="card-text text-muted small">Чистая HTML-вёрстка или циклы для вывода данных. Движок сам подставит шапку, тайтл и подвал из <code>layouts/main.php</code>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Алгоритм настройки -->
            <section id="setup" class="mb-5">
                <h3 class="pb-2 border-bottom fw-bold text-dark">Алгоритм настройки</h3>
                <div class="timeline">

                    <div class="mb-4">
                        <h5>1. Инициализация и База данных</h5>
                        <p class="text-muted">Откройте консоль в корне проекта и выполните команду <code>composer install</code> для сборки автозагрузчика классов PSR-4. Если проекту нужна база данных — скопируйте <code>config/config.example.php</code> в <code>config/config.php</code> и заполните массив <code>db</code> данными от MySQL.</p>
                    </div>

                    <div class="mb-4">
                        <h5>2. Создание файла логики (Controller)</h5>
                        <p class="text-muted">Создайте класс в папке <code>controllers/</code>. Благодаря Composer ручные подключения через <code>require_once</code> больше не нужны, обязательно указывайте пространство имён:</p>
                        <pre class="bg-dark text-light p-3 rounded font-monospace small">
&lt;?php
// Файл: controllers/AboutController.php

namespace App\Controllers; // Указываем пространство имен папки controllers

use Core\Controller;       // Импортируем базовый класс из ядра

class AboutController extends Controller
{
    public function about()
    {
        $aboutData = null;

        // Безопасная проверка: подключена ли БД в проекте
        if ($this->db !== null) {
            $stmt = $this->db->query("SELECT * FROM site_info LIMIT 1");
            $aboutData = $stmt->fetch();
        }

        // Передаем данные в рендер страницы views/about.php
        $this->render('about', [
            'title' => 'О компании',
            'js'    => 'slider.js, script.js', // через запятую с пробелом (если есть js)
            'info'  => $aboutData
        ]);
    }
}</pre>
                    </div>

                    <div class="mb-4">
                        <h5>3. Создание представления (View)</h5>
                        <p class="text-muted">В папке <code>views/</code> создайте файл отображения для вашей страницы (например, <code>about.php</code>). Используйте переменные, переданные из контроллера. Для защиты от XSS-атак всегда фильтруйте динамический вывод:</p>
                        <pre class="bg-dark text-light p-3 rounded font-monospace small">
&lt;!-- Файл: views/about.php --&gt;
&lt;div class="container my-5"&gt;
    &lt;h1 class="fw-bold"&gt;&lt;?= $title ?&gt;&lt;/h1&gt;

    &lt;div class="card shadow-sm mt-4"&gt;
        &lt;div class="card-body"&gt;
            &lt;p class="lead"&gt;
                &lt;?= htmlspecialchars($info['description'] ?? 'Контент временно недоступен.') ?&gt;
            &lt;/p&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</pre>
                        <span class="text-muted small mt-1 d-block">
                            💡 <strong>Важно:</strong> Микрофреймворк автоматически обернёт этот код в ваш главный макет <code>layouts/main.php</code>, подставив шапку, подвал и заголовок.
                        </span>
                    </div>

                    <div class="mb-4">
                        <h5>4. Настройка главного макета</h5>
                        <p class="text-muted">В <code>views/layouts/main.php</code> пропишите общий каркас сайта (Header, Footer, навигацию). Фреймворк сам подставит контент страницы в переменную <code>$content</code>, заголовок в <code>$title</code>, а скрипты страницы подключит через массив <code>$js</code>. <strong>Не удаляйте эти системные переменные из макета!</strong></p>
                    </div>

                    <div class="mb-4">
                        <h5>5. Регистрация маршрута (Route)</h5>
                        <p class="text-muted">Зарегистрируйте URL вашей страницы в файле <code>config/route.php</code> по следующему шаблону:</p>
                        <pre class="bg-dark text-light p-3 rounded font-monospace small">
return [
    // ['URL-адрес', 'КлассController@метод', 'HTTP-метод']
    ['/', 'HomeController@index', 'GET'],
    ['/about', 'AboutController@about', 'GET'],
    ['/contact/submit', 'ContactController@submit', 'POST'],
];</pre>
                        <span class="text-muted small mt-1 d-block">Где: 1 — URL-адрес, 2 — Класс@Метод, 3 — HTTP-метод запроса (GET или POST).</span>
                    </div>

                </div>
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
</style>
