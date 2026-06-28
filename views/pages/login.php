<div class="main-auth">
    <div class="auth">
        <div class="auth-left">
            <h1 class="sign-title">Connexion</h1>

            <form method="POST" action="index.php?action=login" class="sign-form">

                <div class="field">
                    <label for="email">Adresse email</label>
                    <input type="email" name="email" id="email" required>
                </div>

                <div class="field">
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" id="password" required>
                </div>

                <button type="submit" class="sign-submit-btn">Se connecter</button>
            </form>

            <div class="sign-ask">
                Pas de compte ? <a href="index.php?action=register">Inscrivez-vous</a>
            </div>
        </div>

        <img src="img/books/image_inscription.jpg" class="auth-img" alt="Bibliothèque">
    </div>
</div>