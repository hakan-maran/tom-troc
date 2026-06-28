<?php

namespace TomTroc\Model\Entity;

use TomTroc\Engine\Database\AbstractEntity;

class Message extends AbstractEntity
{
    private int $sender_id;
    private int $receiver_id;
    private string $content;
    private bool $is_read;
    private \DateTime $created_at;

    public function getSenderId(): int
    {
        return $this->sender_id;
    }

    public function getReceiverId(): int
    {
        return $this->receiver_id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function isRead(): bool
    {
        return $this->is_read;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->created_at;
    }

    public function setSenderId(int $sender_id): void
    {
        $this->sender_id = $sender_id;
    }

    public function setReceiverId(int $receiver_id): void
    {
        $this->receiver_id = $receiver_id;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function setIsRead(bool $is_read): void
    {
        $this->is_read = $is_read;
    }

    public function setCreatedAt(\DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }
}
