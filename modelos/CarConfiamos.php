<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class CarConfiamos
{

    	//Implementar un método para saber si acepto los datos 
	public function verificar($id_credencial)
	{
		$sql="SELECT * FROM carconfiamos WHERE id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

    // Implementamos una función para cargar los edatos del estudiant
    public function listar($id_credencial){

        $sql = "SELECT * FROM carconfiamos cso INNER JOIN estudiantes_datos_personales edp ON cso.id_credencial=edp.id_credencial WHERE cso.id_credencial= :id_credencial";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

        //Implementamos un método para insertar data
	public function insertardata($id_credencial,$aceptodata,$fechaaceptodata)
	{
		$sql="INSERT INTO carconfiamos (id_credencial,aceptodata,fechaaceptodata)
		VALUES ('$id_credencial','$aceptodata','$fechaaceptodata')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}  

	public function editarDatos($id_credencial,$p1,$p2,$p3,$p4,$p5,$p6,$fecha)
    {
       
        $sql=" UPDATE `carconfiamos` SET
		 `cop1`='$p1',`cop2`='$p2',`cop3`='$p3',`cop4`='$p4',`cop5`='$p5',`cop6`='$p6',

		 `updatedata`='$fecha', `estado`='0'

		 WHERE `id_credencial` = '$id_credencial'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
		return $consulta;
        

    }


  
}


?>