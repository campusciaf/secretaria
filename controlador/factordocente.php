<?php 
require_once "../modelos/FactorDocente.php";
$factordocente = new FactorDocente();

date_default_timezone_set("America/Bogota");	
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$mes_actual=date('Y-m')."-00";

$rsptaperiodo = $factordocente->periodoactual();
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
		$rspta = $factordocente->selectPeriodo();
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

		$rspta = $factordocente->selectPrograma($escuela_enviar,$nivel_enviar);
			for ($i=0;$i<count($rspta);$i++){
				echo "<option value='" . $rspta[$i]["id_programa"] . "'>" . $rspta[$i]["nombre"] . "</option>";
			}
	break;

	case "selectJornada":	
		$rspta = $factordocente->selectJornada();
		for ($i=0;$i<count($rspta);$i++){
            echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
        }
	break;

	case "selectNivelFormacion":	
		$rspta = $factordocente->selectNivelFormacion();
		for ($i=0;$i<count($rspta);$i++){
            echo "<option value='" . $rspta[$i]["id_nivel_formacion"] . "'>" . $rspta[$i]["nombre_formacion"] . "</option>";
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

        /* logica para campo contrato*/
			$contrato=$_POST["contrato"];
			if($contrato == 0){
				$contrato_enviar='';
			}else{
				$contrato_enviar='';
				$contrato_largo=count($contrato);
				$contrato_cumplir='';
				$contrato_tambien='';
				$contrato_cerrar= '';

				$c = 1;

				foreach ($contrato as $contra){

						if($c==1){
							$contrato_cumplir='and (';
						}else{
							$contrato_cumplir="";
						}
						if($c<$contrato_largo){
							$contrato_tambien=' or ';
						}else{
							$contrato_tambien='';
						}
						if($c==$contrato_largo){
							$contrato_cerrar= ') ';
						}else{
							$contrato_cerrar= '';
						}

						$contrato_enviar.= $contrato_cumplir .'tipo_contrato="'. $contra . '"' . $contrato_tambien . $contrato_cerrar;
		
					$c++;
				}
			}
		/* ************************* */

		    /* logica para campo contrato*/
			$nivel_formacion=$_POST["nivel_formacion"];
			if($nivel_formacion == 0){
				$nivel_formacion_enviar='';
			}else{
				$nivel_formacion_enviar='';
				$nivel_formacion_largo=count($nivel_formacion);
				$nivel_formacion_cumplir='';
				$nivel_formacion_tambien='';
				$nivel_formacion_cerrar= '';

				$f = 1;

				foreach ($nivel_formacion as $formacion){

						if($f==1){
							$nivel_formacion_cumplir='and (';
						}else{
							$nivel_formacion_cumplir="";
						}
						if($f<$nivel_formacion_largo){
							$nivel_formacion_tambien=' or ';
						}else{
							$nivel_formacion_tambien='';
						}
						if($f==$nivel_formacion_largo){
							$nivel_formacion_cerrar= ') ';
						}else{
							$nivel_formacion_cerrar= '';
						}

						$nivel_formacion_enviar.= $nivel_formacion_cumplir .'nivel_formacion="'. $formacion . '"' . $nivel_formacion_tambien . $nivel_formacion_cerrar;
		
					$f++;
				}
			}
		/* ************************* */


        $data["nivel_formacion"] = $nivel_formacion ;
		$data["periodo"] = $periodo ;
		$data["nivel"] = $nivel ;
		$data["escuela"] = $escuela ;
		$data["jornada"] = $jornada ;
		$data["semestre"] = $semestre ;
		$data["programa"] = $programa ;


		$datos=$factordocente->total($periodo,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar,$contrato_enviar,$nivel_formacion_enviar);// consulta periodo consultado

		$dato_id_periodo=$factordocente->selectPeriodoid($periodo);// consulta que trae el id del periodo consultado
		$id_periodo=$dato_id_periodo["id_periodo"]-1;

		$buscarperiodoacterior=$factordocente->periodoanterior($id_periodo);//buscar el periodo anterior por id;
		$periodoantes=$buscarperiodoacterior["periodo"];

		$datosanterior=$factordocente->total($periodoantes,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar,$contrato_enviar,$nivel_formacion_enviar);// consulta periodo anterior

		/* formula para calcular el porcentaje con respecto al periodo anterior */
		if (count($datosanterior) != 0) {
			$porcentajenuevos=((count($datos)-count($datosanterior))/count($datosanterior))*100;
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
			<div class="col-xl-3 col-lg-4 col-md-6 col-12">
				<div class="row justify-content-center">
					<div class="col-11">
						<div class="row align-items-center">
							<div class="col-auto">
								<div class="avatar rounded bg-light-green">
									<i class="fa-solid fa-users text-success fa-2x"></i>
								</div>
							</div>
							<div class="col ps-0">
								<div class="row">
									<div class="col-12"><span class="small mb-0">Docentes activos '. $nivel_enviar .'</span></div>
									<div class="col-auto"><h4 class="mb-0 titulo-2 fs-36 font-weight-bolder">'.count($datos).'</h4></div>		
									<div class="col-auto line-height-16">
										<span class="small fs-12 '.$texto.'">'.$porcentajenuevosf.'%</span></br>
										<span title="'.count($datosanterior).' Doocentes" class="pointer">'. $periodoantes .'</span>
									</div>
									<div class="col-auto pt-1">'.$flecha.'</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		';




		/* *************************** cifras contratos ********************** */
          
            $countmedia=0;
            $countcompleto=0;
            $counthora=0;
			$countprestacion=0;
				for ($contra=0;$contra<count($datos);$contra++){
					$tipo_contrato=$datos[$contra]["tipo_contrato"];
					if($tipo_contrato =="1"){
						$countmedia++;
					}
                    if($tipo_contrato =="2"){
						$countcompleto++;
					}
                    if($tipo_contrato =="3"){
						$counthora++;
					}
					if($tipo_contrato =="4"){
                        $countprestacion++;
                    }
				}

            $pormedia=round(($countmedia/count($datos))*100);
	        $porcompleto=round(($countcompleto/count($datos))*100);
            $porhora=round(($counthora/count($datos))*100);
            $porprestacion=round(($countprestacion/count($datos))*100);
		
			$data["dtotal"] .='
             <div class="col-12 mt-4"></div>
				<div class="col-xl-2 col-lg-2 col-md-4 col-12 mt-4 tono-2 borde-right">
					<div class="row">
                        <div class="col-xl-12 pl-4 py-2 ">
							<span class="text-semibold fs-16">Tipo de contratos</span>
						</div>
                        <div class="col-xl-12 pl-4">
							<span class="text-secondary fs-14">Medio tiempo</span>
							<h5>'.$pormedia.'% <small class="text-green fw-light fs-12"><i class=" bi bi-arrow-up vm"></i>'.$countmedia.' Doc.</small></h5>
						</div>

						<div class="col-xl-12 pl-4">
							<span class="text-secondary fs-14 ">Tiempo completo</span>
							<h5>'.$porcompleto.'% <small class="text-green fw-light fs-12"><i class=" bi bi-arrow-up vm"></i> '.$countcompleto.' Doc.</small></h5>
						</div>

                        <div class="col-xl-12 pl-4">
							<span class="text-secondary fs-14 ">Hora catedra</span>
							<h5>'.$porhora.'% <small class="text-green fw-light fs-12"><i class=" bi bi-arrow-up vm"></i>'.$counthora.' Doc.</small></h5>
						</div>
						
                        <div class="col-xl-12 pl-4">
							<span class="text-secondary fs-14 ">Prestación de servicios</span>
							<h5>'.$porprestacion.'% <small class="text-green fw-light fs-12"><i class=" bi bi-arrow-up vm"></i>'.$countprestacion.' Doc.</small></h5>
						</div>

					</div>
				</div>
			';
            
        /* *************************** cifras caracterización ********************** */
          
            $counthombres=0;
            $countmujeres=0;
				for ($ge=0;$ge<count($datos);$ge++){
					$sexo=$datos[$ge]["usuario_genero"];
					if($sexo =="Masculino"){
						$counthombres++;
					}else{
                        $countmujeres++;
                    }
				}

            $porhombres=round(($counthombres/count($datos))*100);
	        $pormujeres=round(($countmujeres/count($datos))*100);
		
			$data["dtotal"] .='
				<div class="col-xl-2 col-lg-2 col-md-4 col-12 mt-4 tono-2 borde-right">
					<div class="row">
                        <div class="col-xl-12 pl-4 py-2 ">
							<span class="text-semibold fs-16">Población por sexo</span>
						</div>
                        <div class="col-xl-12 pl-4">
							<span class="text-secondary fs-14">Mujeres</span>
							<h5>'.$pormujeres.'% <small class="text-green fw-light fs-12"><i class=" bi bi-arrow-up vm"></i>'.$countmujeres.' Doc.</small></h5>
						</div>

						<div class="col-xl-12 pl-4">
							<span class="text-secondary fs-14 ">Hombres</span>
							<h5>'.$porhombres.'% <small class="text-green fw-light fs-12"><i class=" bi bi-arrow-up vm"></i> '.$counthombres.' Doc.</small></h5>
						</div>
						
					</div>
				</div>
			';



		/* *************************** ********************** */
			


	

	
		/* ********************************************** */



	
	// 	$data["datosuno"] ="";
	// 	$data["datosuno"] .=' [';
	// 	$coma=",";
	// 	$valoranterior=0;
	// 	$valoranterior=0;

	// 	$id_periodo_actual=$dato_id_periodo["id_periodo"]-9;

	// 	for ($i=0;$i<10;$i++){
	// 		$periodo_historico=$factordocente->periodoanterior($id_periodo_actual);

	// 		$datoshistorico=$factordocente->total($periodo_historico["periodo"],$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// consulta periodo consultado
			
	// 		if($i<10-1){
	// 			$coma=",";
	// 		}else{
	// 			$coma="";
	// 		}

	// 		$valornuevo=$total;

	// 		if(count($datoshistorico) > $valoranterior){
	// 			$ganancia="gain";
	// 			$figura="triangle";
	// 			$color="#6B8E23";
	// 		}else{
	// 			$ganancia="loss";
	// 			$figura="cross";
	// 			$color="tomato";
	// 		}


	// 		$data["datosuno"] .='{ "label": "'.$periodo_historico["periodo"].'", "y": '.count($datoshistorico).', "indexLabel": "'.count($datoshistorico).'", "markerType": "'.$figura.'",  "markerColor": "'.$color.'" }'.$coma.'';
			
	// 		$id_periodo_actual++;
	// 		$valoranterior=count($datoshistorico);
	// 	}	
	
	// $data["datosuno"] .=' ]';

		echo json_encode($data);

	break;




}

?>