<?php
class DBConnection {
    private $host;
    private $user;
    private $pass;
    private $dbname;
    private $conn;

    public function __construct() {
        $this->host = DB_HOST;
        $this->user = DB_USER;
        $this->pass = DB_PASS;
        $this->dbname = DB_NAME;

        try {
            $sqlstr = "mysql:host=$this->host;dbname=$this->dbname";

            $this->conn = new PDO($sqlstr, $this->user, $this->pass);
        } catch (PDOException $e) {
            $this ->conn = null;
        }
    }

    public function getConnection() {
        return $this->conn;
    }
    }
?>