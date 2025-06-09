# Página Web de Suplementos

Este repositorio contiene el código fuente de una página web orientada a la venta de suplementos alimenticios. Está desarrollada principalmente con **PHP**, **CSS** y **JavaScript**.

## 📁 Estructura del Proyecto

- `index.php`: Página de inicio.
- `acceso.php`, `procesar_login.php`: Módulo de inicio de sesión.
- `carrito.php`, `carrito.js`: Funcionalidad del carrito de compras.
- `conexion.php`: Archivo para la conexión a la base de datos.
- `admin_dashboard.php`, `adminagregar.php`: Panel administrativo.
- `acerca de.php`, `contacto.php`, `nuestros_suplementos.php`: Páginas informativas.
- Carpeta `db/`: Contiene el archivo SQL necesario para importar la base de datos en tu servidor local.

## 📦 Requisitos

Para ejecutar esta página localmente necesitas:

- [XAMPP](https://www.apachefriends.org/index.html) o similar (para Apache + MySQL)
- Navegador web moderno
- Editor de texto como Visual Studio Code (opcional)

## 🚀 Instrucciones para Uso Local

1. Clona o descarga este repositorio desde GitHub.
2. Copia la carpeta en el directorio `htdocs` de XAMPP.
3. Inicia **Apache** y **MySQL** desde el panel de XAMPP.
4. Importa el archivo `.sql` que está en la carpeta `db/` en phpMyAdmin para crear la base de datos.
5. Asegúrate de que los datos de conexión en `conexion.php` coincidan con tu entorno local.
6. Abre tu navegador y entra a:
   ```
   http://localhost/Suplementos-web/
   ```

## 🔐 Cuentas de Prueba

### Usuario invitado:
- Usuario: ``
- Contraseña: ``

### Usuario normal:
- Usuario: `Guillermo`
- Contraseña: `1234`

### Administrador:
- Usuario: `admin`
- Contraseña: `admin123`

## 💳 Pruebas con PayPal (Sandbox)

Esta página está integrada con **PayPal** en modo de pruebas (sandbox). Aún no está configurada para realizar compras reales.

Cuenta de prueba para pagos:

- Correo: `sb-kwolg33961445@personal.example.com`
- Contraseña: `usq4JDV&`

## ☁️ Subir a GitHub

1. Crea un repositorio en GitHub.
2. Desde tu terminal, dentro del proyecto:
   ```bash
   git init
   git add .
   git commit -m "Subida inicial"
   git remote add origin https://github.com/tuusuario/nombre-repo.git
   git push -u origin main
   ```

## 🌐 Activar GitHub Pages

> ⚠️ Este proyecto usa PHP, por lo tanto **GitHub Pages no puede ejecutarlo** directamente. GitHub Pages solo soporta HTML, CSS y JavaScript.

Para publicarlo online, considera usar un hosting gratuito como:

- [000webhost](https://www.000webhost.com/)
- [InfinityFree](https://infinityfree.net/)
- O contratar un hosting con soporte PHP y MySQL.

## 📄 Licencia

Este proyecto es de uso educativo o personal. Puedes adaptarlo según tus necesidades.
