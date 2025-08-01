<?php
require 'db.php';

// ENDPOINT: POST ------------------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Solo se permite método POST']);
    exit;
}

// Leer datos JSON enviados desde frontend
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['error' => 'No se recibieron datos o formato inválido']);
    exit;
}

$codigo = $data['codigo'] ?? '';
$nombre = $data['nombre'] ?? '';
$bodega = $data['bodega'] ?? '';
$sucursal = $data['sucursal'] ?? '';
$moneda = $data['moneda'] ?? '';
$precio = $data['precio'] ?? 0;
$plastico = !empty($data['plastico']) ? true : false;
$metal = !empty($data['metal']) ? true : false;
$madera = !empty($data['madera']) ? true : false;
$vidrio = !empty($data['vidrio']) ? true : false;
$textil = !empty($data['textil']) ? true : false;
$descripcion = $data['descripcion'] ?? '';

try {
    // Validar unicidad código
    $stmtCheck = $conn->prepare('SELECT COUNT(*) FROM productos WHERE codigo = :codigo');
    $stmtCheck->execute(['codigo' => $codigo]);
    if ($stmtCheck->fetchColumn() > 0) {
        http_response_code(400);
        echo json_encode(['error' => 'El código del producto ya está registrado.']);
        exit;
    }

    // Insertar nuevo producto
    $stmt = $conn->prepare('INSERT INTO productos (codigo, nombre, bodega, sucursal, moneda, precio, plastico, metal, madera, vidrio, textil, descripcion)
                            VALUES (:codigo, :nombre, :bodega, :sucursal, :moneda, :precio, :plastico, :metal, :madera, :vidrio, :textil, :descripcion)');

    $stmt->execute([
        ':codigo' => $codigo,
        ':nombre' => $nombre,
        ':bodega' => $bodega,
        ':sucursal' => $sucursal,
        ':moneda' => $moneda,
        ':precio' => $precio,
        'plastico' => $plastico ? 1 : 0,
        'metal' => $metal ? 1 : 0,
        'madera' => $madera ? 1 : 0,
        'vidrio' => $vidrio ? 1 : 0,
        'textil' => $textil ? 1 : 0,
        ':descripcion' => $descripcion
    ]);

    echo json_encode(['message' => 'Producto guardado con éxito']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al guardar producto: ' . $e->getMessage()]);
}
?>
