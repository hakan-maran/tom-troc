<?php require_once __DIR__ . '/../../services/Utils.php';

use Services\Utils; ?>
<header class="site-header">
    <div class="header-inner">
        <nav class="nav">
            <div class="nav-left">
                <a href="index.php" class="logo">
                    <img src="img/min/logo.svg" alt="Logo">
                </a>
                <a href="index.php">Accueil</a>
                <a href="index.php?action=books">Nos livres à l’échange</a>
            </div>

                <?php if (Utils::isUserConnected()) : ?>
                        <img src="img/min/Line.svg" alt="séparateur" class="separator">
                        <div class="nav-right">
                            <div class="nav-item">
                                <img src="img/min/icon_messagerie.svg" alt="icon">
                                <a href="index.php?action=messages">Messagerie</a>

                                <?php
                                $unreadCount = $_SESSION['unread_count'] ?? 0;
                                // On vérifie si la session contient un chiffre > 0
                                if ($unreadCount > 0) : ?>
                                        <div class="badge-wrapper">
                                            <span class="badge-number"><?= htmlspecialchars($unreadCount) ?></span>
                                        </div>
                                <?php endif; ?>

                            </div>

                            <div class="nav-item">
                                <img src="img/min/icon_mon_compte.svg" alt="Logo mon compte">
                                <a href="index.php?action=profile">Mon compte</a>
                            </div>
                            <a href="index.php?action=logout" class="connexion">Déconnexion</a>
                        </div>
                <?php else : ?>
                        <div class="nav-right push-right">
                            <a href="index.php?action=login" class="connexion">Connexion</a>
                        </div>
                <?php endif; ?>
            </nav>
        </div>
    </header>