<?php 
require "../config/Conexion.php";

class HeteroContestaron{
    //listar periodos
    public function periodoactual()
    {
    	$sql="SELECT * FROM periodo_actual"; 

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }

    //Listar estuidantes
    public function listarEstudiantes($periodo){

        $sql="SELECT DISTINCT `id_estudiante` FROM `heteroevaluacion` WHERE periodo= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;

    }

    //Implementar un método para listar los departamentos en un select
	public function selectPeriodo()
	{	
		$sql="SELECT * FROM periodo order by id_periodo DESC";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

    		//Implementamos un método para cambiar de estado al programa
	public function datosestudiante($id_estudiante)
	{
		$sql="SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial WHERE est.id_estudiante= :id_estudiante";
		global $mbd;

		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}



}

?>