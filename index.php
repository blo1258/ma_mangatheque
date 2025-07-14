<?php
// Hata raporlamayı maksimum seviyeye getir
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Oturum henüz başlatılmadıysa başlat
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Composer autoload dosyasını dahil et (Mutlak yol kullanıyoruz)
// Bu dosya, AltoRouter dahil tüm bağımlılıkları otomatik olarak yükleyecektir.
require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/model/Model.php';
require_once __DIR__ . '/model/ModelManga.php';


// AltoRouter nesnesini oluştur
$router = new AltoRouter();
$router->setBasePath('/ma_mangatheque'); 

// --- Rota Tanımları ---
// !!! ÖNEMLİ: Daha spesifik ve sabit rotalar, daha genel rotalardan önce gelmelidir! !!!

// 1. Anasayfa (En basit rota)
$router->map('GET', '/', 'ControllerPage#homePage', 'homepage'); 

// 2. Manga Ekleme Formu (Sabit ve spesifik bir yol)
$router->map('GET', '/mangas/create', 'ControllerManga#createMangaForm', 'manga_create_form'); 

// 3. Manga Ekleme İşlemi (POST isteği olduğu için sıralamada sorun yaratmaz)
$router->map('POST', '/mangas/store', 'ControllerManga#storeManga', 'mangas_store');

// 4. Manga Detay Sayfası (Dinamik bir ID içeriyor, ama [i:id] formatı spesifik)
// BU ROTA, /mangas rotasından ÖNCE GELMELİ!
$router->map('GET', '/mangas/[i:id]', 'ControllerManga#showManga', 'mangas_show');

$router->map('POST', '/mangas/[i:id]/delete', 'ControllerManga#deleteManga', 'mangas_delete'); // Manga Silme İşlemi

$router->map('GET', '/mangas/[i:id]/edit', 'ControllerManga#editMangaForm', 'mangas_edit_form'); // Manga Düzenleme Formu
$router->map('POST', '/mangas/[i:id]/edit', 'ControllerManga#updateManga', 'mangas_update'); // Manga Güncelleme İşlemi

// 5. Manga Listesi (En genel rota - Arama parametresi GET ile geleceği için rota tanımına dahil edilmez)
// BU ROTA, tüm diğer /mangas/* rotalarından SONRA GELMELİ!
$router->map('GET', '/mangas/?', 'ControllerManga#listManga', 'mangas_list'); 

// --- Rota Eşleşmesini Yürütme ---
$match = $router->match();

if ($match) { // Eşleşme bulunduysa
    list($controllerName, $methodName) = explode("#", $match['target']);
    
    // Controller dosyasının yolunu belirle (Mutlak yol kullanıyoruz)
    $controllerFilePath = __DIR__ . '/controller/' . $controllerName . '.php';

    // 1. Controller dosyasının varlığını kontrol et
    if (!file_exists($controllerFilePath)) {
        // Eğer controller dosyası yoksa, 404 hata sayfasına yönlendir.
        require_once __DIR__ . '/controller/ControllerPage.php'; 
        $controller = new ControllerPage();
        $controller->notFound();
        exit; // Yönlendirme sonrası betiği durdur
    }
    require_once $controllerFilePath; // Controller dosyasını dahil et

    // 2. Sınıfın varlığını kontrol et
    if (!class_exists($controllerName)) {
        // Eğer sınıf yoksa, 404 hata sayfasına yönlendir.
        require_once __DIR__ . '/controller/ControllerPage.php'; 
        $controller = new ControllerPage();
        $controller->notFound();
        exit; // Yönlendirme sonrası betiği durdur
    }

    $controller = new $controllerName(); // Controller nesnesini oluştur

    // 3. Metodun çağrılabilirliğini kontrol et
    if (is_callable(array($controller, $methodName))) {
        // Parametreleri metoda geçirerek çağır
        call_user_func_array(array($controller, $methodName), $match['params']);
    } else {
        // Eğer metot çağrılamazsa, 404 hata sayfasına yönlendir.
        require_once __DIR__ . '/controller/ControllerPage.php'; 
        $controller = new ControllerPage();
        $controller->notFound();
        exit; // Yönlendirme sonrası betiği durdur
    }

} else { // Eşleşme bulunamadıysa (404 Not Found)
    // Rota eşleşmediğinde 404 hata sayfasına yönlendir.
    require_once __DIR__ . '/controller/ControllerPage.php'; // ControllerPage'i dahil et
    $controller = new ControllerPage();
    $controller->notFound();
    exit; // Yönlendirme sonrası betiği durdur
}
?>