<?php 
session_start();
require_once "../modelos/ConsultaTotalEscuelas.php";

date_default_timezone_set("America/Bogota");	

$fecha=date('Y-m-d');
$hora=date('H:i:S');

$consultatotalescuelas=new ConsultaTotalEscuelas();

$periodo_actual=$_SESSION['periodo_actual'];


switch ($_GET["op"]){

	case 'listar':
		$data= Array();//Vamos a declarar un array
		$data["0"] ="";//iniciamos el arreglo	
		$titulo="";

		$listarescuelas=$consultatotalescuelas->listarescuelas();
		for($c=0;$c<count($listarescuelas);$c++){

			$registros=0;
			$registrosnuevos=0;
			$registrosnuevoshomologado=0;
			$registrosinternos=0;
			$registrosrematricula=0;

			$id_escuelas=$listarescuelas[$c]["id_escuelas"];
			$nombre_escuela=$listarescuelas[$c]["escuelas"];
			$color_ingles=$listarescuelas[$c]["color_ingles"];


			$data["0"] .="<div class='col-12 card'>";
				$data["0"] .="<div class='row'>";

				$data["0"] .='

					<div class="col-xl-12 col-lg-12 col-md-12 col-12 px-4 pb-4 pt-3 tono-3">
						<div class="row align-items-center pt-2">
							<div class="col-xl-auto col-lg-auto col-md-auto col-2">
									<span class="rounded bg-light-'.$color_ingles.' p-3 text-'.$color_ingles.' ">
									<i class="fa-solid fa-headset" aria-hidden="true"></i>
									</span> 
							</div>
							<div class="col-xl-10 col-lg-10 col-md-10 col-10">
								
									<span class="fs-14 line-height-18">Escuela</span> <br>
									<span class="text-semibold fs-16 titulo-2 line-height-16" id="dato_periodo">'.$nombre_escuela.' </span> 
								
							</div>
						</div>
					</div>';
					

					$consulta1=$consultatotalescuelas->listarelprogramas($id_escuelas);
					for ($d=0;$d<count($consulta1);$d++){
						$data["0"] .="<div class='borde col-xl-4 px-4 pt-4 pb-2'>";

							$programa=$consulta1[$d]["nombre"];
							$id_programa=$consulta1[$d]["id_programa"];

							$consulta2=$consultatotalescuelas->listarestudiantes($id_programa);// trae todos los estudiantes
							$consulta3=$consultatotalescuelas->listarestudiantesnuevos($id_programa);// trae todos los estudiantes nuevos
							$consulta4=$consultatotalescuelas->listarestudiantesnuevoshomologados($id_programa);// trae todos los estudiantes nuevos homologados
							$consulta5=$consultatotalescuelas->listarestudiantesinternos($id_programa);// trae todos los estudiantes nuevos homologados
							$consulta6=$consultatotalescuelas->listarestudiantesrematricula($id_programa);// trae todos los estudiantes rematriculados

							$registros= $registros+count($consulta2);//total
							$registrosnuevos= $registrosnuevos+count($consulta3);//nuevos
							$registrosnuevoshomologado= $registrosnuevoshomologado+count($consulta4);//nuevos homologados
							$registrosinternos= $registrosinternos+count($consulta5);// internos
							$registrosrematricula= $registrosrematricula+count($consulta6);// rematriculas


							
							$data["0"] .='
							<div class="row">
								<div class="col-12">
									<h3 class="titulo-2 fs-14 line-height-16"><b>'.$programa.'</b></h3>
								</div>

								<div class=" p-0">
									<table class="table-sm">
										<thead>
											<tr class="fs-12">
												<td>Nuevos</td>
												<td title="Homologados">Homol.</td>
												<td>Internos</td>
												<td title="Rematricula">Remat.</td>
												<td style="width: 40px">Total</td>
											</tr>
										</thead>
										<tbody class="text-center">
											<tr>
												<td>'. count($consulta3) .'</td>
												<td>'. count($consulta4) .'</td>
												<td>'. count($consulta5) .'</td>
												<td>'. count($consulta6) .'</td>
												<td><span class="badge bg-primary">'. count($consulta2) .'</span></td>
											</tr>
									
										</tbody>
									</table>
								</div>
							</div>';

						$data["0"] .="</div>";
					}

					$data["0"] .="<div class='col-xl-12 mt-4'>";

							$data["0"] .='
							<div class="row">
								<div class="col-2 tono-3">
									<h3 class="fs-14 pt-3"><b>Total estudiantes escuela</b></h3>
								</div>

								<div class="col-12 tono-3 pb-3" >
									<table class="table-sm col-12" style="width:100%">
										<thead>
											<tr class="fs-14">
												<th>Nuevos</th>
												<th>Homologados</th>
												<th>Internos</th>
												<th>Rematricula</th>
												<th style="width: 50px">Total</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>'. $registrosnuevos .'</td>
												<td>'. $registrosnuevoshomologado .'</td>
												<td>'. $registrosinternos .'</td>
												<td>'. $registrosrematricula .'</td>
												<td><span class="badge bg-success">'. $registros .'</span></td>
											</tr>
									
										</tbody>
									</table>
								</div>
							</div>';

					$data["0"] .="</div>";

				$data["0"] .="</div>";

			$data["0"] .="</div>";


		}

		


		/* ******* en esta parte comienza la ventana flotante *************************** */
		
		
		$consultatotalgeneral=0;
		$consultatotalgeneralnuevos=0;
		$consultatotalgeneralnuevoshomologados=0;
		$consultatotalgeneralinternos=0;
		$consultatotalgeneralrematricula=0;

		$listarescuelas2=$consultatotalescuelas->listarescuelas();
		for($a=0;$a<count($listarescuelas2);$a++){
			$id_escuelas_2=$listarescuelas2[$a]["id_escuelas"];

			$consultaparatotal=$consultatotalescuelas->listarelprogramas($id_escuelas_2);

			for ($b=0;$b<count($consultaparatotal);$b++){

				$id_programa=$consultaparatotal[$b]["id_programa"];

				$consultatotal=$consultatotalescuelas->listartotal($id_programa);
				$consultatotalnuevos=$consultatotalescuelas->listarestudiantesnuevos($id_programa);
				$consultatotalnuevoshomologados=$consultatotalescuelas->listarestudiantesnuevoshomologados($id_programa);
				$consultatotalinternos=$consultatotalescuelas->listarestudiantesinternos($id_programa);
				$consultatotalrematricula=$consultatotalescuelas->listarestudiantesrematricula($id_programa);


				$consultatotalgeneral = $consultatotalgeneral+count($consultatotal);//total
				$consultatotalgeneralnuevos = $consultatotalgeneralnuevos+count($consultatotalnuevos);//total
				$consultatotalgeneralnuevoshomologados = $consultatotalgeneralnuevoshomologados+count($consultatotalnuevoshomologados);//total
				$consultatotalgeneralinternos = $consultatotalgeneralinternos+count($consultatotalinternos);//total
				$consultatotalgeneralrematricula = $consultatotalgeneralrematricula+count($consultatotalrematricula);//total
				
				
			}	


		}


			
				
		// ************************************* //	
		
	

		$data["0"] .='
			<div class="row" style="position:fixed; bottom:0px; right:0px; z-index:1; width:auto">';
		$data["0"] .='
					<div class="tono-1">
						<div class="card-body p-0">
							<table class="table table-sm">
								<thead>
									<tr>
										<th>Nuevos</th>
										<th>Homologados</th>
										<th>Internos</th>
										<th>Rematricula</th>
										<th style="width: 40px">Total</th>
									</tr>
								</thead>
								<tbody>
									<tr class="text-center">
										<td>'. $consultatotalgeneralnuevos .'</td>
										<td>'. $consultatotalgeneralnuevoshomologados .'</td>
										<td>'. $consultatotalgeneralinternos .'</td>
										<td>'. $consultatotalgeneralrematricula .'</td>
										<td><span class="badge bg-success">'. $consultatotalgeneral .'</span></td>
									</tr>
							
								</tbody>
							</table>
						</div>
					</div>';
						
			$data["0"] .='	</div>';
		
  
        

		$results = array($data);
		echo json_encode($results);
	break;

	case 'configurar':

		$rspta=$consultatotalescuelas->totalprogramas();
		
 		//Vamos a declarar un array
 		$data= Array();
		$reg=$rspta;
		
	
 		for ($i=0;$i<count($reg);$i++){

			$nombre=$reg[$i]["nombre"];
			$estado=$reg[$i]["estado_total_escuelas"];
			$id_programa=$reg[$i]["id_programa"];

			$boton="";
			if($estado==1){
				$boton="<a onclick='cambioestado($id_programa,0)' class='btn btn-success btn-xs'>Activado</a>";
			}else{
				$boton="<a onclick='cambioestado($id_programa,1)' class='btn btn-danger btn-xs'>Bloqueado</a>";
			}

			// $datoscredencialestudiante=$consultatotalescuelas->datoscredencialestudiante($id_credencial);
			
 			$data[]=array(
				"0"=>$nombre,
 				"1"=>$boton,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;	
	case 'cambioestado':
		$data= Array();//Vamos a declarar un array
		$data["0"] ="";//iniciamos el arreglo
		
		$id_programa=$_POST["id_programa"];
		$estado=$_POST["estado"];

		$rspta = $consultatotalescuelas->cambioestado($id_programa,$estado);

		if ($rspta == 0) {
			$data["0"] = "1";
		} else {

			$data["0"] = "0";
		}

		echo json_encode($data);

		break;

}

?>
