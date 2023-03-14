<?php

//require_once __DIR__.'/Aplicacion.php';

/**
 * Parámetros de conexión a la BD
 */

 // Cambiar
define('BD_HOST', 'localhost');
define('BD_NAME', 'klaer');
define('BD_USER', 'klaer');
define('BD_PASS', 'klaer');

/**
 * Parámetros de configuración utilizados para generar las URLs y las rutas a ficheros en la aplicación
 */

 // Cambiar
/*define('RAIZ_APP', __DIR__);
define('RUTA_IMGS', RUTA_APP.'/img');
define('RUTA_CSS', RUTA_APP.'/css');
define('RUTA_JS', RUTA_APP.'/js');
define('RUTA_VISTAS', RAIZ_APP.'/vistas');*/

/**
 * Configuración del soporte de UTF-8, localización (idioma y país) y zona horaria
 */
/*ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');
date_default_timezone_set('Europe/Madrid');*/

// Inicializa la aplicación
//$app = Aplicacion::getInstance(); // Comprobar
//$app->init(['host'=>BD_HOST, 'bd'=>BD_NAME, 'user'=>BD_USER, 'pass'=>BD_PASS]);

/**
 * @see http://php.net/manual/en/function.register-shutdown-function.php
 * @see http://php.net/manual/en/language.types.callable.php
 */
//register_shutdown_function([$app, 'shutdown']);