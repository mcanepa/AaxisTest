<p align="center">
	<img src="https://www.aaxisdigital.com/hs-fs/hubfs/AAXIS_January2020%20Theme/images/aaxis-logo-orange-200px-Web.png?width=200&height=36&name=aaxis-logo-orange-200px-Web.png" alt="" height="75">
</p>


## ¡AAXIS demo app/api!

Challenge para demostrar por qué deben contratarme =)

A continuación las instrucciones para poder instalar y correr el proyecto...

## Antes de comenzar...

Asegurate de tener instalado git, composer, postgresql y php >= 8.2

## Paso 1: Clonar el repo

Abrir una consola y ejecutar

```
git clone https://github.com/mcanepa/AaxisTest
```

Luego entrar al directorio

```
cd AaxisTest/backend
```

## Paso 2: Instalar proyecto y dependencias

Ya dentro del directorio ejecutamos:

```
composer install
```

Y dejamos que composer haga su magia

## Paso 3: Archivo de entorno

En el raíz del proyecto hay un archivo ```.env```, editalo para configurar la conexión a la base de datos

```
DATABASE_URL="postgresql://[usuario]:[password]@127.0.0.1:5432/[nombre_db]?serverVersion=16&charset=utf8"
```

Reemplaza ```usuario```, ```password```, y ```nombre_db``` con los datos verdaderos de conexión.

Una vez editado el archivo, hay que generar una clave de aplicación

```
php bin/console lexik:jwt:generate-keypair
```

## Paso 4: Crear base de datos y tablas

Ejecutar

```
php bin/console doctrine:database:create
```

Luego ejecuta las migrations para poder crear las tablas necesarias

```
php bin/console doctrine:migrations:migrate
```

## Paso 5: Correr el proyecto

Ejecuta

```
symfony server:start
```

(si no tienes ese comando, sigue [estas instrucciones](https://symfony.com/download))

Eso deja corriendo el proyecto en http://127.0.0.1:8000

Ahora que la API está online, puedes probarla con la interfaz gráfica que viene en este proyecto. Ve a la carpeta frontend y haz doble click en el archivo index.html

Allí podrás registrar un nuevo usuario, hacer login, ver un listado de registros y tendrás la posibilidad de crear más y actualizarlos!!

## Notas finales

Los endpoints de la API son:

Puedes testearlos con la UI provista o mediante algun programa como Postman

```
http://127.0.0.1:8000/api/registration [POST]
http://127.0.0.1:8000/api/login_check [POST]
http://127.0.0.1:8000/api/products [GET]
http://127.0.0.1:8000/api/products [POST]
http://127.0.0.1:8000/api/products [PUT]
```

## Saludos
Aguardo feedback y estamos en contacto!
