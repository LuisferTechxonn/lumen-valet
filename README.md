# Lumen Api Documentation Generation TEST with SCRIBE. BOOKS

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)

[![License](https://img.shields.io/packagist/l/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)

En la búsqueda de crear documentación, se han realizado dos mini-proyectos con sendas APIs CRUD, una de Libros y otra de Coches, generando documentación de Scribe y Swagger para ver cuál genera mejor, más rápido...

En concreto esta versión se ha utilizado Scribe. La versión de Swagger está en el mismo repositorio y se denomina **lumen-valet-swagger**

## Dependencias

Para generar en este caso el fichero Yaml con especificaciones OA se ha utilizado la librería [knuckleswtf/scribe](https://github.com/knuckleswtf/scribe) 

También se ha utilizado Fractalistic basado en Fractal para la devolución de datos [Spatie Fractalistic](https://github.com/spatie/fractalistic)
```json
{
    "require": {
        "php": "^7.3|^8.0",

        "laravel/lumen-framework": "^8.0",
        "mpociot/documentarian": "dev-master as 0.4.0",
        "mpociot/laravel-apidoc-generator": "dev-master",
        "spatie/fractalistic": "^2.9"
    },
    "require-dev": {
        "fakerphp/faker": "^1.8",
        "knuckleswtf/scribe": "^3.1",
        "mockery/mockery": "^1.3.1",
        "phpunit/phpunit": "^9.3"
    }
}
```


## Operaciones

Dado un objeto que gestiona Books, hemos creado rutas (y documentación) para:

- Get All: Devuelve todos los libros
- Get 1: Devuelve 1 Libro específico
- Put 1: Modifica todo el item de la colección (debe recibir todos los datos)
- Patch 1: Modifica parte del item de la colección (debe recibir al menos 1 dato a actualizar)
- Post 1: Inserta 1 item a la colección
- Delete 1: Elimina (soft delete) el elemento de la colección. 

## Scribe

Ver el proyecto para ver cómo se ha documentado. 
Para ver la documentación: 

- (con Valet): http://lumen-valet.test/docs/index.html

El json generado se encuentra en: 

- /public/docs/openapi.yaml

Para regenerar el json generado:

```bash
php artisan scribe:generate
```

## Conversiones

Para convertir la librería, se pueden utilizar [https://www.apimatic.io/](https://www.apimatic.io/)

## Instalación del proyecto

1. Clona el proyecto en local del repositorio remoto de Git
2. Crea una BBDD en algún servidor de MySql. Se recomienda utilizar **DBngin** por su simplicidad. 
3. Pon los datos de conexión en el fichero *.env*. Básicamente:


----
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=books
DB_USERNAME=root
DB_PASSWORD=
```
----

4. Realiza la Migración de la BBDD. 
```bash
php artisan migrate
```
5. El proyecto tiene un **seeder** que generará 68 libros inventados. Para ejecutarlo:
```bash
php artisan db:seed --class=BooksSeeder
```
6. Jugar con la Api con *Postman* o *Insomnia* o similar. 

## Licencia

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
