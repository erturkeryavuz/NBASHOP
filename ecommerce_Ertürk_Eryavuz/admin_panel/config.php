<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
} //--we started session--

// Display PHP errors (modify to suit your needs)
ini_set('display_errors', '1'); // 1 is on, 0 is off
ini_set('display_startup_errors', '1'); // 1 is on, 0 is off
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Functions
if (!function_exists('berkhoca_query_parser')) {
    function berkhoca_query_parser($sql='') {
        global $conn;
        if (empty($sql)) {
            return 'sql statement is empty';
        }
        $query_result = $conn->query($sql);
        $array_result = [];
        while ($row = $query_result->fetch_assoc()) {
            $array_result[] = $row;
        }
        return $array_result;
    }
}

if (!function_exists('berk_hoce_insert_or_delete')) {
    function berk_hoce_insert_or_delete($sql='') {
        global $conn;
        if (empty($sql)) {
            return 'sql statement is empty';
        }
        $query_result = $conn->query($sql);
        return $query_result;
    }
}
?>
