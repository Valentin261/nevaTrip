
<?php

function respondApi()
{
    //Получаем случайный ответ от системы
    $randomAnswer = random_int(1, 2);
    if ($randomAnswer == 1) {
        echo "order successfully booked";
        //подключаем класс для работы с БД
        require_once('class/class.Dataprocessing.php');

        //Создаем объект, для работы с БД
        $workWithTheDatabase = new Dataprocessing();

        //Посылаем случайные данные + barcode
        $ValidationUserDate = $workWithTheDatabase->inputValidation(event_id, ticket_adult_price, ticket_adult_quantity, ticket_kid_price, ticket_kid_quantity);


        //Пишем данные в БД (генерация уникального баркода + проверка на повтор внутри функции, в случае одновременного запроса)
        if ($ValidationUserDate) $workWithTheDatabase->addOrder(event_id, ticket_adult_price, ticket_adult_quantity, ticket_kid_price, ticket_kid_quantity);

    } else echo 'barcode already exists';
}

//Эмитируем ответы от системы
respondApi();
