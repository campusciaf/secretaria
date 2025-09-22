		<?php 
		require_once "../modelos/SacObjectivosEspecificos.php";

		$sacobjetivosespecificos = new SacObjectivosEspecificos();
		$id_objetivo = isset($_POST["id_objetivo"])? limpiarCadena($_POST["id_objetivo"]):"";
		$id_objetivo_especifico = isset($_POST["id_objetivo_especifico"])? limpiarCadena($_POST["id_objetivo_especifico"]):"";
		$nombre_objetivo_especifico = isset($_POST["nombre_objetivo_especifico"])? limpiarCadena($_POST["nombre_objetivo_especifico"]):"";
	
		switch ($_GET["op"]){
			case 'guardaryeditarobjetivoespecifico':
				if (empty($id_objetivo_especifico)){
					$rspta = $sacobjetivosespecificos->insertarobjetivoespecifico($nombre_objetivo_especifico, $id_objetivo);
					echo $rspta ? "objetivo especifico registrado" : "objetivo especifico no se pudo registrar";
				}else{
					$rspta=$sacobjetivosespecificos->editarobjetivoespecifico($id_objetivo_especifico, $nombre_objetivo_especifico);
					echo $rspta ? "objetivo especifico actualizada" : "objetivo especifico no se pudo actualizar";
				}
			break;

				
		}
		?>