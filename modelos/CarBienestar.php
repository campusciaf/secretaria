<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class CarBienestar
{

    	//Implementar un método para saber si acepto los datos 
	public function verificar($id_credencial)
	{
		$sql="SELECT * FROM carbienestar WHERE id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

    // Implementamos una función para cargar los edatos del estudiant
    public function listar($id_credencial){

        $sql = "SELECT * FROM carbienestar cso INNER JOIN estudiantes_datos_personales edp ON cso.id_credencial=edp.id_credencial WHERE cso.id_credencial= :id_credencial";
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
		$sql="INSERT INTO carbienestar (id_credencial,aceptodata,fechaaceptodata)
		VALUES ('$id_credencial','$aceptodata','$fechaaceptodata')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}  

	public function editarDatos($id_credencial,$p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8,$p9,$p10,$p11,$p12,$p13,$p14,$p15,$p16,$p17,$p18,$p19,$p20,$p21,$p22,$p23,$fecha)
    {
       
       $sql=" UPDATE `carbienestar` SET
		 `bp1`='$p1',`bp2`='$p2',`bp3`='$p3',`bp4`='$p4',`bp5`='$p5',`bp6`='$p6',`bp7`='$p7',`bp8`='$p8',`bp9`='$p9',`bp10`='$p10',
         `bp11`='$p11',`bp12`='$p12',`bp13`='$p13',`bp14`='$p14',`bp15`='$p15',`bp16`='$p16',`bp17`='$p17',`bp18`='$p18',`bp19`='$p19',
        `bp20`='$p20',`bp21`='$p21',`bp22`='$p22',`bp23`='$p23',
		 `updatedata`='$fecha', `estado`='0'

		 WHERE `id_credencial` = '$id_credencial'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
		return $consulta;
        

    }


  
}


?>