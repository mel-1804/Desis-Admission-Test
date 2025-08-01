# Sistema de Registro de Productos – Desis Admission Test

Este proyecto corresponde al desafío técnico solicitado por **Desis** para evaluar habilidades en desarrollo web con tecnologías nativas.

---

## Tecnologías utilizadas

- ✅ **HTML5**
- ✅ **CSS3** (nativo, sin frameworks)
- ✅ **JavaScript** (puro, con uso de `fetch()` / AJAX)
- ✅ **PHP** 8.4 (8.4.11) (sin frameworks)
- ✅ **PostgreSQL** (como gestor de base de datos)

---

## Cómo ejecutar el proyecto localmente

### 1. Clonar el repositorio

git clone https://github.com/mel-1804/Desis-Admission-Test.git

cd Desis-Admission-Test

### 2. Crear la base de datos

Asegúrate de tener PostgreSQL instalado.

Crea una base de datos llamada productos (o edita db.php para usar otro nombre).

Ejecuta el script init.sql ubicado en database/:

CREATE TABLE products (
id SERIAL PRIMARY KEY,
code VARCHAR(50) NOT NULL,
name VARCHAR(255) NOT NULL,
description TEXT,
quantity INTEGER NOT NULL,
price NUMERIC(10, 2) NOT NULL
);

### 3. Configurar conexión en backend/db.php

Edita tus credenciales de conexión a la base de datos:

$host = "localhost";
$dbname = "productos";
$user = "TU_USUARIO";
$password = "TU_CONTRASEÑA";

### 4. Ejecutar el servidor

Con PHP instalado, corre este comando desde la raíz del proyecto o la carpeta frontend/:

php -S localhost:8000
Y abre en el navegador:

http://localhost:8000

## Funcionalidad

Valida que todos los campos requeridos estén completos.

Envía los datos del formulario al backend usando JavaScript y fetch().

El backend guarda los datos en la base de datos PostgreSQL.

Muestra mensajes de éxito o error al usuario.

## Autora

Melissa Ortiz
LinkedIn: https://www.linkedin.com/in/melissaortizmunnoz/
