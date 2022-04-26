<?php

    spl_autoload_register(function($class) {

        $pieces = explode("\\", $class);
        $cName = array_pop($pieces);

        for($i=0; $i<count($pieces); $i++) 
            $pieces[$i] = strtolower($pieces[$i]);

        $folder = implode("/", $pieces);
        $path = $folder . "/" . $cName . ".php";

        if(file_exists($path)) include($path);
        else die("Risorsa richiesta non valida: " . $path);
        
    });