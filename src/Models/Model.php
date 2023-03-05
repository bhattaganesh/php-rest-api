<?php

namespace Ganesh\PhpRestApi\Models;

use Ganesh\PhpRestApi\Database\Database;

class Model
{
    protected $conn;
    protected $table;

    public function __construct($table)
    {
        $db = Database::getInstance();

        $this->conn = $db->getConnection();
        $this->table = $table;
    }

    public function getAll()
    {
        try {
            $query = "SELECT * FROM {$this->table}";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Error fetching data from database: " . $e->getMessage());
        }
    }
}
