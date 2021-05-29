<?php
namespace App\Controllers\Admin;

//user admin controller

class Users extends \Core\Controller 
{
	protected function before()
	{
		//Make sure admin user is logged for example
		//return fasle
	}
	
	//show the index page 
	public function indexAction()
	{
		echo 'User admin index';
	}
	
}

?>