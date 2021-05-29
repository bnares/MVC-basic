<?php

namespace App\Models;

use PDO;

//post model


class Post extends \Core\Model
{
	
	//get all the posts as a associate array
	// return arry
	
	public static function getAll()
	{
		//$host = "localhost";
		//$dbname = "mvc-youtube";
		//$username = "root";
		//$password = "";
		
		try{
			//$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",
            //             $username, $password);
			
			$db = Post::getDB();
			
			$stm = $db->query('SELECT id, title, content FROM posts
                                ORDER BY created_at');
			$results = $stm->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		} catch(PDOException $e){
			echo $e->getMessage();
		}
	}
}


?>