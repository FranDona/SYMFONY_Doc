# SYMFONY_Doc

[//]: # (version: 1.0)
[//]: # (author: Fran Dona Villar)
[//]: # (date: 2024-01-23)


- [SYMFONY\_Doc](#symfony_doc)
  - [Instalaicon Symfony](#instalaicon-symfony)
  - [2. Crear Proyecto de Symfony](#2-crear-proyecto-de-symfony)
  - [3. Instalacion Depedencias](#3-instalacion-depedencias)
  - [4. Repositorio GitHub](#4-repositorio-github)
    - [4.1 Añadir Proyecto Symfony a Repositorio](#41-añadir-proyecto-symfony-a-repositorio)
    - [4.2 Descargar y usar Symfony desde un Repositorio](#42-descargar-y-usar-symfony-desde-un-repositorio)
  - [5. Crear Controlador](#5-crear-controlador)
  - [5. Crear Rutas](#5-crear-rutas)
    - [5.1 Rutas en routes.yaml](#51-rutas-en-routesyaml)
    - [5.2 Rutas con Anotaciones](#52-rutas-con-anotaciones)
  - [6.Editar Twig](#6editar-twig)
  - [7. Base de Datos en Symfony](#7-base-de-datos-en-symfony)
  - [8. Crear entidades(tablas)](#8-crear-entidadestablas)
    - [Relacionar Tablas con Symfony](#relacionar-tablas-con-symfony)
  - [Persistir Objetos (Create)](#persistir-objetos-create)
    - [Create mediante Array](#create-mediante-array)
    - [Create mediante URL](#create-mediante-url)
    - [Array Bidimensional](#array-bidimensional)
    - [Inserccion de datos por parámetros](#inserccion-de-datos-por-parámetros)
  - [Consultar Objetos (Read)](#consultar-objetos-read)
  - [Carpetas de Symfony](#carpetas-de-symfony)
  - [Comandos de Interes para Symfony](#comandos-de-interes-para-symfony)


## Instalaicon Symfony

```console
# Bajamos el instalador
cd ~/Descargas
wget https://get.symfony.com/cli/installer -O - | bash

# Instalamos globalmente
sudo mv ~/.symfony5/bin/symfony /usr/local/bin/symfony

# Comprobamos
symfony

# Comprobar requerimientos
symfony check:requirements

# Si mas adelante nos sale DEPRECATED
sudo rm /usr/local/bin/symfony
# Y repetimos los pasos de la instalación
```

- Extensiones recomenddas para Visual Studio Code
    - Twig Language 2 (mblode)
    - yaml (Red Hat)
    - Symfony for VSCode (TheNouillet)

## 2. Crear Proyecto de Symfony
```console
# Creamos el proyecto con el nombre que queramos
symfony new nombre_proyecto --version="6.4.*" --webapp

#Tambien podemos instalar la ultima version LTS
symfony new /var/www/html/symfony6 --version=lts

# Para iniciar el proyecto
symfony server:start
# Estando en la carpeta del proyecto!!!

# Para apagar el servidor
symfony server:stop
# Estando en otro bash!!!
```

## 3. Instalacion Depedencias
```console
# Estando en el directorio del proyecto
composer require --dev symfony/maker-bundle
composer require twig
composer require symfony/form
composer require symfony/orm-pack
composer require annotations

# Si nos da un error annotations:
# code config/services.yaml
# Añadir lo siguiente en la sección services:
# annotation_reader:
#        class: Doctrine\Common\Annotations\AnnotationReader
php bin/console cache:clear
composer update sensio/framework-extra-bundle
composer require symfony/orm-pack
composer require annotations
```

## 4. Repositorio GitHub

### 4.1 Añadir Proyecto Symfony a Repositorio

```console
# En cualquier momento podemos ver si lo tenemos todo para instalar una aplicación Symfony:
symfony check:requirements
# Y procedemos a crear un proyecto para un microservicio, aplicación de copnsola o API
symfony new symfony5-manual
```

1. Comenzamos creando un repositorio en GitHub, le damos un nombre, una descripción. Con eso sería suficiente por el momento

2. Cuando tengamos el proyecto de symfony creado localmente iremos a su raíz y lo sincronizaremos.
   
    ```console
    cd nombre_proyecto
    git branch -M main
    git status #Para confirmar que estamos en main
    git remote add origin https://github.com/USERNAME/nombre_proyecto.git
    git add .
    git commit -m "[+] Cambios añadidos" 
    git push -u origin main
    #Colocamos nuestro Usuario, nuestro Token y comenzara la subida al repositorio 
    ```

### 4.2 Descargar y usar Symfony desde un Repositorio

1. Descargamos y descomprimimos el proyecto Symfony desde GitHub
2. Lo metemos dentro de nuestra carpeta /var/www/html

  ```conole
  #Instalamos todas las dependecias del proyecto
  composer install

  #Iniciamos el servidor
  symfony server:start
  ```
  
## 5. Crear Controlador
```console
php bin/console make:controller
Choose a name for your controller class (e.g. GrumpyElephantController):
 > Prueba

 created: src/Controller/PruebaController.php
 created: templates/prueba/index.html.twig

  Success!
  ```

## 5. Crear Rutas

### 5.1 Rutas en routes.yaml
- Editaremos el archivo src/Controller/PruebaController.php

```php
<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PruebaController extends AbstractController
{
  //#[Route('/prueba', name: 'app_prueba')]
    public function index(): Response
    {
        echo "Hola mundo";   
        return new Response();
    }
}
```

- Editamos el arvhivos config/routes.yaml
```yaml
controllers:
  resource:
    path: ../src/Controller/
    namespace: App\Controller
  type: attribute

num_prueba1:
  path: /prueba
  controller: App\Controller\PruebaController::index

# Si queremos añadir otra ruta (ENDPOINT)
# Copiamos, pegamos, y cambiamos nombre y path.
num_prueba2:
  path: /mi-prueba
  controller: App\Controller\PruebaController::index
  ```

> [!CAUTION]
> Los nombres de rutas no pueden repetirse.

### 5.2 Rutas con Anotaciones
- Editaremos el archivo en src/Controller/PruebaController.php

```php
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PruebaController extends AbstractController
{
    // public function index(): Response
    // ...

    // En la anotación ponemos la ruta: http://localhost:8000/prueba
    #[Route('/prueba2', name: 'app_prueba2')]
    public function index2(): Response
    {
        // ATENCIÓN: $saludo se recogerá en el twig entre llaves: {{ saludo }}
        $saludo = "Hola mundo";   
        return $this->('prueba/index/html.twig', [
          'controller_name' => 'PruebaController',
          'prueba' => $saludo,
        ]);
    }
}
```

- Si queremos añadir mas rutas difderentes...

```php
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/prueba', name: 'app_prueba_')]
class PruebasController extends AbstractController
{
    #[Route('/prueba1', name: 'app_prueba1')]
    public function prueba1(): Response
    {
        return $this->render('pruebas/prueba1.html.twig');
    }

    #[Route('/prueba2', name: 'app_prueba2')]
    public function prueba2(): Response
    {
        return $this->render('pruebas/prueba2.html.twig');
    }

    #[Route('/prueba3', name: 'app_prueba3')]
    public function prueba3(): Response
    {
        return $this->render('pruebas/prueba3.html.twig');
    }
}
```
- Dentro de cada ruta podremos poner lo que queramos en este ejemplo hemos redirigido directamente a un twig, pero no tiene que ser necesariamente así
> [!NOTE]
> http://localhost:8000/prueba/prueba1 <br>
> http://localhost:8000/prueba/prueba2 <br>
> http://localhost:8000/prueba/prueba3 



## 6.Editar Twig
Twig es un motor de plantillas para el lenguaje de programación PHP. twig permite a los desarrolladores separar la lógica de presentación del código PHP
- Cuando creamos un controlador nos genera automaticamente un Twig.

```twig
{% extends 'base.html.twig' %}

{% block title %}Hola PruebaController!{% endblock %}

{% block body %}
<style>
    .example-wrapper { margin: 1em auto; max-width: 800px; width: 95%; font: 18px/1.5 sans-serif; }
    .example-wrapper code { background: #F5F5F5; padding: 2px 6px; }
</style>

<div class="example-wrapper">
    <h1>Hola {{ controller_name }}! ✅</h1>

    <!-- El resto del código lo dejamos o lo borramos...-->
    <p>  {{ prueba }} </p>
</div>
{% endblock %}
```

## 7. Base de Datos en Symfony

Para poder crear la base de datos tendremos que irnos al archivo llamado .env ubicado en la raíz de la carpeta del nuestro proyecto.

Tendremos que desmarcar la línea que necesitemos según el tipo de bbdd que estemos usando, en nuestro caso será mysql

```yaml
mysql://<usuario>:<contraseña>@<host>:<puerto>/<nombre_base_datos>?serverVersion=<version>&charset=utf8mb4
```
```yaml
###> symfony/framework-bundle ###
APP_ENV=dev
APP_SECRET=d04f9778c2872e15b0e59bdd55a683fd
###< symfony/framework-bundle ###

###> doctrine/doctrine-bundle ###
# Format described at https://www.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html#connecting-using-a-url
# IMPORTANT: You MUST configure your server version, either here or in config/packages/doctrine.yaml
#
DATABASE_URL="mysql://root:root@127.0.0.1:3306/mi_bbdd?serverVersion=8.0.32&charset=utf8mb4"

# DATABASE_URL="mysql://root:root@127.0.0.1:3306/soltel?serverVersion=10.11.2-MariaDB&charset=utf8mb4"
# DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=16&charset=utf8"
# DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"

###< doctrine/doctrine-bundle ###
```


```console
# Para crear la base de datos usaremos:
php bin/console doctrine:database:create
```

## 8. Crear entidades(tablas)

```console
php bin/console make:entity
Class name of the entity to create or update (e.g. OrangeKangaroo):
 > Autores

 created: src/Entity/Autores.php
 created: src/Repository/AutoresRepository.php

 Entity generated! Now let's add some fields!
 You can always add more fields later manually or by re-running this command.

 New property name (press <return> to stop adding fields):
 > nombre

 Field type (enter ? to see all types) [string]:
 >

 Field length [255]:
 >

 Can this field be null in the database (nullable) (yes/no) [no]:
 >

 updated: src/Entity/Autores.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > edad

 Field type (enter ? to see all types) [string]:
 > integer

 Can this field be null in the database (nullable) (yes/no) [no]:
 >
  # INTRO!
 updated: src/Entity/Autores.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 >

  # INTRO!

  Success!
```
> [!NOTE]
> Si queremos añadir nonbre campos adicionales solo tendremos que escribir de nuevo el misno nombre de la tabla

- **Creamos una segunda tabla**

```console
php bin/console make:entity
Class name of the entity to create or update (e.g. DeliciousChef):
 > Articulos

 Your entity already exists! So let's add some new fields!

 New property name (press <return> to stop adding fields):
 > Autor

Field type (enter ? to see all types) [string]:
 > ManyToOne

 What class should this entity be related to?:
 > Autores

 Is the Articulos.autor property allowed to be null (nullable)? (yes/no) [yes]:
 > no

 Do you want to add a new property to Autores so that you can access/update Articulos objects from it - e.g. $autores->getArticulos()? (yes/no) [yes]:
 >

 A new property will also be added to the Autores class so that you can access the related Articulos objects from it.

 New field name inside Autores [articulos]:
 >

 Do you want to activate orphanRemoval on your relationship?
 A Articulos is "orphaned" when it is removed from its related Autores.
 e.g. $autores->removeArticulos($articulos)

 NOTE: If a Articulos may *change* from one Autores to another, answer "no".

 Do you want to automatically delete orphaned App\Entity\Articulos objects (orphanRemoval)? (yes/no) [no]:
 >

 updated: src/Entity/Articulos.php
 updated: src/Entity/Autores.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 >

  Success!

 Next: When you're ready, create a migration with php bin/console make:migration
```

- Con esto ya tendremos dos tablas en nuestra base de datos!!

### Relacionar Tablas con Symfony

Para este ejemplo vamos unir la tabla creada anteriormente (Artiuclos)

- Autores será la tabla principal y Articulos la tabla derivada
- Por tanto, para crear la relación NOS VAMOS A LA DERIVADA (Articulos)
- El tipo será ManyToOne (muchos Articulos son de 1 Autor)

```console
php bin/console make:entity
Class name of the entity to create or update (e.g. DeliciousChef):
 > Articulos

 Your entity already exists! So let's add some new fields!

 New property name (press <return> to stop adding fields):
 > Autor

Field type (enter ? to see all types) [string]:
 > ManyToOne

 What class should this entity be related to?:
 > Autores

 Is the Articulos.autor property allowed to be null (nullable)? (yes/no) [yes]:
 > no

 Do you want to add a new property to Autores so that you can access/update Articulos objects from it - e.g. $autores->getArticulos()? (yes/no) [yes]:
 >

 A new property will also be added to the Autores class so that you can access the related Articulos objects from it.

 New field name inside Autores [articulos]:
 >

 Do you want to activate orphanRemoval on your relationship?
 A Articulos is "orphaned" when it is removed from its related Autores.
 e.g. $autores->removeArticulos($articulos)

 NOTE: If a Articulos may *change* from one Autores to another, answer "no".

 Do you want to automatically delete orphaned App\Entity\Articulos objects (orphanRemoval)? (yes/no) [no]:
 >

 updated: src/Entity/Articulos.php
 updated: src/Entity/Autores.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 >

  Success!

 Next: When you're ready, create a migration with php bin/console make:migration
```

<br>
Para terminar cargamos los cambios:
<br><br>


```console
php bin/console make:migration
Success!

 Next: Review the new migration "migrations/Version2232323233.php"
```

Como nos dice la consola podemos ver el archivo migrations/Version2232323233.php" para personalizar los comandos SQL que se van a ejecutar respecto al SGBD.
Por experiencia, suele ser buena idea cambiar los nombres de los FK (Foreign Key) e IDX (Index)
Y lo trasladamos:

```console
php bin/console doctrine:migrations:migrate

WARNING! You are about to execute a migration in database "symfony5" that could result in schema changes and data loss. Are you sure you wish to continue? (yes/no) [yes]:
 >
  # INTRO!

[notice] Migrating up to DoctrineMigrations\Version2232323233
[notice] finished in 57.7ms, used 14M memory, 1 migrations executed, 3 sql queries
```

## Persistir Objetos (Create)

Comenzamos creando un controlador

```console
# php bin/console make:controller <nombre_controlador>
php bin/console make:controller Autores
```

### Create mediante Array
```php
<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Debemos añadir las siguientes clases...
use App\Entity\Autores;
use Doctrine\Persistence\ManagerRegistry;

class AutoresController extends AbstractController
{
    #[Route('/crea-autor', name: 'crea-autor')]
    public function crearAutor(ManagerRegistry $doctrine): Response
    {
        // Creamos el objeto Gestor de Entidad
        $entityManager = $doctrine->getManager();

        // Defino un objeto autor
        $autor = new Autores();
        $autor->setNombre('Fran Dona');
        $autor->setEdad(46);

        // Y lo guardo
        $entityManager->persist($autor);
        $entityManager->flush();

        return new Response('Guardado Autor con ID -> ' . $autor->getId());
    }
}
```

### Create mediante URL
```php
<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Debemos añadir las siguientes clases...
use App\Entity\Autores;
use Doctrine\Persistence\ManagerRegistry;

class AutoresController extends AbstractController
{
    #[Route('/crea-autor', name: 'crea-autor')]
    //public function crearAutor(ManagerRegistry $doctrine): Response

    #[Route('/crea-autor/{nombre}/{edad}', name: 'crea-autor2')]
    public function crearAutor2(ManagerRegistry $doctrine, String $nombre, int $edad): Response
    {
        // Creamos el objeto Gestor de Entidad
        $entityManager = $doctrine->getManager();

        // Defino un objeto autor
        $autor = new Autores();
        $autor->setNombre($nombre);
        $autor->setEdad($edad);

        // Y lo guardo
        $entityManager->persist($autor);
        $entityManager->flush();

        return new Response('Guardado Autor con ID -> ' . $autor->getId());
    }
}
```
### Array Bidimensional

Repetimos el mismo proceso para la segunda tabla Articulos

En este caso usaremos un array bidimensional para añadir varios registros de golpe

```php
<?php

namespace App\Controller;

// Nuevas clases para añadir
use App\Entity\Articulos;
use App\Entity\Autores;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticulosController extends AbstractController
{
    /**
     * @Route("/crea-articulos", name="create_articles")
     */
    public function crearArticulos(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $registros = array(
            "articulo1" => array(
                "titulo" => 'Manual de Symfony5',
                "publicado" => 1,
                "autor" => 1
            ),

            "articulo2" => array(
                "titulo" => 'Notas sobre GIT',
                "publicado" => 0,
                "autor" => 1
            ),

            "articulo3" => array(
                "titulo" => 'Bienvenidos',
                "publicado" => 1,
                "autor" => 1
            )
        );

        foreach ($registros as $clave => $registro) {
            $articulo = new Articulos();
            $articulo->setTitulo($registro['titulo']);
            $autor = $entityManager->getRepository(Autores::class)->findOneBy(['id' => $registro['autor']]);
            $articulo->setAutor($autor);
            $articulo->setPublicado($registro['publicado']);

            $entityManager->persist($articulo);
            $entityManager->flush();
        }


        return new Response('Guardados Articulos!');
    }
}
```
### Inserccion de datos por parámetros

```php
#[Route('/crea-articulo/{titulo}/{publicado}/{autor}', name: 'crea-articulo')]
    public function crearArticulo(
        ManagerRegistry $doctrine,
        String $titulo,
        int $publicado,
        int $autor
    ): Response {
        $entityManager = $doctrine->getManager();

        $articulo = new Articulos();
        $articulo->setTitulo($titulo);
        $articulo->setPublicado($publicado);

        // Para el caso del autor, debemos buscar el autor
        // con la ID pasada por parámetro
        $autor = $entityManager->getRepository(Autores::class)->find($autor);
        $articulo->setAutor($autor);

        $entityManager->persist($articulo);
        $entityManager->flush();

        return new Response('Articulo agregado');
    }
```

## Consultar Objetos (Read)

1. Vamos a empezar sacando un SELECT * FROM articulos usando como salida una tabla HTML usando el findAll():

- En src/Controller/ArticulosController

```php
// Añadimos el repositorio a las clases que usamos:
use App\Repository\ArticulosRepository;
```

- Creamos un nuevo métod en el controlador de Artículos 

```php
  #[Route('/ver-articulos', name: 'ver-articulos')]
  public function mostrarArticulos(ArticulosRepository $repo): Response
  {
      $articulos = $repo->findAll();
      $respuesta = "<html>
      <body>
          <table border=1>
              <th>ID</th>
              <th>Titulo</th>
              <th>publicado</th>
              <th>autor</th>";
      // con getAutor obtenemos el autor como objeto
      // Con eso, sacamos lo que queramos, por ejemplo el nombre
      foreach ($articulos as $articulo) {
          $respuesta .= "<tr>
          <td> " . $articulo->getId() . "</td>
          <td> " . $articulo->getTitulo() . "</td>
          <td> " . $articulo->isPublicado() . "</td>
          <td> " . $articulo->getAutor()->getNombre() . "</td>
          </tr>";
      }
      $respuesta .= "</table>
      </body>
      </html>";
      return new Response($respuesta);
  }
```

2. Ahora vamos a sacar SELECT * FROM articulos WHERE id = 1 usando como salida JSON, usando el find($id):

- En src/Controller/ArticulosController

```php
// Añadimos el JsonResponse para sacarlo en formato JSON (Para API REST)
use Symfony\Component\HttpFoundation\JsonResponse;
```

```php
#[Route('/articulo/{id}', name: 'ver-articulo')]
public function verArticulo(ManagerRegistry $doctrine, int $id): Response
{
    $articulo = $doctrine->getRepository(Articulos::class)->find($id);
    // De nuevo, sacamos el autor con el objeto completo...
    return new JsonResponse([
        'id' => $articulo->getId(),
        'titulo' => $articulo->getTitulo(),
        'publicado' => $articulo->isPublicado(),
        'autor' => $articulo->getAutor()->getNombre(),
    ]);
}
```

## Carpetas de Symfony

- bin -> Ejecutables principales del sistema
  - console -> php/bin console...
- config -> Archivos de configuración
  - routes -> Listado de rutas
  - services -> Listado de Servicios creados
- migrations -> creación de migraciones de BBDD
- public -> Páginas publicas
- src -> Recursos del sistema
  - Controller -> Controladores (MVC)
  - Entity -> Entidades (objetos)
  - Repository -> Gestión de consultas
- templates -> plantillas (twig)
- var -> caché de la aplicación y registros (logs)
- vendor -> Dependencias
  - bin -> Ejecutables de dependencias
    - doctrine -> BBDD
    - var-dump-server -> Backup BBDD
    - phpunit -> Test Unitarios
  - Symfony -> núcleo de la aplicación
  - sension -> Maker bundle

## Comandos de Interes para Symfony

composer create-project symfony/skeleton nombre_proyecto ^6.4<br>
-> Crear proyecto, creara una carpeta en la ubicaion donde este.

symfony server:start<br>
-> Iniciar servidor, es necesario estar ubicado en la carpeta del proyecto

symfony server:restart<br>
-> Reiniciar servidor

symfony server:stop<br>
-> Para servidor

php bin/console doctrine:database:create<br>
-> Crear base de datos

php bin/console make:entity<br>
-> Asistente para creacion de tablas y capos de ella

php bin/console make:migration<br>
-> Crear una migracion de los datos creados anteriormente (Se crea archivo de version migraciones)

php bin/console doctrine:migrations:migrate<br>
-> Se aplican cambios a la base de datos

php bin/console make:controller<br>
-> Crear Controlador

php bin/console doctrine:schema:update --force<br>
-> Actualiza la base de datos desde las entidades

php bin/console doctrine:query:sql "SELECT * FROM nombre_tabla"
-> Consultas mysql directamente en symfony

php bin/console cache:clear<br>
-> Limpia la cache

php bin/console debug:router<br>
-> Ver las rustas de la página

php bin/console make:repository
-> Se utiliza para generar automáticamente una clase de repositorio para una entidad de Doctrine en tu proyecto.
