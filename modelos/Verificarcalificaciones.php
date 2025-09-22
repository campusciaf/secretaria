<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();

class VerificarCalificaciones
{
    public function listarProgramas()
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `programa_ac` WHERE `programa_ac`.`estado` = 1 ORDER BY `programa_ac`.`nombre` ASC");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($registro);
    }

    public function consulta($id_programa)
    {
        global $mbd;
        $pe = $_SESSION['periodo_actual'];
        $sentencia = $mbd->prepare(" SELECT * FROM `docente_grupos` WHERE id_programa=$id_programa AND `periodo` = '$pe' ");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        return $registro;
    }

    public function verificarcalificacion($corte,$programa,$materia,$c,$semestre,$jornada)
    {
        global $mbd;
        $pe = $_SESSION['periodo_actual'];
        $mate = "materias".$c;
        $retVal = ($programa == "1") ? "programa" : '`programa` = '.$programa;
        $sentencia = $mbd->prepare(" SELECT $corte FROM $mate WHERE nombre_materia = '$materia' AND periodo = '$pe' AND semestre = '$semestre' AND $retVal AND `jornada` = '$jornada' ");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        $can = count($registro) / 2;
        $a = 0;
        for ($i=0; $i < count($registro); $i++) { 
            if ($registro[$i][$corte] > 0.1) {
                $a++;
            }
        }

        if ($a >= $can) {
            return 1;
        } else {
            return 0;
        }

        //return $a;
        
    }

     public function datosDocente($id)
    {
        global $mbd;
        $pe = $_SESSION['periodo_actual'];
        $sentencia = $mbd->prepare(" SELECT * FROM `docente` WHERE id_usuario = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        if($id==NULL){
            $data['apellido']="Sin asignar";
            $data['nombre']="Sin asignar";
            $data['cc']="";
        }else{
            $data['apellido'] = $registro['usuario_apellido'].' '.$registro['usuario_apellido_2'];
            $data['nombre'] = $registro['usuario_nombre'].' '.$registro['usuario_nombre_2'];
            $data['cc'] = $registro['usuario_identificacion'];
        }
        


        return $data;
    }

    public function datosPrograma($id)
    {
        global $mbd;
        $pe = $_SESSION['periodo_actual'];
        $sentencia = $mbd->prepare(" SELECT nombre FROM `programa_ac` WHERE id_programa = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    	//Implementar un método para traer el id del programa de la materia
	public function BuscarDatosAsignatura($id_materia)
	{
		$sql="SELECT id_programa_ac,nombre,semestre FROM materias_ciafi WHERE id= :id_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}





}


?>