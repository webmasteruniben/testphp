<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../config/database.php';
  
// instantiate elections object
include_once '../objects/electionvotes.php';
  
$database = new Database();
$db = $database->getConnection();
  
$electionvote = new Electionvote($db);


// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if(
    !empty($data->number) &&
    !empty($data->category_id) &&
    !empty($data->product_id) 
){
  
    // set product property values
    $electionvote->number = $data->number;
    $electionvote->faculty = $data->faculty;
    $electionvote->department = $data->department;
    $electionvote->gender = $data->gender;
    $electionvote->position = $data->position;
    $electionvote->product_id = $data->product_id;
    $electionvote->category_id = $data->category_id;
    $electionvote->created = date('Y-m-d H:i:s');
  
    // create the product
    if($electionvote->voteExists()){
        // set response code - 400 bad request
        http_response_code(400);
    
        // tell the user
        echo json_encode(array("message" => "You have already Voted."));
    } else {
        if($electionvote->create()){
    
            // set response code - 201 created
            http_response_code(201);
    
            // tell the user
            echo json_encode(array("message" => "Election Vote was created."));
        }
    
        // if unable to create the product, tell the user
        else{
    
            // set response code - 503 service unavailable
            http_response_code(503);
    
            // tell the user
            echo json_encode(array("message" => "Unable to create election vote."));
        }
    }
   
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to create election vote. Data is incomplete."));
}
?>