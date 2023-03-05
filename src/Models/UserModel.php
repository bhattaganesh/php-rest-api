<?php

namespace Ganesh\PhpRestApi\Models;

use Ganesh\PhpRestApi\Models\Model;

class UserModel extends Model
{
    public function __construct()
    {
        parent::__construct('users');
    }

    public function getById($id)
    {
        try {
            $query = "SELECT * FROM {$this->table} WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $params = array(':id' => $id);
            $stmt->execute($params);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Error fetching data from database: " . $e->getMessage());
        }
    }


    public function create($data)
    {
        try {

            $cols = implode(', ', array_keys($data));
            $params = array();

            foreach ($data as $key => $value) {
                $params[':' . $key] = $value;
            }

            $placeholders = implode(', ', array_keys($params));
            $sql = "INSERT INTO $this->table ($cols) VALUES ($placeholders)";
            $stmt = $this->conn->prepare($sql);

            $stmt->execute($params);

            $insert_id = $this->conn->lastInsertId();

            return $insert_id;
        } catch (\PDOException $e) {
            throw new \Exception("Error creating data: " . $e->getMessage());
        }
    }

    public function update($id, $data)
    {
        try {
            $set = implode('=?,', array_keys($data)) . '=?';
            $sql = "UPDATE $this->table SET $set WHERE id = ?";
            $stmt = $this->conn->prepare($sql);

            $params = array_values($data);
            $params[] = $id;

            foreach ($params as $key => $value) {
                $stmt->bindValue(($key + 1), $value);
            }
            print_r($set);
            $stmt->execute();

            return $stmt->rowCount();
        } catch (\PDOException $e) {
            throw new \Exception("Error updating data: " . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = :id");

            $stmt->bindValue(':id', $id);

            $stmt->execute();

            return $stmt->rowCount();
        } catch (\PDOException $e) {
            throw new \Exception("Error deleting data: " . $e->getMessage());
        }
    }
}
