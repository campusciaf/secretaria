<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Idiomas{

    public function traeridestudiante($id_credencial,$id_programa_ac)
    {
        global $mbd;
        $sentencia =$mbd->prepare(" SELECT * FROM `estudiantes` WHERE `id_credencial` = :id_credencial AND `id_programa_ac` = :id_programa_ac");
        // echo $sentencia;
        $sentencia->bindParam(":id_credencial",$id_credencial);
        $sentencia->bindParam(":id_programa_ac",$id_programa_ac);
        $sentencia->execute();
        $datos = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $datos;
    }
    public function listar_niveles()
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `programa_ac` WHERE `escuela` = 4 AND `estado_nuevos` = 0 ORDER BY `nombre` ASC ");
        $sentencia->execute();
        $resultado = $sentencia->fetchall();
        return $resultado;
    }
    public function consulta_pagos($programa,$id_estudiante)
    {
        global $mbd;
        $sentencia =$mbd->prepare(" SELECT * FROM `materias6` WHERE `id_estudiante` = :id_estudiante AND `programa` = :programa");
        // echo $sentencia;
        $sentencia->bindParam(":id_estudiante",$id_estudiante);
        $sentencia->bindParam(":programa",$programa);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function valor_cursos($id)    
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `ingles_precios` WHERE id_programa = :id");
        
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        $datos = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $datos;
    }
    public function traervalocursos($nivel_global)
    {
        global $mbd;
        $nombre = "%$nivel_global%"; 
        $sentencia = $mbd->prepare("SELECT * FROM `programa_ac` WHERE `nombre` LIKE :nombre ORDER BY `nombre` ASC");
        $sentencia->bindParam(":nombre", $nombre);
        $sentencia->execute();
        $datos = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $datos;
    }

    //Implementar un método para listar las escuelas
	public function selectJornada()
	{
		$sql = "SELECT * FROM `jornada` WHERE `idiomas_matriculas` = 1 ORDER BY `idiomas_matriculas` ASC";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

    public function contar_cursos_ingles($programa,$id_estudiante){	
	
		global $mbd;
		$sql="SELECT count(`id_estudiante`) AS total_notas FROM `materias6` WHERE `id_estudiante` = :id_estudiante AND `programa` = :programa";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->bindParam(":programa", $programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

    public function mosrtarpromediotabla($id_estudiante,$id_programa_ac)
    {
        global $mbd;
        $sentencia =$mbd->prepare(" SELECT * FROM `estudiantes` WHERE `id_estudiante` = :id_estudiante AND `id_programa_ac` = :id_programa_ac");
        // echo $sentencia;
        $sentencia->bindParam(":id_estudiante",$id_estudiante);
        $sentencia->bindParam(":id_programa_ac",$id_programa_ac);
        $sentencia->execute();
        $datos = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $datos;
    }


    public function consultar_datos_estudiante($id_credencial)    
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `credencial_estudiante` WHERE id_credencial = :id_credencial");
        $sentencia->bindParam(":id_credencial",$id_credencial);
        $sentencia->execute();
        $datos = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $datos;
    }

}
