<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Mon Site') ?></title>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
</head>
<body>

    <?php $this->partial('navbar') ?>

    <main class="container">
        <?= $content ?>     <!-- Content of the view -->
    </main>

    <?php $this->partial('footer') ?>

</body>
</html>
