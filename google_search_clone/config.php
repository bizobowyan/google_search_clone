<?php 

	ob_start();

	try{


		$con = new PDO("mysql:dbname=google_search_clone;host=localhost", "root", "");

		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

		
	}
	catch(PDOException $e){
		echo "Connection Failed: " . $e->getMessage();
	}



?>