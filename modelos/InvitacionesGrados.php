<?php 
session_start(); 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

Class InvitacionesGrados
{
	public function __construct()
	{

	}

    public function listarEstudiantes()
    {
    	$sql="SELECT * FROM ingresos_invitaciones_grados;";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
    }

    public function uploadQREstudiante($cedula_hash, $cedula)
    {
		global $mbd;

		$sql = "UPDATE ingresos_invitaciones_grados SET cedula_encrypt = :cedula_hash WHERE cedula = :cedula;";

		$consulta = $mbd->prepare($sql);

		$consulta->bindParam(":cedula_hash", $cedula_hash);
		$consulta->bindParam(":cedula", $cedula);

		return $consulta->execute();
	}

    public function infoEstudiante($cedula)
    {
        global $mbd;

    	$sql="SELECT * FROM ingresos_invitaciones_grados WHERE cedula = :cedula;";
		
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":cedula", $cedula);
        $consulta->execute();

		$resultado = $consulta->fetch();

		return $resultado;
    }

    public function buscarPorHash($hash)
    {
        global $mbd;

        $sql = "SELECT * FROM ingresos_invitaciones_grados WHERE cedula_encrypt = :hash LIMIT 1";

        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(':hash', $hash, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    public function aumentarIngreso($id, $ingresos)
    {
		global $mbd;

		$sql = "UPDATE ingresos_invitaciones_grados SET ingresos = :ingresos WHERE id = :id;";

		$consulta = $mbd->prepare($sql);

		$consulta->bindParam(":ingresos", $ingresos);
		$consulta->bindParam(":id", $id);

		return $consulta->execute();
	}

}