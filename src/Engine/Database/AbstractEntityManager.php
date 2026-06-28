<?php

namespace TomTroc\Engine\Database;

use TomTroc\Engine\Database\DatabaseConnection;

abstract class AbstractEntityManager
{
    protected $db;
    public string $table = "";

    public function __construct()
    {
        $this->db = DatabaseConnection::connect();
    }

    /**
     * Update an existing entity in the database.
     */
    public function update(mixed $entity): int
    {
        $reflection = new \ReflectionClass($entity);
        $params = [];
        $sql = "UPDATE {$this->table} SET ";
        foreach ($reflection->getProperties() as $property) {
            $propertyName = $property->getName();
            $method = 'get' . str_replace('_', '', ucwords($propertyName, '_'));
            $content = $entity->$method();
            if ($content !== "") {
                $sql .= $propertyName . '=:' . $propertyName . ', ';
                if ($content instanceof \DateTime) {
                    $params[$propertyName] = $content->format('Y-m-d H:i:s');
                } elseif (is_bool($content)) {
                    if (!empty($content)) {
                        $params[$propertyName] = 1;
                    } else {
                        $params[$propertyName] = 0;
                    }
                } else {
                    $params[$propertyName] = $content;
                }
            }
        }
        $sql = substr($sql, 0, -2);
        $sql .= " WHERE id=:id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $this->db->lastInsertId();
    }
}
