<?php 
session_start(); 
require_once "../modelos/CarVerEmpresas.php";

$carverempresas=new CarVerEmpresas();

$id_ejes=isset($_POST["id_ejes"])? limpiarCadena($_POST["id_ejes"]):"";
$nombre_ejes=isset($_POST["nombre_ejes"])? limpiarCadena($_POST["nombre_ejes"]):"";
$periodo=isset($_POST["periodo"])? limpiarCadena($_POST["periodo"]):"";
$objetivo=isset($_POST["objetivo"])? limpiarCadena($_POST["objetivo"]):"";

switch ($_GET["op"]){

case 'listar':
		$periodo=$_POST["periodo"];
		$valor=$_POST["valor"];
		$data= Array();
		$data["0"] ="";
		/* consulta para traer el header de la tabla */
		$data["0"] .= '<thead>';
			$data["0"] .= '<th> Credencial</th>';
			$data["0"] .= '<th> Identificacion</th>';
			$data["0"] .= '<th> Nombre</th>';
			$data["0"] .= '<th> Celular</th>';
			$data["0"] .= '<th> Correo</th>';
			$data["0"] .= '<th> Programa académico</th>';
			$data["0"] .= '<th> Periodo ingreso </th>';
			$data["0"] .= '<th> Jornada </th>';
			$data["0"] .= '<th> Semestre </th>';
			$data["0"] .= '<th> Caracterización </th>';

			$data["0"] .= '<th>¿Trabajas actualmente?</th>';
            $data["0"] .= '<th>¿Nombre de la empresa en la que trabajas?</th>';
            $data["0"] .= '<th>¿Tipo de sector de la empresa en la que trabajas?</th>';
            $data["0"] .= '<th>¿Dirección de la empresa donde trabajas?</th>';
            $data["0"] .= '<th>¿Teléfono de la empresa donde trabajas?</th>';
            $data["0"] .= '<th>¿Jornada laboral?</th>';
            $data["0"] .= '<th>¿Qué incentivos genera tu empresa para tu proceso de formación?</th>';
            $data["0"] .= '<th>¿Alguien de tu trabajo actual o anteriores, te inspiró a estudiar?</th>';
            $data["0"] .= '<th>¿Nombre completo?</th>';
            $data["0"] .= '<th>¿Teléfono de contacto?</th>';
            $data["0"] .= '<th>¿Tienes una empresa legalmente constituida?</th>';
            $data["0"] .= '<th>¿Nombre y razón social de la empresa?</th>';
            $data["0"] .= '<th>¿Tienes una idea de negocio o emprendimiento?</th>';
            $data["0"] .= '<th>¿Nombre de la empresa, emprendimiento o idea de negocio?</th>';
            $data["0"] .= '<th>¿Sector de la empresa, emprendimiento o idea de negocio?</th>';
            $data["0"] .= '<th>¿Cuál fue tu principal motivación para emprender?</th>';
            $data["0"] .= '<th>¿Qué recursos o apoyo necesitarías para desarrollar tu emprendimiento?</th>';
            $data["0"] .= '<th>¿Has realizado algún curso o capacitación relacionada con emprendimiento?</th>';
            $data["0"] .= '<th>¿Cuál curso o capacitación?</th>';

			

		$data["0"] .= '</thead>';
		$data["0"] .= '<tbody>';
		/* ********************************* */
		if($valor==0){
			$rspta=$carverempresas->listar();
		}else{
			$rspta=$carverempresas->listar2($valor);
		}
		
		for ($a=0;$a<count($rspta);$a++){
			
			$id_credencial= $rspta[$a]["id_credencial"];
			

			$datosestudiante=$carverempresas->datosestudiante($id_credencial);
			$credencial_identificacion = $datosestudiante["credencial_identificacion"];

			$data["0"] .= '<tr>';
				$data["0"] .= '<td>';
					$data["0"] .= $id_credencial;
				$data["0"] .= '</td>';
				$data["0"] .= '<td>';
					$data["0"] .= $credencial_identificacion;
				$data["0"] .= '</td>';
				$data["0"] .= '<td>';
					$data["0"] .= '<p class="text-uppercase">'. $datosestudiante["credencial_apellido"] .' '. $datosestudiante["credencial_apellido_2"] .' '. $datosestudiante["credencial_nombre"] .' '. $datosestudiante["credencial_nombre_2"] ;
				$data["0"] .= '</td>';
				$data["0"] .= '<td>';
					$data["0"] .= $datosestudiante["celular"];
				$data["0"] .= '</td>';
				$data["0"] .= '<td>';
					$data["0"] .= $datosestudiante["email"] .'<br>'. $datosestudiante["credencial_login"];
				$data["0"] .= '</td>';
				$data["0"] .= '<td>';
					$data["0"] .= $datosestudiante["fo_programa"];
				$data["0"] .= '</td>';
				$data["0"] .= '<td>';
					$data["0"] .= $datosestudiante["periodo"];
				$data["0"] .= '</td>';
				$data["0"] .= '<td>';
					$data["0"] .= $datosestudiante["jornada_e"];
				$data["0"] .= '</td>';
				$data["0"] .= '<td>';
					$data["0"] .= $datosestudiante["semestre_estudiante"];
				$data["0"] .= '</td>';

			


			$miestado=$rspta[$a]["estado"]=="0" ? "Finalizado":"pendiente";
			$data["0"] .= '<td>';
					$data["0"] .= $miestado;
			$data["0"] .= '</td>';

			$res=0;
			for($r=1;$r<=19;$r++){

				$res='ep'. '' . $r;
				if($r==1){// trabajas
					$opcion=($rspta[$a][$res]=="2") ? "si" : (($rspta[$a][$res]=="") ? "" :"no");
					$data["0"] .= '<td>';
						$data["0"] .= $opcion;
					$data["0"] .= '</td>';
				}
				else if($r==8){//apoyo a estudiar
					$opcion=($rspta[$a][$res]=="2") ? "si" : (($rspta[$a][$res]=="") ? "" :"no");
					$data["0"] .= '<td>';
						$data["0"] .= $opcion;
					$data["0"] .= '</td>';
				}
                else if($r==11){//empresa legal
					$opcion=($rspta[$a][$res]=="2") ? "si" : (($rspta[$a][$res]=="") ? "" :"no");
					$data["0"] .= '<td>';
						$data["0"] .= $opcion;
					$data["0"] .= '</td>';
				}

                else if($r==13){//empresa legal
					$opcion=($rspta[$a][$res]=="2") ? "si" : (($rspta[$a][$res]=="") ? "" :"no");
					$data["0"] .= '<td>';
						$data["0"] .= $opcion;
					$data["0"] .= '</td>';
				}
                else if($r==18){//empresa legal
					$opcion=($rspta[$a][$res]=="2") ? "si" : (($rspta[$a][$res]=="") ? "" :"no");
					$data["0"] .= '<td>';
						$data["0"] .= $opcion;
					$data["0"] .= '</td>';
				}
				else{
					$data["0"] .= '<td>';
						$data["0"] .= $rspta[$a][$res];
					$data["0"] .= '</td>';
				}

				

			}
			
			$data["0"] .= '</tr>';
		
		}
 		
		$data["0"] .= '</tbody>';
 		$results = array($data);
 		echo json_encode($results);
	break;
		
	case 'datostabla':
		
		$data= Array();
		$data["usuario"] ="";
		
		$data["usuario"] .= $_SESSION['usuario_cargo'];

 		echo json_encode($data);
	break;
		
	case "selectPeriodo":	
		$rspta = $carverempresas->selectPeriodo();
		echo "<option value=''>Seleccionar</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
				}
	break;

		
}
?>