<?php

namespace Core;

//view 

class View
{

	//render a view file
	
	public static function render($view, $args = [])
	{
		extract($args, EXTR_SKIP);
		$file = "../App/Views/$view"; //relative to Core directory
		
		if(is_readable($file)){
			require $file;
		}else{
			echo "$file not found";
		}
	}
	
	/**
	*Render a view template using TWIG
	*@param string $template The template file
	*@param array $args Associative array of data ti display in the view (optional)
	*return void
	
	*/
	
	public static function renderTemplate($template, $args =[])
	{
		static $twig = null;
		if($twig ===null)
		{
			$loader = new \Twig_Loader_Filesystem('../App/Views');
			$twig = new \Twig_Environment($loader);
		}
		echo $twig->render($template);
	}
	
}