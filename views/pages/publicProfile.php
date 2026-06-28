<?php

use Services\Utils;

?>
<div class="profile-page-wrapper">
    <div class="container-profile-main-flex">

        <div class="profile-sidebar">
            <div class="profile-card">
                <div class="profile-avatar">
                    <img src="img/avatars/<?= htmlspecialchars($user->getAvatar() ?: 'Avatar_default.png') ?>"
                        alt="Avatar de <?= htmlspecialchars($user->getUsername()) ?>">
                </div>

                <img src="img/min/line3.png" alt="ligne separatrice" class="profile-separator-img">

                <h1 class="profile-name"><?= htmlspecialchars($user->getUsername()) ?></h1>
                <p class="profile-member-since">Membre depuis <?= Utils::format($user->getCreatedAt()) ?></p>

                <div class="profile-library-info">
                    <p class="library-label">BIBLIOTHÈQUE</p>
                    <div class="library-count-box">
                        <img src="img/min/livres.svg" alt="icon" class="livre-library">
                        <span class="library-count">

                            <?= count($books) ?> livre<?= count($books) > 1 ? 's' : '' ?>
                        </span>
                    </div>
                </div>

                <div class="profile-action">
                    <?php if (isset($_SESSION['user_id'])) : ?>
                            <?php if ($_SESSION['user_id'] != $user->getId()) : ?>
                                    <a href="index.php?action=messagerie&create_chat_with=<?= htmlspecialchars($user->getId()) ?>" class="btn-write-message">
                                        Écrire un message
                                    </a>
                            <?php endif; ?>
                    <?php else : ?>
                            <a href="index.php?action=login" class="btn-write-message">
                                Écrire un message
                            </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="profile-content">
            <div class="table-round-container">
                <table class="books-table">
                    <thead>
                        <tr>
                            <th class="col-photo">PHOTO</th>
                            <th class="col-title">TITRE</th>
                            <th class="col-author">AUTEUR</th>
                            <th class="col-desc">DESCRIPTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($books)) : ?>
                                <tr>
                                    <td colspan="4" class="empty-state">Cet utilisateur n'a pas encore de livres.</td>
                                </tr>
                        <?php else : ?>
                                <?php foreach ($books as $book) : ?>
                                        <tr>
                                            <td class="col-photo">
                                                <div class="book-img-wrapper">
                                                    <img src="img/books/<?= htmlspecialchars($book->getImage() ?: 'default_book.png') ?>"
                                                        alt="Cover" class="book-cover-img-wrapper">
                                                </div>
                                            </td>
                                            <td class="col-title"><?= htmlspecialchars($book->getTitle()) ?></td>
                                            <td class="col-author"><?= htmlspecialchars($book->getAuthor()) ?></td>
                                            <td class="col-desc">
                                                <?= htmlspecialchars(mb_substr($book->getDescription(), 0, 150)) ?>...
                                            </td>
                                        </tr>
                                <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>