<?php


class PhonesData{

    // Connection instance
    private $connection;

    // table name
    private $table_name = "phoneNumber";
    private $password = "";

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

        $mysqli = new mysqli("localhost", "root", $this->password, "mydb");

        $query = "INSERT INTO
            " . $this->table_name . " (id,number, status, bodyText, createdAt, updatedAt, serviceHostPort)
        VALUES (
        ".$this->id.", 
        ".$this->number.",
        ".$this->status.",
        ". $this->bodyText .",
        " .$this->createdAt. ",
        " .$this->updatedAt .",
        " . $this->serviceHostPort .");";

        // prepare query
        $stmt = $this->connection->prepare($query);

        // // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->number=htmlspecialchars(strip_tags($this->number));
        $this->status=htmlspecialchars(strip_tags($this->status));
        $this->createdAt=htmlspecialchars(strip_tags($this->createdAt));
        $this->updatedAt=htmlspecialchars(strip_tags($this->updatedAt));
        $this->serviceHostPort=htmlspecialchars(strip_tags($this->serviceHostPort));
        $this->serviceHostPort=htmlspecialchars(strip_tags($this->bodyText));

        // bind values
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":number", $this->number);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":createdAt", $this->createdAt);
        $stmt->bindParam(":updatedAt", $this->updatedAt);
        $stmt->bindParam(":serviceHostPort", $this->serviceHostPort);
        $stmt->bindParam(":bodyText", $this->bodyText);

       


        

        // execute query
        // if($stmt->execute()){
        // return true;
        // }
        // return false;
        if($mysqli->query($query)){
            // echo "Records added successfully.";
            return true;
        } else{
            echo "ERROR: Could not able to execute $query. " . mysqli_error($this->connection);
            return false;
        }
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
        $mysqli = new mysqli("localhost", "root", $this->password, "mydb");

        $query = "UPDATE
        " . $this->table_name . "
            SET
                status =" . $this->status . ",
                updatedAt=" . $this->updatedAt . ",
                serviceHostPort=" . $this->serviceHostPort . "
            WHERE
                id=" . $this->id . ";";

       
        // echo $query;

        if($mysqli->query($query)){
            // echo "Records updated successfully.";
            return true;
        } else{
            echo "ERROR: Could not able to execute $query. " . mysqli_error($this->connection);
            return false;
        }

    }
    //D
    public function delete(){}
}