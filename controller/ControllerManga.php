<?php
// C:\wamp64\www\ma_mangatheque\controller\ControllerManga.php
// BURADA SADECE ModelManga'yı dahil ediyoruz, Database.php'yi değil.
// Çünkü ModelManga zaten Model'den türeyecek ve Model içinde DB bağlantısı var.
require_once './model/ModelManga.php'; // ModelManga sınıfını dahil ediyoruz
// Eğer ControllerPage'i kullanacaksak, onu da dahil edebiliriz.
require_once './controller/ControllerPage.php'; // ControllerPage sınıfını dahil ediyoruz

class ControllerManga {

    public function listManga() {
        
        $modelManga = new ModelManga(); // ModelManga nesnesi oluştur

        $searchTerm = filter_input(INPUT_GET, 'search', FILTER_UNSAFE_RAW); // Arama terimini al
        

       

        if (!empty($searchTerm)) { // Eğer arama terimi boş değilse (null veya boş string değilse)
            $mangas = $modelManga->searchManga($searchTerm); // Modeldeki arama metodunu çağır
            $mainHeading = "Résultats de recherche pour : \"" . htmlspecialchars($searchTerm) . "\"";
        } else {
            $mangas = $modelManga->getAllMangas(); // Tüm mangaları getir (metod adı getAllManga, getAllMangas değil)
            $mainHeading = "Liste de tous les Mangas";
        }

        $pageTitle = "Ma Mangathèque - Liste des Mangas";

        

        ob_start();
        require './view/manga/list.php'; // Manga listesi görünümünü dahil ediyoruz
        $content = ob_get_clean();

        // **BURASI KRİTİK DÜZELTME:** base-html.php dosya yolu
        require './view/base-html.php'; // Tüm sayfa yapısını içeren HTML şablonunu dahil ediyoruz
    }

    // Diğer Manga CRUD metotları buraya eklenecek:
    // public function createMangaForm() { ... }

    public function createMangaForm() {
        $pageTitle = "Ajouter un Manga - Ma Mangathèque";
        $mainContent = "<h1>Ajoute un manga à ta Mangatheque ! </h1>";
        
        ob_start();
        require './view/manga/create_edit.php'; // Manga ekleme formu görünümünü dahil ediyoruz
        $content = ob_get_clean();
        require './view/base-html.php'; // Tüm sayfa yapısını içeren HTML şablonunu dahil ediyoruz
    }

    // public function storeManga() { ... }
    public function storeManga() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $modelManga = new ModelManga(); // ModelManga nesnesi oluştur

            // POST verilerini al ve boşlukları temizle
            $data = [
                // FILTER_SANITIZE_STRING yerine FILTER_UNSAFE_RAW ve htmlspecialchars kullanıyoruz
                'title' => htmlspecialchars(filter_input(INPUT_POST, 'title', FILTER_UNSAFE_RAW) ?? '', ENT_QUOTES, 'UTF-8'),
                'author' => htmlspecialchars(filter_input(INPUT_POST, 'author', FILTER_UNSAFE_RAW) ?? '', ENT_QUOTES, 'UTF-8'),
                'publication_year' => filter_input(INPUT_POST, 'publication_year', FILTER_VALIDATE_INT),
                'synopsis' => htmlspecialchars(filter_input(INPUT_POST, 'synopsis', FILTER_UNSAFE_RAW) ?? '', ENT_QUOTES, 'UTF-8'),
                'volumes' => filter_input(INPUT_POST, 'volumes', FILTER_VALIDATE_INT),
                'cover_image_url' => filter_input(INPUT_POST, 'cover_image_url', FILTER_SANITIZE_URL), // Bu hala geçerli
                'status' => htmlspecialchars(filter_input(INPUT_POST, 'status', FILTER_UNSAFE_RAW) ?? '', ENT_QUOTES, 'UTF-8')
            ];

            if (empty($data['title']) || empty($data['author'])) {
                echo "<p>Erreur: Le titre du manga est obligatoire !</p>";
                exit;
            }

            if ($modelManga->addManga($data)) {
                header('Location: /ma_mangatheque/mangas'); // Başarılı ekleme sonrası manga listesine yönlendir
                exit;
            } else {
                echo "<p>Une erreur est survenue lors de l'ajout du manga.</p>";
            }
        } else {
            header('Location: /ma_mangatheque/manga/create'); // POST olmayan isteklerde form sayfasına yönlendir
            exit;
        }

            
    }
    // public function showManga(int $id) { ... }

    public function showManga(int $id) {
        $modelManga = new ModelManga();
        $manga = $modelManga->getMangaById($id);
        if (!$manga) {
            http_response_code(404);
            echo "<p>404 Not Found - Manga not found.</p>";
            exit;
        } 
        $pageTitle = "Manga Details - " . htmlspecialchars($manga['title']);
        $mainHeading = "<h1>" . htmlspecialchars($manga['title']) . "</h1>";

        ob_start();
        require './view/manga/show.php'; // Manga detay görünümünü dahil ediyoruz
        $content = ob_get_clean();
        require './view/base-html.php'; // Tüm sayfa yapısını içeren HTML şablonunu dahil ediyoruz

    }   
    
    
    // public function editMangaForm(int $id) { ... }
    // public function updateManga(int $id) { ... }
    // public function deleteManga(int $id) { ... }

    public function deleteManga(int $id) {
        $modelManga = new ModelManga();
        if ($modelManga->deleteManga($id)) {
            header('Location: /ma_mangatheque/mangas?message=Manga supprimé avec succès!'); // Manga silindikten sonra manga listesine yönlendir
            exit;
        } else {
            echo "<p>Une erreur est survenue lors de la suppression du manga.</p>";
        }
    }

    public function editMangaForm(int $id) {
        $modelManga = new ModelManga();
        $manga = $modelManga->getMangaById($id);
        if (!$manga) {
            require_once './controller/ControllerPage.php'; // ControllerPage'i dahil ediyoruz
            $controllerPage = new ControllerPage();
            $controllerPage->notFound(); // Manga bulunamazsa 404 sayfasına yönlendir
            return;

        } 

        $pageTitle = "Modifier le Manga - " . htmlspecialchars($manga['title']);
        $mainHeading = "<h1>Modifier le Manga: " . htmlspecialchars($manga['title']) . "</h1>";

        ob_start();
        require './view/manga/create_edit.php'; // Manga düzenleme formu görünümünü dahil ediyoruz
        $content = ob_get_clean();
        require './view/base-html.php'; // Tüm sayfa yapısını içeren HTML şablonunu dahil ediyoruz
    }

    public function updateManga(int $id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $modelManga = new ModelManga(); // ModelManga nesnesi oluştur

            // POST verilerini al ve boşlukları temizle
            $data = [
                'title' => htmlspecialchars(filter_input(INPUT_POST, 'title', FILTER_UNSAFE_RAW) ?? '', ENT_QUOTES, 'UTF-8'),
                'author' => htmlspecialchars(filter_input(INPUT_POST, 'author', FILTER_UNSAFE_RAW) ?? '', ENT_QUOTES, 'UTF-8'),
                'publication_year' => filter_input(INPUT_POST, 'publication_year', FILTER_VALIDATE_INT),
                'synopsis' => htmlspecialchars(filter_input(INPUT_POST, 'synopsis', FILTER_UNSAFE_RAW) ?? '', ENT_QUOTES, 'UTF-8'),
                'volumes' => filter_input(INPUT_POST, 'number_of_volumes', FILTER_VALIDATE_INT),
                'cover_image_url' => filter_input(INPUT_POST, 'cover_image_url', FILTER_SANITIZE_URL), // Bu hala geçerli
                'status' => htmlspecialchars(filter_input(INPUT_POST, 'status', FILTER_UNSAFE_RAW) ?? '', ENT_QUOTES, 'UTF-8')
            ];

            if (empty($data['title']) || empty($data['author'])) {
                echo "<p>Erreur: Le titre du manga est obligatoire !</p>";
                exit;
            }

            if ($modelManga->updateManga($id, $data)) {
                header('Location: /ma_mangatheque/mangas/' . $id); // Başarılı güncelleme sonrası manga detayına yönlendir
                exit;
            } else {
                echo "<p>Une erreur est survenue lors de la mise à jour du manga.</p>";
            }
        } else {
            header('Location: /ma_mangatheque/mangas/' . $id . '/edit'); // POST olmayan isteklerde düzenleme formuna yönlendir
            exit;
        }
    }




}