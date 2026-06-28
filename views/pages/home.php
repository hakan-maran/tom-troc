<section class="banner">
    <div class="banner-inner">
        <div class="banner-content">
        <h1 class="title">Rejoignez nos lecteurs passionnés</h1>
        <p class="text">
            Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux de la lecture.
            Nous croyons en la magie du partage de connaissances et d'histoires à travers les livres.
        </p>
        <a href="index.php?action=books" class="btn">Découvrir</a>
        </div>

        <div class="banner-image">
        <img src="img/books/book_hope.jpg" alt="author" class="image">

        <div class="card">
            <span class="name">xxx</span>
        </div>
        </div>
    </div>
</section>

<section class="books">
    <h2 class="section-title">Les derniers livres ajoutés</h2>

    <div class="books-list">
        <?php if (isset($books) && !empty($books)) : ?>
                <?php foreach ($books as $book) : ?>
                        <a href="index.php?action=book&id=<?= $book->getId() ?>" class="book">
                            <div class="book-cover">
                                <img src="img/books/<?= htmlspecialchars($book->getImage() ?: 'default_book.png') ?>"
                                    alt="<?= htmlspecialchars($book->getTitle()) ?>"
                                    class="image">
                            </div>

                            <div class="book-details">
                                <h3 class="book-title"><?= htmlspecialchars($book->getTitle()) ?></h3>
                                <p class="book-author"><?= htmlspecialchars($book->getAuthor()) ?></p>
                                <?php
                                $userManager = new \Models\Managers\UserManager();
                                $seller = $userManager->findById($book->getUserId());
                                $sellerName = $seller ? $seller->getUsername() : 'Inconnu';
                                ?>
                                <p class="book-seller">Vendu par : <?= htmlspecialchars($sellerName) ?></p>
                            </div>
                        </a>
                <?php endforeach; ?>
        <?php else : ?>
                <p>Aucun livre disponible.</p>
        <?php endif; ?>
    </div>

    <div class="center-btn">
        <a href="index.php?action=books" class="btn-outline">Voir tous les livres</a>
    </div>
</section>

<section class="steps">
    <div class="steps-inner">
        <h2 class="section-title">Comment ça marche ?</h2>
        <p class="subtitle">Échanger des livres avec TomTroc c'est simple et<br> amusant ! Suivez ces étapes pour commencer :</p>

        <div class="steps-list">
            <div class="step">Inscrivez-vous gratuitement sur notre plateforme.</div>
            <div class="step">Ajoutez les livres que vous souhaitez échanger à votre profil.</div>
            <div class="step">Parcourez les livres disponibles chez d'autres membres.</div>
            <div class="step">Proposez un échange et discutez avec d'autres passionnés de lecture.</div>
        </div>

        <div class="center-btn">
            <a href="index.php?action=books" class="btn-outline">Voir tous les livres</a>
        </div>
    </div>
</section>

<section class="values">
    <div class="values-banner">
        <img src="img/books/xxx.jpg" alt="Nos valeurs">
    </div>

    <div class="values-content">
        <h2 class="title-left">Nos valeurs</h2>
        <p>Chez Tom Troc, nous mettons l'accent sur le partage, la découverte et la communauté. Nos valeurs sont ancrées dans notre passion pour les livres et notre désir de créer des liens entre les lecteurs. Nous croyons en la puissance des histoires pour rassembler les gens et inspirer des conversations enrichissantes. Notre association a été fondée avec une conviction profonde : chaque livre mérite d'être lu et partagé. Nous sommes passionnés par la création d'une plateforme conviviale qui permet aux lecteurs de se connecter, de partager leurs découvertes littéraires et d'échanger des livres qui attendent patiemment sur les étagères.</p>

        <div class="signature-box">
            <span class="team-name">L'équipe de Tom Troc</span>
            <img src="img/min/vector.png" alt="heart" class="heart">
        </div>
    </div>
</section>
