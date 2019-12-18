<?php
{
    /**
     * helpful defines
     */

    # define time zone
    date_default_timezone_set('UTC');
    $now = time();

    define('MONGO_FIRST_ID',      '4bae63c00000000000000000');    # mongo first id

    define('TIMING', [
        'minute'    => 60,
        'minutes5'  => 300,
        'minutes15' => 900,
        'hour'      => 3600,
        'day'       => 86400,
        'week'      => 604800
    ]);

    define('CHUNKS', [
        'default'   => 10000,
        'large'      => 100000
    ]);

    define('COLORS', [
        'red'       => "\033[31m",
        'green'     => "\033[32m",
        'yellow'    => "\033[33m",
        'blue'      => "\033[34m",
        'purple'    => "\033[35m",
        'lightGray' => "\033[36m",
        'end'       => "\033[0m"
    ]);

    define('SYMBOLES', [
        'circle'        => "● ",
        'checkMark'     => "✔ ",
        'unCheckMark'   => "✘ ",
    ]);

}