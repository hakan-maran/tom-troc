<section class="edit-book-page-wrapper">
    <div class="edit-book-container">
        <div class="edit-back-navigation">
            <a href="index.php?action=books" class="edit-btn-back">
                <img src="img/min/line4.svg" alt="Retour" class="edit-back-icon">
                Retour
            </a>
        </div>

        <h1 class="edit-main-title">Ajouter un livre</h1>

        <div class="edit-card-white">
            <form method="POST" action="index.php?action=create-book">
                <div class="edit-columns-flex">
                <div class="edit-col-left-photo">
                    <p class="edit-label-light">Photo du livre</p>
                    <div class="edit-image-frame">
                        <img src="img/books/default_book.png" alt="Couverture du livre">
                    </div>
                    <span class="edit-link-modify-photo">Vous pourrez modifier l’image après création</span>
                </div>

                <div class="edit-col-right-inputs">
                    <div class="edit-form-group">
                        <label class="edit-label-light" for="title">Titre</label>
                        <input type="text" id="title" name="title" required>
                    </div>
                    <div class="edit-form-group">
                        <label class="edit-label-light" for="author">Auteur</label>
                        <input type="text" id="author" name="author" required>
                    </div>
                    <div class="edit-form-group">
                        <label class="edit-label-light" for="description">Description</label>
                        <textarea id="description" name="description"></textarea>
                    </div>
                    <button type="submit" class="edit-btn-validate">Créer le livre</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</section>
