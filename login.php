
<?php
require 'vendor/autoload.php';
require 'keycloak-config.php';

use Jumbojett\OpenIDConnectClient;

session_start();

// Inisialisasi client OIDC untuk Keycloak
$oidc = new OpenIDConnectClient(
    KEYCLOAK_URL,
    CLIENT_ID,
    CLIENT_SECRET
);
$oidc->setRedirectURL(REDIRECT_URI);

try {
    // Cek jika sesi 'admin' belum ada, maka lakukan autentikasi
    if (empty($_SESSION['admin'])) {
        $oidc->authenticate();
        // Menyimpan user ke sesi setelah autentikasi berhasil
        $_SESSION['admin'] = $oidc->requestUserInfo('preferred_username');
        header('Location: index.php'); // Arahkan ke halaman utama
        exit();
    }
} catch (Exception $e) {
    echo "Login Error: " . $e->getMessage();
}
?>
