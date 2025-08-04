# Sistema de Registro de Productos – Desis Admission Test

Este proyecto corresponde al desafío técnico solicitado por **Desis** para evaluar habilidades en desarrollo web con tecnologías nativas.

---

## Tecnologías utilizadas

- ✅ **HTML5**
- ✅ **CSS3** (nativo, sin frameworks)
- ✅ **JavaScript** (puro, con uso de `fetch()` / AJAX)
- ✅ **PHP** (v8.4.11 - sin frameworks)
- ✅ **PostgreSQL** (v17.5 - como gestor de base de datos)

---

## Cómo ejecutar el proyecto localmente

### 1. Clonar el repositorio

git clone https://github.com/mel-1804/Desis-Admission-Test.git

cd desis-product-register

### 2. Crear la base de datos

Asegúrate de tener PostgreSQL instalado.

Crea una base de datos llamada productos (o edita db.php para usar otro nombre).

Ejecuta el script init.sql ubicado en database.

### 3. Configurar conexión en backend/db.php

En el archivo db.php edita tus credenciales de conexión a la base de datos:

$host = "localhost";
$dbname = "productos";
$user = "TU_USUARIO";
$password = "TU_CONTRASEÑA";

### 4. Ejecutar el servidor

Debes tener PHP instalado.
Este proyecto está pensado para ejecutarse en un entorno local usando XAMPP (o similar). Asegúrate de tener Apache y PHP habilitados en el panel de control de XAMPP.

Pasos:
Copia la carpeta del proyecto dentro del directorio htdocs de XAMPP.

Ejemplo: C:\xampp\htdocs\desis-product-register

Abre el panel de XAMPP y asegúrate de iniciar el módulo Apache (y PostgreSQL si lo tienes configurado localmente, o asegúrate de que esté activo externamente).

Accede al proyecto desde el navegador:

http://localhost/desis-product-register/index.html (para visualizar el formulario).

## Funcionalidad

Valida que todos los campos requeridos estén completos.

Envía los datos del formulario al backend usando JavaScript y fetch().

El backend guarda los datos en la base de datos PostgreSQL.

Muestra mensajes de éxito o error al usuario.

## Autora

Melissa Ortiz
LinkedIn: https://www.linkedin.com/in/melissaortizmunnoz/
