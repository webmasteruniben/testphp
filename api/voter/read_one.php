<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/voter.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$voter = new Voter($db);

// set ID property of record to read
$voter->id = isset($_GET['id']) ? $_GET['id'] : die();
  
// read the details of product to be edited
$voter->readOne();
  
if($voter->email!=null){
    // create array
    $product_arr = array(
        "id" =>  $voter->id,
        "firstname" => $voter->firstname,
        "middlename" => $voter->middlename,
        "lastname" => $voter->lastname,
        "email" => $voter->email,
        "level" => $voter->level,
        "department" => $voter->department,
        "faculty" => $voter->faculty,
        "code" => $voter->code,
        "category" => $voter->category,
        "number" => $voter->number,
        "status" => $voter->status,
        "created" => $voter->created,
  
    );
  
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($product_arr);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user product does not exist
    echo json_encode(array("message" => "Voter does not exist."));
}
?>