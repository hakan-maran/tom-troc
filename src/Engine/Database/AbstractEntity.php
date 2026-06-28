<?php

namespace TomTroc\Engine\Database;

/**
 * Abstract class representing a generic entity with an ID.
 * Common properties or methods for all entities can be defined here
 */
abstract class AbstractEntity
{
    protected int $id = -1;

    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }

    /**
     * Hydrate the entity with data from an associative array.
     */
    protected function hydrate(array $data): void
    {
        foreach ($data as $key => $value) {
            $method = 'set' . str_replace('_', '', ucwords($key, '_'));
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /**
     * Set the ID of the entity.
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    /**
     * Get the ID of the entity.
     */
    public function getId(): int
    {
        return $this->id;
    }
}
