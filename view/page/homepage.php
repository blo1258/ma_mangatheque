<?php ?>
<div class="homepage-container">
    <div class="jumbotron text-center">
        <h1 class="display-4"><?= htmlspecialchars($welcomeMessage ?? 'Bienvenue !') ?></h1>
        <p class="lead"><?= htmlspecialchars($introText ?? 'Votre porte d\'entrée vers le monde des mangas.') ?></p>
        <hr class="my-4">
        <p>
            Prêt(e) à plonger dans l'aventure ?
        </p>
        <p class="lead">
            <a class="btn btn-primary btn-lg" href="/ma_mangatheque/mangas" role="button">Découvrir tous les mangas</a>
            <a class="btn btn-success btn-lg ml-3" href="/ma_mangatheque/mangas/create" role="button">Ajouter un nouveau manga</a>
        </p>
    </div>

    <?php /* if (isset($latestNews) && !empty($latestNews)): */ ?>
    <div class="row my-5">
        <div class="col-md-12">
            <h2>Dernières Actualités</h2>
            <div class="list-group">
                <?php /* foreach ($latestNews as $news): */ ?>
                    <?php /* endforeach; */ ?>
                <p>Yakında haberler gelecek!</p>
            </div>
        </div>
    </div>
    <?php /* endif; */ ?>

    <?php if (isset($recentMangas) && !empty($recentMangas)): ?>
    <div class="row my-5">
        <div class="col-md-12">
            <h2>Mangas Récemment Ajoutés</h2>
            <div class="row">
                <?php foreach ($recentMangas as $manga): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <?php /* if ($manga->getImagePath()): ?>
                                <img src="/ma_mangatheque/<?= htmlspecialchars($manga->getImagePath()) ?>" class="card-img-top" alt="<?= htmlspecialchars($manga->getTitle()) ?>">
                            <?php else: */ ?>
                                <img src="/ma_mangatheque/public/img/default-manga.jpg" class="card-img-top" alt="Image par défaut">
                            <?php /* endif; */ ?>
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($manga->getTitle()) ?></h5>
                                <p class="card-text"><small class="text-muted"><?= htmlspecialchars($manga->getAuthor()) ?></small></p>
                                <a href="/ma_mangatheque/mangas/view/<?= htmlspecialchars($manga->getId()) ?>" class="btn btn-sm btn-outline-primary">Voir Détails</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if (isset($isAdmin) && $isAdmin): ?>
    <div class="row my-5">
        <div class="col-md-12">
            <h2>Menu Administrateur</h2>
            <ul class="list-group">
                <li class="list-group-item"><a href="/ma_mangatheque/admin/dashboard">Tableau de bord Admin</a></li>
                <li class="list-group-item"><a href="/ma_mangatheque/users">Gérer les utilisateurs</a></li>
                </ul>
        </div>
    </div>
    <?php endif; ?>

</div>