<?php 

	//We should set headers on this file so it will only accept JSON data
	header("Access-Control-Allow-Origin: http://localhost/rest_api_example/");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



	//include our library
	include_once 'config/core.php';
	include_once 'libs/php_jwt/src/BeforeValidException.php';
	include_once 'libs/php_jwt/src/ExpiredException.php';
	include_once 'libs/php_jwt/src/SignatureInvalidException.php';
	include_once 'libs/php_jwt/src/JWT.php';
	
	use \Firebase\JWT\JWT;


	//file needed for DB connection
	include_once 'config/database.php';
	include_once 'objects/user.php';


	$database = new Database();
	$db = $database->getConnection();

	$user = new User($db);

	//Retrieve JWT
	$data = json_decode(file_get_contents("php://input"));

	$user->id = $data->id;


	if ($user->delete()) {
		
			//set response
			http_response_code(200);
			echo json_encode(array(
				"message" => "User Deleted Successfully"
			));

	} else {

		http_response_code(401);
		echo json_encode(array(
			"message" => "Cannot Delete User"
		));
	}



 ?>