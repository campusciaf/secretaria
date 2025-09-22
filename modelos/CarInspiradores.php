<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class CarInspiradores
{

    	//Implementar un método para saber si acepto los datos 
	public function verificar($id_credencial)
	{
		$sql="SELECT * FROM carinspiradores WHERE id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

    // Implementamos una función para cargar los edatos del estudiant
    public function listar($id_credencial){

        $sql = "SELECT * FROM carinspiradores cso INNER JOIN estudiantes_datos_personales edp ON cso.id_credencial=edp.id_credencial WHERE cso.id_credencial= :id_credencial";
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
		$sql="INSERT INTO carinspiradores (id_credencial,aceptodata,fechaaceptodata)
		VALUES ('$id_credencial','$aceptodata','$fechaaceptodata')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}  

	public function editarDatos($id_credencial,$p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8,$p9,$p10,$p11,$p12,$p13,$p14,$p15,$p16,$p17,$p18,$p19,$p20,$p21,$p22,$p23,$p24,$p25,$p26,$p27,$p28,$p29,$p30,$p31,$fecha)
    {
       
        $sql=" UPDATE `carinspiradores` SET
		 `ip1`='$p1',`ip2`='$p2',`ip3`='$p3',`ip4`='$p4',`ip5`='$p5',`ip6`='$p6',`ip7`='$p7',`ip8`='$p8',`ip9`='$p9',`ip10`='$p10',`ip11`='$p11',`ip12`='$p12',
         `ip13`='$p13',`ip14`='$p14',`ip15`='$p15',`ip16`='$p16',`ip17`='$p17',`ip18`='$p18',`ip19`='$p19',`ip20`='$p20',`ip21`='$p21',`ip22`='$p22',`ip23`='$p23',
         `ip24`='$p24',`ip25`='$p25',`ip26`='$p26',`ip27`='$p27',`ip28`='$p28',`ip29`='$p29',`ip30`='$p30',`ip31`='$p31',
		 `updatedata`='$fecha', `estado`='0'

		 WHERE `id_credencial` = '$id_credencial'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
		return $consulta;
        

    }


  
}


?>