<?php
$host = 'localhost';
$dbname = 'todo_app';
$username = 'root';
$password = 'ursuletuldeplus69';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Conexiunea la baza de date a eșuat: " . $e->getMessage();
    die();
}
?> 