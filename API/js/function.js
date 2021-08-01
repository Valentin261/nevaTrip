/**
 * Created by Valentin on 17.07.2021.
 */


function getRandomInt(max) {
    return Math.floor(Math.random() * max);
}

var event_id = 101;
var event_date = '2021-07-29 18:00:00';
var ticket_adult_price = 1000;
var ticket_adult_quantity = 0;
var ticket_kid_price = 1200;
var ticket_kid_quantity = 1;
var barcode = getRandomInt(999999);


function SendDataOrder() {

    // Массив из записанных полей (для записи в бд)
    var mes_string = {
        'event_id': event_id, 'event_date': event_date, 'ticket_adult_price': ticket_adult_price,
        'ticket_adult_quantity': ticket_adult_quantity, 'ticket_kid_price': ticket_kid_price,
        'ticket_kid_quantity': ticket_kid_quantity, 'barcode': barcode
    };

    var answer = 'barcode already exists';

     while (answer == 'order successfully booked') {
    $.ajax({
        type: 'POST',
        url: 'api.site.com.book.php',
        data: mes_string,
        beforeSend: function () {

            $('#infoLoad').html('<br><p>Обновляем данные...<img src="img/33.gif"></p>');

        },
        success: function (data) {
            $('#infoReloadInfo').html(data);
            $('#infoLoad').html('');
            answer = data;
        }
    });
     };


}

function RecOrderForDB(useBarcode) {
    var barcode = {'barcode': useBarcode};

    $.ajax({
        type: 'POST',
        url: 'api.site.com.approve.php',
        data: barcode,
        beforeSend: function () {
            $('#infoReloadInfoRecBarcode').html('<br><p>Обновляем данные...<img src="img/33.gif"></p>');
        },
        success: function (data) {
            $('#InfoTest').html(data);
            answer = data;
            $('#infoReloadInfoRecBarcode').html('');
        }
    });


};