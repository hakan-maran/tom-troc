<section class="edit-book-page-wrapper">
    <div class="edit-book-container">
        <div class="edit-back-navigation">
            <a href="index.php?action=messagerie" class="edit-btn-back">
                <img src="img/min/line4.svg" alt="Retour" class="edit-back-icon">
                Retour
            </a>
        </div>

        <h1 class="edit-main-title">Nouveau message</h1>

        <div class="edit-card-white">
            <?php if (!empty($error)) : ?>
                    <div class="form-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form action="index.php?action=create-message" method="POST">
                <div class="edit-form-group">
                    <label class="edit-label-light" for="receiver_id">Destinataire</label>
                    <input type="number" id="receiver_id" name="receiver_id" value="<?= htmlspecialchars($receiver_id ?? '') ?>" required>
                </div>

                <div class="edit-form-group">
                    <label class="edit-label-light" for="content">Message</label>
                    <textarea id="content" name="content" rows="6" required></textarea>
                </div>

                <button type="submit" class="edit-btn-validate">Envoyer le message</button>
            </form>
        </div>
    </div>
</section>
