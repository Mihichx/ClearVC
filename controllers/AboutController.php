<?
require_once __DIR__ . '/../core/Controller.php';

class AboutController extends Controller
{
    public function about()
    {
        global $connect;
        
        // SQL запрос не зависит от типа подключения, исполнение зависит
        $query = "SELECT * FROM table";
        
        // mysqli
        // $result = mysqli_query($connect, $query);
        // $service = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // PDO
        // $stmt = $connect->prepare($query);
        // $stmt->execute();
        // $workes = $stmt->fetchAll();

        $this->render('about', [
            // название страницы отображаемое в браузере
            'title' => 'о нас',
            // передаём данные выборки из бд. можно передавать сколько угодно выборок под разными ключами
            // 'service'=>$service,
            // 'workes'=>$workes,
        ]);
    }
}