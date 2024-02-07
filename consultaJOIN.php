<?php


//Consulta Join :)
    #[Route('/consultarAlumnos/{aula}/{sexo}', name: 'app_consultar_alumnos')]
    public function nombreFuncion(ManagerRegistry $nombreDoctrina){  
        $conexion = $gestorDoctrine->getConnection();

        $alumnos = $conexion
        ->prepare("SELECT nif, nombre, sexo, num_aula, docente
                                        FROM aulas
                                        JOIN alumnos
                                        ON num_aula = aulas_num_aula" )
        ->executeQuery()
        ->fetchAllAssociative();
        
    }