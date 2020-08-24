<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
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
 
// instantiate product object
$voter = new Voter($db);
 
// submitted data will be here
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set product property values
$voter->firstname = $data->firstname;
$voter->lastname = $data->lastname;
$voter->middlename = $data->middlename;
$voter->email = $data->email;
$voter->department = $data->department;
$voter->faculty = $data->faculty;
$voter->level = $data->level;
$voter->number = $data->number;
$voter->code = $data->code;
$voter->category = $data->category;
$voter->password = $data->password;
$voter->status = $data->status;
$voter->created = date('Y-m-d H:i:s');
 
// use the create() method here
// create the user
if(
    !empty($voter->firstname) &&
    !empty($voter->lastname) &&
    !empty($voter->number) &&
    !empty($voter->code) &&
    !empty($voter->email) &&
    !empty($voter->password) &&
    $voter->create()
){
 
    // set response code
    http_response_code(200);
 
    // display message: user was created
    echo json_encode(array("message" => "Voter was created."));
}
 
// message if unable to create user
else{
 
    // set response code
    http_response_code(400);
 
    // display message: unable to create user
    echo json_encode(array("message" => "Unable to create voter."));
}
?>