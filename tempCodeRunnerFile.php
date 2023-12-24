<?php
function sameWeek($date1, $date2) {
        $dateTime1 = new DateTime($date1);
        $dateTime2 = new DateTime($date2);

        $weekYear1 = $dateTime1->format('YW');
        $weekYear2 = $dateTime2->format('YW');

        return $weekYear1 === $weekYear2;
    }