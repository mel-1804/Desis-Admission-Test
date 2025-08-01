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