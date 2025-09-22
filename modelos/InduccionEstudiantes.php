<?php 
require "../config/Conexion.php";

Class InduccionEstudiantes{
	// Implementamos nuestro constructor
	public function __construct() {
    }

    public function registrarDatosEstudiante($identificacion,$nombre,$programa,$inspirador,$parentesco){
        if ($programa == "soft") {
            $nombre_programa = "Ingeniería de Software";
        } else if ($programa == "sst") {
            $nombre_programa = "Seguridad y Salud en el Trabajo";
        } else if ($programa == "admon"){
            $nombre_programa = "Administración de Empresas";
        } else if ($programa == "cont") {
            $nombre_programa = "Contaduría Pública";
        }

        $sql_insertar_registro = "INSERT INTO induccion_estudiante VALUES ('',:identificacion,:nombre,:programa,:inspirador,:parentesco)";
		global $mbd;
		$consulta_insertar_registro = $mbd->prepare($sql_insertar_registro);
		$consulta_insertar_registro->execute(array(
            "identificacion" => $identificacion,
            "nombre" => $nombre,
            "programa" => $nombre_programa,
            "inspirador" => $inspirador,
            "parentesco" => $parentesco
        ));
		return $consulta_insertar_registro;
    }
}
?>