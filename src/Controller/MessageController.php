<?php

namespace TomTroc\Controller;

use TomTroc\Engine\View;
use TomTroc\Model\Manager\MessageManager;
use TomTroc\Model\Manager\UserManager;

class MessageController
{
    /**
     * Display the message inbox.
     */
    public function index(): void
    {
        $userId = $_SESSION['user_id'] ?? null;
        if (empty($userId)) {
            header('Location: index.php?action=login');
            exit;
        }

        $manager = new MessageManager();

        $otherUserId = null;
        if (isset($_GET['sender_id'])) {
            $otherUserId = $_GET['sender_id'];
        } elseif (isset($_GET['id'])) {
            $otherUserId = $_GET['id'];
        } elseif (isset($_GET['create_chat_with'])) {
            $otherUserId = $_GET['create_chat_with'];
        }

        $conversations = $manager->findConversationsByReceiver($userId);
        $selectedConversationId = null;
        $messages = [];
        $otherUserPseudo = null;
        $otherUserAvatar = null;

        if ($otherUserId) {
            $data = $manager->findConversationBetween((int) $userId, $otherUserId);
            $selectedConversationId = $otherUserId;
            $messages = $data['messages'];
            $otherUserPseudo = $data['other_user']['username'] ?? 'Utilisateur';
            $otherUserAvatar = $data['other_user']['avatar'] ?? 'Avatar_default.png';

            if (empty($messages)) {
                $userManager = new UserManager();
                $otherUser = $userManager->findById($otherUserId);
                if ($otherUser) {
                    $otherUserPseudo = $otherUser->getUsername();
                    $otherUserAvatar = $otherUser->getAvatar() ?: 'Avatar_default.png';
                }
            }
        }

        $view = new View('Messages');
        $view->render('messages', [
            'conversations' => $conversations,
            'selectedConversationId' => $selectedConversationId,
            'messages' => $messages,
            'otherUserId' => $otherUserId,
            'otherUserPseudo' => $otherUserPseudo,
            'otherUserAvatar' => $otherUserAvatar,
        ]);
    }

    /**
     * Create a new message.
     */
    public function create(array $data = []): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $senderId = $_SESSION['user_id'] ?? null;
            $receiverId = isset($data['receiver_id']) ? (int) $data['receiver_id'] : null;
            $content = trim($data['content'] ?? '');

            if (empty($senderId) || empty($receiverId) || $content === '') {
                $error = 'Merci de remplir tous les champs pour envoyer un message.';
                $view = new View('Nouveau message');
                $view->render('createMessage', ['error' => $error, 'receiver_id' => $receiverId]);
                return;
            }

            $manager = new MessageManager();
            $messageId = $manager->create([
                'sender_id' => $senderId,
                'receiver_id' => $receiverId,
                'content' => $content,
                'is_read' => 0,
            ]);

            header('Location: index.php?action=messagerie&id=' . $receiverId);
            exit;
        }

        $receiverId = isset($_GET['receiver_id']) ? (int) $_GET['receiver_id'] : null;
        $view = new View('Nouveau message');
        $view->render('createMessage', ['receiver_id' => $receiverId]);
    }
}
