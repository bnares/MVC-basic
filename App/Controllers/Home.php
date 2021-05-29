<?php

namespace App\Controllers;

use \Core\View;

/**
 * Home controller
 *
 * PHP version 5.4
 */
class Home extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
	   /**
	   echo 'Hello from the index action in the Home controller!';
		View::render('Home/index.php', [
		'name'=>'Piotr',
		'colours'=>['red', 'green', 'blue']
		]);
		*/
		
		View::render('Home/index.php', [
		'name'=>'Piotr',
		'colours'=>['red', 'green', 'blue']
		]);
		
    }
	
	protected function before()
	{
		echo "{before}";
	}
	
	protected function after()
	{
			echo "{after}";
	}
    
}
