<?php
namespace Ganesh\PhpRestApi\Database;

class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private static $instance = null;
    private $conn;

    private function __construct() {

        $this->host = $_ENV['DB_HOST'];
        $this->db_name = $_ENV['DB_NAME'];
        $this->username = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASSWORD'];

        $this->conn = $this->connect();

        // Create tables if they don't exist
        $tableManager = new TableManager($this->conn);
        $tableManager->createTablesIfNotExist();
    
    }

    private function connect() {
        $this->conn = null;
        
        try {
            $this->conn = new \PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch(\PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
            return null;
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }

    final private function __clone() {}

    final private function __wakeup() {}
}
