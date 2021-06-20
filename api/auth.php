<?php
header("Access-Control-Allow-Origin: http://test.ru/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once('includes/config.php');
include_once('objects/user.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
	
	$user = new User($db);
	$data = json_decode(file_get_contents("php://input"));

	$user->login = $data->login;
	$user->password = $data->password;
	$data = $user->auth();

	if(isset($data['id'])){
		$_SESSION['user'] = $data['login'];
	    echo json_encode(
		    array(
		        "login" => true,
		    )
		);
	}else{
		 http_response_code(404);
		 echo json_encode(array("message" => "error"));
	}
	exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    session_destroy();
    http_response_code(200);
    echo json_encode(array("txt" => "Success"));
    exit();
}