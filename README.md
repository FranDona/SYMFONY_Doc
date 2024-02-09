# SYMFONY_Doc
Documentación sobre Symfony, algunos datos curiosos sobre cosas enseñadas en clase


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
