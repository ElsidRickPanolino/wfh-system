<?php
    function sameWeek($date1, $date2) {
        $dateTime1 = new DateTime($date1);
        $dateTime2 = new DateTime($date2);

        $startOfWeek = clone $dateTime1;
        $startOfWeek->modify('last sunday');

        $endOfWeek = clone $startOfWeek;
        $endOfWeek->modify('+6 days');

        return $dateTime2 >= $startOfWeek && $dateTime2 <= $endOfWeek;
    }

    function getSunday($date) {
        $dateTime = new DateTime($date);
        $dateTime->setISODate($dateTime->format('Y'), $dateTime->format('W'), 7);
    
        return $dateTime;
    }

    function addSixDays($date) {
        $dateTime = new DateTime($date->format('Y-m-d'));
        $dateTime->modify('+6 days');
    
        return $dateTime;
    }

    function addSevenDays($date) {
        $dateTime = new DateTime($date->format('Y-m-d'));
        $dateTime->modify('+7 days');
    
        return $dateTime;
    }
?>