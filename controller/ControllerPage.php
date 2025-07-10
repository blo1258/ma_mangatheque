<?php
class ControllerPage {
    public function homePage(){
        $pageTitle = "Accueil - Ma Mangathèque";
        $mainContent = "<h1>Bienvenue sur Ma Mangathèque</h1>";
        
        ob_start();
        require '/../view/page/homepage.php'; // Ana sayfa görünümünü dahil ediyoruz
        $content = ob_get_clean();
        require '/../view/base-html.php'; // Tüm sayfa yapısını içeren HTML şablonunu dahil ediyoruz
        
    }

    public function notFound() {
        $pageTitle = "404 Not Found";
        $mainContent = "<h1>Page non trouvée</h1><p>La page que vous cherchez n'existe pas.</p>";
        
        ob_start();
        require __DIR__ . '/../view/page/notfound.php'; // 404 sayfası görünümünü dahil ediyoruz
        $content = ob_get_clean();
        require __DIR__ . '/../view/page/base-html.php'; // Tüm sayfa yapısını içeren HTML şablonunu dahil ediyoruz
    }
}