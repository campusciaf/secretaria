<?php 

require_once "../modelos/ProyeccionHorarios.php";

$proyeccionhorarios=new ProyeccionHorarios();

$periodo_siguiente=$_SESSION['periodo_siguiente'];

switch ($_GET["op"]){
		
	case 'listar':
		$data= Array();
		$data["0"] ="";
			$rspta=$proyeccionhorarios->listar();
			$reg=$rspta;
				
				
		
				for ($i=0;$i<count($reg);$i++){
					
					$data["0"] .= $id_docente_grupo=$reg[$i]["id_docente_grupo"];
					$data["0"] .= '-';
					$data["0"] .= $id_docente=$reg[$i]["id_docente"];
					$data["0"] .= $materia=$reg[$i]["materia"];
					$data["0"] .= $jornada=$reg[$i]["jornada"];
					$data["0"] .= $semestre=$reg[$i]["semestre"];
					$data["0"] .= $id_programa=$reg[$i]["id_programa"];
					$data["0"] .= $grupo=$reg[$i]["grupo"];
					$data["0"] .= $ciclo=$reg[$i]["ciclo"];
					$data["0"] .= $num_estu=$reg[$i]["num_estu"];
					$data["0"] .= $c1=$reg[$i]["c1"];
					$data["0"] .= $c2=$reg[$i]["c2"];
					$data["0"] .= $c3=$reg[$i]["c3"];
					$data["0"] .= $c4=$reg[$i]["c4"];
					$data["0"] .= $c5=$reg[$i]["c5"];
					$data["0"] .= $restriccion=$reg[$i]["restriccion"];
					$data["0"] .= $confirmacion=$reg[$i]["confirmacion"];
					
					$data["0"] .= $dia=$reg[$i]["dia"];
					$data["0"] .= $hora=$reg[$i]["hora"];
					$data["0"] .= $hasta=$reg[$i]["hasta"];
					$data["0"] .= $diferencia=$reg[$i]["diferencia"];
					$data["0"] .= $salon=$reg[$i]["salon"];
					
					
			
	// este codigo lo activo para que realice la proyeccíon				
					

//				$insertar=$proyeccionhorarios->insertarRegistro($id_docente,$materia,$jornada,$semestre,$id_programa,$grupo,$ciclo,$num_estu,$c1,$c2,$c3,$c4,$c5,$restriccion,$confirmacion,$periodo_siguiente);
//
//					$idusuarionew = $mbd->lastInsertId();
//					$data["0"] .= "-";
//					$data["0"] .= $idusuarionew;
//					
//				$insertar2=$proyeccionhorarios->insertarHora($idusuarionew,$dia,$hora,$hasta,$diferencia,$salon,$periodo_siguiente);
					
					$data["0"] .= "<br>";
					
				}

			
		
		
		$results = array($data);
 		echo json_encode($results);
	break;
		
}
?>