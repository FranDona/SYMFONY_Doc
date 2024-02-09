# SYMFONY_Doc

[//]: # (version: 1.0)
[//]: # (author: Fran Dona Villar)
[//]: # (date: 2024-01-23)


- [SYMFONY\_Doc](#symfony_doc)
  - [Instalaicon Symfony](#instalaicon-symfony)
  - [2. Crear Proyecto de Symfony](#2-crear-proyecto-de-symfony)
  - [3. Instalacion Depedencias](#3-instalacion-depedencias)
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

## Comandos de Interes para Symfony

composer create-project symfony/skeleton nombre_proyecto ^6.4
-> Crear proyecto, creara una carpeta en la ubicaion donde este.

symfony server:start
-> Iniciar servidor, es necesario estar ubicado en la carpeta del proyecto

symfony server:restart
-> Reiniciar servidor

symfony server:stop
-> Para servidor

php bin/console doctrine:database:create
-> Crear base de datos

php bin/console make:entity
-> Asistente para creacion de tablas y capos de ella

php bin/console make:migration
-> Crear una migracion de los datos creados anteriormente (Se crea archivo de version migraciones)

php bin/console doctrine:migrations:migrate
-> Se aplican cambios a la base de datos

php bin/console make:controller
-> Crear Controlador

php bin/console doctrine:schema:update --force
-> Actualiza la base de datos desde las entidades

php bin/console cache:clear
-> Limpia la cache

php bin/console debug:router
-> Ver las rustas de la página

php bin/console make:repository
-> Se utiliza para generar automáticamente una clase de repositorio para una entidad de Doctrine en tu proyecto.
