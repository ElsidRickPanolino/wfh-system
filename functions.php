<?php
    function sameWeek($date1, $date2) {
        $dateTime1 = new DateTime($date1);
        $dateTime2 = new DateTime($date2);

        $dateTime1->modify('+1 day');
        $dateTime2->modify('+1 day');

        $weekYear1 = $dateTime1->format('YW');
        $weekYear2 = $dateTime2->format('YW');

        return $weekYear1 === $weekYear2;
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