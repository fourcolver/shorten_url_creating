<?php
	require 'dbconfig.php';
	if($_POST['to_shorten']) {
		$origin_url = $_POST['original_url'];
		$short_code = $crud->originToShorten($origin_url);
		if(isset($short_code["error"])) {
			$_SESSION['error'] = "valid";
			$_SESSION['msg'] = $short_code['content'];
		}
		else {
			$_SESSION['success'] = "valid";
			$_SESSION['msg'] = $short_code['content'];
		}
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
?>