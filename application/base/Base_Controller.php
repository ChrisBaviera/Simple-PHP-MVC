<?php

namespace Application\Base;

use Application\Helpers\LogManager;

class Base_Controller {

    public function __construct() {
        
        LogManager::add("Controller", "Controller " . get_called_class() . " started!");
    }

    public function __destruct() {
        
        LogManager::add("Controller", "Controller " . get_called_class() . " destructed!");
    }
}