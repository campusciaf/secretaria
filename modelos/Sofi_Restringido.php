<?php 
require "../config/Conexion.php";
require ('../public/mail/sendSolicitud.php');
require ('../public/mail/templateSolicitud.php');
session_start();
class Estado_Restringido
{

    public function consultaEstudiante($cedula){
		global $mbd;
		$sql_mostrar = "SELECT credencial_estudiante.id_credencial,credencial_estudiante.credencial_nombre,credencial_estudiante.credencial_nombre_2, credencial_estudiante.credencial_apellido,credencial_estudiante.credencial_apellido_2, estado_ciafi, credencial_estudiante.credencial_identificacion FROM `sofi_persona` INNER JOIN sofi_matricula on sofi_matricula.id_persona = sofi_persona.id_persona INNER JOIN credencial_estudiante ON sofi_persona.numero_documento = credencial_estudiante.credencial_identificacion WHERE credencial_estudiante.credencial_identificacion = :cedula";
		$consulta_mostrar = $mbd->prepare($sql_mostrar);
		$consulta_mostrar->bindParam(":cedula", $cedula);
		$consulta_mostrar->execute();
		$resultado_mostrar = $consulta_mostrar->fetch(PDO::FETCH_ASSOC);
		return $resultado_mostrar;
	} 
    public function consultaCorreo($cedula)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `credencial_estudiante` WHERE `id_credencial` = :id ");
        $sentencia->bindParam(":id",$cedula);
        if ($sentencia->execute()) {
            $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $registro;
        } else {
            echo "false";
        }
        
    }

	public function estadoEst($estado_ciafi,$cedula){
		$sql="UPDATE `sofi_persona` INNER JOIN sofi_matricula on sofi_matricula.id_persona = sofi_persona.id_persona INNER JOIN credencial_estudiante ON sofi_persona.numero_documento = credencial_estudiante.credencial_identificacion SET `estado_ciafi`= :estado_ciafi WHERE credencial_estudiante.credencial_identificacion = :cedula;";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":estado_ciafi", $estado_ciafi);
		$consulta->bindParam(":cedula", $cedula);
		$consulta->execute();
		return $consulta;	
	}
    
}
