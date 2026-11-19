<?php
// Database connection. Update credentials if your XAMPP setup differs.
$host = 'localhost';
$db   = 'smart_campus_lost_found';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8mb4",
        $user,
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
} catch (PDOException $e) {
    exit('Database connection failed. Import database/smart_campus.sql in phpMyAdmin and check config/database.php.');
}
