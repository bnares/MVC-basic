<?php

namespace Core;

/**
*Base Controller
*
*PHP version 8
*/

abstract class Controller
{
	/**
	*Parameters from the matched route
	*@var array
	*/
	protected $route_params =[];
	/**
	*Class constructor
	*
	*$param array $route_params Parameters from the route 
	*
	**@return void
	*/
	public function __construct($route_params)
	{
		$this->route_params=$route_params;
	}
	
	/**
	
	__call method is working when compilator cant find a method in samo class or the calling method is private or protected
	
	implementing the magic __call method to deliberetly call wrong function force __call method to work and use some method before the actual method or/and after actual method this is useful to register or checking if the user have autorisation to see this page
	*/
	
	public function __call($name, $args)
	{
		$method = $name."Action";   //all the method in class are going to have 'Action' attachemnt in the end  so that way at first the function cant be find and __call method i moving in
		if(method_exists($this, $method)){
			if($this ->before() !==false){ //before methosd works before we use the main method from call_user_func_array
				call_user_func_array([$this, $method],$args); //method which are doing callbac after the firs faila
				$this->after();
			}
		}
		else{
			echo "Method $method not found in controller ".get_class($this);
		}
	}
	
	//before filter called before an action method 
	protected function before()
	{
		
	}
	//after filter called after action method
	protected function after()
	{
		
	}
}