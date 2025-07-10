<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manga detail </title>
</head>
<body>
    <?php // C:\wamp64\www\ma_mangatheque\view\manga\show.php ?>
    <img src="/ma_mangatheque/public/images/mangatheque-logo.png" alt="Ma Mangathèque Logo" class="site-logo">
    <div class="manga-detail">
        <?php if (!empty($manga['cover_image_url'])): ?>
            <img src="<?= htmlspecialchars($manga['cover_image_url']) ?>" alt="Cover image of <?= htmlspecialchars($manga['title']) ?>" style="max-width: 200px; max-height: 300px;">
        <?php endif; ?>

        <p><strong>Titre: </strong> <?= htmlspecialchars($manga['title'] ?? 'N/A') ?></p>
        <p><strong>Auteur: </strong> <?= htmlspecialchars($manga['author'] ?? 'N/A') ?></p>
        <p><strong>Année de publication: </strong> <?= htmlspecialchars($manga['publication_year'] ?? 'N/A') ?></p>
        <p><strong>Nombre de volumes: </strong> <?= htmlspecialchars($manga['volumes'] ?? 'N/A') ?></p>
        <p><strong>Statut: </strong> <?= htmlspecialchars($manga['status'] ?? 'N/A') ?></p>
        <p><strong>Synopsis: </strong> <?= htmlspecialchars($manga['synopsis'] ?? 'N/A') ?></p>

        <div class="actions">
            <a href="/ma_mangatheque/mangas/<?=htmlspecialchars($manga['id']) ?>/edit" class="button">Modifier</a>
            <form action="/ma_mangatheque/mangas/<?=htmlspecialchars($manga['id']) ?>/delete" method="POST" style="display:inline;">
            <button type="submit" class="button button-delete" onclick="return confirm('Es-tu sûr(e) de vouloir supprimer ce manga ?');">Supprimer ce manga</button>
            </form>
            <a href="/ma_mangatheque/mangas" class="button">Retour à la liste</a>
        </div>
    </div>
</body>
</html>