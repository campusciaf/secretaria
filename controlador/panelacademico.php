<?php 
require_once "../modelos/PanelAcademico.php";
$panelacademico = new PanelAcademico();

date_default_timezone_set("America/Bogota");	
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$mes_actual=date('Y-m')."-00";

$rsptaperiodo = $panelacademico->periodoactual();
$periodo_actual = $rsptaperiodo["periodo_actual"];
$periodo_anterior = $rsptaperiodo["periodo_anterior"];
$id_usuario = $_SESSION['id_usuario'];


// $lastChar = substr($periodo_actual, -1);


// $nuevafecha = strtotime ( '-1 year' , strtotime ( $fecha ) ) ; 
// $periodo_comparado_uno = date ( 'Y' , $nuevafecha );
// $periodo_comparado=$periodo_comparado_uno . "-".$lastChar;

switch ($_GET["op"]){



    case "traerPeriodo":	
		echo $periodo_actual;
	break;

	case "selectPeriodo":	
		$rspta = $panelacademico->selectPeriodo();
		echo "<option value='".$periodo_actual."' selected='selected'>".$periodo_actual."</option>";
		for ($i=0;$i<count($rspta);$i++){
		  echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
        }
	break;

    case "selectPrograma":	
		$rspta = $panelacademico->selectPrograma();
		echo "<option value='0'>Todas</option>";
		for ($i=0;$i<count($rspta);$i++){
		  echo "<option value='" . $rspta[$i]["id_programa"] . "'>" . $rspta[$i]["nombre"] . "</option>";
        }
	break;
	case "selectJornada":	
		$rspta = $panelacademico->selectJornada();
		echo "<option value='0'>Todas</option>";
		for ($i=0;$i<count($rspta);$i++){
            echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
        }
	break;

	case 'totalestudiantes':

		$periodo=$_POST["periodo"];
		$nivel=$_POST["nivel"];
		$escuela=$_POST["escuela"];
		$programa=$_POST["programa"];
		$jornada=$_POST["jornada"];
		$semestre=$_POST["semestre"];

		$ano=substr($periodo, 0, -2);
		$anoanterior=$ano-1;


		$lastChar = substr($periodo, -1);

		$periodo_comparado=$anoanterior. "-".$lastChar;


		$data= Array();
		$data["n1"] ="";
		$data["n2"] ="";
		$data["n3"] ="";
		$data["n4"] ="";
		$data["n5"] ="";
		$data["n6"] ="";
		$data["n7"] ="";
		$data["n8"] ="";
		
		$data["n11"] ="";
		$data["n22"] ="";
		$data["n33"] ="";
		$data["n44"] ="";
		$data["n55"] ="";
		$data["n66"] ="";
		$data["n77"] ="";
		$data["n88"] ="";

		$data["totalestudiantes"] ="";
		$data["totalestudiantesanterior"] ="";
		$data["totalestudiantesunicos"] ="";

		/*  consulta para estudiantes activos */
		$rsptaactivos=$panelacademico->totalestudiantesactivos($periodo,$nivel,$escuela,$programa,$jornada,$semestre);
		$totalestudiantesactivos=count($rsptaactivos);

		$rsptaactivosanterior=$panelacademico->totalestudiantesactivos($periodo_comparado,$nivel,$escuela,$programa,$jornada,$semestre);
		$totalestudiantesactivosanterior=count($rsptaactivosanterior);

		@$porcentajeactivos=(($totalestudiantesactivos-$totalestudiantesactivosanterior)/$totalestudiantesactivosanterior)*100;
		$porcentajefinalactivos=round($porcentajeactivos, 2);
		if($porcentajefinalactivos < 0) {
			$flecha="<img src='../public/img/bajo.webp' width='20px'>";
			$texto="text-danger";
		}else{
			$flecha="<img src='../public/img/aumento.webp' width='20px'>";
			$texto="text-success";
		}

		$data["totalestudiantes"] .= '
		<div class="col-xl-3">
			<table>
				<tr>
					<td colspan="2"><span class="titulo-3">Estudiantes Activos '. $periodo .'</span></td>
				</tr>
				<tr>
					<td><h1 class="titulo">'.$totalestudiantesactivos.'</h1> </td>
					<td ><span class="titulo-3 '.$texto.'">'.$porcentajefinalactivos.'% '.$flecha.'</span><br><span style="cursor:pointer" title="'.$totalestudiantesactivosanterior.'">'.$periodo_comparado.' </span></td>
				</tr>
			</table>      
		</div>';

		/* ***************************************** */



		/* periodo actual matriculas*/
		$rspta1=$panelacademico->totalestudiantes($periodo,"materias1");
		$rspta2=$panelacademico->totalestudiantes($periodo,"materias2");
		$rspta3=$panelacademico->totalestudiantes($periodo,"materias3");
		$rspta4=$panelacademico->totalestudiantes($periodo,"materias4");// seminarios
		$rspta5=$panelacademico->totalestudiantes($periodo,"materias5");// nivelatorios
		$rspta6=$panelacademico->totalestudiantes($periodo,"materias6");// ingles
		$rspta7=$panelacademico->totalestudiantes($periodo,"materias7");// laborales
		$rspta8=$panelacademico->totalestudiantes($periodo,"materias8");// idiomas

		$totalestudiantesn1=count($rspta1);//nivel 1
		$totalestudiantesn2=count($rspta2);//nivel 2
		$totalestudiantesn3=count($rspta3);//nivel 3
		$totalestudiantesn4=count($rspta4);//nivel 4
		$totalestudiantesn5=count($rspta5);//nivel 5
		$totalestudiantesn6=count($rspta6);//nivel 6
		$totalestudiantesn7=count($rspta7);//nivel 7
		$totalestudiantesn8=count($rspta8);//nivel 8

		$totalestudiantes=$totalestudiantesn1+$totalestudiantesn2+$totalestudiantesn3+$totalestudiantesn4+$totalestudiantesn5+$totalestudiantesn6+$totalestudiantesn7+$totalestudiantesn8;

		$data["n1"] .=$totalestudiantesn1;
		$data["n2"] .=$totalestudiantesn2;
		$data["n3"] .=$totalestudiantesn3;
		$data["n4"] .=$totalestudiantesn4;
		$data["n5"] .=$totalestudiantesn5;
		$data["n6"] .=$totalestudiantesn6;
		$data["n7"] .=$totalestudiantesn7;
		$data["n8"] .=$totalestudiantesn8;
		/* **************************************** */
		
		/* periodo anterior matriculas*/
		$rspta11=$panelacademico->totalestudiantes($periodo_comparado,"materias1");
		$rspta22=$panelacademico->totalestudiantes($periodo_comparado,"materias2");
		$rspta33=$panelacademico->totalestudiantes($periodo_comparado,"materias3");
		$rspta44=$panelacademico->totalestudiantes($periodo_comparado,"materias4");
		$rspta55=$panelacademico->totalestudiantes($periodo_comparado,"materias5");
		$rspta66=$panelacademico->totalestudiantes($periodo_comparado,"materias6");
		$rspta77=$panelacademico->totalestudiantes($periodo_comparado,"materias7");
		$rspta88=$panelacademico->totalestudiantes($periodo_comparado,"materias8");

		$totalestudiantesn11=count($rspta11);//nivel 1
		$totalestudiantesn22=count($rspta22);//nivel 2
		$totalestudiantesn33=count($rspta33);//nivel 3
		$totalestudiantesn44=count($rspta44);//nivel 4
		$totalestudiantesn55=count($rspta55);//nivel 5
		$totalestudiantesn66=count($rspta66);//nivel 6
		$totalestudiantesn77=count($rspta77);//nivel 7
		$totalestudiantesn88=count($rspta88);//nivel 8

		$data["n11"] .=$totalestudiantesn11;
		$data["n22"] .=$totalestudiantesn22;
		$data["n33"] .=$totalestudiantesn33;
		$data["n44"] .=$totalestudiantesn44;
		$data["n55"] .=$totalestudiantesn55;
		$data["n66"] .=$totalestudiantesn66;
		$data["n77"] .=$totalestudiantesn77;
		$data["n88"] .=$totalestudiantesn88;

		$totalestudiantesanterior=$totalestudiantesn11+$totalestudiantesn22+$totalestudiantesn33+$totalestudiantesn44+$totalestudiantesn55+$totalestudiantesn66+$totalestudiantesn77+$totalestudiantesn88;

		/* **************************************** */


		@$porcentaje=(($totalestudiantes-$totalestudiantesanterior)/$totalestudiantesanterior)*100;
		$porcentajefinal=round($porcentaje, 2);
		if($porcentajefinal < 0) {
			$flecha="<img src='../public/img/bajo.webp' width='20px'>";
			$texto="text-danger";
		}else{
			$flecha="<img src='../public/img/aumento.webp' width='20px'>";
			$texto="text-success";
		}


		


		$data["totalestudiantes"] .= '
		<div class="col-xl-3">
			<table>
				<tr>
					<td colspan="2"><span class="titulo-3">Número de Matriculas '. $periodo .'</span></td>
				</tr>
				<tr>
					<td><h1 class="titulo">'.$totalestudiantes.'</h1> </td>
					<td ><span class="titulo-3 '.$texto.'">'.$porcentajefinal.'% '.$flecha.'</span><br><span style="cursor:pointer" title="'.$totalestudiantesanterior.'">'.$periodo_comparado.'</span> </td>
				</tr>
			</table>      
		</div>';



		/*  consulta para estudiantes nuevos */
		$rsptanuevos=$panelacademico->estudiantesnuevos($periodo,$nivel,$escuela,$programa,$jornada,$semestre);
		$totalnuevos=count($rsptanuevos);

		$rsptanuevosanterior=$panelacademico->estudiantesnuevos($periodo_comparado,$nivel,$escuela,$programa,$jornada,$semestre);
		$totalnuevosanterior=count($rsptanuevosanterior);

		@$porcentajenuevos=(($totalnuevos-$totalnuevosanterior)/$totalnuevosanterior)*100;
		$porcentajefinalnuevos=round($porcentajenuevos, 2);
		if($porcentajenuevos < 0) {
			$flecha="<img src='../public/img/bajo.webp' width='20px'>";
			$texto="text-danger";
		}else{
			$flecha="<img src='../public/img/aumento.webp' width='20px'>";
			$texto="text-success";
		}

		$data["totalestudiantes"] .= '
		<div class="col-xl-3">
			<table>
				<tr>
					<td colspan="2"><span class="titulo-3">Estudiantes Nuevos '. $periodo .'</span></td>
				</tr>
				<tr>
					<td><h1 class="titulo">'.$totalnuevos.'</h1> </td>
					<td ><span class="titulo-3 '.$texto.'">'.$porcentajefinalnuevos.'% '.$flecha.'</span><br><span style="cursor:pointer" title="'.$totalnuevosanterior.'">'.$periodo_comparado.'</span> </td>
				</tr>
			</table>      
		</div>';

		
		

		echo json_encode($data);

	break;



	case "grafico":
		$periodo=$_POST["periodo"];
		$nivel=$_POST["nivel"];
		$escuela=$_POST["escuela"];
		$programa=$_POST["programa"];
		$jornada=$_POST["jornada"];
		$semestre=$_POST["semestre"];
		
		

		$data= Array();	
		$data["datosuno"] ="";

		$valoranterior=0;
		$valornuevo=0;

	
		$listaprograma = $panelacademico->programas($nivel,$escuela,$programa);
	

		$coma=",";

		$data["datosuno"] .='[ ';

		for ($i=0;$i<count($listaprograma);$i++){

			if($i<count($listaprograma)-1){
				$coma=",";
			}else{
				$coma="";
			}

			$id_programa=$listaprograma[$i]["id_programa"];
			$programa=$listaprograma[$i]["nombre"];

			$caracteres=strlen($programa);

			// if($caracteres > 30){
			// 	$programa=substr($programa, 0, -5);
			// }else{
				
			// }
			

			$rspta1 = $panelacademico->totalestudiantesactivosprograma($periodo,$id_programa,$jornada,$semestre);

			$total=count($rspta1);
			
		
			$data["datosuno"] .='{ "y": '.$total.', "label": "'.$programa.'", "indexLabel": "'.$total.'"}'.$coma.'';


		}	
		
		$data["datosuno"] .=' ]';

		echo json_encode($data);

	break;



	case "grafico2":// estudiantes totales de la tabla estudiantes activos
		$data= Array();	
		$data["datosuno"] ="";


		$listaperiodo = $panelacademico->periodo();
		$coma=",";

		$valoranterior=0;
		$valornuevo=0;

		$data["datosuno"] .=' [';

			for ($i=0;$i<count($listaperiodo);$i++){

				if($i<count($listaperiodo)-1){
					$coma=",";
				}else{
					$coma="";
				}
				$periodo=$listaperiodo[$i]["periodo"];

				// $rspta1 = $panelacademico->totalestudiantes($periodo,"materias1");
				// $rspta2 = $panelacademico->totalestudiantes($periodo,"materias2");
				// $rspta3 = $panelacademico->totalestudiantes($periodo,"materias3");
				// $rspta4 = $panelacademico->totalestudiantes($periodo,"materias4");
				// $rspta5 = $panelacademico->totalestudiantes($periodo,"materias5");
				// $rspta6 = $panelacademico->totalestudiantes($periodo,"materias6");
				// $rspta7 = $panelacademico->totalestudiantes($periodo,"materias7");
				// $total=count($rspta1)+count($rspta2)+count($rspta3)+count($rspta4)+count($rspta5)+count($rspta6)+count($rspta7);

				$rspta1 = $panelacademico->totalmatriculaestudiantes($periodo);
				$total=count($rspta1);
				$valornuevo=$total;

				if($valoranterior < $valornuevo){
					$ganancia="gain";
					$figura="triangle";
					$color="#6B8E23";
				}else{
					$ganancia="loss";
					$figura="cross";
					$color="tomato";
				}
			
				$data["datosuno"] .='{ "label": "'.$periodo.'", "y": '.$total.', "indexLabel": "'.$total.'", "markerType": "'.$figura.'",  "markerColor": "'.$color.'" }'.$coma.'';
				$valoranterior=$valornuevo;
			}	
		
		$data["datosuno"] .=' ]';

		echo json_encode($data);

	break;

	case "grafico3":
		$periodo=$_POST["periodo"];
		$data= Array();	
		$data["datosuno"] ="";
		

		$data["datosuno"] .=' [';

			for ($nivel=1;$nivel<=3;$nivel++){

				if($nivel<3){
					$coma=",";
				}else{
					$coma="";
				}

				$rspta1 = $panelacademico->totalestudiantesactivospornivel($periodo,$nivel);

				$total=count($rspta1);
				$niveltexto="Nivel " . $nivel;
			
				$data["datosuno"] .='{ "y": '.$total.', "label": "'.$niveltexto.'"}'.$coma.'';
	
			}	
		
		$data["datosuno"] .=' ]';

		echo json_encode($data);

	break;

	
	case "grafico4":
		$data= Array();	
		$data["datosuno"] ="";

		$valoranterior=0;
		$valornuevo=0;

		$listaperiodo = $panelacademico->periodo();
		$coma=",";

		$data["datosuno"] .='[ ';

		for ($i=0;$i<count($listaperiodo);$i++){

			if($i<count($listaperiodo)-1){
				$coma=",";
			}else{
				$coma="";
			}

			$periodo=$listaperiodo[$i]["periodo"];


			$rspta1 = $panelacademico->totalestudiantesactivos1($periodo);

			$total=count($rspta1);
			$valornuevo=$total;

			if($valoranterior < $valornuevo){
				$ganancia="gain";
				$figura="triangle";
				$color="#6B8E23";
			}else{
				$ganancia="loss";
				$figura="cross";
				$color="tomato";
			}
		
			$data["datosuno"] .='{ "label": "'.$periodo.'", "y": '.$total.', "indexLabel": "'.$total.'", "markerType": "'.$figura.'",  "markerColor": "'.$color.'" }'.$coma.'';

			$valoranterior=$valornuevo;
		}	
		
		$data["datosuno"] .=' ]';

		echo json_encode($data);

	break;

}

?>