-- Archivo que contiene la estructura de la base de datos
-- Creación de la base de datos y tabla de productos
CREATE TABLE productos (
    id SERIAL PRIMARY KEY,
    codigo VARCHAR(15) NOT NULL CHECK (
        char_length(codigo) >= 5
        AND char_length(codigo) <= 15
    ),
    nombre VARCHAR(50) NOT NULL CHECK (
        char_length(nombre) >= 2
        AND char_length(nombre) <= 50
    ),
    bodega VARCHAR(100) NOT NULL,
    sucursal VARCHAR(100) NOT NULL,
    moneda VARCHAR(10) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL CHECK (precio >= 0),
    plastico BOOLEAN DEFAULT FALSE,
    metal BOOLEAN DEFAULT FALSE,
    madera BOOLEAN DEFAULT FALSE,
    vidrio BOOLEAN DEFAULT FALSE,
    textil BOOLEAN DEFAULT FALSE,
    descripcion VARCHAR(1000) CHECK (
        char_length(descripcion) >= 10
        AND char_length(descripcion) <= 1000
    ),
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- Creación de ENUM para las monedas.
CREATE TYPE tipo_moneda AS ENUM ('CLP', 'USD', 'EUR', 'UF', 'BTC');
-- Para consultar los valores del ENUM tipo_moneda
SELECT enumlabel
FROM pg_enum
    JOIN pg_type ON pg_enum.enumtypid = pg_type.oid
WHERE pg_type.typname = 'tipo_moneda';
--Creación de ENUM para bodegas y sucursales.
-- Tipo para las bodegas
CREATE TYPE tipo_bodega AS ENUM ('norte', 'centro', 'sur');
-- Tipo para las sucursales
CREATE TYPE tipo_sucursal AS ENUM (
    'iquique',
    'calama',
    'valparaiso',
    'santiago',
    'concepcion',
    'temuco'
);
--Creación de tabla que relacione bodegas y sucursales.
CREATE TABLE bodega_sucursal (
    bodega tipo_bodega,
    sucursal tipo_sucursal
);
-- Insertar datos en la tabla bodega_sucursal estableciendo la relación efectiva entre bodegas y sucursales
INSERT INTO bodega_sucursal
VALUES ('norte', 'iquique'),
    ('norte', 'calama'),
    ('centro', 'valparaiso'),
    ('centro', 'santiago'),
    ('sur', 'concepcion'),
    ('sur', 'temuco');