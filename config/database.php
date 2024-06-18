

<?php
$dbHost = 'localhost';
$dbName = 'portfolio';
$dbUser = 'root';
$dbPassword = 'root';

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    throw new PDOException("Database connection error: " . $e->getMessage());
}
?>