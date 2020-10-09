<?php
// required headers
header("Access-Control-Allow-Origin: https://testphp.uniben.edu/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// database connection will be here
// files needed to connect to database
include_once '../config/database.php';
include_once '../objects/voter.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// instantiate user object
$voter = new Voter($db);
 
// check email existence here
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set product property values
$voter->email = $data->email;
$email_exists = $voter->emailExists();
 
// files for jwt will be here

// generate json web token
include_once '../config/core.php';
include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;
 
// generate jwt will be here
// check if email exists and if password is correct
if($email_exists && password_verify($data->password, $voter->password)){
 
    $token = array(
       "iss" => $iss,
       "aud" => $aud,
       "iat" => $iat,
       "nbf" => $nbf,
       "data" => array(
           "id" => $voter->id,
           "firstname" => $voter->firstname,
           "lastname" => $voter->lastname,
           "middlename" => $voter->middlename,
           "email" => $voter->email,
           "level" => $voter->level,
           "department" => $voter->department,
           "faculty" => $voter->faculty,
           "number" => $voter->number,
           "code" => $voter->code,
           "category" => $voter->category,
           "election" => $voter->election,
           "status" => $voter->status
       )
    );
 
    // set response code
    http_response_code(200);
 
    // generate jwt
    $jwt = JWT::encode($token, $key);
    echo json_encode(
            array(
                "message" => "Successful login.",
                "jwt" => $jwt
            )
        );
 
}
 
// login failed will be here
// login failed
else{
 
    // set response code
    http_response_code(401);
 
    // tell the user login failed
    echo json_encode(array("message" => "Login failed."));
}
?>