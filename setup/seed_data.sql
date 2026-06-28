-- Jeu de données pour la base tomtroc
USE tomtroc;

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE messages;
TRUNCATE TABLE books;
TRUNCATE TABLE users;
SET FOREIGN_KEY_CHECKS = 1;

-- Utilisateurs
INSERT INTO users (id, username, email, password, avatar, created_at) VALUES
(1, 'janedoe', 'jane@example.com', '$2y$12$xE/q8atlTYtMZz1nQeediNe9lMrIPgAPUCnAen9UB/Rvg24bMHhCl2', 'avatar_2_6a33f6b0e1195.jpg', '2025-08-12 10:15:00'),
(2, 'thomas', 'thomas@example.com', '$2y$12$OB0JuK6xe6cRNFJO32FdLOxrj1n5N/xDqElatdRGcM.7hg1B2XfE2', 'avatar_2_6a340c00990da.png', '2025-08-13 09:05:00'),
(3, 'claire', 'claire@example.com', '$2y$12$UrNQjWS7a5TeW.AM9AvNUe18kwzO1mTIxF1YOcBH3BFc8HG29C2CS', 'avatar_2_6a340c282ca7c.jpg', '2025-08-14 14:22:00'),
(4, 'marc', 'marc@example.com', '$2y$12$iSH0DyoFQlntj475WwygNONdvR01ZKaB.zQF2OYk/sCXro/1esFOe', 'avatar_2_6a3d31a8713f7.jpg', '2025-08-15 11:43:00'),
(5, 'sophie', 'sophie@example.com', '$2y$12$OkCsihsC2QOrwWyD4nRB1OjpvWa4nWRSTfhwVpZuvfVcGg.2euOy6', 'avatar_2_6a3d31b265120.jpg', '2025-08-16 18:30:00'),
(6, 'julien', 'julien@example.com', '$2y$12$SiFzFPwUP442nrB5Tu6xSOsJf61nnLzbdxuqWVYhEo2evHKMgC8Ue', 'avatar_2_6a3d32d26db7a.jpg', '2025-08-17 08:05:00'),
(7, 'emma', 'emma@example.com', '$2y$12$iOgCX7FWWjnmhJYUQT0vJOHAGhx5thcLjf7m2w9ehhUJxCJYWyrz2', 'avatar_2_6a3d32f146afd.jpg', '2025-08-18 15:10:00'),
(8, 'nicolas', 'nicolas@example.com', '$2y$12$MeroDJylT4YMCa6TlN836uzD6JMzlW0oADCK606/1WUUwq3Ko01ea', 'avatar_2_6a3d450898edb.jpg', '2025-08-19 12:50:00'),
(9, 'elise', 'elise@example.com', '$2y$12$/na9HajHPiNoGsTE99vY6.rbUGBSz8P/05oML8QRit6tM0TAUY.c2', 'avatar_4_6a35393dd761e.jpg', '2025-08-20 13:20:00'),
(10, 'lucas', 'lucas@example.com', '$2y$12$qhlTMkjrORXS/BtZh7bciOqI7tRLJVhw3TWvzDZDsKH8XfEJ673ve', 'avatar_4_6a35395d58268.jpg', '2025-08-21 16:45:00');

-- Livres
INSERT INTO books (id, user_id, title, author, image, description, is_available) VALUES
(1, 1, 'Le Petit Prince', 'Antoine de Saint-Exupéry', 'lotr.png', 'Un classique intemporel qui invite à redécouvrir la poésie et la simplicité du regard d’un enfant.', 1),
(2, 2, 'Wabi Sabi', 'Leonard Koren', 'wabi_sabi.png', 'Exploration de la beauté de l’imperfection et de l’authenticité dans la vie quotidienne.', 0),
(3, 3, 'Milk and Honey', 'Rupi Kaur', 'milk_honey.png', 'Recueil de poèmes sur l’amour, la douleur, la guérison et la féminité.', 1),
(4, 4, 'Harry Potter et la Chambre des Secrets', 'J.K. Rowling', 'book_10_6a3981544c623.jpg', 'La deuxième aventure du jeune sorcier dans l’école de Poudlard.', 1),
(5, 5, 'Hope', 'Auteur Inconnu', 'book_hope.jpg', 'Un récit plein d’émotion, sur la force de la confiance et le renouveau.', 1),
(6, 6, 'Le Seigneur des Anneaux : La Communauté de l’Anneau', 'J.R.R. Tolkien', 'alabaster.png', 'Épopée fantastique et quête légendaire pour sauver le monde de l’ombre.', 1),
(7, 7, 'Code 42', 'Jules Verne', 'book_13_6a3d457c7864e.jpg', 'Aventure et science-fiction dans un récit d’anticipation stimulant.', 0),
(8, 8, 'Livre Secret', 'Anonyme', 'book_6_6a3d320307aa5.jpg', 'Un roman mystérieux rempli de tensions et de symboles cachés.', 1),
(9, 9, 'Le Voyage', 'Paul Auster', 'book_8_6a33f9643cf90.jpg', 'Une histoire d’exploration intérieure et de destin entrecroisé.', 1),
(10, 10, 'Noir et Blanc', 'Marie Dubois', 'book_9_6a3402d7b7772.jpg', 'Un polar urbain qui confronte les personnages à des choix difficiles.', 0),
(11, 1, 'Le Manuscrit', 'Lucie Martin', 'book_6_6a3d321ba92c0.png', 'Un roman contemporain sur la recherche de soi et la trace laissée par les mots.', 1),
(12, 2, 'Rêves d’été', 'Maya Angelou', 'book_8_6a33f9c9e2d45.jpg', 'Poésie et souvenirs d’une saison lumineuse et chargée d’émotion.', 1),
(13, 3, 'Histoires de demain', 'Antoine Dupont', 'book_hope.png', 'Nouvelles visionnaires sur les transformations du monde et de l’humanité.', 1),
(14, 4, 'La Bibliothèque', 'Claire Simon', 'image_inscription.jpg', 'Une plongée dans un espace rempli de livres, de secrets et de rencontres inattendues.', 1),
(15, 5, 'XXX', 'Auteur X', 'xxx.jpg', 'Un roman percutant qui explore des thèmes contemporains avec intensité.', 0);

-- Messages
INSERT INTO messages (id, sender_id, receiver_id, content, is_read, created_at) VALUES
(1, 1, 2, 'Bonjour Thomas, j’ai vu ton livre disponible et je serais intéressée pour l’échanger.', 0, '2025-09-01 09:10:00'),
(2, 2, 1, 'Salut Jane, oui bien sûr ! Peux-tu récupérer le livre cette semaine ?', 1, '2025-09-01 10:15:00'),
(3, 3, 4, 'Marc, as-tu toujours le livre de poésie que tu as mentionné ?', 0, '2025-09-02 14:00:00'),
(4, 4, 3, 'Bonjour Claire, oui il est encore disponible. On peut se voir jeudi soir ?', 1, '2025-09-02 14:30:00'),
(5, 5, 6, 'Julien, j’aime beaucoup ton annonce, peux-tu m’en dire plus sur l’état du livre ?', 0, '2025-09-03 12:05:00'),
(6, 6, 5, 'Bonjour Sophie, le livre est en très bon état et je peux l’apporter près de la gare.', 1, '2025-09-03 12:40:00'),
(7, 7, 8, 'Emma, est-ce que ton livre est encore disponible pour échange ?', 0, '2025-09-04 18:20:00'),
(8, 8, 7, 'Oui Nicolas, il est prêt à être échangé. Dis-moi juste quand tu es libre.', 1, '2025-09-04 18:50:00');
