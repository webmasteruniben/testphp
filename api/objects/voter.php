<?php
// 'voter' object
class Voter{
 
    // database connection and table name
    private $conn;
    private $table_name = "voters";
 
    // object properties
    public $id;
    public $firstname;
    public $lastname;
    public $created;
    public $password;
    public $status;
    public $middlename;
    public $level;
    public $department;
    public $faculty;
    public $category;
    public $election;
    public $number;
    public $email;
    public $code;
 
    // constructor
    public function __construct($db){
        $this->conn = $db;
    }
 
// create() method will be here
// create new user record
function create(){
 
    // insert query
    $query = "INSERT INTO " . $this->table_name . "
            SET
                firstname = :firstname,
                lastname = :lastname,
                middlename = :middlename,
                level = :level,
                department = :department,
                faculty = :faculty,
                category = :category,
                election = :election,
                number = :number,
                email = :email,
                code = :code,
                password = :password,
                status = :status,
                created = :created";
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->firstname=htmlspecialchars(strip_tags($this->firstname));
    $this->lastname=htmlspecialchars(strip_tags($this->lastname));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->middlename=htmlspecialchars(strip_tags($this->middlename));
    $this->level=htmlspecialchars(strip_tags($this->level));
    $this->department=htmlspecialchars(strip_tags($this->department));
    $this->faculty=htmlspecialchars(strip_tags($this->faculty));
    $this->category=htmlspecialchars(strip_tags($this->category));
    $this->election=htmlspecialchars(strip_tags($this->election));
    $this->number=htmlspecialchars(strip_tags($this->number));
    $this->code=htmlspecialchars(strip_tags($this->code));
    $this->status=htmlspecialchars(strip_tags($this->status));
    $this->created=htmlspecialchars(strip_tags($this->created));
    $this->password=htmlspecialchars(strip_tags($this->password));
 
    // bind the values
    $stmt->bindParam(':firstname', $this->firstname);
    $stmt->bindParam(':lastname', $this->lastname);
    $stmt->bindParam(':email', $this->email);
    $stmt->bindParam(':middlename', $this->middlename);
    $stmt->bindParam(':level', $this->level);
    $stmt->bindParam(':department', $this->department);
    $stmt->bindParam(':faculty', $this->faculty);
    $stmt->bindParam(':category', $this->category);
    $stmt->bindParam(':election', $this->election);
    $stmt->bindParam(':number', $this->number);
    $stmt->bindParam(':code', $this->code);
    $stmt->bindParam(':status', $this->status);
    $stmt->bindParam(':created', $this->created);
   
    

    // hash the password before saving to database
    $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
    $stmt->bindParam(':password', $password_hash);
 
    // execute the query, also check if query was successful
    if($stmt->execute()){
        return true;
    }
 
    return false;
}
 
// emailExists() method will be here
// check if given email exist in the database
function emailExists(){
 
    // query to check if email exists
    $query = "SELECT id, firstname, lastname, middlename, email, level, department, faculty, category, election, number, code, status, password
            FROM " . $this->table_name . "
            WHERE email = ?
            LIMIT 0,1";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
 
    // sanitize
    $this->email=htmlspecialchars(strip_tags($this->email));
 
    // bind given email value
    $stmt->bindParam(1, $this->email);
 
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
        $this->firstname = $row['firstname'];
        $this->lastname = $row['lastname'];
        $this->email = $row['email'];
        $this->middlename = $row['middlename'];
        $this->level = $row['level'];
        $this->department = $row['department'];
        $this->faculty = $row['faculty'];
        $this->category = $row['category'];
        $this->election = $row['election'];
        $this->number = $row['number'];
        $this->code = $row['code'];
        $this->status = $row['status'];
        $this->password = $row['password'];
 
        // return true because email exists in the database
        return true;
    }
 
    // return false if email does not exist in the database
    return false;
}
 
// update() method will be here
// update a user record
public function update(){
 
    // if password needs to be updated
    $password_set=!empty($this->password) ? ", password = :password" : "";
 
    // if no posted password, do not update the password
    $query = "UPDATE " . $this->table_name . "
            SET
                firstname = :firstname,
                lastname = :lastname,
                middlename = :middlename,
                level = :level,
                department = :department,
                faculty = :faculty,
                category = :category,
                election = :election,
                number = :number,
                email = :email,
                code = :code,
                status = :status
                {$password_set}
            WHERE id = :id";
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->firstname=htmlspecialchars(strip_tags($this->firstname));
    $this->lastname=htmlspecialchars(strip_tags($this->lastname));
    $this->middlename=htmlspecialchars(strip_tags($this->middlename));
    $this->level=htmlspecialchars(strip_tags($this->level));
    $this->department=htmlspecialchars(strip_tags($this->department));
    $this->faculty=htmlspecialchars(strip_tags($this->faculty));
    $this->category=htmlspecialchars(strip_tags($this->category));
    $this->election=htmlspecialchars(strip_tags($this->election));
    $this->number=htmlspecialchars(strip_tags($this->number));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->code=htmlspecialchars(strip_tags($this->code));
    $this->status=htmlspecialchars(strip_tags($this->status));
    //$this->created=htmlspecialchars(strip_tags($this->created));
 
    // bind the values from the form
    $stmt->bindParam(':firstname', $this->firstname);
    $stmt->bindParam(':lastname', $this->lastname);
    $stmt->bindParam(':middlename', $this->middlename);
    $stmt->bindParam(':email', $this->email);
    $stmt->bindParam(':level', $this->level);
    $stmt->bindParam(':department', $this->department);
    $stmt->bindParam(':faculty', $this->faculty);
    $stmt->bindParam(':category', $this->category);
    $stmt->bindParam(':election', $this->election);
    $stmt->bindParam(':number', $this->number);
    $stmt->bindParam(':code', $this->code);
    $stmt->bindParam(':status', $this->status);
    //$stmt->bindParam(':created', $this->created);
    
 
    // hash the password before saving to database
    if(!empty($this->password)){
        $this->password=htmlspecialchars(strip_tags($this->password));
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);
    }
 
    // unique ID of record to be edited
    $stmt->bindParam(':id', $this->id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}


// update() method will be here
// update a user record
public function updatevoter(){
 
    // if password needs to be updated
    $password_set=!empty($this->password) ? ", password = :password" : "";
 
    // if no posted password, do not update the password
    $query = "UPDATE " . $this->table_name . "
            SET
                firstname = :firstname,
                lastname = :lastname,
                middlename = :middlename,
                level = :level,
                department = :department,
                email = :email
                {$password_set}
            WHERE id = :id";
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->firstname=htmlspecialchars(strip_tags($this->firstname));
    $this->lastname=htmlspecialchars(strip_tags($this->lastname));
    $this->middlename=htmlspecialchars(strip_tags($this->middlename));
    $this->level=htmlspecialchars(strip_tags($this->level));
    $this->department=htmlspecialchars(strip_tags($this->department));
    $this->faculty=htmlspecialchars(strip_tags($this->faculty));
    $this->category=htmlspecialchars(strip_tags($this->category));
    $this->election=htmlspecialchars(strip_tags($this->election));
    $this->number=htmlspecialchars(strip_tags($this->number));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->code=htmlspecialchars(strip_tags($this->code));
    $this->status=htmlspecialchars(strip_tags($this->status));
    //$this->created=htmlspecialchars(strip_tags($this->created));
 
    // bind the values from the form
    $stmt->bindParam(':firstname', $this->firstname);
    $stmt->bindParam(':lastname', $this->lastname);
    $stmt->bindParam(':middlename', $this->middlename);
    $stmt->bindParam(':email', $this->email);
    $stmt->bindParam(':level', $this->level);
    $stmt->bindParam(':department', $this->department);
    $stmt->bindParam(':faculty', $this->faculty);
    $stmt->bindParam(':category', $this->category);
    $stmt->bindParam(':election', $this->election);
    $stmt->bindParam(':number', $this->number);
    $stmt->bindParam(':code', $this->code);
    $stmt->bindParam(':status', $this->status);
    //$stmt->bindParam(':created', $this->created);
    
 
    // hash the password before saving to database
    if(!empty($this->password)){
        $this->password=htmlspecialchars(strip_tags($this->password));
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);
    }
 
    // unique ID of record to be edited
    $stmt->bindParam(':id', $this->id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}

// accredit() method will be here
// Accredit a voter record
public function accredit(){
 
    
 
    // if no posted password, do not update the password
    $query = "UPDATE " . $this->table_name . "
            SET
                status = :status
            WHERE id = :id";
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->status=htmlspecialchars(strip_tags($this->status));
    
 
    // bind the values from the form
    $stmt->bindParam(':status', $this->status);
    
    // unique ID of record to be edited
    $stmt->bindParam(':id', $this->id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}


// read products
function read(){
  
    // select all query
    $query = "SELECT
                firstname, lastname, middlename, email, department, faculty, level, number, code, category, election, created, id, status
            FROM
                " . $this->table_name . " 
            ORDER BY
                created DESC";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // execute query
    $stmt->execute();
  
    return $stmt;
}

// used when filling up the update product form
function readOne(){
  
    // query to read single record
    $query = "SELECT
                firstname, lastname, middlename, email, department, faculty, level, number, code, category, election, created, id, status
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
    $this->firstname = $row['firstname'];
    $this->middlename = $row['middlename'];
    $this->lastname = $row['lastname'];
    $this->email = $row['email'];
    $this->department = $row['department'];
    $this->faculty = $row['faculty'];
    $this->level = $row['level'];
    $this->number = $row['number'];
    $this->code = $row['code'];
    $this->category = $row['category'];
    $this->election = $row['election'];
    $this->created = $row['created'];
    $this->status = $row['status'];
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
                firstname, lastname, middlename, email, department, faculty, level, number, code, category, election, created, id, status
            FROM
                " . $this->table_name . " 
            WHERE
            firstname LIKE ? OR lastname LIKE ? OR faculty LIKE ? OR level LIKE ? OR category LIKE ? OR election LIKE ?
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
    $stmt->bindParam(3, $keywords);
    $stmt->bindParam(4, $keywords);
    $stmt->bindParam(5, $keywords);
    $stmt->bindParam(6, $keywords);
  
    // execute query
    $stmt->execute();
  
    return $stmt;
}

// read products with pagination
public function readPaging($from_record_num, $records_per_page){
  
    // select query
    $query = "SELECT
                firstname, lastname, middlename, email, department, faculty, level, number, code, category, election, created, id, status
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


}

?>