<?

namespace Core\Helpers;

class Image
{
    public static function load($connect)
    {
        if (empty($_SESSION['user'])) { header('Location: /'); exit; } 

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_FILES['img']) && $_FILES['img']['error'] === 0) {
                $tmpPath = $_FILES['img']['tmp_name'];        // Путь хранения(временного) загруженного фото
                $img_name = $_FILES['img']['name'];          // Имя загружаемого файла
                $uploadDir = 'assets/img/avatar/';          // Путь сохранения файла
                $white_extension = ['jpg', 'png'];         // Разрешённые типы файла
                $user_name = $_SESSION['user']['login'];  // Логин пользователя
                $user_id = $_SESSION['user']['id'];      // ID пользователя

                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);  // Создаём папку аватарок если нету

                $extension = mb_strtolower(pathinfo($img_name, PATHINFO_EXTENSION));  // Находим тип файла
                if (!in_array($extension, $white_extension, true)){ $_SESSION['error'] = 'Данный формат файла не поддерживается'; header('Location: /img'); exit; }  // Проверяем на разрешённые типы

                $new_name_img = $user_name . '.' . $extension;  // Генерируем новое название (логин.тип)
                $finalPath = $uploadDir . $new_name_img;       // Финальный путь с названием файла

                // Проверка на существование аватар
                self::delete($connect, $user_id, $uploadDir);

                if (move_uploaded_file($tmpPath, $finalPath)) {  // Выполняет перенос файла и проверяет, успешно ли он завершился
                    $stmt = $connect->prepare("INSERT INTO `avatar`(`user_id`, `name`) VALUES (?, ?)");  // Записываем имя файла в БД
                    $stmt->execute([$user_id, $new_name_img]);

                    header('Location: /profile');
                    exit;
                } else {
                    $_SESSION['error'] = 'Ошибка при сохранении файла'; header('Location: /img'); exit;
                }
            } else {
                $_SESSION['error'] = 'Вы не загрузили файл'; header('Location: /img'); exit;
            }
        }

        $error = $_SESSION['error'] ?? '';
        unset($_SESSION['error']);

        return $error;
    }

    public static function unload($connect)
    {
        $user_id = $_SESSION['user']['id'];
        $stmt = $connect->prepare("SELECT * FROM `avatar` WHERE `user_id` = ? LIMIT 1");
        $stmt->execute([$user_id]);
        $row = $stmt->fetch();
        if ($row) {
            $user_img = $row['name'];
            $avatar_path = 'assets/img/avatar/' . $user_img;
            $version =  file_exists($avatar_path) ? filemtime($avatar_path) : 1;
            $path = $avatar_path . '?v=' . $version;
            return $path;
        }
        return 'assets/img/avatar/default.svg';
    }

    public static function delete($connect) 
    {
        $user_id = $_SESSION['user']['id'];

        $stmt = $connect->prepare("SELECT * FROM `avatar` WHERE `user_id` = ? LIMIT 1");  // Проверяем на существование названия в БД
        $stmt->execute([$user_id]);
        $row = $stmt->fetch();

        if ($row) {
            $uploadDir = 'assets/img/avatar/';

            $oldFile = $uploadDir . $row['name'];                                     // Путь к старому файлу
            if (file_exists($oldFile)) unlink($oldFile);                             // Проверяем на существование и удаляем
            $stmt = $connect->prepare("DELETE FROM `avatar` WHERE `user_id` = ?");  // Удаляем в БД
            $stmt->execute([$user_id]);
        }
    }
}
