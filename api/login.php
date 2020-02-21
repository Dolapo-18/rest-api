<?php 
	//We should set headers on this file so it will only accept JSON data
	header("Access-Control-Allow-Origin: http://localhost/rest_api_example/");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


	include_once 'config/database.php';
	include_once 'objects/user.php';

	//include our library
	include_once 'config/core.php';
	include_once 'libs/php_jwt/src/BeforeValidException.php';
	include_once 'libs/php_jwt/src/ExpiredException.php';
	include_once 'libs/php_jwt/src/SignatureInvalidException.php';
	include_once 'libs/php_jwt/src/JWT.php';

	use \Firebase\JWT\JWT;


	//Get DB connection
	$database = new Database();
	$db = $database->getConnection();

	$user = new User($db);

	//get posted data
	$data = json_decode(file_get_contents("php://input"));

	//set propertt values
	$user->email = $data->email;
	$email_exists = $user->emailExists($user->email);

	//if email exist and password is correct
	if ($email_exists && password_verify($data->password, $user->password)) {
		
		$token = array(
			"iss" => $iss,
			"aud" => $aud,
			"iat" => $iat,
			"nbf" => $nbf,
			"data" => array(
				"id" => $user->id,
				"firstname" => $user->firstname,
				"lastname" => $user->lastname,
				"email" => $user->email

				));

		//response code
		http_response_code(200);

		//generate jwt
		$jwt = JWT::encode($token, $key);
		echo json_encode(
				array(
					"message" => "Successful Login",
					"jwt" => $jwt
				));
			
			
	} else {

		//response code - unauthorized
		http_response_code(401);

		echo json_encode(array("message" => "Login Failed"));

	}
	


 ?>