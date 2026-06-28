<main class="edit-book-page-wrapper">
    <div class="edit-book-container">

        <nav class="edit-back-navigation">
            <a href="index.php?action=profile" class="edit-btn-back">
                <img src="img/min/line4.svg" alt="Ligne retour" class="edit-back-icon">
                retour
            </a>
        </nav>

        <h1 class="edit-main-title">Modifier les informations</h1>

        <section class="edit-card-white">
            <form action="index.php?action=editBook&id=<?= $book->getId() ?>" method="POST" enctype="multipart/form-data" class="edit-main-form">

                <div class="edit-columns-flex">

                    <div class="edit-col-left-photo">
                        <span class="edit-label-light">Photo</span>

                        <div class="edit-image-frame">
                            <img src="img/books/<?= htmlspecialchars($book->getImage() ?: 'default_book.png') ?>"alt="<?= htmlspecialchars($book->getTitle()) ?>" class="book-image-detail">
                        </div>

                        <label for="book-image-upload" class="edit-link-modify-photo">Modifier la photo</label>
                        <input type="file" name="image_file" id="book-image-upload" accept="image/png, image/jpeg" class="hidden-input">
                    </div>


                    <div class="edit-col-right-inputs">

                        <div class="edit-form-group">
                            <label for="title" class="edit-label-light">Titre</label>
                            <input type="text" name="title" id="title" value="<?= htmlspecialchars($book->getTitle()) ?>" required>
                        </div>

                        <div class="edit-form-group">
                            <label for="author" class="edit-label-light">Auteur</label>
                            <input type="text" name="author" id="author" value="<?= htmlspecialchars($book->getAuthor()) ?>" required>
                        </div>

                        <div class="edit-form-group">
                            <label for="description" class="edit-label-light">Commentaire</label>
                            <textarea name="description" id="description" rows="20" required><?= htmlspecialchars($book->getDescription()) ?></textarea>
                        </div>

                        <div class="edit-form-group">
                            <label for="available" class="edit-label-light">Disponibilité</label>
                            <div class="edit-select-wrapper">
                                <select name="available" id="available">
                                    <option value="1" <?= $book->getIsAvailable() ? 'selected' : '' ?>>disponible</option>
                                    <option value="0" <?= !$book->getIsAvailable() ? 'selected' : '' ?>>non disponible</option>
                                </select>
                            </div>
                        </div>

                        <div class="edit-submit-zone">
                            <button type="submit" class="edit-btn-validate">Valider</button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</main>