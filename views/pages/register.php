<div class="main-auth">
    <div class="auth">
        <div class="auth-left">
            <h1 class="sign-title">Inscription</h1>

            <form method="POST" action="index.php?action=createUser" class="sign-form">
                <div class="field">
                    <label for="pseudo">Pseudo</label>
                    <input type="text" name="pseudo" id="pseudo" required>
                </div>

                <div class="field">
                    <label for="email">Adresse email</label>
                    <input type="email" name="email" id="email" required>
                </div>

                <div class="field">
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" id="password" required>
                </div>

                <button type="submit" class="sign-submit-btn">S'inscrire</button>
            </form>

            <div class="sign-ask">
                Déjà inscrit ? <a href="index.php?action=login">Connectez-vous</a>
            </div>
        </div>

        <img src="img/books/image_inscription.jpg" class="auth-img" alt="Bibliothèque">
    </div>
</div>