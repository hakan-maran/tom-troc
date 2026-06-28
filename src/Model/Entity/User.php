<?php

namespace TomTroc\Model\Entity;

use TomTroc\Engine\Database\AbstractEntity;
use TomTroc\Service\Utils;

class User extends AbstractEntity
{
    private string $username;
    private string $email;
    private string $password;
    private ?string $avatar = 'Avatar_default.png';
    private \DateTime $created_at;
    
    public function setUsername(string $username): void
    {
        $this->username = Utils::trim($username);
    }

    public function setEmail(string $email): void
    {
        $this->email = Utils::trim($email);
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setAvatar(?string $avatar): void
    {
        $this->avatar = Utils::trim($avatar) ?: 'Avatar_default.png';
    }

    /**
     * @todo It is not the entity's job to handle Datetime type, enter a Datetime here.
     */
    public function setCreatedAt($created_at): void
    {
        if (is_string($created_at)) {
            $this->created_at = new \DateTime($created_at);
            return;
        }

        if ($created_at instanceof \DateTime) {
            $this->created_at = $created_at;
            return;
        }
        // Fallback to now if unexpected type
        $this->created_at = new \DateTime();
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getAvatar(): ?string
    {
        $avatar = Utils::trim($this->avatar);

        if ($avatar === '' || strtolower($avatar) === 'avatar_default.png') {
            return 'Avatar_default.png';
        }

        return $avatar;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->created_at;
    }
}
