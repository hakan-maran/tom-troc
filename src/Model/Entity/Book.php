<?php

namespace TomTroc\Model\Entity;

use TomTroc\Engine\Database\AbstractEntity;

class Book extends AbstractEntity
{
    private int $user_id;
    private string $title;
    private string $author;
    private ?string $image;
    private ?string $description;
    private bool $is_available;

    public function getUserId(): int
    {
        return $this->user_id;
    }
    
    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getIsAvailable(): bool
    {
        return $this->is_available;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setIsAvailable(?bool $is_available): void
    {
        $this->is_available = $is_available;
    }
}
