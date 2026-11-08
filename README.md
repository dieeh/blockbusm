# BlockbUSM

Aplicación web de catálogo y descubrimiento de películas con funcionalidades sociales. Permite explorar títulos, consultar información, revisar métricas y disponibilidad, publicar reseñas e interactuar con otros usuarios mediante seguimiento.

## Funcionalidades

- Catálogo de películas con información, género, clasificación, reparto y descripción.
- Secciones de descubrimiento: últimos títulos agregados, mejor y peor puntuación, películas más arrendadas y títulos con pocas unidades disponibles.
- Registro e inicio de sesión de usuarios.
- Reseñas y comentarios asociados a películas.
- Seguimiento entre usuarios y visualización de reseñas de personas seguidas.
- Lista personal de películas (wishlist/favoritos).
- Funcionalidades de administración para gestionar el catálogo.

## Tecnologías

- PHP
- MySQL / MariaDB
- PDO para el acceso a datos
- HTML, CSS y JavaScript
- Apache (XAMPP para desarrollo local)

## Requisitos

- PHP 8.1 o compatible.
- MySQL o MariaDB.
- Servidor web Apache.
- phpMyAdmin (opcional, para importar la base de datos).

## Ejecución local

1. Clona el repositorio dentro del directorio `htdocs` de XAMPP:

   ```bash
   git clone https://github.com/dieeh/blockbusm.git
   ```

2. Inicia Apache y MySQL desde el panel de XAMPP.
3. Crea una base de datos llamada `blockbusm`.
4. Importa el archivo `SQL/blockbusm.sql` desde phpMyAdmin.
5. Revisa la configuración de conexión a la base de datos en `conexion.php` y ajusta host, usuario, contraseña y nombre de la base de datos según el entorno local.
6. Abre la aplicación en:

   ```
   http://localhost/blockbusm
   ```

## Estructura general

- `SQL/`: esquema y datos iniciales de la base de datos.
- `assets/`: hojas de estilo, imágenes y recursos gráficos.
- Archivos PHP de la raíz: páginas, autenticación, catálogo y funcionalidades de la aplicación.

## Notas

Este proyecto fue desarrollado como trabajo académico. La base de datos incluida contiene datos de ejemplo para levantar la aplicación localmente. No reutilices credenciales de demostración ni publiques credenciales reales en el repositorio.
