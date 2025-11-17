<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>



# 🛠️ Gestor de Taller DAW

¡Bienvenido al repositorio del proyecto Gestor de Taller DAW! Esta es una aplicación web desarrollada con el framework Laravel para la gestión eficiente de proyectos (o trabajos en taller), materiales, herramientas y los pasos de construcción asociados.

El objetivo principal es proporcionar una herramienta robusta para asignar trabajos a empleados, gestionar el inventario de herramientas y llevar un control detallado de las instrucciones paso a paso para cada proyecto.


# ✨ Características Principales

+ **Gestión de Proyectos:** Creación, edición, visualización y eliminación de trabajos o tareas del taller.

+ **Roles de Usuario:** Diferenciación entre usuarios Administradores (acceso total, asignación) y Empleados (solo ven sus proyectos asignados).

+ **Detalle de Proyectos:**

  + **Materiales:** Listado dinámico de materiales necesarios (nombre, cantidad, notas).

  + **Herramientas:** Asociación Many-to-Many de herramientas requeridas.

  + **Pasos de Construcción:** Guía paso a paso con instrucciones detalladas y soporte para imágenes por cada paso.

+ **Control de Estado y Prioridad:** Clasificación de proyectos por pendiente, en_proceso, terminado, etc.


# 🚀 Requisitos del Sistema

- PHP => 8.2

- Composer

- Node.js (para la compilación de assets con Vite)

- Una base de datos: un servidor MySQL: se recomienda XAMPP.

# ⚙️ Instalación y Configuración

Sigue estos pasos para poner en marcha el proyecto en tu entorno local.

### 1. Clonar el Repositorio

Si aún no lo has hecho, clona el repositorio:
```
git clone [https://github.com/IberianSoldierPC/gestor-taller-daw.git](https://github.com/IberianSoldierPC/gestor-taller-daw.git)
cd gestor-taller-daw
```

### 2. Dependencias

Instala las dependencias de PHP y JavaScript:
```
# Instalar dependencias de PHP (Composer)
composer install

# Instalar dependencias de JavaScript (NPM)
npm install
```

### 3. Configuración del Entorno

Copia el archivo de ejemplo para crear tu archivo .env:
```
cp .env.example .env
```

Genera la clave de aplicación de Laravel:
```
php artisan key:generate
```

Edita el archivo .env para configurar tu conexión a la base de datos (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

### 4. Base de Datos y Seeders

🚨 Antes de este paso, debes iniciar el servicio de MySQL en tu servidor local

Ejecuta las migraciones para crear las tablas de la base de datos y luego ejecuta los seeders para añadir datos iniciales (como el usuario Administrador y algunas herramientas base).
```
php artisan migrate --seed
```

Nota: El seeder incluye un usuario admin por defecto. Revisa el archivo database/seeders/AdminUserSeeder.php para ver las credenciales.

### 5. Compilación de Assets

Compila los estilos CSS y JavaScript con Vite.
```
npm run dev
o para producción:
npm run build
```



## 💻 Uso de la Aplicación

Inicia el servidor de desarrollo de Laravel:

php artisan serve


Abre tu navegador y navega a http://localhost:8000.



## 🤝 ***Colaboración***

Si deseas contribuir o reportar un error, por favor, abre un ***issue*** o envía un ***pull request***.
