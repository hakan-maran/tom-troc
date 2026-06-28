<?php

namespace TomTroc\Engine\Database;

use PDO;
use PDOStatement;

require_once __DIR__ . '/../../../config/database.php';

class DatabaseConnection
{
    // Singleton pattern to ensure only one connection is created - one and only one instance of PDO is used throughout the application
    /** @todo Singleton is the bad of oop and here can react like database persitance that can do some errors */
    private static $instance = null;

    private $db;

    private function __construct()
    {
        $this->db = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
            DB_USER,
            DB_PASS
        );
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public static function getInstance(): DatabaseConnection
    {
        if (self::$instance === null) {
            self::$instance = new DatabaseConnection();
        }
        return self::$instance;
    }

    public static function connect(): PDO
    {
        return self::getInstance()->db;
    }

    public function query(string $sql, array $params = []): PDOStatement
    {
        if (empty($params)) {
            return $this->db->query($sql);
        } else {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        }
    }
}
