<?php
/**
 * User: Valentin
 * Date: 17.07.2021
 * Time: 15:35
 */

//подключаем класс работы с БД
require_once('class/class.Dataprocessing.php');

//подключаем класс проверок (корректности введенных данных), вопросов относящихся к обработке ошибок
require_once('class/class.DataValidation.php');

//Создаем объек для проведения проверок введенных данных
$Validation = new DataValidation();

//Проверка переданных от формы данных (используется запрос POST)
$flag = $Validation->dataAvailability($_POST["event_id"], $_POST["ticket_adult_price"],$_POST["ticket_adult_quantity"], $_POST["ticket_kid_price"], $_POST["ticket_kid_quantity"] );
/
///Если введены оператором данные не корректны, заверщаем работу и отправляем
//извещаем его и отправляем обратно на форму заполнения данных
if ($flag == false) {
    echo "<h1>Введенные данные не корректны</h1>";
    return;
}

//В случае успешной проверки данных, создаем объект работы с БД
$workWithTheDatabase = new Dataprocessing();

//Записываем полученные методом POST данные в БД (генерация уникального баркода используется внутри класса)
if ($ValidationUserDate) $workWithTheDatabase->addOrder($_POST["event_id"], $_POST["ticket_adult_price"],$_POST["ticket_adult_quantity"], $_POST["ticket_kid_price"], $_POST["ticket_kid_quantity"]);
