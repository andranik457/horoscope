<?php
{
    # require config file
    require_once(dirname(__FILE__) . '/../../include/config.inc.php');

    $ignio = new ZIgnioController();

    $ignio->getZodiacData();
    $ignio->parseZodiacData();
    $ignio->saveZodiacData();


}