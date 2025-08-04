<?php
require 'db.php'; 

// Este archivo recibe una solicitud GET con un parámetro codigo, y responde con un JSON que indica si ese código ya existe en la base de datos.
// La respuesta será un json.
header('Content-Type: application/json');

// Valida que haya recibido el parámetro codigo
if (!isset($_GET['codigo'])) {
    echo json_encode(['error' => 'No se recibió código']);
    exit;
}
 // Asigna el valor de código a la variable $codigo. $_GET es una sintaxis de PHP que permite acceder a los parámetros enviados por URL.
$codigo = $_GET['codigo'];

try {
    // Prepara la consulta para verificar si el código ya existe
    $stmt = $conn->prepare('SELECT COUNT(*) FROM productos WHERE codigo = :codigo');
    $stmt->execute(['codigo' => $codigo]);
    // Fetch el resultado, que será un número de filas que coinciden con el código
    $exists = $stmt->fetchColumn() > 0;

    echo json_encode(['exists' => $exists]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al consultar base de datos']);
}
// Cada uno de estos métodos (prepare, execute, fetchColumn) son métodos de objetos, lo cual sí es OOP, aunque no se haya creado una clase propia.
?>
