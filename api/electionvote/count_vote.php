<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");

  
// database connection will be here
// include database and object files
include_once '../config/database.php';
include_once '../objects/electionvotes.php';
  
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$electionvote = new Electionvote($db);
$electionvote->category_id = isset($_GET['id']) ? $_GET['id'] : die();
// read products will be here
// query products
$stmt = $electionvote->countVotes();
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
            "votes" => $votes,
            "product_id" => $product_id,
            "candidate" => $candidate,
            "price" => $price,
            "profile_pic" => $profile_pic,
            "category_id" => $category_id,
            "election" => $election
        );
  
        array_push($electionvotes_arr["records"], $electionvote_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show products data in json format
    echo json_encode($electionvotes_arr);
} else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "No Votes found.")
    );
}

?>