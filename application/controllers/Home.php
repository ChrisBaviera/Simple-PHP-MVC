<?php

namespace Application\Controllers;

use Application\Base\Base_Controller;
use Application\Helpers\LogManager;
use Application\Helpers\ViewManager;
use Application\Models\User;

class Home extends Base_Controller {

    public function index() {

        echo ViewManager::load("home");

    }
}