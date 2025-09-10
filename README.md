# GeoLabs Project - Sistema de Autenticación

Sistema de autenticación desarrollado con Laravel 8 y Vue.js 3, incluye funcionalidades de login y registro de usuarios.

## Características

- **Frontend**: Vue.js 3 Composition API
- **Backend**: Laravel 8 API REST
- **Autenticación**: Sistema completo de login y registro
- **Validación**: Validación en tiempo real en el frontend
- **UI/UX**: Bootstrap 5 y estilos personalizados
- **Responsive**: Diseño adaptable a dispositivos móviles

## Requisitos del Sistema

### Servidor
- **PHP**: 8.0 o superior
- **Composer**: Para gestión de dependencias PHP
- **Node.js**: 14+ y NPM para compilación de assets
- **Base de datos**: MySQL 5.7+ 
- **Servidor web**: Apache 2.4+ 

## Instalación

### 1. Clonar el Repositorio
```bash
git clone [URL_DEL_REPOSITORIO]
cd geolabsProject
```

### 2. Instalar Dependencias PHP
```bash
composer install --optimize-autoloader
```

### 3. Instalar Dependencias Node.js
```bash
npm install
```

### 4. Configurar Variables de Entorno
```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configurar Base de Datos
Editar el archivo `.env` con los datos de tu base de datos:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=geolabs_db
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### 6. Ejecutar Migraciones
```bash
php artisan migrate
```

### 7. Compilar Assets
```bash
# Para desarrollo
npm run dev

# Para producción
npm run production
```

### 8. Ejecutar el Servidor de Desarrollo
```bash
# Ejecutar el servidor Laravel
php artisan serve


## API Endpoints
### Autenticación
- `POST /api/login` - Iniciar sesión
- `POST /api/register` - Registrar usuario

