<?php
// Hata raporlamayı etkinleştirme
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Veritabanı bağlantı ayarları
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce_db";

// Bağlantıyı oluştur
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

// Sadece bir kez session başlatmak için kontrol ekle
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
