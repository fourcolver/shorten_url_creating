<?php
	$DB_host = "localhost";
	$DB_user = "root";
	$DB_pass = "";
	$DB_name = "shorten_test";

	if(session_status() == PHP_SESSION_NONE){
	    //session has not started
	    session_start();
	}

	try
	{
	    $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
	    $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e)  
	{
	    echo $e->getMessage();
	}
	include_once 'class.crud.php';

	$crud = new crud($DB_con);

	// short code from get request
	if(isset($_GET["shorten"])) {
		try{
		    // Get origin long url from short url
		    $url = $crud->shortCodeToUrl($_GET["shorten"]);
		    
		    // Redirect to the original URL
		    header("Location: ".$url);
		    exit;
		}catch(Exception $e){
		    echo $e->getMessage();
		}
	}
	
?>