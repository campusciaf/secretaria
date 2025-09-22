<?php

session_start(); 

//Incluímos inicialmente la conexión a la base de datos

require "../config/Conexion.php";

	class Ciudad{

		public function __construct(){

		}
		public function cv_mostrar($id){
			$sql = "SELECT * FROM municipios WHERE departamento_id=$id";
            global $mbd;
            $consulta = $mbd->prepare($sql);
            $consulta->execute();
            $resultado = $consulta->fetchAll();
            return $resultado;

		}

	}

?>