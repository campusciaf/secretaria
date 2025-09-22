<?php
require "../config/Conexion.php";

class Especial
{
	// Implementamos nuestro constructor
	public function __construct() {}

	public function trae_id_credencial($id_credencial)
	{
		global $mbd;
		$sql = "SELECT * FROM `credencial_estudiante` WHERE `id_credencial` = :id_credencial";
		// echo $sql;

		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function buscar_por_nombre($credencial_nombre)
	{
		global $mbd;
		$sql = "SELECT * FROM `credencial_estudiante` WHERE `credencial_nombre` LIKE :credencial_nombre OR `credencial_nombre_2` LIKE :credencial_nombre";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":credencial_nombre", $credencial_nombre);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function verificarDocumento($valor_seleccionado)
	{
		global $mbd;
		$sentencia = $mbd->prepare(" SELECT `credencial_estudiante`.id_credencial FROM `credencial_estudiante` INNER JOIN `estudiantes_datos_personales` ON `credencial_estudiante`.`id_credencial` = `estudiantes_datos_personales`.`id_credencial` WHERE $valor_seleccionado");
		$sentencia->execute();
		return $sentencia->fetch(PDO::FETCH_ASSOC);
	}
	public function cargarInformacion($id_credencial)
	{
		$sql_cargar_info = "SELECT * FROM `estudiantes` WHERE `id_credencial` = :id_credencial ORDER BY `estudiantes`.`fo_programa` ASC";
		global $mbd;
		$consulta_cargar_info = $mbd->prepare($sql_cargar_info);
		$consulta_cargar_info->execute(array(":id_credencial" => $id_credencial));
		$resultado_cargar = $consulta_cargar_info->fetchAll(PDO::FETCH_ASSOC);
		return $resultado_cargar;
	}


	
	public function cambiarEstadoEspecial($id_credencial)
	{
		$sql = "UPDATE `credencial_estudiante` SET psicologia = 0 WHERE id_credencial = :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		return $consulta->execute();
		
	}

	public function listarescuelas()
    {	

        $sql="SELECT * FROM escuelas WHERE estado='1' ORDER BY orden ASC";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        // $consulta->bindParam(":relacion", $relacion);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	public function listar($id_escuela, $periodo_anterior = null) {
	// Si id_escuela es 0, significa todas las escuelas
	if ($id_escuela == 0) {
		$sql = "SELECT * FROM estudiantes_activos est
				INNER JOIN credencial_estudiante ce ON est.id_credencial = ce.id_credencial
				INNER JOIN estudiantes_datos_personales edp ON est.id_credencial = edp.id_credencial
				WHERE ce.psicologia = 0"; 
	} else {
		$sql = "SELECT * FROM estudiantes_activos est
				INNER JOIN credencial_estudiante ce ON est.id_credencial = ce.id_credencial
				INNER JOIN estudiantes_datos_personales edp ON est.id_credencial = edp.id_credencial
				WHERE est.escuela = :id_escuela
				AND ce.psicologia = 0"; 
	}

	global $mbd;
	$consulta = $mbd->prepare($sql);

	if ($id_escuela != 0) {
		$consulta->bindParam(":id_escuela", $id_escuela);
	}

	$consulta->execute();
	$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
	return $resultado;
}

	


	

	
    public function traer_nom_escuela($id_escuela)
    {
        $sql="SELECT * FROM escuelas WHERE id_escuelas= :id_escuela";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_escuela", $id_escuela);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Implementar un método para traer el nombre del programa
    public function traer_nom_programa($id_programa)
    {
        $sql="SELECT * FROM programa_ac WHERE id_programa= :id_programa";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

       //Implementar un método para verificar a jornada de estudio si es una joranda para renovar
       public function verificarjornada($jornada)
       {
           $sql="SELECT nombre,rematricula FROM jornada WHERE nombre= :jornada";
           global $mbd;
           $consulta = $mbd->prepare($sql);
           $consulta->bindParam(":jornada", $jornada);
           $consulta->execute();
           $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
           return $resultado;
       }

           //traer el numero de whatsapp estudiantes
    public function traerCelularEstudiante($numero_documento){
        global $mbd;
        $hoy = date("Y-m-d");
        $sentencia = $mbd->prepare("SELECT `edp`.`celular` FROM `credencial_estudiante` `ce` INNER JOIN `estudiantes_datos_personales` `edp` ON `ce`.`id_credencial` = `edp`.`id_credencial` WHERE `ce`.`credencial_identificacion` = :numero_documento LIMIT 1;");
        $sentencia->bindParam(":numero_documento", $numero_documento);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }

    
    public function obtenerRegistroWhastapp($numero_celular){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `whatsapp_registros` WHERE `numero_whatsapp` LIKE :numero_celular ORDER BY `numero_whatsapp` ASC");
        $sentencia->bindParam(':numero_celular', $numero_celular);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }

    //Implementar un método para verificar a jornada de estudio si es una joranda para renovar
    public function buscarpagos($identificacion,$periodo_pecuniario)
    {
        $sql="SELECT * FROM pagos_rematricula WHERE identificacion_estudiante= :identificacion and periodo_pecuniario= :periodo_pecuniario and x_respuesta='Aceptada'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":identificacion", $identificacion);
        $consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    //Implementar un método para verificar a jornada de estudio si es una joranda para renovar
    public function buscarcredito($identificacion,$periodo_pecuniario)
    {
        $sql="SELECT * FROM sofi_persona WHERE numero_documento= :identificacion and periodo= :periodo_pecuniario and estado='Aprobado'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":identificacion", $identificacion);
        $consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

	public function cargarPeriodo(){
        $sql = "SELECT periodo_anterior,periodo_actual,periodo_pecuniario FROM periodo_actual";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta -> execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

	public function desmarcar($id_credencial)
	{
		$sql = "UPDATE `credencial_estudiante` SET psicologia = 1 WHERE id_credencial = :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		return $consulta->execute();
		
	}

   
    public function listarEspecialesMatriculados() {
        global $mbd;
        $sql = "SELECT ce.id_credencial, ce.credencial_identificacion, ce.credencial_nombre, ce.credencial_apellido, ce.psicologia
                FROM on_entrevista oe
                INNER JOIN on_interesados oi ON oe.id_estudiante = oi.id_estudiante
                INNER JOIN credencial_estudiante ce ON ce.credencial_identificacion = oi.identificacion
                WHERE oe.condicion_especial = 1
                  AND ce.psicologia = 1"
                  ;
                  //select id_credencial, credencial_identificacion, credencial_nombre, credencial_apellido, psicologia from credencial_estudiante where psicologia = 0
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

 

}