<?php
{
    # Show all errors
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    # PHP ini
    ini_set('memory_limit', '3072M');

    #
    define('DIR_INCLUDE',   '/var/www/zodiac/include/');
    define('DIR_LIBRARY',   '/var/www/zodiac/library/');

    $hostname = gethostname();
    if ($hostname === 'trebel-HP-Notebook' || $hostname === 'andraaniksserver') {

        # main DB | zodiac
        $mongoHostZodiac = [
            'host'      => "mongodb://localhost:27017",
            'params'    => null
        ];

    }
    else {

        # main DB | zodiac
        $mongoHostZodiac = [
            'host'      => "mongodb://localhost:27017",
            'params'    => null
        ];

    }

    define('DB_MONGO_HOSTNAME_ZODIAC',  json_encode($mongoHostZodiac));

    # require databases
    require_once(DIR_INCLUDE . 'catalog/databases.inc.php');

    # Helpful defines
    require_once(DIR_INCLUDE . 'catalog/helpful.inc.php');

    # For mongoDB php7.* connection
    require_once(DIR_LIBRARY . 'mongo/vendor/autoload.php');

    # For elasticSearch
    require_once(DIR_LIBRARY . 'elasticsearch/vendor/autoload.php');

    # defined tables
    require_once(DIR_INCLUDE . 'catalog/collections.inc.php');

    # AutoLoad class
    require_once(DIR_INCLUDE . 'catalog/autoload.inc.php');

}