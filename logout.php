<?php
session_start();

// Konfigurasi URL Keycloak
$keycloakLogoutUrl = 'http://192.168.1.122:8080/realms/handalcorp/protocol/openid-connect/logout';
$redirectUri = 'http://localhost:82/kopi3/login.php'; // Sesuaikan dengan halaman login aplikasi Anda

try {
    // Cek jika sesi 'admin' ada, maka kita logout
    if (!empty($_SESSION['admin'])) {
        // Hapus sesi
        session_destroy();
        
        // Tambahkan log untuk debugging
        error_log("User logged out: " . $_SESSION['admin']);
        
        // Redirect ke Keycloak logout URL
        header("Location: $keycloakLogoutUrl?redirect_uri=" . urlencode($redirectUri));
        exit();
    } else {
        // Jika sesi tidak ada, arahkan langsung ke halaman login
        header('Location: ' . $redirectUri);
        exit();
    }
} catch (Exception $e) {
    // Tambahkan log untuk kesalahan
    error_log("Logout Error: " . $e->getMessage());
    echo "Logout Error: " . $e->getMessage();
}
?>
