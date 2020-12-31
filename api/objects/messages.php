<?php
class Message{
  
    // database connection and table name
    private $conn;
    private $table_name = "messages";
  
    // object properties
    public $id;
    public $fullname;
    public $subject;
    public $message;
    public $created;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
function read(){
  
    // select all query
    $query = "SELECT
                p.id, p.fullname, p.subject, p.message, p.created
            FROM
                " . $this->table_name . " p
            ORDER BY
                p.created DESC";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // execute query
    $stmt->execute();
  
    return $stmt;
}

// create product
function create(){
  
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                fullname=:fullname, subject=:subject, message=:message, created=:created";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->fullname=htmlspecialchars(strip_tags($this->fullname));
    $this->subject=htmlspecialchars(strip_tags($this->subject));
    $this->message=htmlspecialchars(strip_tags($this->message));
    $this->created=htmlspecialchars(strip_tags($this->created));
  
    // bind values
    $stmt->bindParam(":fullname", $this->fullname);
    $stmt->bindParam(":subject", $this->subject);
    $stmt->bindParam(":message", $this->message);
    $stmt->bindParam(":created", $this->created);
  
    // execute query
    if($stmt->execute()){
        return true;
    }
  
    return false;
      
}

// used when filling up the update product form
function readOne(){
  
    // query to read single record
    $query = "SELECT
                p.id, p.fullname, p.subject, p.message, p.created
            FROM
                " . $this->table_name . " p
            WHERE
                p.id = ?
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
    $this->fullname = $row['fullname'];
    $this->subject = $row['subject'];
    $this->message = $row['message'];
    $this->created = $row['created'];
}



// update the product
function update(){
  
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                fullname = :fullname,
                subject = :subject,
                message = :message,
            WHERE
                id = :id";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->fullname=htmlspecialchars(strip_tags($this->fullname));
    $this->subject=htmlspecialchars(strip_tags($this->subject));
    $this->message=htmlspecialchars(strip_tags($this->message));
   
  
    // bind new values
    $stmt->bindParam(':fullname', $this->fullname);
    $stmt->bindParam(':subject', $this->subject);
    $stmt->bindParam(':message', $this->message);
    $stmt->bindParam(':id', $this->id);
  
    // execute the query
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

// search products
function search($keywords){
  
    // select all query
    $query = "SELECT
                p.id, p.fullname, p.subject, p.message, p.created
            FROM
                " . $this->table_name . " p
            WHERE
                p.fullname LIKE ? OR p.subject LIKE ? OR c.message LIKE ?
            ORDER BY
                p.created DESC";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $keywords=htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";
  
    // bind
    $stmt->bindParam(1, $keywords);
    $stmt->bindParam(2, $keywords);
    $stmt->bindParam(3, $keywords);
  
    // execute query
    $stmt->execute();
  
    return $stmt;
}

// read products with pagination
public function readPaging($from_record_num, $records_per_page){
  
    // select query
    $query = "SELECT
                p.id, p.fullname, p.subject, p.message, p.created
            FROM
                " . $this->table_name . " p
            ORDER BY p.created DESC
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

}
?>