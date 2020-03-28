<?php
session_start();

require_once '../engine/Loader.php';
require_once '../view/initial.php';
require_once '../view/routing.php';

$loader = new \engine\Loader();
$init = new Initial();



    foreach ($init->web as $key => $value) {
        $loader->loaderClass($key,$value);
    }
    
    foreach ($init->model as $key => $value) {
        $loader->loaderClass($key,$value);
    }
    
    foreach ($init->controller as $key => $value) {
        $loader->loaderClass($key,$value);
    }
    
// init class yang di gunakan

    $json = new \engine\utility\JsonManipulation();
    $basic = new engine\database\BasicQuery();
    $con = new \engine\database\Connection();
    $request = new \engine\http\Request();
    $response = new engine\http\Response();
    $route = new engine\http\Route();
    $pagination = new engine\pagination\Pagination();

    $app_name = $json->getValue($loader->loaderFile('environment.json'), 'App', 'App_name');
    $app_server = $json->getValue($loader->loaderFile('environment.json'), 'App', 'App_server');
    $app_asset = $json->getValue($loader->loaderFile('environment.json'), 'App', 'App_asset');
    $app_files = $json->getValue($loader->loaderFile('environment.json'), 'App', 'App_files');

    define('APP_NAME', $app_name);
    define('APP_SERVER', $app_server);
    define('APP_ASSET', $app_asset);
    define('APP_FILES', $app_files);

    // untuk mencetak nilai url
    function url($page) {
        $GLOBALS['response']->url($page);
    }

    function inc($section) {
        $GLOBALS['request']->inc($section);
    }

    function asset($filename) {
        $GLOBALS['response']->call($GLOBALS['request']->assets($filename));
    }

    function getFiles($filename){
        $GLOBALS['response']->call($GLOBALS['request']->getFiles($filename));
    }
    
    // routing
    $rout = new Routing();

    ?>