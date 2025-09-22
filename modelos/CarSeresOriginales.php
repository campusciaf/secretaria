<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class CarSeresOriginales
{

    	//Implementar un método para saber si acepto los datos 
	public function verificar($id_credencial)
	{
		$sql="SELECT * FROM carseresoriginales WHERE id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

    // Implementamos una función para cargar los edatos del estudiant
    public function listar($id_credencial){

        $sql = "SELECT * FROM carseresoriginales cso INNER JOIN estudiantes_datos_personales edp ON cso.id_credencial=edp.id_credencial WHERE cso.id_credencial= :id_credencial";
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
		$sql="INSERT INTO carseresoriginales (id_credencial,aceptodata,fechaaceptodata)
		VALUES ('$id_credencial','$aceptodata','$fechaaceptodata')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}  

	public function editarDatos($id_credencial,$p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8,$p9,$p10,$p11,$p12,$p13,$p14,$p15,$p16,$p17,$p18,$fecha)
    {
       
        $sql=" UPDATE `carseresoriginales` SET
		 `p1`='$p1',`p2`='$p2',`p3`='$p3',`p4`='$p4',`p5`='$p5',`p6`='$p6',`p7`='$p7',`p8`='$p8',`p9`='$p9',`p10`='$p10',`p11`='$p11',`p12`='$p12',`p13`='$p13',`p14`='$p14',`p15`='$p15',`p16`='$p16',`p17`='$p17',`p18`='$p18',

		 `updatedata`='$fecha', `estado`='0'

		 WHERE `id_credencial` = '$id_credencial'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
		return $consulta;
        

    }


  
}


?>