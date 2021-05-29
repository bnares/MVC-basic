<?php

//echo "Requested URL = ".$_SERVER['QUERY_STRING'];


/**
 * Routing
 */
//require '../Core/Router.php';

// Require the controller class
//require '../App/Controllers/Posts.php';

/**
--------------------------------------------------poczatek

spl_autoload_register(function ($class){
	$root = dirname(__DIR__); //get the parent directory
	$file = $root.'/'.str_replace('\\','/', $class).'.php';
	if(is_readable($file)){
		require $root.'/'.str_replace('\\','/',$class).'.php';
	}
});

$router = new \Core\Router();

//echo get_class($router);

//Add the routes 

$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router -> add('admin/{controller}/{action}', ['namespace' =>'Admin']);

$router->dispatch($_SERVER['QUERY_STRING']);
---------------------------------------------------------------------koniec

*/

/*
//display the routing table
//echo '<pre>';
//var_dump($router->getRoutes());
//echo '</pre>';

//Match the requested route

// Display the routing table
echo '<pre>';
//var_dump($router->getRoutes());
echo htmlspecialchars(print_r($router->getRoutes(), true));
echo '</pre>';


$url = $_SERVER['QUERY_STRING'];

if($router->match($url))
{
	echo '<pre>';
	var_dump($router->getParams());
	echo '</pre>';
}
else
{
	echo 'No route found for URL: '.$url;
}

*/




/**
 * Front controller
 *
 * PHP version 5.4
 */

/**
 * Twig
 */
//require_once dirname(__DIR__) . '/vendor/twig/twig/lib/Twig/Autoloader.php';

require '../vendor/autoload.php';
Twig_Autoloader::register();


/**
 * Autoloader
 -------------------------------------poczatek
 */
spl_autoload_register(function ($class) {
    $root = dirname(__DIR__);   // get the parent directory
    $file = $root . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_readable($file)) {
        require $root . '/' . str_replace('\\', '/', $class) . '.php';
    }
});




/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);
    
$router->dispatch($_SERVER['QUERY_STRING']);




?>