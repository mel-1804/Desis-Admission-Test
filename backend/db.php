<?php
$host = 'localhost';
$dbname = 'desis_products_db';
$user = 'postgres';
$password = '1804';

try {
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    // Opciones para lanzar excepciones en errores
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error al conectar a la base de datos: ' . $e->getMessage();
    exit;
}
?>


