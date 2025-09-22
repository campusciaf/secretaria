<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class CertificadoEst
{
	//Implementamos nuestro constructor
	public function __construct() {}
	

public function ListarEstudiantesConHoras() {
    $sql = "SELECT ce.id_credencial, ce.credencial_nombre, ce.credencial_nombre_2, ce.credencial_apellido, ce.credencial_apellido_2, edp.celular, edp.email,
                SUM(ass.horas_servicio) AS horas_acumuladas  FROM actividades_servicio_social ass  INNER JOIN credencial_estudiante ce ON ass.id_credencial = ce.id_credencial
            INNER JOIN estudiantes_datos_personales edp ON ce.id_credencial = edp.id_credencial GROUP BY ce.id_credencial, ce.credencial_nombre, ce.credencial_nombre_2, ce.credencial_apellido, ce.credencial_apellido_2, edp.celular, edp.email
            HAVING horas_acumuladas >= 40";
    global $mbd;
    $stmt = $mbd->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
