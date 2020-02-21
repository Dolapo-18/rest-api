<?php 

	header("Access-Control-Allow-Origin: http://localhost/rest_api_example/");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


	//files for decoding
	include_once 'config/core.php';
	include_once 'libs/php_jwt/src/BeforeValidException.php';
	include_once 'libs/php_jwt/src/ExpiredException.php';
	include_once 'libs/php_jwt/src/SignatureInvalidException.php';
	include_once 'libs/php_jwt/src/JWT.php';

	use \Firebase\JWT\JWT;


	//retrive JWT here
	$data = json_decode(file_get_contents("php://input"));

	//get jwt
	$jwt = isset($data->jwt) ? $data->jwt : "";

	//decode JWT if it exists
	if ($jwt) {
		
		try {
			
			$decoded = JWT::decode($jwt, $key, array('HS256'));

			//response
			http_response_code(200);

			echo json_encode(array(
						"message" => "Access Granted",
						"data" => $decoded->data
					));

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
		
		echo json_encode(array("message" => "Access Denied"));
	}

 ?>