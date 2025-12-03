<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>



# 🛠️ Gestor Taller DAW

Aplicación Laravel para gestionar proyectos y herramientas de taller, con control de estados, asignaciones y administración de usuarios.


# ✨ Características Principales

+ **Proyectos**
  - Estados: Pendiente, En proceso, Terminado, En espera de piezas, Urgente.
  - Urgente como estado (no prioridad), visible en métricas y listados.
  - Métricas por usuario: el usuario ve sus métricas; admin ve global.
  - Asignación opcional: se pueden crear proyectos “Sin asignar” y asignar más tarde.
  - Listado con badge de estado y chip “No asignado” cuando no tiene responsable.
  - Ordenación: Más recientes primero por defecto; opción Alfabético (A→Z).
  - Confirmación de borrado con modal estilizado; mensajes de éxito con auto-dismiss y cierre manual.

+ **Herramientas**
  - Estados: Disponible, En uso, Mantenimiento.
  - Asignación opcional (user_id nullable) y “No asignado” en listados.
  - Tooltip de descripción al pasar el cursor por el nombre.
  - Ordenación: Más recientes primero (por defecto) y Alfabético (A→Z).
  - Confirmación de borrado con modal estilizado; mensajes de éxito con auto-dismiss y cierre manual.

+ **Administración de usuarios (solo admin)**
  - Navegación: 👥 Gestión usuarios en menú principal (visible solo admin).
  - Listado, edición y borrado de usuarios.
  - Roles simplificados: Admin y Empleado; protección para evitar auto-eliminarse.

+ **Branding y UX**
  - Título del sitio y pestaña: Gestor Taller DAW (APP_NAME configurable).
  - Favicon SVG martillo/llave inglesa y fallback favicon.ico para compatibilidad.
  - Navegación con iconos: 🏠 Panel, 🔧 Herramientas, 📁 Proyectos, 👥 Gestión usuarios.
  - Panel sin “encajonado”, sombras y espaciado pulidos.


## 🚀 Requisitos del Sistema

- PHP => 8.2

- Composer

- Node.js (para la compilación de assets con Vite)

- Una base de datos MySQL. Se recomienda XAMPP.

## ⚙️ Instalación y Configuración

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

```pwsh
php artisan serve
```

Abre tu navegador y navega a `http://localhost:8000`.

### Limpieza de cachés (si cambias APP_NAME o favicon)

```pwsh
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan cache:clear
```

### Migraciones relevantes

- BD preparada para asignaciones nulas:
  - `tools.user_id` nullable con `nullOnDelete`.
  - `projects.assigned_to_user_id` nullable (si aplica), con `set null` al borrar usuario.

### Ordenación

- Controladores aceptan `?sort=alpha` para A→Z; por defecto `created_at` DESC.

### Favicon

- `public/favicon.svg` (martillo/llave inglesa) y `public/favicon.ico` como fallback.
 
 
 
## 🤝 Colaboración

Si deseas contribuir o reportar un error, por favor, abre un issue o envía un pull request.

## 🧪 Pruebas

Ejecuta la suite:

```pwsh
php artisan test
```

- Validación de reglas de autorización: solo propietario o admin pueden actualizar/borrar herramientas y proyectos.
- Pruebas ajustadas para esperar `403 Forbidden` en usuarios sin permisos.
