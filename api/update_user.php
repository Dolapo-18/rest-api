<?php 

	//We should set headers on this file so it will only accept JSON data
	header("Access-Control-Allow-Origin: *");
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

	$jwt = isset($data->jwt) ? $data->jwt : "";

	//if JWT exists, set user property
	if ($jwt) {
		
		try {
			
			$decoded = JWT::decode($jwt, $key, array('HS256'));
			//set user property value
			$user->firstname = $data->firstname;
			$user->lastname = $data->lastname;
			$user->email = $data->email;
			$user->password = $data->password;
			$user->id = $decoded->data->id;

			//update record
			if ($user->update()) {
				
				//regenerate JWT
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

				//generate new JWT
				$jwt = JWT::encode($token, $key);

				//set response
				http_response_code(200);
				echo json_encode(array(
					"message" => "User Updated Successfully",
					"jwt" => $jwt
				));

			} else {

				http_response_code(401);
				echo json_encode(array(
					"message" => "Unable to update user"
				));
			}


		} catch (Exception $e) {
			
			http_response_code(401);
			echo json_encode(array(
						"message" => "Access Denied",
						"error" => $e->getMessage()

					));
		}

		//show error if JWT is empty
	} else {

		http_response_code(401);
		echo json_encode(array("message" => "Access Denied - Token Empty"));
	}





 ?>