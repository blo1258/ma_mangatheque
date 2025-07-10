<?php
// C:\wamp64\www\ma_mangatheque\model\ModelManga.php
require_once 'Model.php'; // Model sınıfını dahil ediyoruz

class ModelManga extends Model {

    public function getAllMangas() {
        // Model sınıfından veritabanı bağlantısını alıyoruz
        $pdo = $this->getDb(); 
        
        $stmt = $pdo->query("SELECT * FROM mangas");
        return $stmt->fetchAll();
    }

    public function searchManga(string $searchTerm) {
        $pdo = $this->getDb();
        // Arama terimini LIKE sorgusu için hazırlıyoruz
        // Her iki tarafına % ekleyerek terimi içeren sonuçları bulacağız
        $searchWildcard = '%' . $searchTerm . '%';

        // Başlık veya yazar alanında arama yapıyoruz
        $stmt = $pdo->prepare("SELECT * FROM mangas WHERE title LIKE ? OR author LIKE ? ORDER BY title ASC");
        $stmt->execute([$searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }

    // Diğer CRUD metodları (getOneMangaById, addManga, updateManga, deleteManga) 
    // ajouter
    public function addManga(array $data) {
        $pdo = $this->getDb();

        $sql = "INSERT INTO mangas (title, author, publication_year, synopsis, volumes, cover_image_url, status) 
                VALUES (:title, :author, :publication_year, :synopsis, :volumes, :cover_image_url, :status)";

        $stmt = $pdo->prepare($sql);

        return $stmt->execute ([
            ':title' => $data['title'] ?? null,
            ':author' => $data['author'] ?? null,
            ':publication_year' => $data['publication_year'] ?? null,
            ':synopsis' => $data['synopsis'] ?? null,
            ':volumes' => $data['volumes'] ?? null,
            ':cover_image_url' => $data['cover_image_url'] ?? null,
            ':status' => $data['status'] ?? null    
        ]);
    }

    public function getMangaById(int $id) {
        $pdo = $this->getDb();
        $sql = "SELECT * FROM mangas WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function deleteManga(int $id) {
        $pdo = $this->getDb();
        $sql = "DELETE FROM mangas WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function updateManga(int $id, array $data) {
        $pdo = $this->getDb();
        $sql = "UPDATE mangas SET 
                title = :title, 
                author = :author, 
                publication_year = :publication_year, 
                synopsis = :synopsis, 
                volumes = :volumes, 
                cover_image_url = :cover_image_url, 
                status = :status 
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':title' => $data['title'] ?? null,
            ':author' => $data['author'] ?? null,
            ':publication_year' => $data['publication_year'] ?? null,
            ':synopsis' => $data['synopsis'] ?? null,
            ':volumes' => $data['volumes'] ?? null,
            ':cover_image_url' => $data['cover_image_url'] ?? null,
            ':status' => $data['status'] ?? null,
            ':id' => $id
        ]);
    }


}