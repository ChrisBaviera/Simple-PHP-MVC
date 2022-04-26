<?php

namespace Application;

use Application\Helpers\LogManager;

class Application {

    private String $controller;
    private String $method;
    private Array  $args;

    public function __construct() {
        
        LogManager::add("Application", "Application started!");

        $this->controller = BASE_CONTROLLER;
        $this->method = BASE_METHOD;
        $this->args = [];

        $this->parseQueryString();

        LogManager::add("MVC Data", $this->controller . "->" . $this->method . "()");
        LogManager::add("MVC Arguments", "{" . implode(", ", $this->args) . "}");

        $controllerClass = new $this->controller();
        call_user_func_array([$controllerClass, $this->method], $this->args);
    }

    public function __destruct() {
        
        LogManager::add("Application", "Application destructed!");
        
        if(APP_DEBUG) LogManager::printLogs();
    }

    private function parseQueryString() : Array {

        $qs = array_filter(explode("/", $_SERVER["QUERY_STRING"]), fn($value) => !is_null($value) && $value !== '');
        $countQS = count($qs);

        switch(TRUE) {

            case ($countQS == 1): $this->method = $qs[0]; break;

            case ($countQS > 1):

                $this->controller = $qs[0];
                $this->method = $qs[1];

                if($countQS > 2) 
                    for($i=2; $i<$countQS; $i++)
                        $this->args[] = $qs[$i];

                break;
        }

        $this->controller = "Application\\Controllers\\" . ucfirst($this->controller);

        return $qs;
    }
}