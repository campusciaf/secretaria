<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class VerMateriasCanceladas
{
	//Implementamos nuestro constructor
	public function __construct()
	{

    }

    public function listar(){
        $sql = "SELECT * FROM materias_canceladas";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function datos_estudiante($id_credencial){
        $sql = "SELECT credencial_identificacion FROM credencial_estudiante WHERE id_credencial =:id_credencial";
        global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch();
		return $resultado;
    }

    public function datos_programa($id_programa){
        $sql = "SELECT nombre FROM programa_ac WHERE id_programa=:id_programa";
        global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch();
		return $resultado;
    }
}
?>