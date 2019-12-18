<?php

    spl_autoload_register('autoload');

    function autoload($className) {
        $className = substr($className, 1);

		if(strpos($className, 'Model') !== false) {
            $autoActionFolder = 'Model/db/';
		}
		else if (strpos($className, 'Controller') !== false) {
            $autoActionFolder = 'Controller/';
            $classNameInfo = explode("Controller", $className);
            $className = ucwords($classNameInfo[0]) . '.' . 'controller';
		}
		else {
            $autoActionFolder = 'Model/';
        }

        require_once(DIR_LIBRARY . $autoActionFolder . $className . '.class.php');
    }