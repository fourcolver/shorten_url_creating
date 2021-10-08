<?php
	require 'dbconfig.php';

	$api_url_list = $crud->getTopUsedUrlApi();
	echo json_encode(array("response_code" => "200",  "response_content" => $api_url_list));

?>