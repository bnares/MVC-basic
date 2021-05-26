<?php

//echo "Requested URL = ".$_SERVER['QUERY_STRING'];


/**
 * Routing
 */
//require '../Core/Router.php';

// Require the controller class
//require '../App/Controllers/Posts.php';

spl_autoload_register(function ($class){
	$root = dirname(__DIR__); //get the parent directory
	$file = $root.'/'.str_replace('\\','/', $class).'.php';
	if(is_readable($file)){
		require $root.'/'.str_replace('\\','/',$class).'.php';
	}
});

$router = new Core\Router();

//echo get_class($router);

//Add the routes 

$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');


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

$router->dispatch($_SERVER['QUERY_STRING']);

?>