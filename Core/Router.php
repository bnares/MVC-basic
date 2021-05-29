<?php

namespace Core;

/**
 *ROuter
 *
 *PHP version jakas
 */
 
class Router
{
	/**
     * Associative array of routes (the routing table)
     * @var array
     */
	 protected $routes= [];
	 
	 /**
	 *Parameters from the matched route
	 *@var array 
	 */
	 protected $params = [];
	 
	 
	 /**
     * Add a route to the routing table
     *
     * @param string $route  The route URL
     * @param array  $params Parameters (controller, action, etc.)
     *
     * @return void
     */
	 
	 public function add($route, $params= [])
	 {
		
		// Convert the route to a regular expression: escape forward slashes
		$route = preg_replace('/\//', '\\/', $route);
		// Convert variables e.g. {controller}
		$route = preg_replace('/\{([a-z]+)\}/', '(?<\1>[a-z-]+)', $route);
		// Convert variables with custom regular expressions e.g. {id:\d+}
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
		// Add start and end delimiters, and case insensitive flag
		$route = '/^'.$route.'$/i';
		
		$this->routes[$route] = $params;
	 }
	 
	 /**
     * Get all the routes from the routing table
     *
     * @return array
     */
	 
	 
	 public function getRoutes()
	 {
		return $this ->routes; 
	 }
	 
	 /**Match thee route to the routes in the routing table setting the $params property if route i found
	 *
	 *@param string $url The route URL
	 *
	 *@return boolean true if match found, false otherwise
	 */
	 
	 public function match($url)
	 {
		
		
		// Match to the fixed URL format /controller/action
        //$reg_exp = "/^(?P<controller>[a-z-]+)\/(?P<action>[a-z-]+)$/";
		
		foreach($this ->routes as $route=>$match)
		{
			if(preg_match($route, $url, $matches))
			{
				foreach($matches as $key=>$param)
				{
					if(is_string($key))
					{
						$match[$key] = $param; //match to jest to samo co match z pierwszej petli foreach jak widac
					}
				}
				$this ->params = $match;
				return true;
			}
		}
		return false;
		 
	 }
	 
	/**
	*Get the currently matched parameters
	*
	*@return array
	*/
	public function getParams()
	{
		return $this ->params;
	}
	
	
	public function dispatch($url)
	{
		
		$url = $this -> removeQueryStringVariables($url);
		if($this->match($url))
		{
			$controller=$this->params['controller'];
			$controller = $this -> convertToStudlyCaps($controller);
			//$controller = "App\Controllers\\$controller";  // the "//" before $controller menas the names space for this class is not in Core namespace where this file (Router.php) is existing but look for this function in App\Controllers namespace
			$controller = $this->getNamespace().$controller;
			if(class_exists($controller))
			{
				$controller_object = new $controller($this->params);
				$action = $this->params['action'];
				$action = $this ->convertToCamelCase($action);
				
				if(preg_match('/action$/i', $action)==0)  //dzieki temu z reki nie mozna ominac sobie __call metod ktora dodaje suffix action i loguje dalej to nam zapobiega wpisaniu z reki na koncu action dzieki temu trzbea przejsc przez ta linijke
				{
					$controller_object->$action();
				}
				
				//if(is_callable([$controller_object, $action])) wersja przed preg_match('/action$/i')
				//{
					//$controller_object->$action();
					//echo "<br>Method $action (in controller $controller)";
					//echo "<br>".$_SERVER['QUERY_STRING']." , method: ".$action;
				//}
				else{
					echo "<br>No method has been found";
					echo "<br>Method $action (in controller $controller) not found";
					//echo "<br>".$_SERVER['QUERY_STRING']." ".$action;
				}
			}
			else{
				echo "<br>No class has been found";
			}
		}
		
		else{
			echo "<br>No route has benn found ".$url;
		}
	}
	
	
	//convert words with '-' inside to words with spaces
	protected function convertToStudlyCaps($string)
	{
		return str_replace(' ','',ucwords(str_replace('-',' ',$string)));
	}
	
	protected function convertToCamelCase($string)
	{
		//$string = $this->convertToStudlyCaps($string);
		return lcfirst($this->convertToStudlyCaps($string));
		//return $string;
	}
	
	
	protected function removeQueryStringVariables($url)
	{
		if($url !=''){
			$parts = explode('&', $url,2);
			if(strpos($parts[0], '=')===false)
			{
				$url = $parts[0];
				
			}
			else
			{
				$url ='';
			}
		}
		return $url;
	}
	
	protected function getNamespace()
	{
		$namespace = 'App\Controllers\\';
		if(array_key_exists('namespace', $this->params)){
			$namespace .= $this->params['namespace'].'\\';
		}
		return $namespace;
		
	}
	 
	
}