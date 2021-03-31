# Backend del proyecto

## Instalación:
* Clonar el repositorio
* Copiar y renombra el archivo `.env.example` to `.env`
* Configurar el archivo `.env` con la conexión de la base de datos y nombre del aplicativo
* Crear las carpetas `storage/framework/cache`, `storage/framework/sessions`, `storage/framework/views` o corre el siguiente comando en linux `mkdir -p storage/framework/{sessions,views,cache}`
* Ejecuta en la consola o terminal `composer install`
* Ejecuta en la consola o terminal `php artisan key:generate`
* Ejecuta en la consola o terminal `php artisan jwt:secret`
* Ejecuta en la consola o terminal `php artisan migrate:fresh`
* Ejecuta en la consola o terminal `php artisan db:seed`