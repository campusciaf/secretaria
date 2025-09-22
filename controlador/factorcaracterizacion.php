<?php 
require_once "../modelos/FactorCaracterizacion.php";
$factorcaracterizacion = new FactorCaracterizacion();

date_default_timezone_set("America/Bogota");	
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$mes_actual=date('Y-m')."-00";

$rsptaperiodo = $factorcaracterizacion->periodoactual();
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
		$rspta = $factorcaracterizacion->selectPeriodo();
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

		$rspta = $factorcaracterizacion->selectPrograma($escuela_enviar,$nivel_enviar);
			for ($i=0;$i<count($rspta);$i++){
				echo "<option value='" . $rspta[$i]["id_programa"] . "'>" . $rspta[$i]["nombre"] . "</option>";
			}
	break;

	case "selectJornada":	
		$rspta = $factorcaracterizacion->selectJornada();
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
		

		$datos=$factorcaracterizacion->total($periodo,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// consulta periodo consultado

		$dato_id_periodo=$factorcaracterizacion->selectPeriodoid($periodo);// consulta que trae el id del periodo consultado
		$id_periodo=$dato_id_periodo["id_periodo"]-1;

		$buscarperiodoacterior=$factorcaracterizacion->periodoanterior($id_periodo);//buscar el periodo anterior por id;
		$periodoantes=$buscarperiodoacterior["periodo"];

		$datosanterior=$factorcaracterizacion->total($periodoantes,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// consulta periodo anterior

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
									<div class="col-12"><span class="small mb-0">Estudiantes activos '. $nivel_enviar .'</span></div>
									<div class="col-auto"><h4 class="mb-0 titulo-2 fs-36 font-weight-bolder">'.count($datos).'</h4></div>		
									<div class="col-auto line-height-16">
										<span class="small fs-12 '.$texto.'">'.$porcentajenuevosf.'%</span></br>
										<span title="'.count($datosanterior).' Estudiantes" class="pointer">'. $periodoantes .'</span>
									</div>
									<div class="col-auto pt-1">'.$flecha.'</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		';

		/********** datos profesioanles ********************* */

		/* formula para calcular los datos de los programas profesionales */
		$countprofesional=0;
		for ($c=0;$c<count($datos);$c++){
			$minivelp=$datos[$c]["nivel"];
			if($minivelp==1 || $minivelp==2 || $minivelp==3 || $minivelp==5){
				$countprofesional++;
			}
		}
		/* ********************************************** */

		/********** datos profesionales ********************* */
		if(($escuela_laboral=='inicio' || $escuela_laboral=='no') && ($nivel_laboral=='inicio' || $nivel_laboral=='no')){
			/* formula para calcular los datos de los programas profesionales  periodo consultado*/
				$countprofesionalanterior=0;
				for ($d=0;$d<count($datosanterior);$d++){
					$minivelpa=$datosanterior[$d]["nivel"];
					if($minivelpa==1 || $minivelpa==2 || $minivelpa==3 || $minivelpa==5){
						$countprofesionalanterior++;
					}
				}
			/* ********************************************** */

			/* formula para calcular el porcentaje con respecto al periodo anterior */
			if ($countprofesionalanterior != 0) {
				$porcentajenuevospro=(($countprofesional-$countprofesionalanterior)/$countprofesionalanterior)*100;
				$porcentajenuevosprof=round($porcentajenuevospro, 2);
			}else{
				$porcentajenuevospro=0;
				$porcentajenuevosprof=0;
			}

				if($porcentajenuevospro < 0) {
					$flechap="<img src='../public/img/bajo.webp' width='20px'>";
					$textop="text-danger";
				}else{
					$flechap="<img src='../public/img/aumento.webp' width='20px'>";
					$textop="text-success";
				}
				/* *************************** ***** ****************/

					$data["dtotal"] .= '
					<div class="col-xl-3 col-lg-4 col-md-6 col-12">
						<div class="row justify-content-center">
							<div class="col-11">
								<div class="row align-items-center">
									<div class="col-auto">
										<div class="avatar rounded bg-light-blue">
											<i class="fa-solid fa-users text-primary fa-2x"></i>
										</div>
									</div>
									<div class="col ps-0">
										<div class="row">
											<div class="col-12"><span class="small mb-0">Profesionales '. $periodo .'</span></div>
											<div class="col-auto"><h4 class="mb-0 titulo-2 fs-36 font-weight-bolder">'.$countprofesional.'</h4></div>		
											<div class="col-auto line-height-16">
												<span class="small fs-12 '.$textop.'">'.$porcentajenuevosprof.'%</span></br>
												<span title="'.$countprofesionalanterior.' Estudiantes" class="pointer">'. $periodoantes .'</span>
											</div>
											<div class="col-auto pt-1">'.$flechap.'</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				';
			/* ************************ ****************************** ********/
		}
		else{

			$data["dtotal"] .= '
				<div class="col-xl-3 col-lg-4 col-md-6 col-12">
					<div class="row justify-content-center">
						<div class="col-11">
							<div class="row align-items-center">
								<div class="col-auto">
									<div class="avatar rounded bg-light-blue">
										<i class="fa-solid fa-users text-primary fa-2x"></i>
									</div>
								</div>
								<div class="col ps-0">
									<div class="row">
										<div class="col-12"><span class="small mb-0">Profesionales '. $periodo .'</span></div>
										<div class="col-auto"><h4 class="mb-0 titulo-2 fs-36 font-weight-bolder">0</h4></div>		
										<div class="col-auto line-height-16">
											<span class="small fs-12 ">0%</span></br>
											<span title="0 Estudiantes" class="pointer">'. $periodoantes .'</span>
										</div>
										<div class="col-auto pt-1"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			';
		}
		/* ********************************************** */


		/********** datos laborales ********************* */
		if(($escuela_laboral=='inicio' || $escuela_laboral=='si') && ($nivel_laboral=='inicio' || $nivel_laboral=='si') && ($jornada_laboral=="inicio" || $jornada_laboral=="si") && ($semestre_laboral=="inicio" || $semestre_laboral=="si")){


			/* formula para calcular los datos de los programas laborales  periodo consultado*/
				$countlaborales=0;
				for ($a=0;$a<count($datos);$a++){
					$minivel=$datos[$a]["nivel"];
					if($minivel==7){
						$countlaborales++;
					}
				}
			/* ********************************************** */

			/* formula para calcular los datos de los programas laborales  periodo consultado*/
				$countlaboralesanterior=0;
				for ($b=0;$b<count($datosanterior);$b++){
					$minivela=$datosanterior[$b]["nivel"];
					if($minivela==7){
						$countlaboralesanterior++;
					}
				}
			/* ********************************************** */

			/* formula para calcular el porcentaje con respecto al periodo anterior */
			if ($countlaboralesanterior != 0) {
				$porcentajenuevoslaboral=(($countlaborales-$countlaboralesanterior)/$countlaboralesanterior)*100;
				$porcentajenuevoslaboralf=round($porcentajenuevoslaboral, 2);
			}else{
				$porcentajenuevoslaboral=0;
				$porcentajenuevoslaboralf=0;
			}
				
				if($porcentajenuevoslaboral < 0) {
					$flechal="<img src='../public/img/bajo.webp' width='20px'>";
					$textol="text-danger";
				}else{
					$flechal="<img src='../public/img/aumento.webp' width='20px'>";
					$textol="text-success";
				}
			/* *************************** ***** ****************/

			$data["dtotal"] .= '
				<div class="col-xl-3 col-lg-4 col-md-6 col-12">
					<div class="row justify-content-center">
						<div class="col-11">
							<div class="row align-items-center">
								<div class="col-auto">
									<div class="avatar rounded bg-light-yellow">
										<i class="fa-solid fa-users text-warning fa-2x"></i>
									</div>
								</div>
								<div class="col ps-0">
									<div class="row">
										<div class="col-12"><span class="small mb-0">Formación para el trabajo '. $periodo .'</span></div>
										<div class="col-auto"><h4 class="mb-0 titulo-2 fs-36 font-weight-bolder">'.$countlaborales.'</h4></div>		
										<div class="col-auto line-height-16">
											<span class="small fs-12 '.$textol.'">'.@$porcentajenuevoslaboralf.'%</span></br>
											<span title="'.$countlaboralesanterior.' Estudiantes" class="pointer">'. $periodoantes .'</span>
										</div>
										<div class="col-auto pt-1">'.$flechal.'</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			';

		
		}else{
			$data["dtotal"] .= '
					<div class="col-xl-3 col-lg-4 col-md-6 col-12">
						<div class="row justify-content-center">
							<div class="col-11">
								<div class="row align-items-center">
									<div class="col-auto">
										<div class="avatar rounded bg-light-yellow">
											<i class="fa-solid fa-users text-warning fa-2x"></i>
										</div>
									</div>
									<div class="col ps-0">
										<div class="row">
											<div class="col-12"><span class="small mb-0">Formación para el trabajo '. $periodo .'</span></div>
											<div class="col-auto"><h4 class="mb-0 titulo-2 fs-36 font-weight-bolder">0</h4></div>		
											<div class="col-auto line-height-16">
												<span class="small fs-12 ">0%</span></br>
												<span title="0 Estudiantes" class="pointer">'. $periodoantes .'</span>
											</div>
											<div class="col-auto pt-1"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				';
		}	
		
		/* *************************** ********************** */


		/* *************************** cifras caracterización ********************** */
          
            $counthombres=0;
            $countmujeres=0;
				for ($ge=0;$ge<count($datos);$ge++){
					$sexo=$datos[$ge]["genero"];
					if($sexo =="Masculino"){
						$counthombres++;
					}else{
                        $countmujeres++;
                    }
				}

            $porhombres=round(($counthombres/count($datos))*100);
	        $pormujeres=round(($countmujeres/count($datos))*100);
		
			$data["dtotal"] .='
             <div class="col-12 mt-4"></div>
				<div class="col-xl-2 col-lg-2 col-md-4 col-12 mt-4 tono-2 borde-right">
					<div class="row">
                        <div class="col-xl-12 pl-4 py-2 ">
							<span class="text-semibold fs-16">Población CIAF</span>
						</div>
                        <div class="col-xl-12 pl-4">
							<span class="text-secondary fs-14">Mujeres</span>
							<h5>'.$pormujeres.'% <small class="text-green fw-light fs-12"><i class=" bi bi-arrow-up vm"></i>'.$countmujeres.' Est.</small></h5>
						</div>

						<div class="col-xl-12 pl-4">
							<span class="text-secondary fs-14 ">Hombres</span>
							<h5>'.$porhombres.'% <small class="text-green fw-light fs-12"><i class=" bi bi-arrow-up vm"></i> '.$counthombres.' Est.</small></h5>
						</div>
						
					</div>
				</div>
			';

            $edad_total_general = 0;
            $contador_general = 0;

            $edad_total_hombres = 0;
            $contador_hombres = 0;

            $edad_total_mujeres = 0;
            $contador_mujeres = 0;

            for ($ed = 0; $ed < count($datos); $ed++) {
                $fecha_nacimiento = $datos[$ed]["fecha_nacimiento"];
                $genero = $datos[$ed]["genero"];

                // Calcular edad
                $nacimiento = new DateTime($fecha_nacimiento);
                $hoy = new DateTime();
                $edad = $hoy->diff($nacimiento)->y;

                // General
                $edad_total_general += $edad;
                $contador_general++;

                // Por género
                if (strtolower($genero) == 'masculino') {
                    $edad_total_hombres += $edad;
                    $contador_hombres++;
                } elseif (strtolower($genero) == 'femenino') {
                    $edad_total_mujeres += $edad;
                    $contador_mujeres++;
                }
            }

            // Mostrar resultados
            if ($contador_general > 0) {
                $edad_general=round($edad_total_general / $contador_general);
            }
            if ($contador_hombres > 0) {
                $edadhombres=round($edad_total_hombres / $contador_hombres);
            }
            if ($contador_mujeres > 0) {
                $edadmujeres=round($edad_total_mujeres / $contador_mujeres);
            }

		
			$data["dtotal"] .='
               
				<div class="col-xl-2 col-lg-2 col-md-4 col-12 mt-4 tono-2 borde-right">
					<div class="row">
                        <div class="col-xl-12 pl-4 py-2 ">
							<span class="text-semibold fs-16">Promedio edad</span>
						</div>
						<div class="col-xl-12 pl-4">
							<h5>'.$edad_general.' Años <small class="text-green fw-light fs-12"><i class=" bi bi-arrow-up vm"></i> '.count($datos).' General</small></h5>
						</div>
                        <div class="col-xl-12 pl-4">
							<span class="text-secondary fs-14 ">Mujeres</span>
							<h5>'.$edadmujeres.' Años <small class="text-green fw-light fs-12"><i class=" bi bi-arrow-up vm"></i> '.$countmujeres.' Est.</small></h5>
						</div>
                        <div class="col-xl-12 pl-4">
							<span class="text-secondary fs-14 ">Hombres</span>
							<h5>'.$edadhombres.' Años<small class="text-green fw-light fs-12"><i class=" bi bi-arrow-up vm"></i> '.$counthombres.' Est.</small></h5>
						</div>

					</div>
				</div>
			';


            $countgay=0;
				for ($ga=0;$ga<count($datos);$ga++){
					$comunidad=$datos[$ga]["comunidad_lgbtiq"];
					if($comunidad =="Si"){
						$countgay++;
					}
				}

            $porgay=round(($countgay/count($datos))*100);
		
			$data["dtotal"] .='
				<div class="col-xl-2 col-lg-2 col-md-4 col-12 mt-4 tono-2 borde-right">
					<div class="row">
                        <div class="col-xl-12 pl-4 py-2 ">
							<span class="text-semibold fs-16">Comunidad lgbtiq</span>
						</div>
						<div class="col-xl-12 pl-4">
							<span class="text-secondary fs-14"> Comunidad lgbtiq</span>
							<h5>'.$porgay.'% <small class="text-green fw-light fs-12"><i class=" bi bi-arrow-up vm"></i> '.$countgay.' Est.</small></h5>
						</div>
					</div>
				</div>
			';

			$countestrato1=0;
			$countestrato2=0;
			$countestrato3=0;
			$countestrato4=0;
			$countestrato5=0;
			$countestrato6=0;

				for ($es=0;$es<count($datos);$es++){
					$estrato=$datos[$es]["estrato"];
					if($estrato ==1){
						$countestrato1++;
					}
					if($estrato ==2){
						$countestrato2++;
					}
					if($estrato ==3){
						$countestrato3++;
					}
					if($estrato ==4){
						$countestrato4++;
					}
					if($estrato ==5){
						$countestrato5++;
					}
					if($estrato ==6){
						$countestrato6++;
					}
				}

            $totalestrato1=round(($countestrato1/count($datos))*100);
			$totalestrato2=round(($countestrato2/count($datos))*100);
			$totalestrato3=round(($countestrato3/count($datos))*100);
			$totalestrato4=round(($countestrato4/count($datos))*100);
			$totalestrato5=round(($countestrato5/count($datos))*100);
			$totalestrato6=round(($countestrato6/count($datos))*100);



            $data["dtotal"] .='
				<div class="col-xl-2 col-lg-2 col-md-4 col-12 mt-4 tono-2 borde-right">
					<div class="row">
                        <div class="col-xl-12 pl-4 py-2 ">
							<span class="text-semibold fs-16">Estrato socioeconómico</span>
						</div>
						<div class="col-xl-12 pl-4">
							<span class="text-secondary fs-14"> Estrato 1</span>
							<h5>'.$totalestrato1.'% <small class="text-green fw-light fs-12"><i class=" bi bi-arrow-up vm"></i>'.$countestrato1.'  Est.</small></h5>
						</div>
						<div class="col-xl-12 pl-4">
							<span class="text-secondary fs-14"> Estrato 2</span>
							<h5>'.$totalestrato2.'% <small class="text-green fw-light fs-12"><i class=" bi bi-arrow-up vm"></i>'.$countestrato2.'  Est.</small></h5>
						</div>
						<div class="col-xl-12 pl-4">
							<span class="text-secondary fs-14"> Estrato 3</span>
							<h5>'.$totalestrato3.'% <small class="text-green fw-light fs-12"><i class=" bi bi-arrow-up vm"></i>'.$countestrato3.'  Est.</small></h5>
						</div>
						<div class="col-xl-12 pl-4">
							<span class="text-secondary fs-14"> Estrato 4</span>
							<h5>'.$totalestrato4.'% <small class="text-green fw-light fs-12"><i class=" bi bi-arrow-up vm"></i>'.$countestrato4.'  Est.</small></h5>
						</div>
						<div class="col-xl-12 pl-4">
							<span class="text-secondary fs-14"> Estrato 5</span>
							<h5>'.$totalestrato5.'% <small class="text-green fw-light fs-12"><i class=" bi bi-arrow-up vm"></i>'.$countestrato5.'  Est.</small></h5>
						</div>
						<div class="col-xl-12 pl-4">
							<span class="text-secondary fs-14"> Estrato 6</span>
							<h5>'.$totalestrato6.'% <small class="text-green fw-light fs-12"><i class=" bi bi-arrow-up vm"></i>'.$countestrato6.'  Est.</small></h5>
						</div>
					</div>
				</div>
			';

            $enfisica=0;
            $enmental=0;
				for ($em=0;$em<count($datos);$em++){
					$fisica=$datos[$em]["enfermedad_fisica"];
                    $mental=$datos[$em]["trastorno_mental"];
					if($fisica =="Si"){
						$enfisica++;
					}
                    if($mental =="Si"){
                        $enmental++;
                    }
				}

            $porfisica=round(($enfisica/count($datos))*100);
	        $pormental=round(($enmental/count($datos))*100);
		
			$data["dtotal"] .='
				<div class="col-xl-2 col-lg-2 col-md-4 col-12 mt-4 tono-2 borde-right">
					<div class="row">
                        <div class="col-xl-12 pl-4 py-2 ">
							<span class="text-semibold fs-16">Población con discapacidad</span>
						</div>
						<div class="col-xl-12 pl-4">
							<span class="text-secondary fs-14 ">Discapacidad Fisíca</span>
							<h5>'.$porfisica.'% <small class="text-green fw-light fs-12"><i class=" bi bi-arrow-up vm"></i> '.$enfisica.' Est.</small></h5>
						</div>
						<div class="col-xl-12 pl-4">
							<span class="text-secondary fs-14">Discapacidad Mental</span>
							<h5>'.$pormental.'% <small class="text-green fw-light fs-12"><i class=" bi bi-arrow-up vm"></i>'.$enmental.' Est.</small></h5>
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
	// 		$periodo_historico=$factorcaracterizacion->periodoanterior($id_periodo_actual);

	// 		$datoshistorico=$factorcaracterizacion->total($periodo_historico["periodo"],$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// consulta periodo consultado
			
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