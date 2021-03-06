<?php
// required header
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/electionvotes.php';
  
// instantiate database and category object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$electionvote = new Electionvote($db);
$electionvote->number = isset($_GET['id']) ? $_GET['id'] : die();
// query categorys
$stmt = $electionvote->readVotes();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // products array
    $electionvotes_arr=array();
    $electionvotes_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $electionvote_item=array(
            "id" => $id,
            "number" => $number,
            "faculty" => $faculty,
            "department" => $department,
            "gender" => $gender,
            "position" => $position,
            "product_id" => $product_id,
            "category_id" => $category_id
        );
  
        array_push($electionvotes_arr["records"], $electionvote_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show categories data in json format
    echo json_encode($electionvotes_arr);
}
  
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no categories found
    echo json_encode(
        array("message" => "No election votes found.")
    );
}
?>