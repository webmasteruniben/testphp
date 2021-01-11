<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/positions.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$position = new Position($db);
  
// set ID property of record to read
$position->id = isset($_GET['id']) ? $_GET['id'] : die();
  
// read the details of product to be edited
$position->readOne();
  
if($position->position!=null){
    // create array
    $product_arr = array(
        "id" =>  $position->id,
        "position" => $position->position,
        "description" => $position->description
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
    echo json_encode(array("message" => "Position does not exist."));
}
?>