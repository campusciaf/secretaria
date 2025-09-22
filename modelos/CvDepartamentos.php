<?php

session_start(); 

//Incluímos inicialmente la conexión a la base de datos

require "../config/Conexion.php";

	class Departamento{

		public function __construct(){

		}

		public function mostrar(){
			$sql = "SELECT * FROM departamentos";
            global $mbd;
            $consulta = $mbd->prepare($sql);
            $consulta->execute();
            $resultado = $consulta->fetchAll();
            return $resultado;
		}
	}

?>