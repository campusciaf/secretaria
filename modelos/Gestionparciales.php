<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
class Gestion
{
    public function consulta($programa,$jornada,$semestre,$periodo)
    {
        global $mbd;
        // $pe = $_SESSION['periodo_actual'];
        $uno = ($jornada == "Ninguno") ? "1" : "`jornada` = '$jornada'" ;
        $dos = ($semestre == "Ninguno") ? "1" : "`semestre` = '$semestre'" ;
        $tres = ($programa == "1") ? "1" : "`id_programa` = '$programa'" ;
        $sql = " SELECT * FROM `docente_grupos` WHERE $uno AND $dos AND $tres AND `periodo` = '$periodo' ";
        $sentencia = $mbd->prepare($sql);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        return $registro;
    }

    public function datosDocente($id)
    {
        global $mbd;
        $pe = $_SESSION['periodo_actual'];
        $sentencia = $mbd->prepare(" SELECT * FROM `docente` WHERE id_usuario = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        $data['nombre'] = $registro['usuario_nombre'].' '.$registro['usuario_nombre_2'].' '.$registro['usuario_apellido'].' '.$registro['usuario_apellido_2'];
        $data['cc'] = $registro['usuario_identificacion'];


        return $data;
    }

    public function cambiarestado($docente,$medio,$columna)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" UPDATE `docente_grupos` SET $columna = $medio WHERE id_docente_grupo = $docente ");
        if ($sentencia->execute()) {
            $data['status'] = "ok";
        } else {
            $data['status'] = "Error, no se cambio el estado";
        }

        echo json_encode($data);
    }

    public function cambiartodo($val,$programa,$jornada,$semestre,$corte)
    {
        global $mbd;
        $pe = $_SESSION['periodo_actual'];

        $uno = ($jornada == "Ninguno") ? "1" : "`jornada` = '$jornada'" ;
        $dos = ($semestre == "Ninguno") ? "1" : "`semestre` = '$semestre'" ;
        $tres = ($programa == "1") ? "1" : "`id_programa` = '$programa'" ;

        $sql = " UPDATE `docente_grupos` SET `$corte` = '$val' WHERE $dos AND $tres AND $uno AND `periodo` = '$pe' ";

        $sentencia = $mbd->prepare($sql);

        if ($sentencia->execute()) {
            $data['status'] = "ok";
        } else {
            $data['status'] = "Error, no se cambio el estado del ".$corte;
        }
        echo json_encode($data);
        
    }

    public function programa($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `programa_ac` WHERE id_programa = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        $data['nombre'] = $registro['nombre'];


        return $data;
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

    public function selectPeriodo()
	{	
		$sql="SELECT * FROM periodo order by id_periodo DESC";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
}


?>