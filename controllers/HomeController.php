<?
require_once __DIR__ . '/../core/Controller.php';

// шаблон класса для логики страницы
class HomeController extends Controller
{
    public function index()
    {
        // ссылка на объект соеденения с бд, нужен для работы внутри класса
        global $connect;
        
        $content = ['блок текста', 'блок специалистов', 'блок статистики'];
        // контент можно взять и из бд, если настроили подключение в config
        // pdo
        // $stmt = $connect->query('SELECT * FROM about');
        // $content = $stmt->fetchAll(PDO::FETCH_ASSOC);
        

        $this->render('home', [
            'title' => 'Главная',
            // для добавление js-файла ОБЯЗАТЕЛЬНО пишите через ', ' (запятую с пробелом)
            'js' => 'slider.js, accordion.js',
            'content' => $content,
        ]);
    }
}