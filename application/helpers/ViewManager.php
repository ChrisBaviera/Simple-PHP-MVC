<?php

namespace Application\Helpers;

class ViewManager {

    public static function load(String $view, bool $template = true, $templateDir = "default") : String {

        ob_start();

            $starttime = microtime(true);

            $path = BASE_PATH . PATH_VIEWS . $view . ".php";
            $tpath = BASE_PATH . PATH_TEMPLATES . $templateDir;

            if($template && file_exists($tpath . "\\header.php")) {

                LogManager::add("View", "Loading header template.");
                @include($tpath . "\\header.php");

            } else LogManager::add("View", "Header template view " . $templateDir . " not found!");
            
            if(file_exists($path)) {

                LogManager::add("View", "Loading view: " . $view . ".php");
                @include($path);

            } else LogManager::add("View", $view . ".php view file not found!");

            if($template && file_exists($tpath . "\\footer.php")) {

                LogManager::add("View", "Loading footer template.");
                @include($tpath . "\\footer.php");

            } else LogManager::add("View", "Footer template view " . $templateDir . " not found!");

            $endtime = microtime(true);
            $loadingTime = number_format(($endtime - $starttime) * 1000, 3);
            LogManager::add("View", "Page loaded in " . $loadingTime . "ms");
            
        return ob_get_clean();
    }
}