<?php
require 'db.php';

// Se define el tipo de contenido de la respuesta como JSON. Es un fetch de tipo GET
header('Content-Type: application/json');

try {
    // Usa una función nativa de PostgreSQL: enum_range(NULL::<tipo_enum>) para obtener todos los valores posibles de un tipo ENUM definido en la base de datos.
    // Con unnest(...) convierte el array en filas individuales.
    $bodegas = $conn->query("SELECT unnest(enum_range(NULL::tipo_bodega))")->fetchAll(PDO::FETCH_COLUMN);
    $monedas = $conn->query("SELECT unnest(enum_range(NULL::tipo_moneda))")->fetchAll(PDO::FETCH_COLUMN);
    
    // Obtener sucursales por bodega, parte como un arreglo vacío.
    $sucursalesPorBodega = [];

    //Iteramos sobre $bodegas y asignamos las sucursales correspondientes a cada bodega.
    foreach ($bodegas as $bodega) {
        switch ($bodega) {
            case 'norte':
                $sucursalesPorBodega[$bodega] = ['iquique', 'calama'];
                break;
            case 'centro':
                $sucursalesPorBodega[$bodega] = ['valparaiso', 'santiago'];
                break;
            case 'sur':
                $sucursalesPorBodega[$bodega] = ['concepcion', 'temuco'];
                break;
            default:
                $sucursalesPorBodega[$bodega] = [];
        }
    }

    // Se envían los datos como un JSON al cliente.
    echo json_encode([
        'bodegas' => $bodegas,
        'monedas' => $monedas,
        'sucursales_por_bodega' => $sucursalesPorBodega
    ]);
    //Manejo de errores
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al obtener opciones: ' . $e->getMessage()]);
}
?>

