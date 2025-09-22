<?php
session_start(); 
require_once "../modelos/CargaDocente.php";
$cargadocente=new CargaDocente();
$periodo=isset($_POST["periodo"])? limpiarCadena($_POST["periodo"]):"";
$escuela=isset($_POST["escuela"])? limpiarCadena($_POST["escuela"]):"";
$id_usuario=isset($_POST["id_usuario"])? limpiarCadena($_POST["id_usuario"]):"";
$observacion=isset($_POST["observacion"])? limpiarCadena($_POST["observacion"]):"";
$id_convenir=isset($_POST["id_convenir"])? limpiarCadena($_POST["id_convenir"]):"";

switch ($_GET["op"]){

	

	case 'periodo':
		$data= Array();
		$rsptaperiodo = $cargadocente->periodoactual();
		$periodo_campana=$rsptaperiodo["periodo_campana"];	
        $data["periodo"]=$periodo_campana;

		echo json_encode($data);

	break;

	case 'listar'://listamos los docentes por periodo
		$periodo = $_GET["periodo"];
		$rspta = $cargadocente->listar();
		$data = array();
		$reg = $rspta;

		// tomamos el periodo actual para que filtre por defecto por el periodo actual y si seleccionan un periodo filtre por ese periodo seleccionado.
		$rsptaperiodo = $cargadocente->periodoactual();
		$periodo_actual=$rsptaperiodo["periodo_actual"];
		$periodo_contrato = isset($_GET['periodo']) ? $_GET['periodo'] : $periodo_actual;



		for ($i=0;$i<count($reg);$i++){
			$mis_horas = 0;
			$mis_horas_corte_2 = 0;
			$grupos = $cargadocente->listarGrupos($reg[$i]["id_usuario"],$periodo);
			$total_grupos = count($grupos);
			$usuario_cargo = $cargadocente->MostrarCargoDocentes($reg[$i]["usuario_identificacion"],$periodo_contrato);
			if ($usuario_cargo) {
				$ultimo_contrato = $usuario_cargo['tipo_contrato'];
			} else {
				$ultimo_contrato = ''; 
			}
			for ($j=0;$j<count($grupos);$j++){
				$diaclase=$grupos[$j]["dia"];
				$diferencia=$grupos[$j]["diferencia"];
				$corte=$grupos[$j]["corte"];
				if($corte==1){
					$mis_horas=$mis_horas + $diferencia;
				}else{
					$mis_horas_corte_2=$mis_horas_corte_2+$diferencia;
				}
			}
			$data[]=array(
				"0"=>"<img src='../files/docentes/".$reg[$i]["usuario_identificacion"].".jpg' height='38px' width='38px' class='rounded-circle'>",
				"1"=>$reg[$i]["usuario_identificacion"],
				"2"=>$reg[$i]["usuario_nombre"] . " " . $reg[$i]["usuario_nombre_2"] . " " . $reg[$i]["usuario_apellido"] . " " . $reg[$i]["usuario_apellido_2"] ,
				"3"=>'<div class="tooltips">'.$reg[$i]["usuario_celular"].'<span class="tooltiptext">'.$reg[$i]["usuario_telefono"].' ' .$reg[$i]["usuario_celular"].'</span></div>',
				"4"=>'<div class="tooltips">'.$reg[$i]["usuario_email_p"].'<span class="tooltiptext">'.$reg[$i]["usuario_email_p"].' ' .$reg[$i]["usuario_email_ciaf"].'</span></div>',
				"5"=>$ultimo_contrato,
				"6"=>'<a class="btn btn-success btn-xs" onclick=modalHorario('.$reg[$i]["id_usuario"].',"'.$periodo.'")>'. $total_grupos ."</a>",
				"7"=>'<div class="tooltips badge badge-secondary">'.$mis_horas . '<span class="tooltiptext">Horas semestre</span></div>
					| <div class="tooltips badge badge-primary">' . $mis_horas_corte_2 . '<span class="tooltiptext">Horas segundo bloque</span></div>',

				"8"=>'<div class="text-center"> 
					<button class="btn btn-primary btn-xs" onclick="modalaconvenir('.$reg[$i]["id_usuario"].')" title="Agregar"><i class="fas fa-plus"></i></button></div>'
			);
		}

		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
			"aaData"=>$data
		);

		echo json_encode($results);
	break;

	case 'iniciarcalendario':

		$id_docente=$_GET["id_docente"];
		$periodo=$_GET["periodo"];


		$impresion="";

		$traerhorario=$cargadocente->TraerHorariocalendario($id_docente,$periodo);
		
		$impresion .='[';

		for ($i=0;$i<count($traerhorario);$i++){
			$id_materia=$traerhorario[$i]["id_materia"];
			$diasemana=$traerhorario[$i]["dia"];
			$horainicio=$traerhorario[$i]["hora"];
			$horafinal=$traerhorario[$i]["hasta"];
			$salon=$traerhorario[$i]["salon"];
			$corte=$traerhorario[$i]["corte"];
			$id_usuario_doc=$traerhorario[$i]["id_docente"];

			$datosmateria=$cargadocente->BuscarDatosAsignatura($id_materia);
			$nombre_materia=$datosmateria["nombre"];

			if($id_usuario_doc==null){
				$nombre_docente="Sin Asignar";
			}else{
				$datosdocente=$cargadocente->datosDocente($id_usuario_doc);
				$nombre_docente=$datosdocente["usuario_nombre"] . ' ' . $datosdocente["usuario_apellido"];
			}
			
			//$nombre_docente=$id_docente;


			switch($diasemana){
				case 'Lunes':
					$dia=1;
				break;
				case 'Martes':
					$dia=2;
				break;
				case 'Miercoles':
					$dia=3;
				break;
				case 'Jueves':
					$dia=4;
				break;
				case 'Viernes':
					$dia=5;
				break;
				case 'Sabado':
					$dia=6;
				break;
				case 'Domingo':
					$dia = 0;
				break;
			}

			if($corte=="1"){
				$color="#fff";
			}else{
				$color="#252e53";
			}


			$impresion .= '{"title":"'.$nombre_materia.' - Salón '.$salon.' - doc: '.$nombre_docente.' ","daysOfWeek":"'.$dia.'","startTime":"'.$horainicio.'","endTime":"'.$horafinal.'","color":"'.$color.'"}';
			if($i+1<count($traerhorario)){
				$impresion .=',';
			}
		}

		
		
		$impresion .=']';

		echo $impresion;

	break;

	case "selectPeriodo":	
		$rspta = $cargadocente->selectPeriodo();
		echo "<option value=''>Seleccionar</option>";
		for ($i=0;$i<count($rspta);$i++){
			echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
		}
	break;

	//listar los nombres de meta por usuario
	case 'horasConvenir':
		
		$hora_a_convenir = $cargadocente->mostrarhorasaconvenir($id_usuario);
		
		$data[0] = "";
		for ($f = 0; $f < count($hora_a_convenir) ; $f++) {

			$escuela=$hora_a_convenir[$f]["escuela"];
			$observacion=$hora_a_convenir[$f]["observacion"];
			$data[0] .='
			
			<form name="escuela" id="escuela" method="POST">
			<div>
				<table class="table table-bordered table-responsive-md">
                <tbody> 
                    <tr>
						<td> <label for="nombre">Nombre</label></td>
                        <td><input type="text" name="escuela" id="escuela" value="'.$escuela.'" class="form-control" required="" placeholder="Nombre"></td>
                    </tr>

					<tr>
                        <td> <label for="nombre">Observaciones</label></td>
                        <td><input type="text" name="observacion" id="observacion" value="'.$observacion.'" class="form-control" required="" placeholder="Observaciones"></td> 
                    </tr>
				</tbody>';
		}	

		echo json_encode($data);
	break;
	//guardo el nombre del proyecto
	case 'guardaryeditarproyecto':

		if (empty($id_proyecto)){
			$inserto_convenir = $cargadocente->insertarconvenir($id_convenir, $id_usuario, $escuela, $observacion);
			echo $inserto_convenir ? "Registrado" : "No se pudo registrar";

		}else{
			$rspta = $cargadocente->editarconvenir($id_convenir, $id_usuario, $escuela, $observacion);
			echo $rspta ? "Actualiada" : "No se pudo actualizar";
		}
	break;

	case 'listarhorario':
		$id_docente = $_POST["id_docente"];
		$periodo = $_POST["periodo"];
		$data = Array();
		$data["0"] = "";
		$semana = array("Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Viernes_FDS_Corte1", "Sabado_FDS_Corte1", "Viernes_FDS_Corte2", "Sabado_FDS_Corte2","Sabado","Sabado_2");
		$data["0"] .= '
				<thead>
					<tr>
						<th>Fila</th>
						<th>Hora</th>
						<th>'.$semana[0].'</th>
						<th>'.$semana[1].'</th>
						<th>'.$semana[2].'</th>
						<th>'.$semana[3].'</th>
						<th>'.$semana[4].'</th>
						<th>'.$semana[5].'</th>
						<th>'.$semana[6].'</th>
						<th>'.$semana[7].'</th>
						<th>'.$semana[8].'</th>
						<th>'.$semana[9].'</th>
						<th>'.$semana[10].'</th>
					</tr>	
				</thead>
				<tbody>';
			$rspta = $cargadocente->listarHorasDia();
			for($i=0;$i<count($rspta);$i++){
			$data["0"] .= '<tr align="center">
						<td>'. $i.'</td>
						<td>'.$rspta[$i]["formato"].'</td>';
			$rsptalunes = $cargadocente->docenteGrupos($id_docente,$periodo,$semana[0]);	
			$data["0"] .= '<td>';	
				for($lunes=0; $lunes<count($rsptalunes); $lunes++){
					$datosprogramalunes = $cargadocente->mostrarDatosPrograma($rsptalunes[$lunes]["id_programa"]);
					if($rspta[$i]["horas"]==$rsptalunes[$lunes]["hora"] or $rspta[$i]["horas"]==$rsptalunes[$lunes]["hasta"]){
						$data["0"] .=$rsptalunes[$lunes]["materia"] . '-'. $rsptalunes[$lunes]["salon"] . ' - Sem: ' . $rsptalunes[$lunes]["semestre"] .'<br>'. $datosprogramalunes["nombre"];
					}
				}
			$data["0"] .= '</td>';
			$rsptamartes = $cargadocente->docenteGrupos($id_docente,$periodo,$semana[1]);	
			$data["0"] .= '<td>';
				for($martes=0;$martes<count($rsptamartes);$martes++){
				$datosprogramamartes = $cargadocente->mostrarDatosPrograma($rsptamartes[$martes]["id_programa"]);						
				if($rspta[$i]["horas"]==$rsptamartes[$martes]["hora"] or $rspta[$i]["horas"]==$rsptamartes[$martes]["hasta"]){
					$data["0"] .=$rsptamartes[$martes]["materia"] . '-'. $rsptamartes[$martes]["salon"] . ' - Sem: ' . $rsptamartes[$martes]["semestre"] .'<br>'. $datosprogramamartes["nombre"];
				}
			}	
			$data["0"] .= '</td>';
			$rsptamiercoles = $cargadocente->docenteGrupos($id_docente,$periodo,$semana[2]);	
			$data["0"] .= '<td>';
			for($miercoles=0;$miercoles<count($rsptamiercoles);$miercoles++){
				$datosprogramamiercoles = $cargadocente->mostrarDatosPrograma($rsptamiercoles[$miercoles]["id_programa"]);
				if($rspta[$i]["horas"]==$rsptamiercoles[$miercoles]["hora"] or $rspta[$i]["horas"]==$rsptamiercoles[$miercoles]["hasta"]){
					$data["0"] .=$rsptamiercoles[$miercoles]["materia"] . '-'. $rsptamiercoles[$miercoles]["salon"] . ' - Sem: ' . $rsptamiercoles[$miercoles]["semestre"] .'<br>'. $datosprogramamiercoles["nombre"];
				}
			}
			$data["0"] .= '</td>';
			$rsptajueves = $cargadocente->docenteGrupos($id_docente,$periodo,$semana[3]);	
			$data["0"] .= '<td>';
			for($jueves=0;$jueves<count($rsptajueves);$jueves++){
				$datosprogramajueves = $cargadocente->mostrarDatosPrograma($rsptajueves[$jueves]["id_programa"]);
				if($rspta[$i]["horas"]==$rsptajueves[$jueves]["hora"] or $rspta[$i]["horas"]==$rsptajueves[$jueves]["hasta"]){
					$data["0"] .=$rsptajueves[$jueves]["materia"] . '-'. $rsptajueves[$jueves]["salon"] . ' - Sem: ' . $rsptajueves[$jueves]["semestre"] .'<br>'. $datosprogramajueves["nombre"];
				}
			}
			$data["0"] .= '</td>';
			$rsptaviernes = $cargadocente->docenteGrupos($id_docente,$periodo,$semana[4]);	
			$data["0"] .= '<td>';
			for($viernes=0;$viernes<count($rsptaviernes);$viernes++){
				$datosprogramaviernes = $cargadocente->mostrarDatosPrograma($rsptaviernes[$viernes]["id_programa"]);
				if($rspta[$i]["horas"]==$rsptaviernes[$viernes]["hora"] or $rspta[$i]["horas"]==$rsptaviernes[$viernes]["hasta"]){
					$data["0"] .=$rsptaviernes[$viernes]["materia"] . '-'. $rsptaviernes[$viernes]["salon"] . ' - Sem: ' . $rsptaviernes[$viernes]["semestre"] .'<br>'. $datosprogramaviernes["nombre"];
				}
			}
			$data["0"] .= '</td>';
			$rsptaviernesfds1 = $cargadocente->docenteGrupos($id_docente,$periodo,$semana[5]);	
				$data["0"] .= '<td>';
				for($viernesfds1=0;$viernesfds1<count($rsptaviernesfds1);$viernesfds1++){
					$datosprogramafds1 = $cargadocente->mostrarDatosPrograma($rsptaviernesfds1[$viernesfds1]["id_programa"]);
					
					if($rspta[$i]["horas"]==$rsptaviernesfds1[$viernesfds1]["hora"] or $rspta[$i]["horas"]==$rsptaviernesfds1[$viernesfds1]["hasta"]){
						$data["0"] .=$rsptaviernesfds1[$viernesfds1]["materia"] . '-'. $rsptaviernesfds1[$viernesfds1]["salon"] . ' - Sem: ' . $rsptaviernesfds1[$viernesfds1]["semestre"] .'<br>'. $datosprogramafds1["nombre"];
					
					}
				}
				
				$data["0"] .= '</td>';
				
			$rsptasabadosfds1 = $cargadocente->docenteGrupos($id_docente,$periodo,$semana[6]);	
				$data["0"] .= '<td>';
				for($sabadosfds1=0;$sabadosfds1<count($rsptasabadosfds1);$sabadosfds1++){
					$datosprogramasfds1 = $cargadocente->mostrarDatosPrograma($rsptasabadosfds1[$sabadosfds1]["id_programa"]);				
					if($rspta[$i]["horas"]==$rsptasabadosfds1[$sabadosfds1]["hora"] or $rspta[$i]["horas"]==$rsptasabadosfds1[$sabadosfds1]["hasta"]){
						$data["0"] .=$rsptasabadosfds1[$sabadosfds1]["materia"] . '-'. $rsptasabadosfds1[$sabadosfds1]["salon"] . ' - Sem: ' . $rsptasabadosfds1[$sabadosfds1]["semestre"] .'<br>'. $datosprogramasfds1["nombre"];
					
					}
				}
				
				$data["0"] .= '</td>';
				
			$rsptaviernesfds2 = $cargadocente->docenteGrupos($id_docente,$periodo,$semana[7]);	
				$data["0"] .= '<td>';
				for($viernesfds2=0;$viernesfds2<count($rsptaviernesfds2);$viernesfds2++){
					$datosprogramafds2 = $cargadocente->mostrarDatosPrograma($rsptaviernesfds2[$viernesfds2]["id_programa"]);
					
					if($rspta[$i]["horas"]==$rsptaviernesfds1[$viernesfds1]["hora"] or $rspta[$i]["horas"]==$rsptaviernesfds2[$viernesfds2]["hasta"]){
						$data["0"] .=$rsptaviernesfds2[$viernesfds2]["materia"] . '-'. $rsptaviernesfds2[$viernesfds2]["salon"] . ' - Sem: ' . $rsptaviernesfds2[$viernesfds2]["semestre"] .'<br>'. $datosprogramafds2["nombre"];
					
					}
				}
				
				$data["0"] .= '</td>';
				
			$rsptasabadosfds2 = $cargadocente->docenteGrupos($id_docente,$periodo,$semana[8]);	
				$data["0"] .= '<td>';
				for($sabadosfds2=0;$sabadosfds2<count($rsptasabadosfds2);$sabadosfds2++){
					$datosprogramasfds2 = $cargadocente->mostrarDatosPrograma($rsptasabadosfds2[$sabadosfds2]["id_programa"]);
					
					if($rspta[$i]["horas"]==$rsptasabadosfds2[$sabadosfds2]["hora"] or $rspta[$i]["horas"]==$rsptasabadosfds2[$sabadosfds2]["hasta"]){
						$data["0"] .=$rsptasabadosfds2[$sabadosfds2]["materia"] . '-'. $rsptasabadosfds2[$sabadosfds2]["salon"] . ' - Sem: ' . $rsptasabadosfds2[$sabadosfds2]["semestre"] .'<br>'. $datosprogramasfds2["nombre"];
					
					}
				}	
				
				$data["0"] .= '</td>';

			$rsptasabados = $cargadocente->docenteGrupos($id_docente,$periodo,$semana[9]);	
				$data["0"] .= '<td>';
				for($sabados=0;$sabados<count($rsptasabados);$sabados++){
					$datosprogramas = $cargadocente->mostrarDatosPrograma($rsptasabados[$sabados]["id_programa"]);
					
					if($rspta[$i]["horas"]==$rsptasabados[$sabados]["hora"] or $rspta[$i]["horas"]==$rsptasabados[$sabados]["hasta"]){
						$data["0"] .=$rsptasabados[$sabados]["materia"] . '-'. $rsptasabados[$sabados]["salon"] . ' - Sem: ' . $rsptasabados[$sabados]["semestre"] .'<br>'. $datosprogramas["nombre"];
					
					}
				}	
				$data["0"] .= '</td>';	
			$rsptasabados_2 = $cargadocente->docenteGrupos($id_docente,$periodo,$semana[10]);	
				$data["0"] .= '<td>';
				for($sabados_2=0;$sabados_2<count($rsptasabados_2);$sabados_2++){
					$datosprogramas_2 = $cargadocente->mostrarDatosPrograma($rsptasabados_2[$sabados_2]["id_programa"]);
					if($rspta[$i]["horas"]==$rsptasabados_2[$sabados_2]["hora"] or $rspta[$i]["horas"]==$rsptasabados_2[$sabados_2]["hasta"]){
						$data["0"] .=$rsptasabados_2[$sabados_2]["materia"] . '-'. $rsptasabados_2[$sabados_2]["salon"] . ' - Sem: ' . $rsptasabados_2[$sabados_2]["semestre"] .'<br>'. $datosprogramas_2["nombre"];
					}
				}	
				$data["0"] .= '</td>';			
			$data["0"] .= '
					</tr>';
			}
			$data["0"] .= '</tbody>';
		$docentedatos = $cargadocente->mostrarDatosDocente($id_docente);
		$data["1"] = $docentedatos["usuario_nombre"] . ' '. $docentedatos["usuario_nombre_2"] . ' '. $docentedatos["usuario_apellido"] . ' '. $docentedatos["usuario_apellido_2"];
		$results = array($data);
		echo json_encode($results);
	break;
}