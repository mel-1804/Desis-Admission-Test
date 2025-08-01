<?php
require 'db.php'; // Conexión a la base de datos

header('Content-Type: application/json');

if (!isset($_GET['codigo'])) {
    echo json_encode(['error' => 'No se recibió código']);
    exit;
}

$codigo = $_GET['codigo'];

try {
    $stmt = $conn->prepare('SELECT COUNT(*) FROM productos WHERE codigo = :codigo');
    $stmt->execute(['codigo' => $codigo]);
    $exists = $stmt->fetchColumn() > 0;

    echo json_encode(['exists' => $exists]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al consultar base de datos']);
}
?>
