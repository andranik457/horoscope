<?php

    spl_autoload_register('autoload');

    function autoload($className) {
        $className = substr($className, 1);

        $classType = '.class.php';
		if(strpos($className, 'Model') !== false) {
            $autoActionFolder = 'Model/db/';
		}
		else if (strpos($className, 'Interface') !== false) {
            $autoActionFolder = 'Interface/';
            $classNameInfo = explode("Interface", $className);
            $className = ucwords($classNameInfo[0]) . '.' . 'interface';

            $classType = '.php';
		}
		else if (strpos($className, 'Controller') !== false) {
            $autoActionFolder = 'Controller/';
            $classNameInfo = explode("Controller", $className);
            $className = ucwords($classNameInfo[0]) . '.' . 'controller';
		}
		else {
            $autoActionFolder = 'Model/';
        }

        require_once( DIR_LIBRARY . $autoActionFolder . $className . $classType );
    }