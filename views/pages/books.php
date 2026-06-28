<section class="books-page">
    <div class="container">
        <header class="books-header">
            <h1 class="page-title">Nos livres à l’échange</h1>
            <div class="search-bar">
                <form action="index.php" method="GET">
                    <input type="hidden" name="action" value="books">
                    <div class="search-section">
                        <label for="search-input" class="visually-hidden">Rechercher un titre par son titre</label>
                        <img src="/img/min/search.png" alt="">
                        <input type="text" name="search" id="search-input" placeholder="Rechercher un livre"
                            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                    </div>
                </form>
            </div>
        </header>

        <section class="books-grid">
            <?php if (isset($books) && !empty($books)) : ?>
                <?php foreach ($books as $book) : ?>
                    <article class="book-card">
                        <a href="index.php?action=book&id=<?= htmlspecialchars($book->getId()) ?>">
                            <div class="book-image">
                                <img src="img/books/<?= htmlspecialchars($book->getImage() ?: 'default_book.png') ?>"
                                    alt="<?= htmlspecialchars($book->getTitle()) ?>">
                                <?php if ($book->getIsAvailable() === false) : ?>
                                    <span class="badge-non-disponible">non dispo.</span>
                                <?php endif; ?>
                            </div>
                            <div class="book-info">
                                <h2 class="book-title"><?= htmlspecialchars($book->getTitle()) ?></h2>
                                <p class="book-author">par <?= htmlspecialchars($book->getAuthor()) ?></p>
                                <?php
                                $userManager = new \Models\Managers\UserManager();
                                $seller = $userManager->findById($book->getUserId());
                                $sellerName = $seller ? $seller->getUsername() : 'Inconnu';
                                ?>
                                <p class="book-seller">Vendu par : <?= htmlspecialchars($sellerName) ?></p>
                            </div>
                        </a>
                    </article>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="no-results">
                    <p>Désolé, aucun livre ne correspond à votre recherche
                        "<strong><?= htmlspecialchars($_GET['search'] ?? '') ?></strong>".</p>
                    <a href="index.php?action=books" class="btn-back">Voir tous les livres</a>
                </div>
            <?php endif; ?>
        </section>
    </div>
</section>