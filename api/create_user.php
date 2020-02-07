<?php 
	//We should set headers on this file so it will only accept JSON data
	header("Access-Control-Allow-Origin: http://localhost/rest_api_example/");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



	include_once 'config/database.php';
	include_once 'objects/user.php';

	//Get DB connection
	$database = new Database();
	$db = $database->getConnection();

	$user = new User($db);

	//Get posted data
	$data = json_decode(file_get_contents("php://input"));

	//We need to assign the submitted data on the object properties
	//we set product property values
	$user->firstname = $data->firstname;
	$user->lastname = $data->lastname;
	$user->email = $data->email;
	$user->password = $data->password;


	//create user based on our objects
	if (!empty($user->firstname) && !empty($user->lastname) && !empty($user->email) && !empty($user->password)) {
		
		$user->create();

		http_response_code(200);
		echo json_encode(array("mesage" => "User Created Successfully"));
	} else {

		http_response_code(400);
		echo json_encode(array("mesage" => "Fail To Create User"));
	}







 ?>