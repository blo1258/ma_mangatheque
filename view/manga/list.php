<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="manga-list-header">
        <img src="/ma_mangatheque/public/images/mangatheque-logo.png" alt="Ma Mangathèque Logo" class="site-logo">
        <form action="/ma_mangatheque/mangas" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Rechercher un manga..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            <button type="submit">Rechercher</button>
        </form>
        <a href="/ma_mangatheque/mangas/create" class="button button-add-top">Ajoute un nouveau manga</a>
    </div>

    <?php if (!empty($mangas)): ?>
        <div class="manga-grid">
            <?php foreach ($mangas as $manga): ?>
                <div class="manga-card">
                <a href="/ma_mangatheque/mangas/<?= htmlspecialchars($manga['id']) ?>" class="manga-link-wrapper">
                    <?php if (!empty($manga['cover_image_url'])): ?>
                        <img src="<?= htmlspecialchars($manga['cover_image_url']) ?>" alt="Cover image of <?= htmlspecialchars($manga['title']) ?>" class="manga-cover">
                    <?php endif; ?>
                    <h2 class="manga-title"><?= htmlspecialchars($manga['title']) ?></h2>
                    <p class="manga-author"><?= htmlspecialchars($manga['author']) ?></p>   
                </a> 
                
            </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="no-manga-message">Oups ! Aucun manga trouvé. <a href="/ma_mangatheque/mangas/create">Commence ta collection maintenant !</a></p>
<?php endif; ?>

<div class="bottom-add-button">
    <a href="/ma_mangatheque/mangas/create" class="button">Ajouter un nouveau manga</a>
</div>
</body>
</html>