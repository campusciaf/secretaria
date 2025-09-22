<?php 
require "../config/Conexion.php";
class Consulta
{

    public function periodoactual(){
    	$sql="SELECT * FROM on_periodo_actual"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }

    public function listar($periodo_campana)
    {
        $sql="SELECT * FROM `on_interesados` WHERE `estado` IN ('Preinscrito','Inscrito', 'Seleccionado', 'Admitido', 'Matriculado') 
        AND `periodo_campana` = :periodo_campana ";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":periodo_campana", $periodo_campana);
		$consulta->execute();
        $resultado=$consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function listarprograma($periodo_campana,$programa)
    {
        $sql="SELECT * FROM `on_interesados` WHERE `estado` IN ('Preinscrito','Inscrito', 'Seleccionado', 'Admitido', 'Matriculado') 
        AND `periodo_campana` = :periodo_campana 
        AND `fo_programa`= :programa";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":periodo_campana", $periodo_campana);
        $consulta->bindParam(":programa", $programa);
		$consulta->execute();
        $resultado=$consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function listarprogramaj($periodo_campana,$programa,$jornada)
    {
        $sql="SELECT * FROM `on_interesados` WHERE `estado` IN ('Preinscrito','Inscrito', 'Seleccionado', 'Admitido', 'Matriculado') 
        AND `periodo_campana` = :periodo_campana 
        AND `fo_programa`= :programa 
        AND `jornada_e`= :jornada";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":periodo_campana", $periodo_campana);
        $consulta->bindParam(":programa", $programa);
        $consulta->bindParam(":jornada", $jornada);
		$consulta->execute();
        $resultado=$consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }



}


?>