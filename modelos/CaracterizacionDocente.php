<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class CaracterizacionDocente
{

    	//Implementar un método para saber si acepto los datos 
	public function aceptoData($id_docente)
	{
		$sql="SELECT * FROM caracterizaciondocente WHERE id_docente= :id_docente";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_docente", $id_docente);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

    // Implementamos una función para cargar los edatos del docente
    public function listar($id_docente){

        $sql = "SELECT * FROM caracterizaciondocente WHERE id_docente= :id_docente";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_docente", $id_docente);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

        //Implementamos un método para insertar data
	public function insertardata($id_docente,$aceptodata,$fechaaceptodata)
	{
		$sql="INSERT INTO caracterizaciondocente (id_docente,aceptodata,fechaaceptodata)
		VALUES ('$id_docente','$aceptodata','$fechaaceptodata')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}  

	public function editarDatos(
		$id_docente, 
		$p1, $p2, $p3, $p4, $p5, $p6, $p7, $p8, $p9, $p10,
		$p11, $p12, $p13, $p14, $p15, $p16, $p17, $p18, $p19, $p20,
		$p21, $p22, $p23, $p24, $p25, $p26, $p27, $p28, $p29, $p30,
		$p31, $p32, $p33, $p34, $p35, $p36, $p37, $p38, $p39, $p40,
		$p41, $p42, $p43, $p44, $p45, $p46, $p47, $p48, $p49, $p50,
		$fecha
	) {
		// Lista de preguntas que deben ser NULL si están vacías
		$preguntasNullables = [
			'p1', 'p2', 'p3', 'p4', 'p7', 'p8', 'p10', 'p11', 'p13', 'p14', 
			'p16', 'p18', 'p19', 'p20', 'p21', 'p27', 'p28', 'p30', 'p31', 
			'p32', 'p33', 'p34', 'p35', 'p36', 'p37', 'p38', 'p40', 'p41', 
			'p42', 'p47', 'p48', 'p50'
		];
	
		// Arreglo de todos los parámetros para procesarlos dinámicamente
		$params = compact(
			'p1', 'p2', 'p3', 'p4', 'p5', 'p6', 'p7', 'p8', 'p9', 'p10',
			'p11', 'p12', 'p13', 'p14', 'p15', 'p16', 'p17', 'p18', 'p19', 
			'p20', 'p21', 'p22', 'p23', 'p24', 'p25', 'p26', 'p27', 'p28', 
			'p29', 'p30', 'p31', 'p32', 'p33', 'p34', 'p35', 'p36', 'p37', 
			'p38', 'p39', 'p40', 'p41', 'p42', 'p43', 'p44', 'p45', 'p46', 
			'p47', 'p48', 'p49', 'p50'
		);
	
		// Procesar las preguntas para reemplazar valores vacíos con NULL
		foreach ($preguntasNullables as $pregunta) {
			if (isset($params[$pregunta]) && trim($params[$pregunta]) === '') {
				$params[$pregunta] = null; // Reemplazar vacío por NULL
			}
		}
	
		// Construir la consulta con los parámetros procesados
		$sql = "UPDATE `caracterizaciondocente` SET 
			`p1` = :p1, `p2` = :p2, `p3` = :p3, `p4` = :p4, `p5` = :p5, `p6` = :p6, 
			`p7` = :p7, `p8` = :p8, `p9` = :p9, `p10` = :p10, `p11` = :p11, `p12` = :p12, 
			`p13` = :p13, `p14` = :p14, `p15` = :p15, `p16` = :p16, `p17` = :p17, 
			`p18` = :p18, `p19` = :p19, `p20` = :p20, `p21` = :p21, `p22` = :p22, 
			`p23` = :p23, `p24` = :p24, `p25` = :p25, `p26` = :p26, `p27` = :p27, 
			`p28` = :p28, `p29` = :p29, `p30` = :p30, `p31` = :p31, `p32` = :p32, 
			`p33` = :p33, `p34` = :p34, `p35` = :p35, `p36` = :p36, `p37` = :p37, 
			`p38` = :p38, `p39` = :p39, `p40` = :p40, `p41` = :p41, `p42` = :p42, 
			`p43` = :p43, `p44` = :p44, `p45` = :p45, `p46` = :p46, `p47` = :p47, 
			`p48` = :p48, `p49` = :p49, `p50` = :p50, `updatedata` = :fecha 
			WHERE `id_docente` = :id_docente";
	
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$params['id_docente'] = $id_docente;
		$params['fecha'] = $fecha;
	
		$consulta->execute($params);
	
		return $consulta;
	}
	


  
}


?>