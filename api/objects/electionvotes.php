<?php

class Electionvote{

    //database connection and table name
    private $conn;
    private $table_name = "electionvotes";

    //object properties
    public $id;
    public $number;
    public $faculty;
    public $department;
    public $gender;
    public $position;
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
                    id, number, product_id, faculty, department, gender, position, category_id, created
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
            id, number, faculty, department, gender, position, product_id, category_id, created
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
                    number=:number, faculty=:faculty, department=:department, gender=:gender, position=:position, product_id=:product_id, category_id=:category_id, created=:created";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->number=htmlspecialchars(strip_tags($this->number));
        $this->faculty=htmlspecialchars(strip_tags($this->faculty));
        $this->department=htmlspecialchars(strip_tags($this->department));
        $this->gender=htmlspecialchars(strip_tags($this->gender));
        $this->position=htmlspecialchars(strip_tags($this->position));
        $this->product_id=htmlspecialchars(strip_tags($this->product_id));
        $this->category_id=htmlspecialchars(strip_tags($this->category_id));
        $this->created=htmlspecialchars(strip_tags($this->created));
    
        // bind values
        $stmt->bindParam(":number", $this->number);
        $stmt->bindParam(":faculty", $this->faculty);
        $stmt->bindParam(":department", $this->department);
        $stmt->bindParam(":gender", $this->gender);
        $stmt->bindParam(":position", $this->position);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":created", $this->created);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }

    function voteExists(){
 
        // query to check if email exists
        $query = "SELECT id, number, faculty, department, gender, position, product_id, category_id
                FROM " . $this->table_name . "
                WHERE number = ? AND position = ?";
     
        // prepare the query
        $stmt = $this->conn->prepare( $query );
     
        // sanitize
        $this->number=htmlspecialchars(strip_tags($this->number));
        $this->position=htmlspecialchars(strip_tags($this->position));

        // bind given email value
        $stmt->bindParam(1, $this->number);
        $stmt->bindParam(2, $this->position);
     
        // execute the query
        $stmt->execute();
     
        // get number of rows
        $num = $stmt->rowCount();
     
        // if email exists, assign values to object properties for easy access and use for php sessions
        if($num>0){
     
            // get record details / values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
            // assign values to object properties
            $this->id = $row['id'];
            $this->number = $row['number'];
            $this->faculty = $row['faculty'];
            $this->department = $row['department'];
            $this->gender = $row['gender'];
            $this->position = $row['position'];
            $this->product_id = $row['product_id'];
            $this->category_id = $row['category_id'];
     
            // return true because vote exists in the database
            return true;
        }
     
        // return false if vote does not exist in the database
        return false;
    }

     // used when filling up the update product form
    function countVotes(){
    
        //$this->category_id = 19;

    // select all query
    $query = "SELECT
        COUNT(number) AS votes, product_id, p.name AS candidate, price, e.position, profile_pic, e.category_id, c.name AS election
        FROM
        " . $this->table_name . " e
        JOIN
        products p
                ON p.id = e.product_id
        JOIN
        categories c
                ON c.id=e.category_id
        WHERE
            e.category_id = " . $this->category_id . "
        GROUP BY
        product_id";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    
    }

     // used when filling up the update product form
     function countAccredited(){
    
        //$this->category_id = 19;

    // select all query
    $query = "SELECT
        COUNT(number) AS accreditedvoters
        FROM
        voters
        WHERE
            status = 'ACCREDITTED'";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    
    }

    // used when filling up the update product form
    function countNotAccredited(){
    
        //$this->category_id = 19;

    // select all query
    $query = "SELECT
        COUNT(number) AS notaccreditedvoters
        FROM
        voters
        WHERE
            status = 'NOT ACCREDITTED' 
        AND
        product_id";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    
    }

     // used when filling up the update product form
     function countVoted(){
    
        //$this->category_id = 19;

    // select all query
    $query = "SELECT
        COUNT(number) AS votedvoters
        FROM
        voters
        WHERE
            status = 'VOTED' 
        AND
        product_id";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    
    }

    function readVotes(){
     //select all data
     $query = "SELECT
        id, number, faculty, department, gender, position, product_id, category_id, created
    FROM
        " . $this->table_name . "
     WHERE
     number = '" . $this->number . "'
    ORDER BY
        number";

    $stmt = $this->conn->prepare( $query );
    $stmt->execute();

    return $stmt;
    }

}


?>