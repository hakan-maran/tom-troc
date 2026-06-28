<?php

namespace TomTroc\Model\Manager;

use TomTroc\Engine\Database\AbstractEntityManager;

class MessageManager extends AbstractEntityManager
{
    public string $table = "messages";

    /**
     * Create a new message in the database.
     */
    public function create(array $data): int
    {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (sender_id, receiver_id, content, is_read, created_at) VALUES (:sender_id, :receiver_id, :content, :is_read, :created_at)");
        $stmt->execute([
            'sender_id' => $data['sender_id'],
            'receiver_id' => $data['receiver_id'],
            'content' => $data['content'],
            'is_read' => $data['is_read'] ?? 0,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        return (int) $this->db->lastInsertId();
    }

    /**
     * Find all conversations for a specific receiver (user).
     * Returns an array of conversations with the last message and other user info.
     */
    public function findConversationsByReceiver(int $userId): array
    {
        $sql = "SELECT m.id,
                       CASE WHEN m.sender_id = :user_id THEN m.receiver_id ELSE m.sender_id END AS other_user_id,
                       u.username AS other_username,
                       u.avatar AS other_avatar,
                       m.content AS last_message,
                       m.is_read AS last_message_read,
                       m.sender_id AS last_message_sender_id,
                       m.created_at AS last_message_date
                FROM {$this->table} m
                LEFT JOIN users u ON u.id = CASE WHEN m.sender_id = :user_id THEN m.receiver_id ELSE m.sender_id END
                WHERE m.sender_id = :user_id OR m.receiver_id = :user_id
                ORDER BY m.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        $rows = $stmt->fetchAll();

        $conversations = [];
        foreach ($rows as $row) {
            $otherUserId = (int) $row['other_user_id'];
            if (!isset($conversations[$otherUserId])) {
                $conversations[$otherUserId] = [
                    'id' => $otherUserId,
                    'other_pseudo' => $row['other_username'] ?? 'Utilisateur',
                    'other_avatar' => $row['other_avatar'] ?? 'Avatar_default.png',
                    'last_message' => $row['last_message'] ?? '',
                    'last_message_date' => $row['last_message_date'] ?? null,
                    'last_message_read' => (int) $row['last_message_read'],
                    'last_message_sender_id' => (int) $row['last_message_sender_id'],
                ];
            }
        }

        return array_values($conversations);
    }

    /**
     * Find all messages exchanged between $userId and $otherUserId.
     * Returns an array with the messages and the other user's information.
     */
    public function findConversationBetween(int $userId, int $otherUserId): array
    {
        // Marquer comme lus les messages reçus par $userId venant de $otherUserId
        $update = $this->db->prepare("UPDATE {$this->table} SET is_read = 1 WHERE receiver_id = :receiver_id AND sender_id = :sender_id AND is_read = 0");
        $update->execute(['receiver_id' => $userId, 'sender_id' => $otherUserId]);

        $sql = "SELECT m.id,
                       m.sender_id,
                       m.receiver_id,
                       u.username AS sender_username,
                       m.content,
                       m.is_read,
                       m.created_at,
                       ou.username AS other_username,
                       ou.avatar AS other_avatar
                FROM {$this->table} m
                LEFT JOIN users u ON m.sender_id = u.id
                LEFT JOIN users ou ON ou.id = :other_id
                WHERE (m.sender_id = :user_id AND m.receiver_id = :other_id)
                   OR (m.sender_id = :other_id AND m.receiver_id = :user_id)
                ORDER BY m.created_at ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId, 'other_id' => $otherUserId]);
        $rows = $stmt->fetchAll();

        $messages = [];
        $otherUser = [
            'id' => $otherUserId,
            'username' => null,
            'avatar' => null,
        ];
        foreach ($rows as $row) {
            $messages[] = [
                'id' => $row['id'],
                'sender_id' => (int) $row['sender_id'],
                'receiver_id' => (int) $row['receiver_id'],
                'sender_username' => $row['sender_username'] ?? 'Utilisateur',
                'content' => $row['content'],
                'is_read' => (int) $row['is_read'],
                'created_at' => $row['created_at'],
            ];
            if ($otherUser['username'] === null && $row['other_username'] !== null) {
                $otherUser['username'] = $row['other_username'];
            }
            if ($otherUser['avatar'] === null && $row['other_avatar'] !== null) {
                $otherUser['avatar'] = $row['other_avatar'];
            }
        }

        if ($otherUser['username'] === null) {
            $otherUser['username'] = 'Utilisateur';
        }
        if ($otherUser['avatar'] === null) {
            $otherUser['avatar'] = 'Avatar_default.png';
        }

        return ['other_user' => $otherUser, 'messages' => $messages];
    }
}
