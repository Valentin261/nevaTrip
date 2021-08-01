<?php
/**
 * User: Valentin
 * Date: 17.07.2021
 * Time: 14:00
 */


/**
 * Класс работы с БД
 *
 * Реализует:
 * - подключение
 * - запросы выборки
 * - добавление данных
 */
class Dataprocessing
{

    protected static $_dbh;
    protected $_db_host;
    protected $_db_name;
    protected $_db_username;
    protected $_db_password;

    private $barcode;


    /**
     * Dataprocessing constructor.
     *
     * Конструктор класса dataprocessing. Внутри определяются основные настройки,
     * учетной записи БД и работа с функиями реализующими взимодейтсивие
     *
     * @host fsdf
     *
     */
    public function __construct()
    {
        // определяем начальные данные для подключения к БД
        $this->_db_host = '144.134.22.129';
        $this->_db_name = 'StoreOrders';
        $this->_db_username = 'phpmyadmin';
        $this->_db_password = '1222873h4284h283';
        self::$_dbh = $this->connectDB_PDO();

    }


    /**
     * Подключение к БД (Методом PDO).
     *
     * Данная функция устанавливает подключение к БД, используя определенные в конструкторе класса
     * настройки подключения (хостинг, имя БД, имя пользователя, пароль). При необходимости подключения к другой БД
     * заранее переоределяются переменные подключения класса "construct".
     *
     * @return object PDO возвращает объект: подключения к БД
     */
    public function connectDB_PDO()
    {
        // соединяемся с сервером базы данных
        try {
            $dbh = new PDO("mysql:host=$this->_db_host;dbname=$this->_db_name", $this->_db_username, $this->_db_password);
            //устанавливаем кодировку файла
            $dbh->exec('SET NAMES utf8');
        } catch (PDOException $e) {
            echo '<p>No connect</p>';
            //Вывод деталей произошедшей ошибки
            //echo $e;
            die();
        }
        return $dbh;
    }


    /**
     * Генератор bar кода
     *
     * Данная функция создает уникальный bar код, необходимый для добавления нового билета на мероприятие
     *
     * @return int возвращает уникальное число
     */
    public function getBarcode()
    {
        $flag = false;

        //Запускаем методом перебора поиск уникального баркода
        while ($flag) {

            //Генерируем псевдо случайное число (наш потенциальный баркод)
            $randBarcode = random_int(1, 999999);

            //Проверяем уникальность сгенерированного баркода, исходя из существующих записей в БД
            $stmt = $dbh->prepare("SELECT COUNT(*) FROM `Orders` WHERE `barcode` = :barcode");
            $stmt->bindParam(':barcode', $barcode);
            $stmt->execute();
            $data = $stmt->fetch();

            //Если код уникален, меняем флаг, пишем баркод в наше приватное свойство и завершаем перебор
            if ($data == 0) {
                $flag = true;
                $this->barcode = $randBarcode;
            }
        }

        return $this->barcode;
    }


    /**
     * Добавление записи "Заказ"
     *
     * Метод создает новую запись в таблице БД (По представленной структуре БД в задании "ТаблицаЗадания1")
     *
     */
    public function addOrder($eventID, $eventDate, $ticketAdultPrice, $ticketAdultQuantity, $ticketKidPrice, $ticketKidQuantity)
    {

        //генерируем уникальный баркод
        $barcode = $this->getBarcode();

        //Добавляем запись в таблицу с пользователями
        $stmt = $dbh->prepare("INSERT INTO `Orders` 
				(`id`, `event_id`, `event_date`, `ticket_adult_price`, `ticket_adult_quantity`, `ticket_kid_price`, `ticket_kid_quantity`, `barcode`, `created`)
				values( , :event_id, :event_date, :ticket_adult_price, :ticket_adult_quantity, :ticket_kid_price, :ticket_kid_quantity, :barcode, NOW() )")

        $stmt->bindParam(':event_id', $eventID);
        $stmt->bindParam(':event_date', $eventDate);
        $stmt->bindParam(':ticket_adult_price', $ticketAdultPrice);
        $stmt->bindParam(':ticket_adult_quantity', $ticketAdultQuantity);
        $stmt->bindParam(':ticket_kid_price', $ticketKidPrice);
        $stmt->bindParam(':ticket_kid_quantity', $ticketKidQuantity);
        $stmt->bindParam(':barcode', $barcode);

        $stmt->execute();
    }


}
