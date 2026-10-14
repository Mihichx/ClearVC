# ClearVC v4.0.0-alpha — полная документация

> ⚠️ **Статус:** ветка `refactor/core-architecture` в активной разработке.
> Ветка `main` содержит стабильную версию 3.x.
> Всё описанное ниже может меняться до релиза 4.0.0-stable.
> Использовать в продакшене **не рекомендуется** до появления CSRF-защиты и Flash Messages.

---

## Содержание

1. [Что такое ClearVC](#что-такое-clearvc)
2. [Roadmap v4.0.0](#roadmap-v400)
3. [Структура проекта](#структура-проекта)
4. [Архитектура и безопасность](#архитектура-и-безопасность)
5. [Жизненный цикл запроса](#жизненный-цикл-запроса)
6. [Установка](#установка)
7. [Быстрый старт](#быстрый-старт)
8. [API ядра — полный справочник](#api-ядра--полный-справочник)
   - [Core\App](#1-coreapp--глобальный-контейнер)
   - [Core\Request](#2-corerequest--обработка-http-запроса)
   - [Core\Router](#3-corerouter--маршрутизатор)
   - [Core\Controller](#4-corecontroller--базовый-контроллер)
   - [Core\ErrorHandler](#5-coreerrorhandler--обработчик-ошибок)
   - [Core\Helpers\Avatar](#6-corehelpersavatar--управление-аватарами)
9. [Работа с базой данных](#работа-с-базой-данных)
10. [Работа с представлениями](#работа-с-представлениями)
11. [Развёртывание](#развёртывание)
12. [Лицензия](#лицензия)

---

## Что такое ClearVC

**ClearVC** — ультралёгкий, быстрый и безопасный PHP-микрофреймворк, построенный по архитектурной схеме **View-Controller (VC)**. Он изолирует системную логику от HTML-вёрстки и даёт разработчику чистый каркас для быстрого развёртывания веб-приложений без привязки к жёстким моделям данных.

Ключевые особенности:

- **Контейнер зависимостей** `Core\App` — глобальный Service Locator для доступа к системным объектам (PDO).
- **Method Injection** — объект `Request` автоматически внедряется в экшены контроллеров.
- **XSS-очистка** входящих данных «из коробки» через `Core\Request`.
- **Layout-система** — буферизированный рендер с внедрением контента в общий лейаут.
- **Глобальный ErrorHandler** — перехват Exception, TypeError, Warning, Fatal Error.
- **Изолированный веб-корень** — сервер смотрит строго в `/public`.

## Законы ClearVC

1. **Безопасность без компромиссов.** XSS, CSRF, SQL-инъекции закрыты по умолчанию.
2. **Новичок разберётся за вечер.** Ядро — 5 файлов. Понятно без документации.
3. **Ноль зависимостей в ядре.** Только PHP и Composer.
4. **Скорость — это фича.** Бенчмарки в CI. Регрессия = блокер.
5. **Ошибки — для людей.** Debug-экран объясняет что, где и почему.
6. **Обратная совместимость.** Код на 4.0 работает на 4.9.
7. **Документация = код.** Нет документации — нет фичи.

---

## Roadmap v4.0.0

### Ядро

- [X] `Core\App` — контейнер зависимостей (Service Locator)
- [X] `Core\Request` — XSS-очистка, `query()`, `input()`, `getMethod()`, `getUri()`
- [X] `Core\Router` — маршрутизация с динамическими `{id}` и авто-внедрением `Request`
- [X] `Core\Controller` — базовый контроллер с Layout-системой
- [X] `Core\ErrorHandler` — глобальный перехват Exception / Error / Warning / Fatal
- [ ] `Core\Response` — единый ответ: HTML (`render`) + JSON (`json`)
- [ ] `Core\Validator` — валидация форм и файлов (правила, сообщения об ошибках)
- [ ] Middleware — хуки `before` / `after` для роутера

### Безопасность

- [ ] CSRF Protection — токен для POST/PUT/DELETE
- [ ] Flash Messages — одноразовые уведомления в сессии

### Инфраструктура

- [ ] PHPUnit — smoke-тесты на Router, Request, Validator
- [ ] CI (GitHub Actions) — lint + tests + PHPStan
- [X] Docker + nginx.conf — воспроизводимое окружение (в тестовом режиме)

---

## Структура проекта

```text
project/
├── 📁 config/                  — Конфигурация системы
│   ├── 📄 config.example.php   — Шаблон настроек окружения и доступов к БД
│   ├── 📄 config.php           — [Игнорируется Git] Локальные настройки и режим debug
│   ├── 📄 PDO.php              — Модуль безопасного подключения к БД через PDO
│   └── 📄 route.php            — Карта маршрутов со встроенной REST-валидацией
│
├── 📁 controllers/             — Контроллеры сайта (App\Controllers)
│
├── 📁 core/                    — Защищённое ядро фреймворка (Core)
│   ├── 📁 Helpers/             — Вспомогательные классы (Core\Helpers)
│   │   └── 📄 Avatar.php       — Загрузка, валидация MIME-типов и удаление аватаров
│   ├── 📄 App.php              — Глобальный контейнер зависимостей (Service Locator)
│   ├── 📄 Controller.php       — Базовый контроллер с Layout-системой
│   ├── 📄 ErrorHandler.php     — Глобальный перехватчик исключений и отладчик
│   ├── 📄 Request.php          — Компонент дезинфекции XSS (GET/POST)
│   └── 📄 Router.php           — Маршрутизатор с динамическими {id}
│
├── 📁 public/                  — ЕДИНСТВЕННАЯ ПУБЛИЧНАЯ ПАПКА (ВЕБ-КОРЕНЬ)
│   ├── 📁 assets/              — Изолированная статика (js, css, картинки, шрифты)
│   │   ├── 📁 css/
│   │   ├── 📁 js/
│   │   └── 📁 img/avatar/      — Папка для загруженных аватаров
│   ├── 📄 .htaccess            — Перенаправление ЧПУ на index.php для Apache
│   └── 📄 index.php            — Точка входа, инициализация сессий и запуск ядра
│
├── 📁 views/                   — Представления (HTML-вёрстка)
│   ├── 📁 errors/              — Шаблоны системных HTTP-ошибок
│   │   ├── 📄 error.php        — Debug-экран разработчика (trace, файл, строка)
│   │   └── 📄 http.php         — Безопасная заглушка для production (404/500)
│   ├── 📁 layouts/             — Общие оболочки страниц
│   │   └── 📄 main.php         — Главный базовый лейаут
│   └── 📄 *.php                — Контентные части страниц
│
├── 📁 docker/                  — Конфиги Docker-окружения
│   └── 📄 nginx.conf           — Nginx-конфиг для контейнера
│
├── 📄 composer.json            — Зависимости и правила автозагрузки PSR-4
├── 📄 docker-compose.yml       — Docker-окружение (Nginx, PHP 8.4, MySQL)
├── 📄 nginx.conf.example       — Эталонный конфиг для Nginx
└── 📄 README.md                — Документация проекта
```

---

## Архитектура и безопасность

### Изолированный веб-корень

ClearVC использует концепцию **изолированного веб-корня**. Веб-сервер (Apache, Nginx, Docker) настраивается так, чтобы его `Document Root` смотрел строго в папку `/public`. Всё остальное — конфиги с паролями, ядро, контроллеры, представления — физически недоступно из интернета.

### Что даёт такая изоляция

- **Невозможность чтения конфигов** — `config/config.php` с паролями БД недосягаем.
- **Невозможность исполнения ядра** — `core/*.php` не запустится через URL.
- **Невозможность чтения представлений** — `views/*.php` не отдаётся как текст.
- **Блокировка PHP в статике** — `.htaccess` и Nginx запрещают запуск PHP-файлов в `/assets/`.

### Заголовки безопасности (Nginx)

```nginx
add_header X-Frame-Options "DENY" always;
add_header X-Content-Type-Options "nosniff" always;
add_header X-XSS-Protection "1; mode=block" always;
add_header Content-Security-Policy "default-src 'self' https:; ..." always;
```

---

## Жизненный цикл запроса

1. **`public/index.php`** — точка входа. Запускает сессии (`HttpOnly`, `SameSite=Lax`).
2. **Инициализация БД** — создаётся `PDO`, регистрируется через `App::setDb($db)`.
3. **Создание `Request`** — объект автоматически очищает `$_GET` и `$_POST` от XSS.
4. **Регистрация `ErrorHandler`** — `ErrorHandler::register($debug)`.
5. **Загрузка маршрутов** — `Router::add(require config/route.php)`.
6. **Диспетчеризация** — `Router::dispatch($request)` находит маршрут и вызывает экшен.
7. **Method Injection** — `Request` передаётся первым аргументом, динамические `{id}` — следом.
8. **Рендер** — контроллер вызывает `$this->render('view', $data)`, ядро склеивает контент с лейаутом.
9. **Любой сбой** — перехватывается `ErrorHandler`, буфер очищается, рендерится страница ошибки.

---

## Установка

### Шаг 1. Клонирование и установка зависимостей

```bash
git clone <repository-url> clearvc
cd clearvc
composer install
```

Composer автоматически:
- Сгенерирует автозагрузчик PSR-4 (`Core\` → `core/`, `App\Controllers\` → `controllers/`).
- Скопирует `config/config.example.php` → `config/config.php` (через post-install-cmd).

### Шаг 2. Настройка БД

Откройте `config/config.php` и заполните параметры подключения:

```php
return [
    'db' => [
        'host'     => '127.0.0.1',
        'port'     => 3306,
        'database' => 'clearvc_db',
        'username' => 'clearvc_user',
        'password' => 'user_password',
        'charset'  => 'utf8mb4',
    ],
    'debug' => true, // false в продакшене
];
```

### Шаг 3. Настройка веб-сервера

**Apache:** укажите `Document Root` как `/path/to/project/public`. Файл `.htaccess` в папке `public/` уже настроит ЧПУ.

**Nginx:** используйте `nginx.conf.example`, заменив `root` на путь к `/public`.

**Docker:** см. раздел [Развёртывание](#развёртывание).

---

## Быстрый старт

### 1. Создание контроллера

Создайте `controllers/HomeController.php`:

```php
<?php

namespace App\Controllers;

use Core\Controller;
use Core\Request;
use Core\App;

class HomeController extends Controller
{
    public function index(Request $request): void
    {
        $this->render('home', [
            'title' => 'Главная страница',
            'name'  => $request->query('name', 'Гость'),
        ]);
    }
}
```

### 2. Создание представления

Создайте `views/home.php`:

```html
<?php /** @var string $title */ ?>
<?php /** @var string $name */ ?>

<div class="container my-5">
    <h1><?= htmlspecialchars($title) ?></h1>
    <p>Привет, <strong><?= htmlspecialchars($name) ?></strong>!</p>
</div>
```

### 3. Регистрация маршрута

В `config/route.php`:

```php
return [
    ['/', 'HomeController@index', 'GET'],
];
```

Готово. Откройте сайт в браузере.

---

## API ядра — полный справочник

### 1. `Core\App` — глобальный контейнер

**Назначение:** Service Locator / Registry. Хранит и отдаёт глобальные системные объекты (в текущей версии — только `PDO`).

**Namespace:** `Core\App`
**Файл:** `core/App.php`

#### Свойства

| Свойство | Тип | Описание |
| :--- | :--- | :--- |
| `private static ?PDO $db` | `PDO\|null` | Глобальное подключение к базе данных. Инициализируется один раз. |

#### Методы

##### `App::setDb(PDO $db): void`

Регистрирует активное подключение к БД в контейнере. Вызывается один раз в `public/index.php`.

**Параметры:**
- `$db` (`PDO`) — сконфигурированный объект подключения.

**Возвращает:** `void`.

**Исключения:** нет.

**Пример:**

```php
use Core\App;

$pdo = new PDO('mysql:host=localhost;dbname=test', 'user', 'pass');
App::setDb($pdo);
```

---

##### `App::db(): PDO`

Возвращает активное подключение к БД. Перед отдачей проверяет, было ли соединение инициализировано.

**Параметры:** нет.

**Возвращает:** `PDO` — активный объект подключения.

**Исключения:**
- `\RuntimeException` — если метод вызван до `App::setDb()`.

**Пример:**

```php
use Core\App;

// Простой SELECT
$stmt = App::db()->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// INSERT с получением ID
$stmt = App::db()->prepare("INSERT INTO posts (title, body) VALUES (?, ?)");
$stmt->execute([$title, $body]);
$newId = App::db()->lastInsertId();

// Транзакция
$db = App::db();
$db->beginTransaction();
try {
    $db->prepare("UPDATE accounts SET balance = balance - ? WHERE id = ?")->execute([100, $from]);
    $db->prepare("UPDATE accounts SET balance = balance + ? WHERE id = ?")->execute([100, $to]);
    $db->commit();
} catch (\Throwable $e) {
    $db->rollBack();
    throw $e;
}
```

---

### 2. `Core\Request` — обработка HTTP-запроса

**Назначение:** Инкапсуляция `$_GET`, `$_POST`, `$_SERVER`. Автоматическая XSS-очистка входящих данных.

**Namespace:** `Core\Request`
**Файл:** `core/Request.php`

#### Свойства

| Свойство | Тип | Описание |
| :--- | :--- | :--- |
| `private array $get` | `array` | Очищенный `$_GET`. |
| `private array $post` | `array` | Очищенный `$_POST`. |
| `private string $uri` | `string` | Путь запроса без GET-параметров. |
| `private string $method` | `string` | HTTP-метод в верхнем регистре. |

#### Конструктор

```php
public function __construct()
```

Автоматически:
1. Очищает `$_GET` и `$_POST` через `clean()`.
2. Определяет HTTP-метод из `$_SERVER['REQUEST_METHOD']`.
3. Парсит URI через `parse_url()` (только путь, без `?query`).

> ⚠️ Конструктор не нужно вызывать вручную — `Router` создаёт `Request` сам.

---

#### Методы

##### `query(string $key, mixed $default = null): mixed`

Возвращает очищенное значение из `$_GET`.

**Параметры:**
- `$key` (`string`) — ключ параметра.
- `$default` (`mixed`, по умолчанию `null`) — значение, если ключ отсутствует.

**Возвращает:** `mixed` — строку, массив или `$default`.

**Пример:**

```php
// URL: /search?q=php&page=2&tags[]=web&tags[]=api
$q    = $request->query('q');              // "php"
$page = $request->query('page', 1);        // 2
$tags = $request->query('tags', []);       // ['web', 'api']
$miss = $request->query('missing', 'N/A'); // "N/A"
```

---

##### `input(string $key, mixed $default = null): mixed`

Возвращает очищенное значение из `$_POST`.

**Параметры:**
- `$key` (`string`) — ключ параметра.
- `$default` (`mixed`, по умолчанию `null`) — значение по умолчанию.

**Возвращает:** `mixed`.

**Пример:**

```php
// Форма: <input name="email"><input name="password">
$email    = $request->input('email');
$password = $request->input('password');
$remember = $request->input('remember', false);
```

---

##### `getUri(): string`

Возвращает текущий путь запроса без GET-параметров.

**Параметры:** нет.

**Возвращает:** `string` — например, `/profile`, даже если URL был `/profile?id=5`.

**Пример:**

```php
$uri = $request->getUri(); // "/about"
```

---

##### `getMethod(): string`

Возвращает HTTP-метод в верхнем регистре.

**Параметры:** нет.

**Возвращает:** `string` — `GET`, `POST`, `PUT`, `DELETE` и т.д.

**Пример:**

```php
if ($request->getMethod() === 'POST') {
    // обработка формы
}
```

---

##### `private clean(array|string $data): array|string`

Рекурсивная очистка входящих данных. Удаляет концевые пробелы и нулевые байты.

**Параметры:**
- `$data` (`array|string`) — сырые данные.

**Возвращает:** `array|string` — очищенные данные.

> ℹ️ **Важно:** метод `clean()` НЕ делает HTML-экранирование. Для защиты от XSS при выводе используйте `htmlspecialchars()` в представлениях.

---

### 3. `Core\Router` — маршрутизатор

**Назначение:** Сопоставление URI с картой маршрутов и вызов экшена контроллера.

**Namespace:** `Core\Router`
**Файл:** `core/Router.php`

#### Свойства

| Свойство | Тип | Описание |
| :--- | :--- | :--- |
| `private array $routes` | `array` | Список зарегистрированных маршрутов. |

#### Методы

##### `add(array $routesList): void`

Регистрирует список маршрутов из `config/route.php`.

**Параметры:**
- `$routesList` (`array`) — массив вида `[['/path', 'Controller@method', 'METHOD'], ...]`.

**Возвращает:** `void`.

**Исключения:**
- `\InvalidArgumentException` — если не указан HTTP-метод (третий элемент).
- `\Exception` (код 500) — если класс контроллера не найден на диске.

**Формат маршрута:**

```php
[
    '/path/{param}',           // URL с опциональным динамическим сегментом
    'ControllerName@method',   // Класс контроллера и метод
    'HTTP_METHOD',             // GET, POST, PUT, DELETE, PATCH
]
```

**Пример:**

```php
$router = new Router();
$router->add([
    ['/',              'HomeController@index',   'GET'],
    ['/about',         'AboutController@about',  'GET'],
    ['/post/{id}',     'PostController@show',    'GET'],
    ['/post/create',   'PostController@create',  'POST'],
    ['/post/{id}/edit','PostController@edit',    'PUT'],
    ['/avatar/upload', 'AvatarController@index', 'POST'],
]);
```

---

##### `dispatch(Request $request): void`

Сопоставляет текущий URI с картой маршрутов и вызывает экшен контроллера.

**Параметры:**
- `$request` (`Request`) — объект текущего запроса.

**Возвращает:** `void`.

**Исключения:**
- `\Exception` (код 404) — если маршрут не найден.
- `\Exception` (код 500) — если метод не существует в контроллере.

**Особенности:**
- Нормализует слэши: `/about/` → `/about`.
- Поддерживает динамические сегменты `{name}` (регулярка `([^/]+)`).
- **Автоматически внедряет `$request` первым аргументом**, динамические параметры — следом.

**Пример вызова экшена:**

Маршрут: `['/post/{id}', 'PostController@show', 'GET']`
URL: `/post/42`

```php
// В контроллере:
public function show(Request $request, string $id): void
{
    // $request — объект Request
    // $id      — "42"
}
```

---

### 4. `Core\Controller` — базовый контроллер

**Назначение:** Родительский класс для всех контроллеров. Предоставляет Layout-систему.

**Namespace:** `Core\Controller`
**Файл:** `core/Controller.php`

#### Константы

| Константа | Значение | Описание |
| :--- | :--- | :--- |
| `VERSION` | `'v4.0.0-alpha'` | Версия ядра фреймворка. |

#### Методы

##### `render(string $view, array $data = []): void`

Собирает страницу-«матрешку»: изолирует переменные, собирает контент в буфер и внедряет его в лейаут.

**Параметры:**
- `$view` (`string`) — имя файла представления в `views/` без расширения `.php`.
- `$data` (`array`) — ассоциативный массив переменных для вывода.

**Возвращает:** `void`.

**Как работает:**
1. `extract($data)` — распаковывает ключи массива в локальные переменные.
2. `ob_start()` — включает буферизацию.
3. `require views/{$view}.php` — рендерит контентную часть в `$content`.
4. `ob_get_clean()` — забирает буфер.
5. `require views/layouts/main.php` — встраивает `$content` в лейаут.

**Пример:**

```php
public function index(Request $request): void
{
    $this->render('home', [
        'title'   => 'Главная',
        'user'    => $user,
        'posts'   => $posts,
        'isAdmin' => false,
    ]);
}
```

**Что доступно в `views/home.php`:**

```php
<?php /** @var string $title */ ?>
<?php /** @var array $user */ ?>
<?php /** @var array $posts */ ?>
<?php /** @var bool $isAdmin */ ?>

<h1><?= htmlspecialchars($title) ?></h1>
<p>Привет, <?= htmlspecialchars($user['name']) ?></p>
```

**Что доступно в `views/layouts/main.php`:**

```php
$content // готовый HTML контентной части
$title   // переменная, переданная в render()
// + все остальные ключи из $data
```

---

### 5. `Core\ErrorHandler` — обработчик ошибок

**Назначение:** Глобальный перехват всех типов ошибок: Exception, TypeError, Warning, Fatal Error.

**Namespace:** `Core\ErrorHandler`
**Файл:** `core/ErrorHandler.php`

#### Свойства

| Свойство | Тип | Описание |
| :--- | :--- | :--- |
| `private static bool $debug` | `bool` | Режим отладки. `true` — подробный trace, `false` — заглушка. |

#### Методы

##### `register(bool $debug = false): void`

Регистрирует систему обработки ошибок в ядре PHP.

**Параметры:**
- `$debug` (`bool`, по умолчанию `false`) — флаг режима отладки.

**Возвращает:** `void`.

**Что делает:**
- `set_exception_handler()` — перехват невыловленных исключений.
- `set_error_handler()` — перехват Warning, Notice.
- `register_shutdown_function()` — перехват Fatal Errors.

**Пример:**

```php
use Core\ErrorHandler;

// В public/index.php
$config = require __DIR__ . '/../config/config.php';
ErrorHandler::register($config['debug'] ?? false);
```

---

##### `handleException(\Throwable $exception): void`

Обработчик невыловленных исключений. Вызывается автоматически.

**Параметры:**
- `$exception` (`\Throwable`) — перехваченное исключение.

**Возвращает:** `void`.

---

##### `handleError(int $level, string $message, string $file, int $line): void`

Обработчик runtime-ошибок PHP. Преобразует Warning/Notice в `ErrorException`.

**Параметры:**
- `$level` (`int`) — уровень ошибки (`E_WARNING`, `E_NOTICE` и т.д.).
- `$message` (`string`) — текст сообщения.
- `$file` (`string`) — путь к файлу.
- `$line` (`int`) — номер строки.

**Возвращает:** `void`.

---

##### `handleFatalError(): void`

Обработчик фатальных ошибок. Вызывается через `register_shutdown_function`.

**Параметры:** нет.

**Возвращает:** `void`.

**Ловит:** `E_ERROR`, `E_PARSE`, `E_CORE_ERROR`, `E_COMPILE_ERROR`.

---

##### `private render(\Throwable $exception): void`

Финальный рендеринг экрана ошибки.

**Логика определения HTTP-статуса:**
- Коды `400, 401, 403, 404, 405` — берутся из `$exception->getCode()`.
- `InvalidArgumentException` или `TypeError` → `400`.
- Все остальные → `500`.

**Что делает:**
1. Очищает буфер вывода (`ob_end_clean`).
2. Отправляет HTTP-заголовок через `http_response_code()`.
3. Если `$debug = false` — подключает `views/errors/http.php` (безопасная заглушка).
4. Если `$debug = true` — подключает `views/errors/error.php` (trace для разработчика).

---

### 6. `Core\Helpers\Avatar` — управление аватарами

**Назначение:** Безопасная загрузка, валидация MIME-типов, отдача веб-пути и удаление аватаров пользователей.

**Namespace:** `Core\Helpers\Avatar`
**Файл:** `core/Helpers/Avatar.php`

#### Свойства

| Свойство | Тип | Значение | Описание |
| :--- | :--- | :--- | :--- |
| `private static string $dir` | `string` | `__DIR__ . '/../../public/assets/img/avatar/'` | Абсолютный путь к папке с аватарами на диске. |
| `private static string $webPath` | `string` | `/assets/img/avatar/` | Веб-путь к папке с аватарами. |
| `private static array $whiteExtension` | `array` | `['jpg', 'jpeg', 'png']` | Белый список расширений. |
| `private static array $whiteMimeTypes` | `array` | `['image/jpeg', 'image/png']` | Белый список MIME-типов. |

#### Зависимости

- **`Core\App`** — для получения `PDO` внутри методов.
- **`$_SESSION['user']`** — массив с ключами `id` и `login`. Ожидается, что сессия уже запущена в `public/index.php`.
- **`finfo`** — встроенное расширение PHP (см. `ext-fileinfo` в `composer.json`).

---

#### `Avatar::load(): string`

Перехватывает POST-запрос с файлом, валидирует его и сохраняет аватар текущего пользователя. Метод вызывается из экшена контроллера, обрабатывающего форму загрузки.

**Параметры:** нет.

**Возвращает:** `string` — текст ошибки из `$_SESSION['error']` (после извлечения флаг ошибки сбрасывается). Пустая строка, если ошибок не было.

**Побочные эффекты:**
- При успешной загрузке: сохраняет файл в `public/assets/img/avatar/{login}.{ext}`, делает `INSERT` в таблицу `avatar` и **делает `header('Location: ...')` + `exit`**.
- При любой ошибке: записывает текст в `$_SESSION['error']` и **делает `header('Location: ...')` + `exit`**.

**Поток выполнения:**

1. **Проверка сессии.** Если `$_SESSION['user']` пуст — редирект на `/` и `exit`.
2. **Проверка метода.** Вся логика загрузки выполняется только для `POST`. Для `GET` метод просто возвращает накопленный текст ошибки.
3. **Проверка наличия файла.** Если `$_FILES['avatar']` пуст или `error !== 0` — пишет `«Вы не загрузили файл»` и редиректит обратно на `HTTP_REFERER`.
4. **Создание папки.** Если `public/assets/img/avatar/` не существует — `mkdir(..., 0755, true)`.
5. **Проверка расширения.** Приводит к нижнему регистру, `jpeg` → `jpg`. Если не входит в `$whiteExtension` — пишет `«Данный формат файла не поддерживается (разрешены jpg, png)»` и редиректит.
6. **Проверка MIME через `finfo`.** Реальный тип файла должен быть `image/jpeg` или `image/png`. Иначе — `«Файл не является картинкой»` и редирект. **Это защита от маскировки PHP-скриптов под картинки.**
7. **Формирование имени.** `{login}.{ext}` (например, `Mihichx.png`).
8. **Удаление старой аватарки.** Вызов `self::delete()` перед записью новой.
9. **Сохранение файла.** `move_uploaded_file($tmp, $final)`.
10. **Запись в БД.** `INSERT INTO avatar (user_id, name) VALUES (?, ?)`.
11. **Редирект** на `HTTP_REFERER`.

**Исключения:** метод сам не бросает исключений. Возможные `PDOException` при работе с БД перехватит `Core\ErrorHandler`.

**Пример использования в контроллере:**

```php
<?php

namespace App\Controllers;

use Core\Controller;
use Core\Helpers\Avatar;

class AvatarController extends Controller
{
    /**
     * GET  /profile       — показать форму загрузки и вывести ошибку (если была).
     * POST /avatar/upload — обработать загрузку файла.
     */
    public function index(): void
    {
        // На POST метод сохранит файл и сделает redirect+exit.
        // На GET метод просто вернёт текст ошибки из сессии (если есть).
        $error = Avatar::load();

        $this->render('profile', [
            'title'    => 'Профиль',
            'error'    => $error,
            'avatarUrl'=> Avatar::unload(),
        ]);
    }
}
```

**Пример формы в представлении `views/profile.php`:**

```html
<?php /** @var string $error */ ?>
<?php /** @var string $avatarUrl */ ?>

<div class="container my-5">
    <h1>Профиль</h1>

    <img src="<?= htmlspecialchars($avatarUrl) ?>" alt="Аватар" width="120">

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="/avatar/upload" method="POST" enctype="multipart/form-data">
        <input type="file" name="avatar" accept="image/jpeg,image/png" required>
        <button type="submit">Загрузить</button>
    </form>
</div>
```

**Схема таблицы `avatar`:**

```sql
CREATE TABLE `avatar` (
    `id`      INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT UNSIGNED NOT NULL,
    `name`    VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uniq_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

---

#### `Avatar::unload(): string`

Возвращает веб-путь к аватарке текущего авторизованного пользователя. Используется в представлениях для тега `<img>`.

**Параметры:** нет.

**Возвращает:** `string` — один из вариантов:
- `/assets/img/avatar/default.svg` — если пользователь не авторизован, аватарки нет или файл пропал с диска.
- `/assets/img/avatar/{login}.{ext}?v={timestamp}` — путь с cache-busting меткой (время последнего изменения файла).

**Логика:**

1. Если `$_SESSION['user']['id']` пуст — сразу возвращает `default.svg`.
2. Ищет запись в таблице `avatar` по `user_id`.
3. **Если запись есть:**
   - Формирует `$pathServer` и `$pathWeb`.
   - Если файла на диске нет — удаляет «битую» запись из БД и возвращает `default.svg`.
   - Иначе возвращает веб-путь с `?v=filemtime($pathServer)` (cache busting).
4. **Если записи нет:**
   - Пробегает по `$whiteExtension` и удаляет возможные «осиротевшие» файлы (`{login}.jpg`, `{login}.png` и т.д.), оставшиеся от старых версий.
   - Возвращает `default.svg`.

**Особенности:**
- **Cache Busting** — браузер мгновенно обновляет картинку после загрузки новой без `Ctrl+F5`.
- **Самовосстановление** — если файл удалили вручную, запись из БД подчистится при следующем вызове.
- **Fallback на default.svg** — не ломает вёрстку, если аватарки нет.

**Пример:**

```php
use Core\Helpers\Avatar;

$avatarUrl = Avatar::unload();
// "/assets/img/avatar/Mihichx.png?v=1718293800"
// или
// "/assets/img/avatar/default.svg"
```

**Использование в лейауте:**

```html
<img src="<?= htmlspecialchars(Avatar::unload()) ?>" alt="Аватар">
```

---

#### `Avatar::delete(): void`

Физически удаляет файл аватарки с диска и стирает запись о ней из БД.

**Параметры:** нет.

**Возвращает:** `void`.

**Логика:**

1. Если `$_SESSION['user']['id']` пуст — тихо выходит (без исключений).
2. Находит запись в таблице `avatar`.
3. Если запись есть — удаляет файл с диска (`unlink`) и `DELETE` из БД.

**Особенности:**
- Вызывается автоматически внутри `load()` перед сохранением новой аватарки.
- Безопасен для повторного вызова — если записи нет, ничего не делает.

**Пример:**

```php
use Core\Helpers\Avatar;

// Удаление аватарки по кнопке "Убрать фото"
public function remove(): void
{
    Avatar::delete();
    header('Location: /profile');
    exit;
}
```

---

#### Полный пример контроллера профиля

```php
<?php

namespace App\Controllers;

use Core\Controller;
use Core\Request;
use Core\App;
use Core\Helpers\Avatar;

class ProfileController extends Controller
{
    public function index(Request $request): void
    {
        // На POST — метод сохранит файл и сделает redirect+exit.
        // На GET — вернёт текст прошлой ошибки (если была) и очистит её.
        $error = Avatar::load();

        $stmt = App::db()->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user']['id']]);
        $user = $stmt->fetch();

        $this->render('profile', [
            'title'     => 'Профиль',
            'user'      => $user,
            'error'     => $error,
            'avatarUrl' => Avatar::unload(),
        ]);
    }
}
```

**Маршруты в `config/route.php`:**

```php
return [
    ['/profile',       'ProfileController@index',  'GET'],
    ['/avatar/upload', 'ProfileController@index',  'POST'],
];
```

---

#### Безопасность

- **Двойная валидация** — расширение + MIME через `finfo` (не доверяет `$_FILES['type']`).
- **Белый список** — только `jpg`, `jpeg`, `png` / `image/jpeg`, `image/png`.
- **Изоляция файлов** — все аватары лежат в `public/assets/img/avatar/`, для которых Nginx/Apache запрещают выполнение PHP.
- **Уникальное имя** — генерируется по логину, что исключает конфликты между пользователями.
- **Проверка сессии** — метод не работает для неавторизованных.
- **Cache Busting** — исключает показ старой картинки после замены.

#### Ограничения текущей версии

- Нет ограничения на размер файла — настройте `client_max_body_size` в Nginx и `upload_max_filesize` / `post_max_size` в PHP.
- Нет ресайза/сжатия — загруженное изображение сохраняется «как есть».
- Нет проверки на реальные размеры (ширина/высота) и на «бомбу декомпрессии» — рекомендуется добавить `getimagesize()`.
- Работает только с `$_FILES['avatar']` — имя поля жёстко зашито.

---

## Работа с базой данных

### Получение PDO

```php
use Core\App;

$db = App::db();
```

### Простой SELECT

```php
$stmt = App::db()->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    throw new \Exception('Пользователь не найден', 404);
}
```

### SELECT с несколькими параметрами

```php
$stmt = App::db()->prepare(
    "SELECT * FROM posts WHERE status = ? AND author_id = ? ORDER BY created_at DESC LIMIT ?"
);
$stmt->execute(['published', $authorId, 10]);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
```

### INSERT

```php
$stmt = App::db()->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
$stmt->execute([$name, $email]);
$newId = App::db()->lastInsertId();
```

### UPDATE

```php
$stmt = App::db()->prepare("UPDATE users SET name = ? WHERE id = ?");
$stmt->execute([$newName, $userId]);
$affected = $stmt->rowCount();
```

### DELETE

```php
$stmt = App::db()->prepare("DELETE FROM posts WHERE id = ?");
$stmt->execute([$postId]);
```

### Транзакции

```php
$db = App::db();
$db->beginTransaction();
try {
    $db->prepare("UPDATE accounts SET balance = balance - ? WHERE id = ?")
       ->execute([100, $fromId]);
    $db->prepare("UPDATE accounts SET balance = balance + ? WHERE id = ?")
       ->execute([100, $toId]);
    $db->commit();
} catch (\Throwable $e) {
    $db->rollBack();
    throw $e;
}
```

### Защита от SQL-инъекций

**Всегда** используйте подготовленные запросы с `?` или именованными плейсхолдерами:

```php
// ✅ ПРАВИЛЬНО
$stmt = App::db()->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);

// ✅ ТОЖЕ ПРАВИЛЬНО (именованные)
$stmt = App::db()->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute([':email' => $email]);

// ❌ НЕПРАВИЛЬНО — SQL-инъекция!
$db->query("SELECT * FROM users WHERE email = '$email'");
```

---

## Работа с представлениями

### Структура

- **`views/layouts/main.php`** — общий каркас сайта (Header, Footer, подключение CSS/JS).
- **`views/{page}.php`** — контентная часть конкретной страницы.
- **`views/errors/error.php`** — debug-экран (только при `$debug = true`).
- **`views/errors/http.php`** — безопасная заглушка (при `$debug = false`).

### Пример лейаута

```html
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'ClearVC') ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header>
        <nav>
            <a href="/">Главная</a>
            <a href="/about">О нас</a>
        </nav>
    </header>

    <main>
        <?= $content ?>
    </main>

    <footer>
        <p>© <?= date('Y') ?> ClearVC</p>
    </footer>

    <?php if (!empty($js)): ?>
        <?php foreach (explode(',', $js) as $script): ?>
            <script src="/assets/js/<?= trim($script) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
```

### Пример контентной части

```html
<?php /** @var string $title */ ?>
<?php /** @var array $user */ ?>

<div class="container my-5">
    <h1><?= htmlspecialchars($title) ?></h1>

    <div class="card">
        <div class="card-body">
            <h5><?= htmlspecialchars($user['name']) ?></h5>
            <p><?= htmlspecialchars($user['email']) ?></p>
        </div>
    </div>
</div>
```

### Защита от XSS при выводе

**Всегда** экранируйте динамический вывод:

```php
<?= htmlspecialchars($variable) ?>
<?= htmlspecialchars($variable, ENT_QUOTES, 'UTF-8') ?>
```

**Для URL:**

```php
<a href="/user/<?= urlencode($userId) ?>">Профиль</a>
```

**Для атрибутов:**

```php
<div data-value="<?= htmlspecialchars($value, ENT_QUOTES) ?>">
```

---

## Развёртывание

### Apache

1. Укажите `Document Root` домена как `/path/to/project/public`.
2. Убедитесь, что `mod_rewrite` включён.
3. Файл `public/.htaccess` уже настроен.

### Nginx

Используйте `nginx.conf.example`:

```nginx
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
}
```

### Docker

```bash
docker-compose up -d
```

Сервисы:
- **web** — Nginx на `localhost:8080`.
- **app** — PHP 8.4 FPM.
- **db** — MySQL 8.0 на `localhost:3306`.

> ⚠️ `docker-compose.yml` помечен `TODO: По тестить`. Перед продакшеном проверьте права на запись в `public/assets/img/avatar/`.

### Продакшен-чеклист

- [ ] Установить `'debug' => false` в `config/config.php`.
- [ ] Настроить HTTPS (Let's Encrypt).
- [ ] Проверить права на запись только для `public/assets/`.
- [ ] Убедиться, что `config/config.php` в `.gitignore`.
- [ ] Включить OPcache в PHP.
- [ ] Настроить логирование ошибок в файл, а не в вывод.
- [ ] Дождаться релиза 4.0.0-stable (CSRF, Flash Messages).

---

## Лицензия

ClearVC распространяется под лицензией **MIT**. Это разрешительная лицензия: код можно свободно использовать в личных и коммерческих проектах, включая закрытые. Единственное требование — сохранить уведомление об авторских правах.

MIT выбран как стандарт PHP-экосистемы (Laravel, Symfony, Composer-пакеты) — он обеспечивает максимальное распространение фреймворка и совместимость с другими библиотеками.

---

**Авторы:** Бакулев М., Кириенков М., Фатахова С., Наумов А., Рагазина Е.
*Разработано в соответствии с современными стандартами безопасности веб-приложений.*
