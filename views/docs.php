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
                <p class="lead text-muted mb-0">Инструкция по настройке и использованию микрофреймворка.</p>
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
                    <div class="mb-2"><span class="text-warning">📁 assets/</span> — папка для js, css, картинок и шрифтов</div>
                    <div class="ps-3 text-muted">├── 📁 bootstrap / 📁 css / 📁 img / 📁 fontAwesome</div>
                    <div class="ps-3 text-muted mb-2">└── 📁 js/ — <span class="text-danger fw-bold">JS-файлы</span></div>
                    
                    <div class="mb-2"><span class="text-warning">📁 config/</span> — конфигурационные файлы</div>
                    <div class="ps-3 text-muted">├── 📄 PDO.php — файл подключения к БД</div>
                    <div class="ps-3 text-muted">├── 📄 config.example.php — шаблон конфига</div>
                    <div class="ps-3 text-muted">├── 📄 config.php — скрытые пароли от базы</div>
                    <div class="ps-3 text-muted mb-2">└── 📄 route.php — список явных путей сайта</div>
                    
                    <div class="mb-2"><span class="text-primary">📁 controllers/</span> — логика страниц (<span class="text-secondary">namespace App\Controllers</span>)</div>
                    
                    <div class="mb-2"><span class="text-danger">📁 core/</span> — служебное ядро фреймворка (<span class="text-secondary">namespace Core</span>)</div>
                    <div class="ps-3 text-muted">├── 📄 Controller.php — базовый класс</div>
                    <div class="ps-3 text-muted mb-2">└── 📄 Router.php — системный роутер фреймворка</div>
                    
                    <div class="mb-2"><span class="text-success">📁 views/</span> — визуальный вид страниц (HTML/вывод из БД)</div>
                    <div class="ps-3 text-muted mb-2">└── 📁 layouts/main.php — основной шаблон (Head, Header, Footer)</div>
                    
                    <div class="mb-2"><span class="text-dark fw-bold">📁 vendor/</span> — автозагрузчик и сторонние библиотеки Composer</div>
                    
                    <div class="mt-3 text-muted">📄 .htaccess / index.php / composer.json / composer.lock — служебные файлы</div>
                </div>
            </section>

            <!-- Описание работы -->
            <section id="how-it-works" class="mb-5">
                <h3 class="pb-2 border-bottom fw-bold text-dark">Описание работы микрофреймворка</h3>
                <p>Этот микрофреймворк разделяет логику (работу с БД) и отображение (HTML) по классической паттерну VC.</p>
                <div class="row g-4 mt-2">
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm bg-light">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-success">1. Создаёшь вид (view)</h5>
                                <p class="card-text text-muted small">Чистая HTML верстка или циклы для вывода данных. Движок сам подставит шапку, тайтл и подвал из <code>layouts/main.php</code>.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm bg-light">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-primary">2. Создаёшь контроллер (controller)</h5>
                                <p class="card-text text-muted small">В нём пишешь запросы к базе данных, обрабатываешь логику и отдаешь переменные через <code>render</code> виду.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Алгоритм настройки -->
            <section id="setup" class="mb-5">
                <h3 class="pb-2 border-bottom fw-bold text-dark"> Алгоритм настройки</h3>
                <div class="timeline">
                    
                    <div class="mb-4">
                        <h5>1. Инициализация и База данных</h5>
                        <p class="text-muted">Откройте консоль в корне проекта и выполните команду <code>composer install</code> для сборки автозагрузчика классов PSR-4. Затем создайте файл <code>config/config.php</code> по образцу <code>config/config.example.php</code> для подключения к MySQL.</p>
                    </div>

                    <div class="mb-4">
                        <h5>2. Создание файла логики (Controller)</h5>
                        <p class="text-muted">Создайте класс в папке <code>controllers/</code>. Благодаря Composer ручные подключения файлов больше не нужны, обязательно указывайте пространство имен:</p>
                        <pre class="bg-dark text-light p-3 rounded font-monospace small">
&lt;?php

namespace App\Controllers; // Указываем пространство имен

use Core\Controller;       // Импортируем базовый контроллер ядра

class AboutController extends Controller
{
    public function about()
    {
        // База данных доступна через $this->db!
        $stmt = $this->db->query("SELECT * FROM info");
        $aboutData = $stmt->fetch();

        // Отправляем данные в рендер
        $this->render('about', [
            'title' => 'О проекте',
            'js'    => 'slider.js, script.js', // через запятую с пробелом (если есть js)
            'about' => $aboutData
        ]);
    }
}</pre>
                    </div>

                    <div class="mb-4">
                        <h5>3. Создание представления (View)</h5>
                        <p class="text-muted">В папке <code>views/</code> создайте файл отображения для вашей страницы (например, <code>about.php</code>). Используйте переменные, которые вы передали из контроллера:</p>
                        <pre class="bg-dark text-light p-3 rounded font-monospace small">
&lt;div class="container my-5"&gt;
    &lt;h1 class="fw-bold"&gt;&lt;?= $title ?&gt;&lt;/h1&gt;
    
    &lt;div class="card shadow-sm mt-4"&gt;
        &lt;div class="card-body"&gt;
            &lt;p class="lead"&gt;
                &lt;?= htmlspecialchars($about['description'] ?? 'Описание отсутствует') ?&gt;
            &lt;/p&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</pre>
                        <span class="text-muted small mt-1 d-block">
                            💡 **Важно:** Микрофреймворк автоматически обернет этот код в ваш главный шаблон <code>layouts/main.php</code>, подставив шапку, подвал и заголовок.
                        </span>
                    </div>

                    <div class="mb-4">
                        <h5>4. Настройка главного шаблона</h5>
                        <p class="text-muted">В <code>views/layouts/main.php</code> пропишите общие шапку и подвал. Не удаляйте системные переменные <code>$content</code>, <code>$title</code> и вывод скриптов.</p>
                    </div>

                    <div class="mb-4">
                        <h5>5. Регистрация маршрута</h5>
                        <p class="text-muted">Пропишите путь в <code>config/route.php</code> по шаблону:</p>
                        <code class="bg-light text-danger p-2 rounded d-block font-monospace">['/about', 'AboutController@about']</code>
                        <span class="text-muted small mt-1 d-block">Где: 1 — URL-адрес, 2 — Класс@Метод, 3 — HTTP-метод запроса (GET или POST). GET используется по умолчанию.</span>
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
