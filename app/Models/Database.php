<?php

namespace App\Models;

class DatabaseHandler {
    private $pdo;

    /**
     * Constructor to initialize the database connection.
     *
     * @param string $host
     * @param string $dbname
     * @param string $username
     * @param string $password
     */
    public function __construct(string $host, string $dbname, string $username, string $password) {
        try {
            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
            $this->pdo = new \PDO($dsn, $username, $password);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            error_log("Database connection error: " . $e->getMessage());
            throw new \Exception("Failed to connect to the database.");
        }
    }

    /**
     * Inserts data into a table.
     *
     * @param string $table The table name.
     * @param array $data Associative array of column-value pairs.
     * @return bool True if successful, false otherwise.
     */
    public function insert(string $table, array $data): bool {
        try {
            // Build the SQL query dynamically
            $columns = implode(', ', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));

            $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
            $stmt = $this->pdo->prepare($sql);

            // Bind values and execute
            foreach ($data as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }

            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Database insert error: " . $e->getMessage());
            return false;
        }
    }




    //////////// CHECKS IF A VALUE EXISTS OR NOT /////////////////////////////
    public function is_existing(string $table, string $column, $value): bool {
        try {


            // Build the SQL query dynamically
            if ($value === null) {
                $sql = "SELECT EXISTS(SELECT 1 FROM $table WHERE $column IS NULL)";
            } else {
                $sql = "SELECT EXISTS(SELECT 1 FROM $table WHERE $column = :value)";
            }
        
            // Prepare and execute the query
            $stmt = $this->pdo->prepare($sql);
        
            if ($value !== null) {
                $stmt->bindValue(':value', $value);
            }
        
            $stmt->execute();
        
            // Fetch the result and return as boolean
            return (bool) $stmt->fetchColumn();
            
            // $sql = "SELECT EXISTS(SELECT 1 FROM $table WHERE $column = $value)";
            // $stmt = $this->pdo->prepare($sql);
            // $stmt->execute();

            // $exists = $stmt->fetchColumn();

            // if($exists){
            //     return true;
            // }
            // else{
            //     return false;
            // }


        } catch (\PDOException $e) {
            error_log("Database insert error: " . $e->getMessage());
            return false;
        }
    }


}