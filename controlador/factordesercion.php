<?php 
require_once "../modelos/FactorDesercion.php";
$factordesercion = new FactorDesercion();

date_default_timezone_set("America/Bogota");	
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$mes_actual=date('Y-m')."-00";

$rsptaperiodo = $factordesercion->periodoactual();
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
		$rspta = $factordesercion->selectPeriodo();
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

		$rspta = $factordesercion->selectPrograma($escuela_enviar,$nivel_enviar);
			for ($i=0;$i<count($rspta);$i++){
				echo "<option value='" . $rspta[$i]["id_programa"] . "'>" . $rspta[$i]["nombre"] . "</option>";
			}
	break;

	case "selectJornada":	
		$rspta = $factordesercion->selectJornada();
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
		

		$datos=$factordesercion->total($periodo,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// consulta periodo consultado

		$dato_id_periodo=$factordesercion->selectPeriodoid($periodo);// consulta que trae el id del periodo consultado
		$id_periodo=$dato_id_periodo["id_periodo"]-1;
		$id_periodo_atras=$dato_id_periodo["id_periodo"]-2;//este es para traer dos periodos atras

		$buscarperiodoacterior=$factordesercion->periodoanterior($id_periodo);//buscar el periodo anterior por id;
		$periodoantes=$buscarperiodoacterior["periodo"];

		$dosperiodosatras=$factordesercion->periodoanterior($id_periodo_atras);//buscar el periodo anterior dos periodos atras por id;
		$dosperiodoantes=$dosperiodosatras["periodo"];

		$datosanterior=$factordesercion->total($periodoantes,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// consulta periodo anterior

		$datosprofesionales=$factordesercion->soloprofesionales($periodo,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// consulta periodo actual;
		$datosprofesionalesanterior=$factordesercion->soloprofesionales($periodoantes,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// consulta periodo anterior;

		$datoslaborales=$factordesercion->sololaborales($periodo,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// consulta periodo actual;
		$datoslaboralesanterior=$factordesercion->sololaborales($periodoantes,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// consulta periodo anterior;

		$terminaronnivel=$factordesercion->terminaronnivel($periodo,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// consulta periodo actual;
		$terminaronnivelanterior=$factordesercion->terminaronnivel($periodoantes,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// consulta periodo anterior;

		$terminaronterminal=$factordesercion->terminaronterminal($periodo,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// consulta periodo actual;
		$terminaronterminalanterior=$factordesercion->terminaronterminal($periodoantes,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// consulta periodo anterior;

		$norenovo=$factordesercion->norenovo($periodo,$periodoantes,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// los que no renovaron que debian renovar;
		//$norenovoanterior=$factordesercion->norenovo($periodoantes,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// consulta periodo anterior;

		$norenovohomo=$factordesercion->norenovohomo($periodo,$periodoantes,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// los que no renovaron que debian renovar;
		$sirenovaronhomo=$factordesercion->sirenovohomo($periodo,$periodoantes,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);
		$datoshomoanterior=$factordesercion->homologados($periodoantes,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// consulta periodo anterior;

		$norenovointerno=$factordesercion->norenovointerno($periodo,$periodoantes,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);
		$sirenointerno=$factordesercion->sirenovointerno($periodo,$periodoantes,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);
		$datosinternoanterior=$factordesercion->internos($periodoantes,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// consulta periodo anterior;
		
		$norenovorema=$factordesercion->norenovorema($periodo,$periodoantes,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);
		$sirenovorema=$factordesercion->sirenovorema($periodo,$periodoantes,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);
		$datosrematriculaanterior=$factordesercion->rematricula($periodoantes,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// consulta periodo anterior;

		$norenovonuevo=$factordesercion->norenovonuevo($periodo,$periodoantes,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);
		$sirenovonuevo=$factordesercion->sirenovonuevo($periodo,$periodoantes,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);

		$sirenovaron=$factordesercion->sirenovo($periodo,$periodoantes,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);

		
	
		// $datosdebenrenovar=$factordesercion->debenrenovar($periodo,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// consulta periodo actual;
		$datosdebenrenovaranterior=$factordesercion->debenrenovar($periodoantes,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// consulta periodo anterior;
		//$datosdebenrenovardosp=$factordesercion->debenrenovar($dosperiodoantes,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// los que deben renovar dos periodos antes

		//$datosnuevos=$factordesercion->nuevos($periodo,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// consulta periodo actual;
		$datosnuevosanterior=$factordesercion->nuevos($periodoantes,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// consulta periodo anterior;
		
		//$datoshomo=$factordesercion->homologados($periodo,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// consulta periodo actual;
		
		
		//$datosinterno=$factordesercion->internos($periodo,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// consulta periodo actual;
		
		
		//$datosrematricula=$factordesercion->rematricula($periodo,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// consulta periodo actual;
		
		
		$jornadarisaralda= "AND jornada_e IN ('R01')";
		$datosrisaralda=$factordesercion->porconvenios($periodo,$escuela_enviar,$nivel_enviar,$jornadarisaralda,$semestre_enviar,$programa_enviar);// activos convenios;
		$datosrisaraldaanterior=$factordesercion->porconvenios($periodoantes,$escuela_enviar,$nivel_enviar,$jornadarisaralda,$semestre_enviar,$programa_enviar);// activos convenios;

		$jornadasumale= "AND jornada_e IN ('A04', 'A03')";
		$datossumale=$factordesercion->porconvenios($periodo,$escuela_enviar,$nivel_enviar,$jornadasumale,$semestre_enviar,$programa_enviar);// activos convenios;
		$datossumaleanterior=$factordesercion->porconvenios($periodoantes,$escuela_enviar,$nivel_enviar,$jornadasumale,$semestre_enviar,$programa_enviar);// activos convenios;
		
		$jornadalau= "AND jornada_e IN ('A06','A06-1','A06-2','A06-3','DDAS')";
		$datoslau=$factordesercion->porconvenios($periodo,$escuela_enviar,$nivel_enviar,$jornadalau,$semestre_enviar,$programa_enviar);// activos convenios;
		$datoslauanterior=$factordesercion->porconvenios($periodoantes,$escuela_enviar,$nivel_enviar,$jornadalau,$semestre_enviar,$programa_enviar);// activos convenios;
		

		$jornadalaucuba= "AND jornada_e IN ('CAP')";
		$datoslaucuba=$factordesercion->porconvenios($periodo,$escuela_enviar,$nivel_enviar,$jornadalaucuba,$semestre_enviar,$programa_enviar);// activos convenios;
		$datoslaucubaanterior=$factordesercion->porconvenios($periodoantes,$escuela_enviar,$nivel_enviar,$jornadalaucuba,$semestre_enviar,$programa_enviar);// activos convenios;
		
		
		$jornadadirectos= "AND jornada_e IN ('D01','N01','F01','S01')";
		$datosdirectos=$factordesercion->porconvenios($periodo,$escuela_enviar,$nivel_enviar,$jornadadirectos,$semestre_enviar,$programa_enviar);// activos convenios;
		$datosdirectosanterior=$factordesercion->porconvenios($periodoantes,$escuela_enviar,$nivel_enviar,$jornadadirectos,$semestre_enviar,$programa_enviar);// activos convenios;
		
		
		if (count($datosanterior) != 0) {
			if (count($datosanterior) > 0) {
				$porcentajenuevos = ((count($datos) - count($datosanterior)) / count($datosanterior)) * 100;
			} else {
				$porcentajenuevos = 0; // O cualquier valor predeterminado
			}
			$porcentajenuevosf=round($porcentajenuevos, 2);
		}else{
			$porcentajenuevos=0;
			$porcentajenuevosf=0;
		}
			
			if($porcentajenuevos < 0) {
				$flecha="<img src='../public/img/bajo.webp' width='20px'>";
				$texto="text-danger";
			}else{
				$flecha="<img src='../public/img/aumento.webp' width='20px'>";
				$texto="text-success";
			}
		/* *************************** ***** ****************/

		


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
								<span class="fs-14 line-height-18">Comportamiento</span> <br>
								<span class="text-semibold fs-16 titulo-2 line-height-16">Deserción '. $periodo .'</span> 
							</div>
						</div>
					</div>
					<div class="col-12 tono-1 ">
						<div class="row">
							<div class="col-xl-2  text-center" title="Cambio de nivel">
							<span class="text-secondary small">Nuevos</span>
								<h5>'.count($norenovonuevo)+count($sirenovonuevo).'</h5>
								<span class="text-secondary small">Por renovar</span>
								<h5>'.count($norenovonuevo).'</h5>
								<span class="text-secondary small">Renovo</span>
								<h5>'.count($sirenovonuevo).'</h5>
							</div>

							<div class="col-xl-2  text-center" title="No renovo homologados">
							<span class="text-secondary small">homologados</span>
								<h5>'.count($norenovohomo)+count($sirenovaronhomo).'</h5>
								<span class="text-secondary small">Por renovar</span>
								<h5>'.count($norenovohomo).'</h5>
								<span class="text-secondary small">Renovo</span>
								<h5>'.count($sirenovaronhomo).'</h5>

							</div>

							<div class="col-xl-2  text-center" title="No renovo homologados">
								<span class="text-secondary small">Internos</span>
								<h5>'.count($norenovointerno)+count($sirenointerno).'</h5>
								<span class="text-secondary small">Por renovar</span>
								<h5>'.count($norenovointerno).'</h5>
								<span class="text-secondary small">Renovo</span>
								<h5>'.count($sirenointerno).'</h5>

							</div>

							<div class="col-xl-2  text-center" title="No renovo homologados">
							<span class="text-secondary small">Rematricula</span>
								<h5>'.count($norenovorema)+count($sirenovorema).'</h5>
								<span class="text-secondary small">Por renovar</span>
								<h5>'.count($norenovorema).'</h5>
								<span class="text-secondary small">Renovo</span>
								<h5>'.count($sirenovorema).'</h5>

							</div>

							<div class="col-xl-2  text-center" title="De los '.count($datosdebenrenovaranterior).' que deden renovar, no renovaron '.count($norenovo).'">
								<span class="text-secondary small">Meta</span>
								<h5 class="text-success">'.count($datosdebenrenovaranterior).'</h5>
								<span class="text-secondary small">Por renovar</span>
								<h5>'.count($norenovo).'</h5>
								<span class="text-secondary small">Renovación</span>
								<h5>'.count($sirenovaron).'</h5>
							</div>

							<div class="col-xl-2 text-center bg-light-red align-items-center" 
								title="Deben renovar del periodo anterior '.count($datosdebenrenovaranterior).', los que no renovaron '.count($norenovo).'">
								<div class="row d-flex align-items-center h-100">
									<div class="col-12 ">
										<span class="text-secondary small">Deserción</span>';
											if (count($datosdebenrenovaranterior) > 0) {
												$porcentajeNoRenovo = round((count($norenovo) / count($datosdebenrenovaranterior)) * 100);
											} else {
												$porcentajeNoRenovo = 0;
											}
										$data["dtotal"] .= '<h5>' . $porcentajeNoRenovo . '%</h5>
									</div>
								</div>
							</div>
							<div class="col-12 border-bottom mb-2"></div>

							<div class="col-12 px-0 mx-0">
								<div class="pl-2 py-2">Cumplimiento ';

										if ((count($norenovo)+count($sirenovaron)) > 0) {
											$cumplimiento = round(((count($sirenovaron)/(count($norenovo)+count($sirenovaron)))*100));
										} else {
											$cumplimiento = 0;
										}

										// codigo para el porcentaje de la grafica de cumplimiento

										if ((count($norenovo)+count($sirenovaron)) > 0) {
											$cumplimientograf = ((count($sirenovaron)/(count($norenovo)+count($sirenovaron)))*100);
										} else {
											$cumplimientograf = 0;
										}
									
									$data["dtotal"] .= $cumplimiento . '%
								</div>
								<div class="progress progress-sm">
									<div class="progress-bar bg-primary" style="width: '.$cumplimientograf.'%"></div>
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
								<span class="fs-14 line-height-18">Meta</span> <br>
								<span class="text-semibold fs-16 titulo-2 line-height-16">Así termino el '. $periodoantes .'</span> 
							</div>
						</div>
					</div>
					<div class="col-2 text-center pt-3" title="Estudiantes que terminaron al final del periodo">
						<i class="fa-solid fa-users avatar bg-light-green text-success rounded-circle fa-2x"></i>
						<h3 class="increamentcount mb-0">'.count($datosanterior).'</h3>
						<p class="small text-secondary">Estudiantes Activos</p>
					</div>
					
					<div class="col-2 text-center pt-3" title="Solo el numero de estudiantes de los programas profesionales">
						<i class="fa-solid fa-user-tie avatar bg-light-blue text-blue rounded-circle fa-2x"></i>
						<h3 class="increamentcount mb-0">'.count($datosprofesionalesanterior).'</h3>
						<p class="small text-secondary">Profesionales</p>
					</div>
					<div class="col-2 text-center pt-3" title="Solo el numero de estudiantes formación para el trabajo">
						<i class="fa-solid fa-user-large avatar bg-light-yellow text-yellow rounded-circle fa-2x"></i>
						<h3 class="increamentcount mb-0">'.count($datoslaboralesanterior).'</h3>
						<p class="small text-secondary">Laborales</p>
					</div>
					<div class="col-2 text-center pt-3" title="Egresados, incluyen todos los programas">
						<i class="fa-solid fa-thumbs-up avatar bg-light-yellow text-yellow rounded-circle fa-2x"></i>
						<h3 class="increamentcount mb-0">'.count($terminaronnivelanterior).'</h3>
						<p class="small text-secondary">Terminaron Nivel</p>
					</div>

					<div class="col-2 text-center pt-3" title="Egresados incluye solo terminal y laborales">
						<i class="fa-solid fa-user-graduate avatar bg-light-yellow text-yellow rounded-circle fa-2x"></i>
						<h3 class="increamentcount mb-0">'.count($terminaronterminalanterior).'</h3>
						<p class="small text-secondary">Egresados</p>
					</div>

					<div class="col-2 text-center pt-3" title="Deben renovar">
						<i class="fa-regular fa-eye avatar bg-light-red text-danger rounded-circle fa-2x"></i>
						<h3 class="increamentcount mb-0">'.count($datosdebenrenovaranterior).'</h3>
						<p class="small text-secondary">Meta</p>
					</div>
					<div class="col-12 border-bottom mb-2"></div>
					<div class="col-12">
						<div class="row">
							<div class="col-xl-2 text-center">
								<span class="text-secondary small">Nuevos</span>
								<h5>'.count($datosnuevosanterior).'</h5>
							</div>
							<div class="col-xl-2 text-center">
								<span class="text-secondary small">Homologados</span>
								<h5>'.count($datoshomoanterior).'</h5>
							</div>

							<div class="col-xl-2 text-center" >
								<span class="text-secondary small">Internos</span>
								<h5>'.count($datosinternoanterior).'</h5>
							</div>

							
							<div class="col-xl-2 text-center">
								<span class="text-secondary small">Rematricula</span>
								<h5>'.count($datosrematriculaanterior).'</h5>
							</div>

							<div class="col-xl-4 text-center bg-light-green">
								<span class="text-secondary small">Meta para el '. $periodo .'</span>
								<h5>'.count($datosdebenrenovaranterior).'</h5>
							</div>

						</div>
					</div>

				</div>
			</div>
        ';

		/* formula para calcular los datos por convenio*/

			$data["dtotal"] .='
				<div class="col-xl-6 mt-4">
					
					<div class="row m-1">
						<div class="col-12 tono-3 py-3">
							<div class="row align-items-center pt-2">
								<div class="col-xl-auto col-lg-auto col-md-auto col-2">
									<span class="rounded bg-light-green p-3 text-success ">
										<i class="fa-solid fa-headset" aria-hidden="true"></i>
									</span> 
								</div>
								<div class="col-xl-10 col-lg-10 col-md-10 col-10">
									<span class="fs-14 line-height-18">Comportamiento</span> <br>
									<span class="text-semibold fs-16 titulo-2 line-height-16" id="dato_periodo">Convenios</span> 
								</div>
							</div>
						</div>

						<div class="col-12 tono-2 p-2">
							<div class="row align-items-center">
								<div class="col-1 text-center">
									<i class="fa-solid fa-r p-2 bg-light-green text-success rounded "></i>
								</div>
								<div class="col-6">
									<span class="mb-0">Risaralda profesional</span>
								</div>
								<div class="col-5">
									<div class="row">
										<div class="col-4 text-right"><span class="titulo-2 fs-24">'. count($datosrisaralda) . ' </span></div>

									</div>
								</div>
							</div>
						</div>

						<div class="col-12 tono-2 p-2">
							<div class="row align-items-center">
								<div class="col-1 text-center">
									<i class="fa-solid fa-plus p-2 bg-light-green text-success rounded "></i>
								</div>
								<div class="col-6">
									<span class="mb-0">Sumale</span>
								</div>
								<div class="col-5">
									<div class="row">
										<div class="col-4 text-right"><span class="titulo-2 fs-24">' . count($datossumale). '</span></div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-12 tono-2 p-2">
							<div class="row align-items-center">
								<div class="col-1 text-center">
									<i class="fa-solid fa-u  p-2 bg-light-green text-success rounded "></i>
								</div>
								<div class="col-6">
									<span class="mb-0">La U en tu colegio</span>
								</div>
								<div class="col-5">
									<div class="row">
										<div class="col-4 text-right"><span class="titulo-2 fs-24">'. count($datoslau) . ' </span></div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-12 tono-2 p-2 mb-4">
							<div class="row align-items-center">
								<div class="col-1 text-center">
									<i class="fa-solid fa-c  p-2 bg-light-green text-success rounded "></i>
								</div>
								<div class="col-6">
									<span class="mb-0">La U en cuba</span>
								</div>
								<div class="col-5">
									<div class="row">
										<div class="col-4 text-right"><span class="titulo-2 fs-24">'. count($datoslaucuba) . ' </span></div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-12 tono-3  py-4 mt-2">
							<div class="row align-items-center">
								<div class="col-1 text-center">
									<i class="fa-solid fa-chart-simple p-2 bg-light-blue text-primary rounded "></i>
								</div>
								<div class="col-6">
									<span class="mb-0 fs-24">Directos</span>
								</div>
								<div class="col-5">
									<div class="row">
										<div class="col-4 text-right"><span class="titulo-2 fs-24">'. count($datosdirectos) . '</span></div>
									</div>
								</div>
							</div>
						</div>

					</div>
						
				</div>

				<div class="col-xl-6 mt-4">
					
					<div class="row m-1">
						<div class="col-12 tono-3 py-3">
							<div class="row align-items-center pt-2">
								<div class="col-xl-auto col-lg-auto col-md-auto col-2">
									<span class="rounded bg-light-green p-3 text-success ">
										<i class="fa-solid fa-headset" aria-hidden="true"></i>
									</span> 
								</div>
								<div class="col-xl-10 col-lg-10 col-md-10 col-10">
									<span class="fs-14 line-height-18">Comportamiento</span> <br>
									<span class="text-semibold fs-16 titulo-2 line-height-16" id="dato_periodo">Convenios</span> 
								</div>
							</div>
						</div>

						<div class="col-12 tono-2 p-2">
							<div class="row align-items-center">
								<div class="col-1 text-center">
									<i class="fa-solid fa-r p-2 bg-light-green text-success rounded "></i>
								</div>
								<div class="col-6">
									<span class="mb-0">Risaralda profesional</span>
								</div>
								<div class="col-5">
									<div class="row">
										<div class="col-4 text-right"><span class="titulo-2 fs-24">'. count($datosrisaraldaanterior) . '</span></div>

									</div>
								</div>
							</div>
						</div>

						<div class="col-12 tono-2 p-2">
							<div class="row align-items-center">
								<div class="col-1 text-center">
									<i class="fa-solid fa-plus p-2 bg-light-green text-success rounded "></i>
								</div>
								<div class="col-6">
									<span class="mb-0">Sumale</span>
								</div>
								<div class="col-5">
									<div class="row">
										<div class="col-4 text-right"><span class="titulo-2 fs-24">' . count($datossumaleanterior). '</span></div>

									</div>
								</div>
							</div>
						</div>

						<div class="col-12 tono-2 p-2">
							<div class="row align-items-center">
								<div class="col-1 text-center">
									<i class="fa-solid fa-u  p-2 bg-light-green text-success rounded "></i>
								</div>
								<div class="col-6">
									<span class="mb-0">La U en tu colegio</span>
								</div>
								<div class="col-5">
									<div class="row">
										<div class="col-4 text-right"><span class="titulo-2 fs-24">'. count($datoslauanterior) . '</span></div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-12 tono-2 p-2 mb-4">
							<div class="row align-items-center">
								<div class="col-1 text-center">
									<i class="fa-solid fa-c  p-2 bg-light-green text-success rounded "></i>
								</div>
								<div class="col-6">
									<span class="mb-0">La U en cuba</span>
								</div>
								<div class="col-5">
									<div class="row">
										<div class="col-4 text-right"><span class="titulo-2 fs-24">'. count($datoslaucubaanterior) . ' </span></div>

									</div>
								</div>
							</div>
						</div>

						<div class="col-12 tono-3  py-4 mt-2">
							<div class="row align-items-center">
								<div class="col-1 text-center">
									<i class="fa-solid fa-chart-simple p-2 bg-light-blue text-primary rounded "></i>
								</div>
								<div class="col-6">
									<span class="mb-0 fs-24">Directos</span>
								</div>
								<div class="col-5">
									<div class="row">
										<div class="col-4 text-right"><span class="titulo-2 fs-24">'. count($datosdirectosanterior) . '</span></div>

									</div>
								</div>
							</div>
						</div>

					</div>
						
				</div>

				<div class="col-xl-8 p-4">
					<div class="row tono-2">
						<div class="col-12 tono-3 py-3">
							<div class="row align-items-center pt-2">
								<div class="col-xl-auto col-lg-auto col-md-auto col-2">
									<span class="rounded bg-light-green p-3 text-success ">
										<i class="fa-solid fa-headset" aria-hidden="true"></i>
									</span> 
								</div>
								<div class="col-xl-10 col-lg-10 col-md-10 col-10">
									<span class="fs-14 line-height-18">Comportamiento</span> <br>
									<span class="text-semibold fs-16 titulo-2 line-height-16" id="dato_periodo">Últimos 5 años</span> 
								</div>
							</div>
						</div>
						<div class="col-12 p-2 m-2">
							<div id="chartContainer2" style="height: 300px; max-width: 920px; margin: 0px auto;"></div>
						</div>
					</div>
				</div>
			';

			


			$data["datosuno"] ="";
			$data["datosuno"] .=' [';
			$coma=",";
			$valoranterior=0;
			$valoranterior=0;

			$id_periodo_actual=$dato_id_periodo["id_periodo"]-9;
			$id_periodo_comparado=$dato_id_periodo["id_periodo"]-10;

			for ($i=0;$i<10;$i++){
				$periodo_historico=$factordesercion->periodoanterior($id_periodo_actual);
				$periodo_comparado=$factordesercion->periodoanterior($id_periodo_comparado);

				$datoshistorico=$factordesercion->debenrenovar($periodo_historico["periodo"],$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// consulta periodo anterior;
				$historiconorenovo=$factordesercion->norenovo($periodo_historico["periodo"],$periodo_comparado["periodo"],$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);
				
				$graficar = count($datoshistorico) > 0 ? round((count($historiconorenovo) / count($datoshistorico)) * 100) : 0;



				if($i<10-1){
					$coma=",";
				}else{
					$coma="";
				}

				$valornuevo=$total;

				if($graficar > $valoranterior){
					$ganancia="gain";
					$figura="triangle";
					$color="#6B8E23";
				}else{
					$ganancia="loss";
					$figura="cross";
					$color="tomato";
				}


				$data["datosuno"] .='{ "label": "'.$periodo_historico["periodo"].'", "y": '.$graficar.', "indexLabel": "'.$graficar.'", "markerType": "'.$figura.'",  "markerColor": "'.$color.'" }'.$coma.'';
				
				$id_periodo_actual++;
				$id_periodo_comparado++;
				
				$valoranterior=$graficar;
			}	
	
			$data["datosuno"] .=' ]';

		/* *************************************** */

		echo json_encode($data);

	break;




}

?>