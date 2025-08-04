<?php
$host = 'localhost';
$dbname = 'desis_products_db';
$user = 'postgres';
$password = '1804';

try {
    // Aquí se aplica la OOP, PDO es una clase, new PDO esta instanciando un objeto. El nuevo objeto se llama $conn (abreviatura de connection)
    // $conn, por convencion es la forma en que se representa una conexión a la base de datos en PHP.
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    // setAttribute es un método de la clase PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //PDOException es otra clase que se usa para manejar errores específicos de PDO
} catch (PDOException $e) {
    echo 'Error al conectar a la base de datos: ' . $e->getMessage();
    exit;
}
?>


