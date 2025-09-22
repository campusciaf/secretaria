<?php 
require_once "../modelos/EstadoAcademico.php";

$estadoacademico=new EstadoAcademico();


$programa_ac=isset($_POST["programa_ac"])? limpiarCadena($_POST["programa_ac"]):"";
$estado=isset($_POST["estado"])? limpiarCadena($_POST["estado"]):"";
$periodo_activo=isset($_POST["periodo_activo"])? limpiarCadena($_POST["periodo_activo"]):"";




switch ($_GET["op"]){

    case 'consultar':
		$data= Array();//Vamos a declarar un array
		$data["programa"] =$programa_ac;
        $data["estado"]=$estado;
		$data["periodo_activo"] =$periodo_activo;
		echo json_encode($data);
		
		
	break;
	
	case 'listar':

		$programa=$_GET["programa"];
		$periodo_activo=$_GET["periodo_activo"];
        $estado=$_GET["estado"];
		
		$rspta1=$estadoacademico->datosPrograma($programa);
		$semestre=$rspta1["semestres"];
		$cantidad_asignaturas=$rspta1["cant_asignaturas"];
		$ciclo=$rspta1["ciclo"];
		
		$rspta=$estadoacademico->listar($programa,$estado,$periodo_activo);
 		//Vamos a declarar un array
 		$data= Array();

			$i = 0;			
			while ($i < count($rspta)){
				$rsptamaterias=$estadoacademico->buscarMaterias($rspta[$i]["id_estudiante"],$ciclo);
				$total=count($rsptamaterias);

                $nombreestado=$estadoacademico->buscarNombreEstado($rspta[$i]["estado"]);
                $estadoactual=$nombreestado["estado"];
				
					$data[]=array(
						"0"=>$rspta[$i]["credencial_identificacion"],
						"1"=>$rspta[$i]["id_estudiante"],
						"2"=>$rspta[$i]["jornada_e"],		
						"3"=>$estadoactual,
						"4"=>$rspta[$i]["semestre_estudiante"],	
						"5"=>$cantidad_asignaturas .'/'.$total,
						"6"=>$rspta[$i]["periodo_activo"],
						"7"=>$cantidad_asignaturas==$total?'<a onclick=convertiregresado("'.$rspta[$i]["id_estudiante"].'") class="btn btn-success">Convertir Egresado</a>':"--",
						);			
					$i++;
			}
		
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
		
	case 'mostrar':
	
		$rspta=$estadoacademico->mostrar($id);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);

	break;	
		

		
	case "selectPrograma":	
		$rspta = $estadoacademico->selectPrograma();
		echo "<option value='todos'>Todos</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
				}
	break;
		
	case "selectPeriodo":	
		$rspta = $estadoacademico->selectPeriodo();
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
				}
	break;

    case "selectEstado":	
		$rspta = $estadoacademico->selectEstado();
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["id_estado_academico"] . "'>" . $rspta[$i]["estado"] . "</option>";
				}
	break;


	case 'convertiregresado':
		$id_estudiante=$_POST["id_estudiante"];

		$rspta=$estadoacademico->convertiregresado($id_estudiante);
		
		if($rspta==0){
			echo "1";
		}else{
			
			echo "0";
		}
	break;
		

		

}
?>