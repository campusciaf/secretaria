<?php 
require_once "../modelos/PanelFinanciero.php";
$consulta = new PanelFinanciero();

date_default_timezone_set("America/Bogota");	
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$mes_actual=date('Y-m')."-00";

$rsptaperiodo = $consulta->periodoactual();
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
		$rspta = $consulta->selectPeriodo();
		echo "<option value='".$periodo_actual."' selected='selected'>".$periodo_actual."</option>";
		for ($i=0;$i<count($rspta);$i++){
		  echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
        }
	break;

    case "selectPrograma":	

		$escuela=$_POST["escuela"];
		if($escuela == 0){
			$escuela_enviar='';
		}else{
			$escuela_enviar='';
			$escuela_laboral='no';
			$escuela_largo=count($escuela);
			$escuela_cumplir='';
			$escuela_tambien='';
			$escuela_cerrar= '';

			$a = 1;

			foreach ($escuela as $es){
				if($a==1){
					$escuela_cumplir='and (';
				}else{
					$escuela_cumplir="";
				}
				if($a<$escuela_largo){
					$escuela_tambien=' or ';
				}else{
					$escuela_tambien='';
				}
				if($a==$escuela_largo){
					$escuela_cerrar= ') ';
				}else{
					$escuela_cerrar= '';
				}
				$escuela_enviar.= $escuela_cumplir .'escuela="'.$es . '"' . $escuela_tambien . $escuela_cerrar;
				$a++;
			}
		}

		$nivel=$_POST["nivel"];
		if($nivel == 0){
			$nivel_enviar='';
		}else{
			$nivel_enviar='';
			$nivel_laboral='no';
			$nivel_largo=count($nivel);
			$nivel_cumplir='';
			$nivel_tambien='';
			$nivel_cerrar= '';

			$b = 1;

			foreach ($nivel as $ni){
				if($b==1){
					$nivel_cumplir='and (';
				}else{
					$nivel_cumplir="";
				}
				if($b<$nivel_largo){
					$nivel_tambien=' or ';
				}else{
					$nivel_tambien='';
				}
				if($b==$nivel_largo){
					$nivel_cerrar= ') ';
				}else{
					$nivel_cerrar= '';
				}
				$nivel_enviar.= $nivel_cumplir .'ciclo="'.$ni . '"' . $nivel_tambien . $nivel_cerrar;
				$b++;
			}
		}

		$rspta = $consulta->selectPrograma($escuela_enviar,$nivel_enviar);
			for ($i=0;$i<count($rspta);$i++){
				echo "<option value='" . $rspta[$i]["id_programa"] . "'>" . $rspta[$i]["nombre"] . "</option>";
			}
	break;

	case "selectJornada":	
		$rspta = $consulta->selectJornada();
		for ($i=0;$i<count($rspta);$i++){
            echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
        }
	break;

	case 'general':


		$data["dtotal"]="";
		
		$periodo=$_POST["periodo"];
		if($periodo==""){
			$periodo=$periodo_actual;
		}

		/* logica para campo escuela*/
			$escuela=$_POST["escuela"];
			$escuela_laboral='inicio';
			if($escuela == 0){
				$escuela_enviar='';
			}else{
				$escuela_enviar='';
				$escuela_laboral='no';
				$escuela_largo=count($escuela);
				$escuela_cumplir='';
				$escuela_tambien='';
				$escuela_cerrar= '';

				$h = 1;

				foreach ($escuela as $es){
					if($h == 1){
						$escuela_cumplir='and (';
					}else{
						$escuela_cumplir="";
					}
					if($h < $escuela_largo){
						$escuela_tambien=' or ';
					}else{
						$escuela_tambien='';
					}
					if($h == $escuela_largo){
						$escuela_cerrar= ') ';
					}else{
						$escuela_cerrar= '';
					}
					$escuela_enviar.= $escuela_cumplir .'escuela='.$es . $escuela_tambien . $escuela_cerrar;

					if($es==7){
						$escuela_laboral="si";
					}
					$h++;
				}
			}
		/* ************************* */

		/* logica para campo nivel*/
			$nivel=$_POST["nivel"];
			$nivel_laboral='inicio';

			if($nivel == 0){
				$nivel_enviar='';
			}else{
				$nivel_enviar='';
				$nivel_laboral='no';
				$nivel_largo=count($nivel);
				$nivel_cumplir='';
				$nivel_tambien='';
				$nivel_cerrar= '';

				$j = 1;

				foreach ($nivel as $e){
					if($j==1){
						$nivel_cumplir='and (';
					}else{
						$nivel_cumplir="";
					}
					if($j<$nivel_largo){
						$nivel_tambien=' or ';
					}else{
						$nivel_tambien='';
					}
					if($j==$nivel_largo){
						$nivel_cerrar= ') ';
					}else{
						$nivel_cerrar= '';
					}
					$nivel_enviar.= $nivel_cumplir .'nivel='.$e . $nivel_tambien . $nivel_cerrar;
					if($e==7){
						$nivel_laboral='si';
					}
					$j++;
				}
			}
		/* ************************* */

		/* logica para campo jornada*/
			$jornada=$_POST["jornada"];
			$jornada_laboral='inicio';
			if($jornada == 0){
				$jornada_enviar='';
			}else{
				$jornada_enviar='';
				$jornada_laboral='no';
				$jornada_largo=count($jornada);
				$jornada_cumplir='';
				$jornada_tambien='';
				$jornada_cerrar= '';
	
				$k = 1;
	
				foreach ($jornada as $ej){
					if($k==1){
						$jornada_cumplir='and (';
					}else{
						$jornada_cumplir="";
					}
					if($k<$jornada_largo){
						$jornada_tambien=' or ';
					}else{
						$jornada_tambien='';
					}
					if($k==$jornada_largo){
						$jornada_cerrar= ') ';
					}else{
						$jornada_cerrar= '';
					}
					$jornada_enviar.= $jornada_cumplir .'jornada_e="'.$ej . '"' . $jornada_tambien . $jornada_cerrar;

					if($ej=="D01" || $ej=="N01" || $ej=="F01" || $ej=="S01" || $ej=="Domingo"){
						$jornada_laboral='si';
					}

					$k++;
				}
			}
		
		/* ************************* */

		/* logica para campo semestre*/
			$semestre=$_POST["semestre"];
			$semestre_laboral='inicio';
			if($semestre == 0){
				$semestre_enviar='';
			}else{
				$semestre_enviar='';
				$semestre_laboral='no';
				$semestre_largo=count($semestre);
				$semestre_cumplir='';
				$semestre_tambien='';
				$semestre_cerrar= '';

				$l = 1;

				foreach ($semestre as $es){
					if($es=="1" || $es=="2" || $es=="3" || $es=="4" || $es=="5"){
						if($l==1){
							$semestre_cumplir='and (';
						}else{
							$semestre_cumplir="";
						}
						if($l<$semestre_largo){
							$semestre_tambien=' or ';
						}else{
							$semestre_tambien='';
						}
						if($l==$semestre_largo){
							$semestre_cerrar= ') ';
						}else{
							$semestre_cerrar= '';
						}

						$semestre_enviar.= $semestre_cumplir .'semestre="'.$es . '"' . $semestre_tambien . $semestre_cerrar;

						if($es=="1" || $es=="2" || $es=="3"){
							$semestre_laboral='si';
						}
					}
					if($es=="11"){
						$semestre_enviar.= 'esotro';
					}

					$l++;
				}
			}
		/* ************************* */
		
		/* logica para campo programa academico*/
			$programa=$_POST["programa"];
			if($programa == 0){
				$programa_enviar='';
			}else{
				$programa_enviar='';
				$programa_largo=count($programa);
				$programa_cumplir='';
				$programa_tambien='';
				$programa_cerrar= '';

				$m = 1;

				foreach ($programa as $pro){

						if($m==1){
							$programa_cumplir='and (';
						}else{
							$programa_cumplir="";
						}
						if($m<$programa_largo){
							$programa_tambien=' or ';
						}else{
							$programa_tambien='';
						}
						if($m==$programa_largo){
							$programa_cerrar= ') ';
						}else{
							$programa_cerrar= '';
						}

						$programa_enviar.= $programa_cumplir .'programa="'.$pro . '"' . $programa_tambien . $programa_cerrar;
		
					$m++;
				}
			}
		/* ************************* */

		$data["periodo"] = $periodo ;
		$data["nivel"] = $nivel ;
		$data["escuela"] = $escuela ;
		$data["jornada"] = $jornada ;
		$data["semestre"] = $semestre ;
		$data["programa"] = $programa ;
		

		

		$dato_id_periodo=$consulta->selectPeriodoid($periodo);// consulta que trae el id del periodo consultado
		$id_periodo=$dato_id_periodo["id_periodo"]-1;
		$id_periodo_atras=$dato_id_periodo["id_periodo"]-2;//este es para traer dos periodos atras

		$buscarperiodoacterior=$consulta->periodoanterior($id_periodo);//buscar el periodo anterior por id;
		$periodoantes=$buscarperiodoacterior["periodo"];

		$dosperiodosatras=$consulta->periodoanterior($id_periodo_atras);//buscar el periodo anterior dos periodos atras por id;
		$dosperiodoantes=$dosperiodosatras["periodo"];

		$datos=$consulta->total($periodo,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// traer datos del periodo consultado
		$datosanterior=$consulta->total($periodoantes,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// consulta periodo anterior
		$datosdosanterior=$consulta->total($dosperiodoantes,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// traer datos dos periodos atras

		$finalizados=$consulta->finalizados($periodo,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// creditos finalizados
		$finalizadosdos=$consulta->finalizados($dosperiodoantes,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// creditos finalizados dos periodos atras


		$activos=$consulta->activos($periodo,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// creditos activos
		$activosaldia=$consulta->activosaldia($periodo,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// creditos activos al dia
		$activosatrazados=$consulta->activosatrasados($periodo,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// creditos activos al dia

		$activosdos=$consulta->activos($dosperiodoantes,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// creditos activos dos periodos atras
		$activosdosaldia=$consulta->activosaldia($dosperiodoantes,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// creditos activos dos antes al dia
		$activosdosatrazados=$consulta->activosatrasados($dosperiodoantes,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// creditos dos antes activos al dia




		if (count($datos) > 0) {
			$aldiaf=count($activosaldia)+count($finalizados);
			$cumplimiento = ($aldiaf / count($datos)) * 100;
		} else {
			$cumplimiento = 0; // O un valor que definas para manejar este caso
		}


		

		if (count($datosdosanterior) > 0) {
			$aldiafdos=count($activosdosaldia)+count($finalizadosdos);
			$cumplimientodos=($aldiafdos/count($datosdosanterior))*100;
		} else {
			$cumplimientodos = 0; // O un valor que definas para manejar este caso
		}



        $data["dtotal"] .= '

			<div class="col-xl-6">			
				<div class="row m-1">
					<div class="col-12 tono-3 py-3">
						<div class="row align-items-center pt-2">
							<div class="col-xl-auto col-lg-auto col-md-auto col-2">
								<span class="rounded bg-light-green p-3 text-success ">
									<i class="fa-solid fa-headset" aria-hidden="true"></i>
								</span> 
							</div>
							<div class="col-xl-10 col-lg-10 col-md-10 col-10">
								<span class="fs-14 line-height-18">Comportamiento '. $periodo .'</span> <br>
								<span class="text-semibold fs-16 titulo-2 line-height-16">Créditos aprobados '.count($datos) .'</span> 
							</div>
						</div>
					</div>
					<div class="col-12 tono-1 ">
						<div class="row">
							<div class="col-xl-4">
								<div class="row">
									<div class="col-xl-8 text-center pt-3" title="Créditos activos">
										<i class="fa-solid fa-users avatar bg-light-blue text-blue rounded-circle fa-2x"></i>
										<h3 class="increamentcount mb-0">'.count($activos).'</h3>
										<p class="small text-secondary">Activos</p>
									</div>
									<div class="col-xl-4 pt-4 text-center" title="Cambio de nivel">
										<div class="row">
											<div class="col-12">
											<span class="text-secondary small">Al día </span>
											<h5>'.count($activosaldia).'</h5>
										</div>
										<div class="col-12">
											<span class="text-secondary small">Atrasado</span>
											<h5>'.count($activosatrazados).'</h5></div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-xl-2 tono-2">
								<div class="row">
									<div class="col-xl-12 text-center pt-3" title="Créditos Finalizados">
										<i class="fa-solid fa-thumbs-up avatar bg-light-green text-success rounded-circle fa-2x"></i>
										<h3 class="increamentcount mb-0">'.count($finalizados).'</h3>
										<p class="small text-secondary">Finalizados</p>
									</div>
								</div>
							</div>

							<div class="col-xl-6 tono-4 align-items-center">
								<div class="row d-flex align-items-center h-100">
									<div class="col-12" title="Créditos al día / créditos activos">
										<span class="text-secondary small">Cumplimiento '.round($cumplimiento).'%</span></h5>
										<div class="progress progress-sm">
											<div class="progress-bar bg-primary" style="width: '.round($cumplimiento).'%"></div>
										</div>
									</div>
	
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>

			<div class="col-xl-6">
				<div class="row tono-2 m-1">

					<div class="col-12 tono-3 py-3">
						<div class="row align-items-center pt-2">
							<div class="col-xl-auto col-lg-auto col-md-auto col-2">
								<span class="rounded bg-light-green p-3 text-success ">
									<i class="fa-solid fa-headset" aria-hidden="true"></i>
								</span> 
							</div>
							<div class="col-xl-10 col-lg-10 col-md-10 col-10">
								<span class="fs-14 line-height-18">Comportamiento '. $dosperiodoantes .'</span> <br>
								<span class="text-semibold fs-16 titulo-2 line-height-16"> Créditos aprobados '. count($datosdosanterior) .'</span> 
							</div>
						</div>
					</div>

					<div class="col-12 tono-1 ">
						<div class="row">
							<div class="col-xl-4">
								<div class="row">
									<div class="col-xl-8 text-center pt-3" title="Créditos activos">
										<i class="fa-solid fa-users avatar bg-light-blue text-blue rounded-circle fa-2x"></i>
										<h3 class="increamentcount mb-0">'.count($activosdos).'</h3>
										<p class="small text-secondary">Activos</p>
									</div>
									<div class="col-xl-4 pt-4 text-center" title="Cambio de nivel">
										<div class="row">
											<div class="col-12">
											<span class="text-secondary small">Al día </span>
											<h5>'.count($activosdosaldia).'</h5>
										</div>
										<div class="col-12">
											<span class="text-secondary small">Atrasado</span>
											<h5>'.count($activosdosatrazados).'</h5></div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-xl-2 tono-2">
								<div class="row">
									<div class="col-xl-12 text-center pt-3" title="Créditos Finalizados">
										<i class="fa-solid fa-thumbs-up avatar bg-light-green text-success rounded-circle fa-2x"></i>
										<h3 class="increamentcount mb-0">'.count($finalizadosdos).'</h3>
										<p class="small text-secondary">Finalizados</p>
									</div>
								</div>
							</div>

							<div class="col-xl-6 tono-4 align-items-center" title="">
								<div class="row d-flex align-items-center h-100">
									<div class="col-12 ">
										<span class="text-secondary small">Cumplimiento '.round($cumplimientodos).'%</span></h5>
										<div class="progress progress-sm">
											<div class="progress-bar bg-primary" style="width: '.round($cumplimientodos).'%"></div>
										</div>
									</div>

								</div>
							</div>

						</div>
					</div>




				</div>
			</div>
        ';



		echo json_encode($data);

	break;




}

?>