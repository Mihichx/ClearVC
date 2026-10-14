<?php

namespace Core\Helpers;

use Core\App;

/**
 * Класс-хелпер для управления аватарками пользователей.
 * 
 * Обеспечивает безопасную загрузку изображений на сервер, валидацию по MIME-типам,
 * удаление старых аватарок, вывод актуального пути для фронтенда и защиту от кэширования браузером.
 * 
 * @package Core\Helpers
 */
class Avatar
{
    /** @var string Абсолютный путь к директории на сервере, где физически хранятся файлы аватарок */
    private static string $dir = __DIR__ . '/../../public/assets/img/avatar/';

    /** @var string Относительный (публичный) URL-путь к аватаркам для отображения в HTML-тегах img */
    private static string $webPath = '/assets/img/avatar/';

    /** @var array<string> Белый список разрешенных расширений файлов */
    private static array $whiteExtension = ['jpg', 'jpeg', 'png'];

    /** @var array<string> Белый список разрешенных MIME-типов для строгой проверки содержимого файла */
    private static array $whiteMimeTypes = ['image/jpeg', 'image/png'];

    /**
     * Обрабатывает загрузку нового аватара пользователя (POST-запрос).
     * 
     * Метод валидирует сессию, проверяет загруженный файл на ошибки, расширение 
     * и реальный MIME-тип, удаляет старый аватар и сохраняет новый в БД и на диск.
     *
     * @return string|void Возвращает строку ошибки из сессии (если она есть) при GET-запросе, либо выполняет редирект и exit при POST.
     * @throws \RuntimeException Если возникают критические ошибки при работе с БД (через класс App)
     */
    public static function load()
    {
        // Проверка авторизации: если пользователя нет в сессии, жестко редиректим на главную
        if (empty($_SESSION['user'])) {
            header('Location: /');
            exit;
        }

        // Если это отправка формы (загрузка файла)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Запоминаем страницу, с которой пришел пользователь, для возврата
            $referer = $_SERVER['HTTP_REFERER'] ?? '/';

            // Проверяем, передан ли файл и нет ли ошибок загрузки со стороны PHP
            if (!empty($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
                $tmpPath   = $_FILES['avatar']['tmp_name']; // Временный путь файла на сервере
                $imgName   = $_FILES['avatar']['name'];     // Оригинальное имя файла от пользователя
                $userLogin = $_SESSION['user']['login'];
                $userId    = $_SESSION['user']['id'];

                // Автоматически создаем папку для аватарок с правами 0755, если её еще нет
                if (!is_dir(self::$dir)) {
                    mkdir(self::$dir, 0755, true);
                }

                // Извлекаем расширение в нижнем регистре и приводим 'jpeg' к единому стандарту 'jpg'
                $extension = mb_strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
                if ($extension === 'jpeg') {
                    $extension = 'jpg';
                }

                // Поверхностная проверка по расширению файла
                if (!in_array($extension, self::$whiteExtension, true)) {
                    $_SESSION['error'] = 'Данный формат файла не поддерживается (разрешены jpg, png)';
                    header("Location: $referer");
                    exit;
                }

                // Строгая проверка: определяем реальное содержимое файла по сигнатуре (MIME-type)
                $finfo    = new \finfo(FILEINFO_MIME_TYPE);
                $mimeType = $finfo->file($tmpPath);

                if (!in_array($mimeType, self::$whiteMimeTypes, true)) {
                    $_SESSION['error'] = 'Файл не является картинкой';
                    header("Location: $referer");
                    exit;
                }

                // Формируем безопасное имя файла на основе логина пользователя (защита от XSS и перезаписи)
                $imgNewName = $userLogin . '.' . $extension;
                $finalPath  = self::$dir . $imgNewName;

                // Удаляем предыдущую аватарку пользователя (из БД и с диска) перед записью новой
                self::delete();

                // Переносим файл из временной папки в постоянную
                if (move_uploaded_file($tmpPath, $finalPath)) {
                    // Фиксируем информацию о новой аватарке в базе данных
                    $stmt = App::db()->prepare("INSERT INTO `avatar`(`user_id`, `name`) VALUES (?, ?)");
                    $stmt->execute([$userId, $imgNewName]);
                    header("Location: $referer");
                    exit;
                } else {
                    $_SESSION['error'] = 'Ошибка при сохранении файла';
                    header("Location: $referer");
                    exit;
                }
            } else {
                $_SESSION['error'] = 'Вы не загрузили файл';
                header("Location: $referer");
                exit;
            }
        }

        // Блок для GET-запроса: извлекаем ошибку из сессии (если она там накопилась) и удаляем её (Flash-placeholder)
        $error = $_SESSION['error'] ?? '';
        unset($_SESSION['error']);

        return $error;
    }

    /**
     * Возвращает валидный веб-путь к аватарке текущего пользователя.
     * 
     * Если у пользователя нет аватарки, возвращается дефолтная заглушка.
     * Если аватарка есть, к пути добавляется timestamp изменения файла (?v=12345),
     * чтобы обойти жесткое кэширование картинок в браузерах при их обновлении.
     *
     * @return string Веб-путь к изображению (например, '/assets/img/avatar/admin.png?v=171000000')
     */
    public static function unload()
    {
        // Если пользователь не авторизован, сразу отдаем дефолтный SVG
        if (empty($_SESSION['user']['id'])) {
            return self::$webPath . 'default.svg';
        }

        $userId    = $_SESSION['user']['id'];
        $userLogin = $_SESSION['user']['login'];

        // Ищем запись об аватаре в БД
        $stmt = App::db()->prepare("SELECT * FROM `avatar` WHERE `user_id` = ? LIMIT 1");
        $stmt->execute([$userId]);
        $row = $stmt->fetch();

        if ($row) {
            $userImg    = $row['name'];
            $pathServer = self::$dir . $userImg;
            $pathWeb    = self::$webPath . $userImg;

            // Синхронизация: если запись в БД есть, а файла на диске физически нет — чистим битую запись в БД
            if (!file_exists($pathServer)) {
                $stmt = App::db()->prepare("DELETE FROM `avatar` WHERE `user_id` = ?");
                $stmt->execute([$userId]);
                return self::$webPath . 'default.svg';
            }

            // Получаем время модификации файла для сброса кэша браузера (Cache Busting)
            $version = file_exists($pathServer) ? filemtime($pathServer) : 1;

            return $pathWeb . '?v=' . $version;
        } else {
            // Если в БД записи нет, на всякий случай зачищаем сиротские файлы на диске,
            // которые могли остаться из-за старых расширений (например, остался старый .png, хотя записи в БД нет)
            foreach (self::$whiteExtension as $ext) {
                $fileName   = $userLogin . '.' . $ext;
                $pathServer = self::$dir . $fileName;

                if (file_exists($pathServer)) {
                    unlink($pathServer);
                    break;
                }
            }

            return self::$webPath . 'default.svg';
        }
    }

    /**
     * Полностью удаляет аватарку текущего пользователя из системы.
     * 
     * Стирает физический файл с жесткого диска сервера и удаляет
     * соответствующую строку из таблицы `avatar` в базе данных.
     *
     * @return void
     */
    public static function delete()
    {
        // Прерываем выполнение, если метод вызван неавторизованным пользователем
        if (empty($_SESSION['user']['id'])) {
            return;
        }

        $userId = $_SESSION['user']['id'];

        // Проверяем наличие аватарки в базе данных
        $stmt = App::db()->prepare("SELECT * FROM `avatar` WHERE `user_id` = ? LIMIT 1");
        $stmt->execute([$userId]);
        $row = $stmt->fetch();

        if ($row) {
            $pathServer = self::$dir . $row['name'];

            // Если физический файл существует — удаляем его с диска
            if (file_exists($pathServer)) {
                unlink($pathServer);
            }

            // Удаляем информацию об аватаре из таблицы БД
            $stmt = App::db()->prepare("DELETE FROM `avatar` WHERE `user_id` = ?");
            $stmt->execute([$userId]);
        }
    }
}
