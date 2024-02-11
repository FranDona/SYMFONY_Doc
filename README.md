# SYMFONY_Doc

[//]: # (version: 1.0)
[//]: # (author: Fran Dona Villar)
[//]: # (date: 2024-01-23)


- [SYMFONY\_Doc](#symfony_doc)
  - [Instalaicon Symfony](#instalaicon-symfony)
  - [2. Crear Proyecto de Symfony](#2-crear-proyecto-de-symfony)
  - [3. Instalacion Depedencias](#3-instalacion-depedencias)
  - [4. Crear Controlador](#4-crear-controlador)
  - [5. Crear Rutas](#5-crear-rutas)
    - [5.1 Rutas en routes.yaml](#51-rutas-en-routesyaml)
    - [5.2 Rutas con Anotaciones](#52-rutas-con-anotaciones)
  - [6.Editar Twig](#6editar-twig)
  - [7. Configurar Base de Datos](#7-configurar-base-de-datos)
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

## 4. Crear Controlador
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

## 7. Configurar Base de Datos



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
