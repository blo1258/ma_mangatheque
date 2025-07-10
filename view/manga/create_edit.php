<?php 
// C:\wamp64\www\ma_mangatheque\view\manga\create_edit.php 

// $manga değişkeni varsa düzenleme modundayız, yoksa oluşturma modundayız.
$isEditing = isset($manga) && !empty($manga['id']);

// Form başlığını ve eylem URL'sini ayarla
$formTitle = $isEditing ? "Modifier le Manga" : "Ajouter un Nouveau Manga";
$formAction = $isEditing ? "/ma_mangatheque/mangas/" . htmlspecialchars($manga['id']) . "/edit" : "/ma_mangatheque/mangas/store";

// Form alanları için mevcut değerleri al (düzenleme modundaysa)
$currentTitle = $isEditing ? htmlspecialchars($manga['title'] ?? '') : '';
$currentAuthor = $isEditing ? htmlspecialchars($manga['author'] ?? '') : '';
$currentPublicationYear = $isEditing ? htmlspecialchars($manga['publication_year'] ?? '') : '';
$currentNumberOfVolumes = $isEditing ? htmlspecialchars($manga['number_of_volumes'] ?? '') : '';
$currentStatus = $isEditing ? htmlspecialchars($manga['status'] ?? '') : '';
$currentSynopsis = $isEditing ? htmlspecialchars($manga['synopsis'] ?? '') : '';
$currentCoverImageUrl = $isEditing ? htmlspecialchars($manga['cover_image_url'] ?? '') : '';
?>

<div class="form-container">
    <h2><?= $formTitle ?></h2>

    <?php if (isset($_GET['error'])): ?>
        <p class="error-message"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif; ?>

    <form action="<?= $formAction ?>" method="POST" class="manga-form">
        <div class="form-group">
            <label for="title">Titre:</label>
            <input type="text" id="title" name="title" value="<?= $currentTitle ?>" required>
        </div>

        <div class="form-group">
            <label for="author">Auteur:</label>
            <input type="text" id="author" name="author" value="<?= $currentAuthor ?>" required>
        </div>

        <div class="form-group">
            <label for="publication_year">Année de publication:</label>
            <input type="number" id="publication_year" name="publication_year" value="<?= $currentPublicationYear ?>">
        </div>

        <div class="form-group">
            <label for="number_of_volumes">Nombre de volumes:</label>
            <input type="number" id="number_of_volumes" name="number_of_volumes" value="<?= $currentNumberOfVolumes ?>">
        </div>

        <div class="form-group">
            <label for="status">Statut:</label>
            <select id="status" name="status">
                <option value="En cours" <?= ($currentStatus == 'En cours') ? 'selected' : '' ?>>En cours</option>
                <option value="Terminé" <?= ($currentStatus == 'Terminé') ? 'selected' : '' ?>>Terminé</option>
                <option value="En pause" <?= ($currentStatus == 'En pause') ? 'selected' : '' ?>>En pause</option>
            </select>
        </div>

        <div class="form-group">
            <label for="synopsis">Synopsis:</label>
            <textarea id="synopsis" name="synopsis" rows="5"><?= $currentSynopsis ?></textarea>
        </div>

        <div class="form-group">
            <label for="cover_image_url">URL de l'image de couverture:</label>
            <input type="url" id="cover_image_url" name="cover_image_url" value="<?= $currentCoverImageUrl ?>">
        </div>

        <div class="form-actions">
            <button type="submit" class="button button-submit"><?= $isEditing ? 'Mettre à jour' : 'Ajouter le manga' ?></button>
            <a href="/ma_mangatheque/mangas" class="button button-cancel">Annuler</a>
        </div>
    </form>
</div>