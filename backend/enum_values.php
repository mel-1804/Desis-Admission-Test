<?php
require 'db.php';

header('Content-Type: application/json');

try {
    $bodegas = $conn->query("SELECT unnest(enum_range(NULL::tipo_bodega))")->fetchAll(PDO::FETCH_COLUMN);
    $monedas = $conn->query("SELECT unnest(enum_range(NULL::tipo_moneda))")->fetchAll(PDO::FETCH_COLUMN);
    
    // Obtener sucursales por bodega
    $sucursalesPorBodega = [];

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

    echo json_encode([
        'bodegas' => $bodegas,
        'monedas' => $monedas,
        'sucursales_por_bodega' => $sucursalesPorBodega
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al obtener opciones: ' . $e->getMessage()]);
}
?>

