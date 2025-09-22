<?php
require "../config/Conexion.php";

Class Faltas
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	public function periodoactual()
    {
    	$sql="SELECT * FROM on_periodo_actual"; 

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }


	//Implementar un método para listar los periodos en un select
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
	//Implementar un método para mostrar el id del programa
	public function listar($periodo)
	{
		
		$sql="SELECT * FROM `faltas` WHERE periodo_falta = '$periodo' ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
			//Implementar un método para eliminar la falta
	public function eliminarfalta($id_falta)
    {
    	$sql="DELETE FROM faltas WHERE id_falta= :id_falta"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_falta", $id_falta);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;

    }
	
	    public function eliminarfaltamateria($id_materia,$ciclo)
    {
		global $mbd;	
		$materia = "materias".$ciclo;
		$sql="UPDATE $materia SET faltas = faltas-1 WHERE `id_materia` = :id_materia"; 
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
        
    }

    public function consultaEstudiante($id_estudiante,$programa)
    {
        global $mbd;

        $sentencia = $mbd->prepare(" SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial WHERE est.id_estudiante= $id_estudiante AND est.id_programa_ac = $programa");
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);



        return $registro;
    }

    public function consultaDocente($id_usuario)
    {
        global $mbd;
        $data = array();
        $sentencia = $mbd->prepare("SELECT * FROM `docente` WHERE `id_usuario` = :id_usuario");
        $sentencia->bindParam(":id_usuario", $id_usuario);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }

    public function programa($id)
    {
        global $mbd;
        $data = array();
        $sentencia = $mbd->prepare(" SELECT * FROM `programa_ac` WHERE id_programa = :id ");
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return  $registro;
    }


	public function fechaesp($date) {
		$dia 	= explode("-", $date, 3);
		$year 	= $dia[0];
		$month 	= (string)(int)$dia[1];
		$day 	= (string)(int)$dia[2];

		$dias 		= array("domingo","lunes","martes","mi&eacute;rcoles","jueves","viernes","s&aacute;bado");
		$tomadia 	= $dias[intval((date("w",mktime(0,0,0,$month,$day,$year))))];

		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

		return $tomadia.", ".$day." de ".$meses[$month]." de ".$year;
	}

}


?>