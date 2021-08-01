<?php
/**
 * User: Valentin
 * Date: 30.07.2021
 * Time: 14:00
 */


/**
 * Класс проверки (валидации) данных
 *
 * Класс реализовывает всевозможные проверки корректности введенных данных пользователем (оператором)
 */
class DataValidation
{

    /**
     * Проверка существования данных, переданных запросом (данные формы ввода)
     *
     * Метод проверяет наличие введенных оператором данных, и возвращает информацию
     * о том, все ли необходимые поля были заполнены, для последующей их записи в БД.
     *
     * (проверка для корректности должна включать множество доп. инструментов таких как проверка:
     * - даты
     * - валидации
     * - типов
     * - и др.
     *
     * @return boolean функция возвращает информацию о полном заполнении формы операторского ввода данных
     */
    public function dataAvailability($eventID, $eventDate, $ticketAdultPrice, $ticketAdultQuantity, $ticketKidPrice, $ticketKidQuantity)
    {

        $flag = true;

        if (isset($eventID) AND isset($eventDate)
            AND isset($ticketAdultPrice) AND isset($ticketAdultQuantity)
            AND isset($ticketKidPrice) AND isset($ticketKidQuantity)
        ) {
            $flag = false;
        }

        return $flag;
    }


}
