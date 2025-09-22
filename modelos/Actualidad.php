<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
class Consulta
{

    public function periodoactual(){
    	$sql="SELECT * FROM periodo_actual"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

    public function consultaestudiante($medio,$jornada,$programa)
    {
        $jornada2 = ($jornada == "Ninguno") ? '' : 'AND jornada_e = "'.$jornada.'"' ;
        $programa2 = ($programa == "1") ? '' : 'AND id_programa_ac = "'.$programa.'"' ;

        $periodo = $_SESSION['periodo_actual'];
        $sql = "SELECT * FROM `estudiantes` WHERE estado=1 and periodo_activo = '$periodo' ".$jornada2." ".$programa2;
        
        //echo $sql;
        global $mbd;
        $sentencia = $mbd->prepare($sql);
        $sentencia->execute();
        $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        return $registros;
        
    }

    public function consultaestudiantenuevos($medio,$jornada,$programa,$periodo)
    {
        $jornada2 = ($jornada == "Ninguno") ? '' : 'AND jornada_e = "'.$jornada.'"' ;
        $programa2 = ($programa == "1") ? '' : 'AND id_programa_ac = "'.$programa.'"' ;

        $sql = " SELECT * FROM `estudiantes` WHERE estado=1 and periodo = '$periodo' ".$jornada2." ".$programa2;
        

        global $mbd;
        $sentencia = $mbd->prepare($sql);
        $sentencia->execute();
        $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        return $registros;
        
    }

    public function consultaestudiantenuevostotal($medio,$jornada,$programa,$periodo)
    {
        $jornada2 = ($jornada == "Ninguno") ? '' : 'AND jornada_e = "'.$jornada.'"' ;
        $programa2 = ($programa == "1") ? '' : 'AND id_programa_ac = "'.$programa.'"' ;

        $sql = " SELECT * FROM `estudiantes` WHERE  periodo = '$periodo' ".$jornada2." ".$programa2;
        

        global $mbd;
        $sentencia = $mbd->prepare($sql);
        $sentencia->execute();
        $registros = $sentencia->fetchAll();

        return $registros;
        
    }
    public function consultaDatos($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM credencial_estudiante INNER JOIN estudiantes_datos_personales ON credencial_estudiante.id_credencial = estudiantes_datos_personales.id_credencial INNER JOIN estudiantes ON credencial_estudiante.id_credencial = estudiantes.id_credencial WHERE credencial_estudiante.id_credencial = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $registros = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registros;
    }

    public function mostrarPeriodo()
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `periodo` ORDER BY `periodo`.`periodo` DESC ");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($registro);
    }
    //Implementar un método para mirar datos del estudiante
	public function est_carac_habeas($id_credencial){
    	$sql="SELECT * FROM caracterizacion_data WHERE id_credencial= :id_credencial"; 
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

    public function mostrarJornada()
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM jornada ");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode ($registro);
    }

    public function listarPrograma()
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `programa_ac` WHERE `programa_ac`.`estado` = 1 ORDER BY `programa_ac`.`nombre` ASC");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($registro);
    }




}


?>