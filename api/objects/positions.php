<?php
class Position{
  
    // database connection and table name
    private $conn;
    private $table_name = "positions";
  
    // object properties
    public $id;
    public $position;
    public $description;
    public $created;

  
    public function __construct($db){
        $this->conn = $db;
    }
  
    // used by select drop-down list
    public function readAll(){
        //select all data
        $query = "SELECT
                    id, position, description
                FROM
                    " . $this->table_name . "
                ORDER BY
                    position";
  
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
  
        return $stmt;
    }

    // used by select drop-down list
public function read(){
  
    //select all data
    $query = "SELECT
                id, position , description
            FROM
                " . $this->table_name . "
            ORDER BY
                position ";
  
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
  
    return $stmt;
}


// create categories
function create(){
  
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                position=:position, description=:description, created=:created";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->position=htmlspecialchars(strip_tags($this->position));
    $this->description=htmlspecialchars(strip_tags($this->description));
    $this->created=htmlspecialchars(strip_tags($this->created));
  
    // bind values
    $stmt->bindParam(":position", $this->position);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":created", $this->created);
  
    // execute query
    if($stmt->execute()){
        return true;
    }
  
    return false;
      
}

// delete the product
function delete(){
  
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->id));
  
    // bind id of record to delete
    $stmt->bindParam(1, $this->id);
  
    // execute query
    if($stmt->execute()){
        return true;
    }
  
    return false;
}


  

// used when filling up the update election form
function readOne(){
  
    // query to read single record
    $query = "SELECT
                position , description
            FROM
                " . $this->table_name . " 
            WHERE
                id = ?
            LIMIT
                0,1";
  
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
  
    // bind id of product to be updated
    $stmt->bindParam(1, $this->id);
  
    // execute query
    $stmt->execute();
  
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
    // set values to object properties
    $this->position = $row['position'];
    $this->description = $row['description'];
   
}

// read products with pagination
public function readPaging($from_record_num, $records_per_page){
  
    // select query
    $query = "SELECT
                position, id, description, created
            FROM
                " . $this->table_name . " 
            ORDER BY created DESC
            LIMIT ?, ?";
  
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
  
    // bind variable values
    $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
    $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
  
    // execute query
    $stmt->execute();
  
    // return values from database
    return $stmt;
}

// used for paging products
public function count(){
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
  
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
    return $row['total_rows'];
}

// search products
function search($keywords){
  
    // select all query
    $query = "SELECT
                position,id, description, created
            FROM
                " . $this->table_name . " 
            WHERE
                position LIKE ? OR description LIKE ? 
            ORDER BY
                created DESC";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $keywords=htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";
  
    // bind
    $stmt->bindParam(1, $keywords);
    $stmt->bindParam(2, $keywords);
    //$stmt->bindParam(3, $keywords);
  
    // execute query
    $stmt->execute();
  
    return $stmt;
}

// update the product
function update(){
  
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                position  = :position,
                description = :description
            WHERE
                id = :id";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->position=htmlspecialchars(strip_tags($this->position));
    $this->description=htmlspecialchars(strip_tags($this->description));
    $this->id=htmlspecialchars(strip_tags($this->id));
  
    // bind new values
    $stmt->bindParam(':position', $this->position);
    $stmt->bindParam(':description', $this->description);
    $stmt->bindParam(':id', $this->id);
  
    // execute the query
    if($stmt->execute()){
        return true;
    }
  
    return false;
}



}
?>