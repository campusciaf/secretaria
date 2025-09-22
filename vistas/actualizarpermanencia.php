<meta charset="utf-8">
<?php

require "config/Conexion.php";
//consulta para colocarle la credencial a la tabla estudiante

// nota para esta consulta debemos quitarle las d a las cédulas
		global $mbd;

	$stmt = $mbd->prepare('SELECT DISTINCT id_usuario FROM caracterizacion');
	$stmt->execute();

	while($datos = $stmt->fetch()){
		echo $id_usuario=$datos["id_usuario"];
		echo '-';

		$compara = $mbd->prepare("SELECT * FROM caracterizacion_data WHERE id_credencial=$id_usuario");
		$compara->execute();
		
		$compararesultado = $compara->fetch(PDO::FETCH_ASSOC);;
		$id_credencial=$compararesultado["id_credencial"];

		if($compararesultado==true){
				echo $id_credencial;
				echo "<br>";
		}else{
			echo "si";
			echo "<br>";
			$stmt2 = $mbd->prepare("INSERT Into caracterizacion_data values('','$id_usuario','1','2020-03-11')");
	 		$stmt2->execute();
		}
				
		
		//$stmt2 = $mbd->prepare('UPDATE estudiantes set id_credencial="'.$id_credencial.'" WHERE identificacion="'.$identificacion.'"');
	 	//$stmt2->execute();

		
	}







?>