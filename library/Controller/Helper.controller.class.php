<?php

class CHelperController {

    /**
     * @param $timestamp
     * @return false|string
     */
    public static function getDateFromTimestamp($timestamp) {
        $date = date('Y-m-d', $timestamp);

        return $date;
    }

}