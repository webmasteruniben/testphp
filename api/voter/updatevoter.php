<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// files for decoding jwt will be here
// required to encode json web token
include_once '../config/core.php';
include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;
 
// database connection will be here
// files needed to connect to database
include_once '../config/database.php';
include_once '../objects/voter.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// instantiate user object
$voter = new Voter($db);
 
// retrieve given jwt here
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// get jwt
$jwt=isset($data->jwt) ? $data->jwt : "";
 
// decode jwt here
// if jwt is not empty

 
    // if decode succeed, show user details
    try {
 
        // decode jwt
        $decoded = JWT::decode($jwt, $key, array('HS256'));
 
        // set user property values here
        // set user property values
        $voter->firstname = $data->firstname;
        $voter->lastname = $data->lastname;
        $voter->email = $data->email;
        
        $voter->middlename = $data->middlename;
        $voter->department = $data->department;
        
        $voter->level = $data->level;
        $voter->password = $data->password;
       
        //$voter->created = $data->created;
        $voter->id = $decoded->data->id;
        
        // update user will be here
        // update the user record
        if($voter->updatevoter()){
            // regenerate jwt will be here
            // we need to re-generate jwt because user details might be different
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
                    "department" => $voter->department
                )
            );
            $jwt = JWT::encode($token, $key);
            
            // set response code
            http_response_code(200);

            
            // response in json format
            echo json_encode(
                    array(
                        "message" => "Voter was updated."
                    )
                );
        }
        
        // message if unable to update user
        else{
            // set response code
            http_response_code(401);
        
            // show error message
            echo json_encode(array("message" => "Unable to update Voter."));
        }
    }
 
    // catch failed decoding will be here
    // if decode fails, it means jwt is invalid
    catch (Exception $e){
    
        // set response code
        http_response_code(401);
    
        // show error message
        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage()
        ));
    }

?>
