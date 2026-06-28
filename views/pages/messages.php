<section class="messagerie-page-wrapper">
    <div class="messagerie-container">

        <div class="messagerie-sidebar">
            <h1 class="messagerie-title">Messagerie</h1>

            <div class="conversation-list">
                <?php foreach ($conversations as $conversation) : ?>
                        <?php
                        //si 'last_message' est vide ou nul, on saute cette itération
                        if (empty($conversation['last_message'])) {
                            continue;
                        }
                        ?>
                        <a href="index.php?action=messagerie&id=<?= $conversation['id'] ?>"
                            class="conversation-item <?= ($selectedConversationId == $conversation['id']) ? 'active' : '' ?>">

                            <div class="conv-avatar">
                                <img src="img/avatars/<?= htmlspecialchars($conversation['other_avatar'] ?? 'Avatar_default.png') ?>" alt="Avatar">
                            </div>

                            <div class="conv-info">
                                <div class="conv-header">
                                    <span class="conv-pseudo"><?= htmlspecialchars($conversation['other_pseudo']) ?></span>
                                    <?php
                                    // On affiche le point SI le dernier message n'est pas lu
                                    // ET SI ce n'est pas NOUS qui l'avons envoyé
                                    if ($conversation['last_message_read'] == 0 && $conversation['last_message_sender_id'] != $_SESSION['user_id']) : ?>
                                            <span class="unread-dot"></span>
                                    <?php endif; ?>
                                    <span class="conv-time"><?= date('H.i', strtotime($conversation['last_message_date'] ?? 'now')) ?> </span>
                                </div>
                                <p class="conv-preview"><?= htmlspecialchars($conversation['last_message'] ?? 'Nouvelle conversation') ?></p>
                            </div>
                        </a>
                <?php endforeach; ?>

                <?php if (empty($conversations)) : ?>
                        <p class="empty-msg">Aucune conversation pour le moment.</p>
                <?php endif; ?>
            </div>
        </div>

        <section class="messagerie-main">
            <?php if (isset($selectedConversationId) && $selectedConversationId) : ?>
                    <div class="chat-header">
                        <div class="chat-header-avatar">
                            <img src="img/avatars/<?= htmlspecialchars($otherUserAvatar ?? 'Avatar_default.png') ?>" alt="Avatar">
                        </div>
                        <h2 class="chat-header-pseudo"><?= htmlspecialchars($otherUserPseudo ?? 'Utilisateur') ?></h2>
                    </div>

                    <div class="chat-messages-area">
                        <?php if (empty($messages)) : ?>
                                <p class="mess-int">Dites bonjour !</p>
                        <?php else : ?>
                                <?php foreach ($messages as $msg) : ?>
                                        <?php
                                        // On vérifie si le message a été envoyé par "Moi" ou par "L'autre"
                                        $isMe = ((int) $msg['sender_id'] === (int) ($_SESSION['user_id'] ?? 0));
                                        $classMessage = $isMe ? 'msg-sent' : 'msg-received';
                                        ?>

                                        <div class="message-row <?= $classMessage ?>">

                                            <?php if (!$isMe) : ?>
                                                    <img src="img/avatars/<?= htmlspecialchars($otherUserAvatar ?? 'Avatar_default.png') ?>" alt="Avatar" class="msg-avatar-small">
                                            <?php endif; ?>

                                            <div class="msg-content-wrapper">
                                                <div class="msg-meta">
                                                    <span class="msg-date"><?= date('d.m', strtotime($msg['created_at'] ?? 'now')) ?></span>
                                                    <span class="msg-time"><?= date('H:i', strtotime($msg['created_at'] ?? 'now')) ?></span>
                                                </div>
                                                <div class="msg-bubble">
                                                    <p><?= htmlspecialchars($msg['content'] ?? '') ?></p>
                                                </div>
                                            </div>
                                        </div>

                                <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <div class="chat-input-wrapper">
                        <form action="index.php?action=create-message" method="POST" class="chat-form">
                            <input type="hidden" name="receiver_id" value="<?= htmlspecialchars($otherUserId ?? '') ?>">
                            <label for="chat-input" class="visually-hidden">Tapez votre message ici</label>
                            <input type="text" name="content" id="chat-input" class="chat-input-field" placeholder="Tapez votre message ici" required>
                            <button type="submit" class="btn-send-chat">Envoyer</button>
                        </form>
                    </div>
            <?php endif; ?>

        </section>

    </div>
</section>