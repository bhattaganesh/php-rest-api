<?php
namespace Ganesh\PhpRestApi\Database;

class TableManager {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function createTablesIfNotExist() {
        $tables = array(
            "users" => array(
                "id" => "INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY",
                "name" => "VARCHAR(255) NOT NULL",
                "email" => "VARCHAR(255) NOT NULL",
                "password" => "VARCHAR(255) NOT NULL",
                "created_at" => "DATETIME DEFAULT CURRENT_TIMESTAMP",
                "updated_at" => "DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP",
            ),
        );

        foreach ($tables as $tableName => $tableColumns) {
            $sql = "CREATE TABLE IF NOT EXISTS `" . $tableName . "` (";
            $columns = array();
            foreach ($tableColumns as $columnName => $columnDefinition) {
                $columns[] = "`" . $columnName . "` " . $columnDefinition;
            }
            
            $sql .= implode(",", $columns);
            $sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
            
            $this->db->query($sql);
        }
    }
}
