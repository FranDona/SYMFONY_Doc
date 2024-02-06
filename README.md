# SYMFONY_Doc
Documentación sobre Symfony, algunos datos curiosos sobre cosas enseñadas en clase


## Comandos de Interes para Symfony

composer create-project symfony/skeleton nombre_proyecto ^6.4
-> Crear proyecto, creara una carpeta en la ubicaion donde este.

symfony server:start
-> Iniciar servidor, es necesario estar ubicado en la carpeta del proyecto

symfony server:restart
-> Reiniciar servidor

symfony server:stop
-> Para servidor

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
