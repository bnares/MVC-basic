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
						$match[$key] = $param; //matchh to nie jest to samo co match z pierwszej petli foreach jak widac
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
		
		if($this->match($url))
		{
			$controller=$this->params['controller'];
			$controller = $this -> convertToStudlyCaps($controller);
			$controller = "App\Controllers\\$controller";
			if(class_exists($controller))
			{
				$controller_object = new $controller();
				$action = $this->params['action'];
				$action = $this ->convertToCamelCase($action);
				if(is_callable([$controller_object, $action]))
				{
					$controller_object->$action();
					//echo "<br>Method $action (in controller $controller)";
					//echo "<br>".$_SERVER['QUERY_STRING']." , method: ".$action;
				}
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
	 
	
}