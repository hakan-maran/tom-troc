<?php

use Services\Utils;

?>
<div class="my-account-wrapper">
    <div class="profile-container">

        <div class="profile-header-flex">
            <h1 class="profile-main-title">Mon compte</h1>

            <a href="index.php?action=create-book" class="btn-add-book">Ajouter un livre</a>

        </div>

        <form action="index.php?action=updateProfile" method="POST" enctype="multipart/form-data"
            class="profile-top-section">

            <div class="profile-columns-flex">

                <div class="profile-col-left">
                    <div class="profile-avatar-frame">
                        <img src="img/avatars/<?= htmlspecialchars($user->getAvatar() ?? 'Avatar_default.png') ?>"
                            alt="Avatar de profil" id="avatar-preview">
                    </div>

                    <label for="avatar_upload" class="edit-avatar-link">modifier</label>
                    <input type="file" id="avatar_upload" name="avatar" accept="image/png, image/jpeg"
                        class="hidden-input">

                    <img src="img/min/line5.svg" alt="séparateur" class="profile-separator-line">

                    <h2 class="profile-pseudo"><?= htmlspecialchars($user->getUsername()) ?></h2>
                    <p class="profile-member-date">Membre depuis <?= Utils::format($user->getCreatedAt()) ?></p>

                    <div class="profile-library-stats">
                        <span class="library-label">BIBLIOTHEQUE</span>
                        <div class="library-count-flex">
                            <img src="img/min/livres.svg" alt="Icon livre" class="icon-book">
                            <span class="library-count-text"><?= count($books) ?> livres</span>
                        </div>
                    </div>
                </div>

                <div class="profile-col-right">
                    <h3 class="form-section-title">Vos informations personnelles</h3>

                    <div class="edit-forms">
                        <label for="email" class="edit-label-blue">Adresse email</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user->getEmail()) ?>"
                            required>
                    </div>

                    <div class="edit-forms">
                        <label for="password" class="edit-label-blue">Mot de passe</label>
                        <input type="password" id="password" name="password" placeholder="•••••••••">
                    </div>

                    <div class="edit-forms">
                        <label for="pseudo" class="edit-label-blue">Pseudo</label>
                        <input type="text" id="pseudo" name="pseudo"
                            value="<?= htmlspecialchars($user->getUsername()) ?>" required>
                    </div>

                    <button type="submit" class="btn-save-outline">Enregistrer</button>
                </div>
            </div>
        </form>

        <div class="profile-table-wrapper">
            <table class="my-books-table">
                <thead>
                    <tr>
                        <th>PHOTO</th>
                        <th>TITRE</th>
                        <th>AUTEUR</th>
                        <th>DESCRIPTION</th>
                        <th>DISPONIBILITE</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($books)) : ?>
                        <tr>
                            <td colspan="6" class="empty-state">Votre bibliothèque est vide.</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($books as $book) : ?>
                            <tr>
                                <td>
                                    <div class="table-img-frame">
                                        <img src="img/books/<?= htmlspecialchars($book->getImage() ?: 'default_book.png') ?>"
                                            alt="Cover">
                                    </div>
                                </td>
                                <td class="table-text-bold"><?= htmlspecialchars($book->getTitle()) ?></td>
                                <td class="table-text-light"><?= htmlspecialchars($book->getAuthor()) ?></td>
                                <td class="table-text-desc">
                                    <div class="text-truncate-wrapper">
                                        <?= htmlspecialchars($book->getDescription() ?? ''); ?>
                                    </div>
                                </td>
                                <td>
                                    <?php if (!$book->getIsAvailable()) : ?>
                                        <span class="badge-not-avalaible">non dispo.</span>
                                    <?php else : ?>
                                        <span class="badge-disponible">disponible</span>
                                    <?php endif; ?>
                                </td>
                                <td class="table-actions">
                                    <a href="index.php?action=editBook&id=<?= $book->getId() ?>" class="action-edit">Éditer</a>
                                    <form action="index.php?action=deleteBook&id=<?= $book->getId() ?>" method="POST"
                                        style="display:inline">
                                        <button type="submit" class="action-delete">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="delete-account-zone">
            <form action="index.php?action=deleteAccount" method="POST">
                <button type="submit" class="btn-delete-account"
                    onclick="return confirm('⚠️⚠️ Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible !');">
                    Supprimer mon compte
                </button>
            </form>
        </div>

    </div>
</div>