<section class="book-page-wrapper">
    <?php if ($book) : ?>
            <div class="chemin-navigation">
                <a href="index.php?action=books">Nos livres à l'échange > </a>
                <span><?= htmlspecialchars($book->getTitle()) ?></span>
            </div>

            <div class="book-content-container">
                <div class="book-cover-section">
                    <img src="img/books/<?= htmlspecialchars($book->getImage() ?: 'default_book.png') ?>"
                        alt="<?= htmlspecialchars($book->getTitle()) ?>" class="book-image-detail">
                </div>

                <div class="book-info-section">
                    <span class="section-main-title">Détails du livre</span>
                    <h1 class="book-main-title"><?= htmlspecialchars($book->getTitle()) ?></h1>
                    <p class="book-main-author"><?= htmlspecialchars($book->getAuthor()) ?></p>
                    <span class="detail-line-separator"></span>
                    <p class="book-main-description"><?= nl2br(htmlspecialchars($book->getDescription())) ?></p>

                    <div class="section-owner">Propriétaire</div>
                    <div class="owner-card">
                        <div class="avatar-wrapper">
                            <img src="img/avatars/<?= htmlspecialchars($owner?->getAvatar() ?: 'Avatar_default.png') ?>"  alt="Avatar propriétaire" class="owner-avatar-img">
                        </div>
                        <div class="owner-name-container">
                            <a href="index.php?action=publicProfile&id=<?= htmlspecialchars($owner?->getId()) ?>">
                                <span><?= htmlspecialchars($owner?->getUsername() ?? 'Utilisateur inconnu') ?></span>
                            </a>
                        </div>
                    </div>

                    <div class="action-wrapper">
                        <?php if (isset($_SESSION['user_id'])) : ?>
                                <?php if ($_SESSION['user_id'] != $book->getUserId()) : ?>
                                        <a href="index.php?action=messagerie&create_chat_with=<?= $book->getUserId() ?>"
                                            class="btn-send-message">
                                            Envoyer un message
                                        </a>
                                <?php endif; ?>
                        <?php else : ?>
                                <a href="index.php?action=login" class="btn-send-message">
                                    Envoyer un message
                                </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
    <?php else : ?>
            <div class="no-results">
                <p>Livre introuvable.</p>
            </div>
    <?php endif; ?>
</section>