<?php
class PhonesData{

    // Connection instance
    private $connection;

    // table name
    private $table_name = "PhoneNumber";

    // table columns
    public $id;
    public $number; 
    public $status;
    public $createdAt;
    public $updatedAt;
    public $serviceHostPort;
    public $bodyText;

    public function __construct($connection){
        $this->connection = $connection;
    }

    
    public function create(){
        // query to insert record
        $query = "INSERT INTO
            " . $this->table_name . "
        SET id=:id, 
        number=:number, status=:status, createdAt=:createdAt , updatedAt=:updatedAt, serviceHostPort=:serviceHostPort, 
        bodyText=:bodyText";

        // prepare query
        $stmt = $this->connection->prepare($query);

        // // sanitize
        // $this->id=htmlspecialchars(strip_tags($this->number));
        // $this->number=htmlspecialchars(strip_tags($this->number));
        // $this->condition=htmlspecialchars(strip_tags($this->condition));
        // $this->createdAt=htmlspecialchars(strip_tags($this->createdAt));
        // $this->updatedAt=htmlspecialchars(strip_tags($this->updatedAt));
        // $this->locationId=htmlspecialchars(strip_tags($this->locationId));

        // bind values
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":number", $this->number);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":createdAt", $this->createdAt);
        $stmt->bindParam(":updatedAt", $this->updatedAt);
        $stmt->bindParam(":serviceHostPort", $this->serviceHostPort);
        $stmt->bindParam(":bodyText", $this->bodyText);

        // execute query
        if($stmt->execute()){
        return true;
        }
        return false;
    }
    //R
    public function read(){
        $query = "SELECT c.id, c.createdAt, c.updatedAt, c.number, c.location_id, c.condition FROM" . $this->table_name . "AS c";
        $stmt = $this->connection->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function readOne($number){
        // query to read single record
        $query = "SELECT
             c.id, c.createdAt, c.updatedAt, c.number, c.location_id, c.condition 
        FROM
            " . $this->table_name . " AS c
        WHERE
            c.number=" . $number;

        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // bind id of product to be updated
        $stmt->bindParam(1, $this->number);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->number = $row['number'];
        $this->condition = $row['condition'];
        $this->createdAt = $row['createdAt'];
        $this->updatedAt = $row['updatedAt'];
        $this->locationId = $row['locationId'];
    }

    //U
    public function update(){
        // update query
    $query = "UPDATE
    " . $this->table_name . "
        SET
            condition = :condition,
            updatedAt = :updatedAt
        WHERE
            number = :number";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->number=htmlspecialchars(strip_tags($this->number));
        $this->condition=htmlspecialchars(strip_tags($this->condition));
        $this->number=htmlspecialchars(strip_tags($this->updatedAt));

        // bind new values
        $stmt->bindParam(':number', $this->number);
        $stmt->bindParam(':condition', $this->condition);
        $stmt->bindParam(':updatedAt', $this->updatedAt);

        // execute the query
        if($stmt->execute()){
        return true;
        }
        return false;
    }
    //D
    public function delete(){}
}