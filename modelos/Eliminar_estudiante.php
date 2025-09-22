<?php 

require "../config/Conexion.php";

class Eliminar
{
    public function buscar($cedula)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `credencial_estudiante` WHERE `credencial_identificacion` = :cedula ");
        $sentencia->bindParam(":cedula", $cedula);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        $sentencia2 = $mbd->prepare("SELECT * FROM `estudiantes` WHERE `id_credencial` = :id ");
        $sentencia2->bindParam(":id", $registro['id_credencial']);
        $sentencia2->execute();
        $registro2 = $sentencia2->fetchAll(PDO::FETCH_ASSOC);
        $cantidad = count($registro2);
        if ($registro) {
            if ($cantidad == 1) {
                $datos['result'] = "<div class='col-xs-12 col-sm-6 col-md-10 col-lg-10'>
                    <i class='fas fa-user'></i> ".$registro['credencial_nombre'] . " "  .$registro['credencial_nombre_2'] . " " .$registro['credencial_apellido'] .  " " . $registro['credencial_apellido'] ." | 
                    <i class='fas fa-clock'></i> ".$registro2[0]['jornada_e']. "<br>
                    <i class='fas fa-book-open'></i> ".$registro2[0]['fo_programa']."
                    </div>
                    <div id='boton_matricular_materias' class='col-xs-12 col-sm-6 col-md-2 col-lg-2'>
                                <button type='button' class='btn btn-success' onClick=eliminarEstudiante('".$registro2[0]['id_estudiante']."','".$registro2[0]['ciclo']."','".$registro['credencial_identificacion']."','".$registro2[0]['id_programa_ac']."')>
                                <i class='fas fa-book'></i> 
                                    Eliminar Todo del estudiante
                                </button>
                            </div>";
                $datos['status'] = "ok";
                $datos['tipo'] = "1";
                $datos['todo'] = $registro2[0];
            } else {
                if ($cantidad > 1) {
                    $datos['status'] = "ok";
                    $datos['tipo'] = "0";
                    $datos['todo'] = $registro2;
                } else {
                    $datos['status'] = "err";
                }                
            }
        } else {
            $datos['status'] = "err";
        }
        echo json_encode($datos);
    }

    public function listarMateria($id,$ciclo)
    {
        $consulta = "";

        /* consultasmos por ciclo para definir la consulta sql  */

        $materias = "materias".$ciclo;
        

        global $mbd;
        $data = array();
        $sentencia = $mbd->prepare(" SELECT * FROM $materias WHERE `id_estudiante` = :id ");
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
		while ($registros = $sentencia->fetchObject()) {
            /* depende de la consulta enviamos la cantidad de datos */
            if ($ciclo == "1" || $ciclo == "2") {
                $data[]=array(                
                "0"=>$registros->nombre_materia,
                "1"=>$registros->c1,
                "2"=>$registros->c2,
                "3"=>$registros->c3,
                "4"=>$registros->promedio,
                "5"=>$registros->periodo
                ); 
            } else {
                    $data[]=array(                
                    "0"=>$registros->nombre_materia,
                    "1"=>$registros->c1,
                    "2"=>$registros->promedio,
                    "3"=>$registros->periodo
                    );
            }
               
        }
        $result = array(
			"sEcho"=>1, //Información para el datatble
			"iTotalRecords"=>count($data),
			"iTotalDisplayRecords"=>count($data),
			"aaData"=>$data
		);      
		

		$mbd = null;
		echo json_encode($result);
    }

    public function consultaCredencial($id)
    {
        global $mbd;
        $data = array();
        $sentencia = $mbd->prepare("SELECT * FROM `credencial_estudiante` WHERE `credencial_identificacion` = :cedula ");
        $sentencia->bindParam(":cedula", $id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
		return $registro['id_credencial'];
    }

    public function consultaEstudiante($id)
    {
        global $mbd;
        $data = array();
        $sentencia = $mbd->prepare("SELECT * FROM `estudiantes` WHERE `id_credencial` = :cedula ");
        $sentencia->bindParam(":cedula", $id);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		return $registro;
    }

    public function consultaPrograma($cedula)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `estudiantes` WHERE `id_estudiante` = :id ");
        $sentencia->bindParam(":id", $cedula);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        $sentencia2 = $mbd->prepare("SELECT * FROM `credencial_estudiante` WHERE `id_credencial` = :id ");
        $sentencia2->bindParam(":id", $registro['id_credencial']);
        $sentencia2->execute();
        $registro2 = $sentencia2->fetch(PDO::FETCH_ASSOC);

        if ($registro) {
            $datos['result'] = "<div class='col-xs-12 col-sm-6 col-md-10 col-lg-10'>
                    <i class='fas fa-user'></i> ".$registro2['credencial_nombre'] . " "  .$registro2['credencial_nombre_2'] . " " .$registro2['credencial_apellido'] .  " " . $registro2['credencial_apellido'] ." | 
                    <i class='fas fa-clock'></i> ".$registro['jornada_e']. "<br>
                    <i class='fas fa-book-open'></i> ".$registro['fo_programa']."
                    </div>
                    <div id='boton_matricular_materias' class='col-xs-12 col-sm-6 col-md-2 col-lg-2'>
                                <button type='button' class='btn btn-success' onClick=eliminarPrograma('".$registro['id_estudiante']."','".$registro['ciclo']."')>
                                <i class='fas fa-book'></i> 
                                    Eliminar Programa
                                </button>
                            </div>";
                $datos['status'] = "ok";
                $datos['todo'] = $registro;
        } else {
            $datos['status'] = "err";
        }
        echo json_encode($datos);
        
    }


    public function deleteEstudiante($id_estudiante,$ciclo,$cedula,$programa)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" DELETE FROM `estudiantes` WHERE `id_estudiante` = :id AND id_programa_ac = :programa ");
        $sentencia->bindParam(":id", $id_estudiante);
        $sentencia->bindParam(":programa", $programa);

        $materia = "materias".$ciclo;

        

        $sentencia2 = $mbd->prepare(" DELETE FROM $materia WHERE `id_estudiante` = :id ");
        $sentencia2->bindParam(":id", $id_estudiante);

        $sentencia3 = $mbd->prepare(" DELETE FROM `credencial_estudiante` WHERE `credencial_identificacion` = :cedula ");
        $sentencia3->bindParam(":cedula", $cedula);

        $sentencia4 = $mbd->prepare(" DELETE FROM `estudiantes_datos_personales` WHERE `id_estudiante` = :cedula ");
        $sentencia4->bindParam(":cedula", $id_estudiante);

        if ($sentencia->execute()) {
            if ($sentencia2->execute()) {
                if ($sentencia3->execute()) {
                    if ($sentencia4->execute()) {
                        $data['status'] = "ok";
                    } else {
                        $data['status'] = "err";
                    }
                } else {
                    $data['status'] = "err";
                }
            } else {
               $data['status'] = "err";
            }
        } else {
            $data['status'] = "err";
        }

        echo json_encode($data);
    }

    public function eliminarPrograma($id_estudiante,$ciclo)
    {
        global $mbd;
        $sentencia = $mbd->prepare("DELETE FROM `estudiantes` WHERE `id_estudiante` = :id");
        $sentencia->bindParam(":id", $id_estudiante);

        $materia = "materias".$ciclo;

        $sentencia2 = $mbd->prepare("DELETE FROM $materia WHERE `id_estudiante` = :id");
        $sentencia2->bindParam(":id", $id_estudiante);

        if ($sentencia->execute()) {
            if ($sentencia2->execute()) {
                $data['status'] = "ok";
            } else {
               $data['status'] = "err";
            }
        } else {
            $data['status'] = "err";
        }

        echo json_encode($data);
        
    }


}


?>