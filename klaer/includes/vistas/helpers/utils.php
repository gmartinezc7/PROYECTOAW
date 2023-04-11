<?php

function resuelve($path = ''){ 
    $url = '';  
    $app = \es\klaer\Aplicacion::getInstance();
    $url = $app->resuelve($path);
    return $url;
}
