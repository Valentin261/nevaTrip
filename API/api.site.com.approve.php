<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>api.site.com/book</title>
</head>
<body>

<?php
//Мокаем поведение
function respondApi(){
    $randomAnswer = random_int(1,2);
    if ($randomAnswer == 1) echo "order successfully aproved" else {
        $randomAnswerError = random_int(1,4);
        switch ($randomAnswerError) {
            case 1:
                echo "event cancelled";
                break;
            case 2:
                echo "no tickets";
                break;
            case 3:
                echo "no seats";
                break;
            case 4:
                echo "fan removed";
                break;
        }
    }



}
?>

</body>
</html>