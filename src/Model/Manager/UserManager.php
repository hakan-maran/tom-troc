<?php

namespace TomTroc\Model\Manager;

use TomTroc\Engine\Database\AbstractEntityManager;
use TomTroc\Model\Entity\User;

class UserManager extends AbstractEntityManager
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'users';
    }
    /**
     * Get a user by their username.
     * @param string $username
     * @return User|null
     */
    public function getUserByUsername(string $username): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();
        return $user ? new User($user) : null;
    }
    /**
     * Get a user by their email address.
     * @param string $email
     * @return User|null
     */
    public function getUserByEmail(string $email): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        return $user ? new User($user) : null;
    }

    /**
     * Find a user by their ID.
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();
        return $user ? new User($user) : null;
    }

    /**
     * Create a new user in the database.
     * @todo It is not the manager's job to handle password encryption.
     * @param User $user
     * @return int
     */
    protected function create(User $user): int
    {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (username, email, password) VALUES (:username, :email, :password)");
        $stmt->execute([
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'password' => password_hash($user->getPassword(), PASSWORD_BCRYPT)
        ]);
        return $this->db->lastInsertId();
    }

    /**
     * Check if a user already exists in the database, based on their Id. If the user does not exist, create a new user. If the user exists, update their information.
     * @param User $user
     * @return int
     */
    public function save(User $user): int
    {
        if ($user->getId() == -1) {
            return $this->create($user);
        }
        return $this->update($user);
    }
}
