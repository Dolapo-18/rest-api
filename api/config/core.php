<?php 

	//show error reporting
	error_reporting(E_ALL);

	//variables for jwt
	$key = "my_secret"; //this is used to sign the JWT payload
	$iss = "localhost";	//issuer application
	$aud = "the_audience"; //the recepient of the JWT
	$iat = time(); //time JWT was issued
	$nbf = $iat + 10; //not valid before
	$exp = $nbf + 60; //expiry

 ?>