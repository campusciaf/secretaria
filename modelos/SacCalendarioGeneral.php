<?php 
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class SacCalendarioGeneral
{
	//Implementamos nuestro constructor
	public function __construct() {

	}

	public function mostraraccionespormetafin($mes,$anio){	
		global $mbd;
		$sql="SELECT * FROM `sac_meta` INNER JOIN `sac_proyecto` ON `sac_meta`.`id_proyecto` = `sac_proyecto`.`id_proyecto` INNER JOIN `sac_accion` ON `sac_meta`.`id_meta` = `sac_accion`.`id_meta` INNER JOIN usuario ON sac_meta.meta_responsable = usuario.id_usuario WHERE MONTH(`sac_accion`.`fecha_fin`) = '$mes' and `sac_meta`.`anio_eje` = :anio ";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":anio", $anio);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar la ejecucion
	public function listarproyecto(){	
		global $mbd;
		$sql="SELECT * FROM sac_proyecto ";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para listar los registros
    public function listar()
    {
        $sql = "SELECT `usuario`.`usuario_imagen`, `usuario_cargo` FROM `usuario` ORDER BY `usuario`.`usuario_imagen` DESC";
        //return ejecutarConsulta($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	public function periodoactual(){
    	$sql="SELECT * FROM periodo_actual"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
}

?>