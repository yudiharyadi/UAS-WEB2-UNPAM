<?php

require __DIR__. "//../vendor/autoload.php";

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__.'//../');
$dotenv->load();

/**
 * Class MySqlDb 
 * used to connect to mysql server
 * 
 * @author teramuza <teramuza@gmail.com> 
 * @link https://github.com/teukuraja/
 */

class MySqlDb {

    protected $host;
    protected $username;
    protected $password;
    protected $db;
    protected $conn;

    function __construct(){
        $this->host = $_ENV['host'];
        $this->username = $_ENV['username'];
        $this->password = $_ENV['password'];
        $this->db = $_ENV['database'];    
        $this->connect();
    }
    
    private function connect(){
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    static function getAllData($table) {
        $myql = new MySqlDb();

        $sql = "SELECT * FROM ".$table;
        $sql = $myql->conn->query($sql);
        $rows = array();
        while($row = $sql->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    static function getArrData($table, $where) {
        $myql = new MySqlDb();

        $sql = "SELECT * FROM ".$table." WHERE ".$where;
        $sql = $myql->conn->query($sql);
        $rows = array();
        while($row = $sql->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }
    
    static function getData($table, $where){
        $myql = new MySqlDb();

        $sql = "SELECT * FROM ".$table." WHERE ".$where;          
        $sql = $myql->conn->query($sql);
        $sql = $sql->fetch_assoc();
        return $sql;
    }

    static function checkData($table, $where) {
        $myql = new MySqlDb();

        $sql = "SELECT * FROM ".$table." WHERE ".$where;          
        $sql = $myql->conn->query($sql);
        $obj = new stdClass();
        if(mysqli_num_rows($sql) > 0){
            $sql = $sql->fetch_assoc();
            $obj->success = true;
            $obj->user_id = $sql['id'];
            return $obj;
        }else{
            $obj->success = false;
            return $obj;
        }
    }

    static function updateData($table, $update_value, $where){
        $myql = new MySqlDb();

        $sql = "UPDATE ".$table." SET ".$update_value." WHERE ".$where;        
        print_r($sql);
        $sql = $myql->conn->query($sql);
        if($sql == true){
            return true;
        }else{
            return false;
        }
    }

    static function createData($table, $columns, $values){
        $myql = new MySqlDb();

        $sql = "INSERT INTO ".$table." (".$columns.") VALUES (".$values.')';  
        $sql = $myql->conn->query($sql);
        if($sql == true){
            return true;
        }else{
            return false;
        }
    }

    static function deleteData($table, $filter){
        $myql = new MySqlDb();

        $sql =  "DELETE FROM ".$table." ".$filter;  
        $sql = $myql->conn->query($sql);
        if($sql == true){
            return true;
        }else{
            return false;
        }
    }
}
?>