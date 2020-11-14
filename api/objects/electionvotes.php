<?php

class Electionvote{

    //database connection and table name
    private $conn;
    private $table_name = "electionvotes";

    //object properties
    public $id;
    public $number;
    public $product_id;
    public $category_id;
    public $created;

    //constructor
    public function __construct($db){
        $this->conn = $db;
    }

    // used by select drop-down list
    public function readAll(){
        //select all data
        $query = "SELECT
                    id, number, product_id, category_id, created
                FROM
                    " . $this->table_name . "
                ORDER BY
                    number";
  
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
  
        return $stmt;
    }

    // used by select drop-down list
    public function read(){
    
            //select all data
            $query = "SELECT
            id, number, product_id, category_id, created
        FROM
            " . $this->table_name . "
        ORDER BY
            number";
    
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
    
        return $stmt;
    }


    // create electionvote
    function create(){
    
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    number=:number, product_id=:product_id, category_id=:category_id, created=:created";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->number=htmlspecialchars(strip_tags($this->number));
        $this->product_id=htmlspecialchars(strip_tags($this->product_id));
        $this->category_id=htmlspecialchars(strip_tags($this->category_id));
        $this->created=htmlspecialchars(strip_tags($this->created));
    
        // bind values
        $stmt->bindParam(":number", $this->number);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":created", $this->created);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }

}


?>