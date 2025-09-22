<?php 
require_once "../modelos/PoblacionEstudiantil.php";
$poblacionestudiantil = new PoblacionEstudiantil();

date_default_timezone_set("America/Bogota");	
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$mes_actual=date('Y-m')."-00";

$rsptaperiodo = $poblacionestudiantil->periodoactual();
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
		$rspta = $poblacionestudiantil->selectPeriodo();
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

		$rspta = $poblacionestudiantil->selectPrograma($escuela_enviar,$nivel_enviar);
			for ($i=0;$i<count($rspta);$i++){
				echo "<option value='" . $rspta[$i]["id_programa"] . "'>" . $rspta[$i]["nombre"] . "</option>";
			}
	break;

	case "selectJornada":	
		$rspta = $poblacionestudiantil->selectJornada();
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
		

		$datos=$poblacionestudiantil->total($periodo,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// consulta periodo consultado

		$dato_id_periodo=$poblacionestudiantil->selectPeriodoid($periodo);// consulta que trae el id del periodo consultado
		$id_periodo=$dato_id_periodo["id_periodo"]-1;

		$buscarperiodoacterior=$poblacionestudiantil->periodoanterior($id_periodo);//buscar el periodo anterior por id;
		$periodoantes=$buscarperiodoacterior["periodo"];

		$datosanterior=$poblacionestudiantil->total($periodoantes,$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// consulta periodo anterior

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


		/* *************************** Terminaron nuevos homologaciones internos renovación ********************** */

			$countegresados=0;
			for ($eg=0;$eg<count($datos);$eg++){
				$estadograduado=$datos[$eg]["graduado"];
				if($estadograduado==0){
					$countegresados++;
				}
			}

			$countnuevos=0;
			$counthomo=0;
			$countinterno=0;
			$countrema=0;
			for ($en=0;$en<count($datos);$en++){
				$estadonuevo=$datos[$en]["estado_matricula"];
				if($estadonuevo=="Nuevo"){
					$countnuevos++;
				}
				$estadohomo=$datos[$en]["estado_matricula"];
				if($estadohomo=="Homologado"){
					$counthomo++;
				}
				$estadointerno=$datos[$en]["estado_matricula"];
				if($estadointerno=="Interno"){
					$countinterno++;
				}
				$estadorema=$datos[$en]["estado_matricula"];
				if($estadorema=="Rematricula"){
					$countrema++;
				}
			}

			$countegresadosan=0;
			for ($eg=0;$eg<count($datosanterior);$eg++){
				$estadograduadoan=$datosanterior[$eg]["graduado"];
				if($estadograduadoan==0){
					$countegresadosan++;
				}
			}
			$countnuevosan=0;
			$counthomoan=0;
			$countinternoan=0;
			$countremaan=0;

			for ($en=0;$en<count($datosanterior);$en++){
				$estadonuevoan=$datosanterior[$en]["estado_matricula"];
				if($estadonuevoan=="Nuevo"){
					$countnuevosan++;
				}
				$estadohomoan=$datosanterior[$en]["estado_matricula"];
				if($estadohomoan=="Homologado"){
					$counthomoan++;
				}
				$estadointernoan=$datosanterior[$en]["estado_matricula"];
				if($estadointernoan=="Interno"){
					$countinternoan++;
				}
				$estadoremaan=$datosanterior[$en]["estado_matricula"];
				if($estadoremaan=="Rematricula"){
					$countremaan++;
				}
			}
		
			$data["dtotal"] .='
				<div class="col-12 mt-4">
					<div class="row">
						<div class="col-xl-2 pl-4">
							<span class="text-secondary small">Terminarón</span>
							<h5>'.$countegresados.' <small class="text-green fw-light fs-12"><i class=" bi bi-arrow-up vm"></i> '.$countegresadosan.'</small></h5>
						</div>
						<div class="col-xl-2 pl-4">
							<span class="text-secondary small">Nuevos</span>
							<h5>'.$countnuevos.' <small class="text-green fw-light fs-12"><i class=" bi bi-arrow-up vm"></i> '.$countnuevosan.'</small></h5>
						</div>
						<div class="col-xl-2 pl-4">
							<span class="text-secondary small">Homologados</span>
							<h5>'.$counthomo.'<small class="text-green fw-light fs-12"><i class=" bi bi-arrow-up vm"></i> '.$counthomoan.'</small></h5>
						</div>
						<div class="col-xl-2 pl-4">
							<span class="text-secondary small">Internos</span>
							<h5>'.$countinterno.' <small class="text-green fw-light fs-12"><i class=" bi bi-arrow-up vm"></i> '.$countinternoan.'</small></h5>
						</div>
						<div class="col-xl-2 pl-4">
							<span class="text-secondary small">Renovación</span>
							<h5>'.$countrema.' <small class="text-green fw-light fs-12"><i class=" bi bi-arrow-up vm"></i> '.$countremaan.'</small></h5>
						</div>
					</div>
				</div>
			';

		/* *************************** ********************** */
			


		/* formula para calcular los datos por convenio*/
		$countlaborales=0;
		$sumale=0;
		$lau=0;
		$laucuba=0;
		$risaralda=0;
		$directos=0;
		for ($e=0;$e<count($datos);$e++){
			$mijornada=$datos[$e]["jornada_e"];

			if($mijornada=="A04" || $mijornada=="A03" || $mijornada=="A03"){
				$sumale++;
			}
			else if($mijornada=="A06" || $mijornada=="A06-1" || $mijornada=="A06-2" || $mijornada=="A06-3" || $mijornada=="DDAS"){
				$lau++;
			}

			else if($mijornada=="CAP"){
				$laucuba++;
			}

			else if($mijornada=="R01"){
				$risaralda++;
			}

			else{
				$directos++;
			}
			

		}
		/* ********************************************** */
		/* formula para calcular los datos por convenio anterior*/
		$countlaboralesa=0;
		$sumalea=0;
		$laua=0;
		$laucubaa=0;
		$risaraldaa=0;
		$directosa=0;
		for ($e=0;$e<count($datosanterior);$e++){
			$mijornadaa=$datosanterior[$e]["jornada_e"];

			if($mijornadaa=="A04" || $mijornadaa=="A03" || $mijornadaa=="A03"){
				$sumalea++;
			}
			else if($mijornadaa=="A06" || $mijornadaa=="A06-1" || $mijornadaa=="A06-2" || $mijornadaa=="A06-3" || $mijornadaa=="DDAS"){
				$laua++;
			}

			else if($mijornadaa=="CAP"){
				$laucubaa++;
			}

			else if($mijornadaa=="R01"){
				$risaraldaa++;
			}

			else{
				$directosa++;
			}
		}
	

	
		/* ********************************************** */

		/* formula para calcular el porcentaje con respecto al periodo anterior en los convenios risaralda*/
		if ($risaraldaa != 0) {
			$pornuevori = (($risaralda - $risaraldaa) / $risaraldaa) * 100;
			$pornuevorif=round($pornuevori, 2);
		} else {
			$pornuevori = 0; // Por ejemplo, asignar 0 si no se puede calcular el porcentaje.
			$pornuevorif=0;
		}

		if($pornuevori == 0) {
			$flechari="<div class='pl-2'><i class='fa-solid fa-equals text-primary'></i></div>";
			$textori="text-primary";
		}
		elseif($pornuevori < 0) {
			$flechari="<img src='../public/img/bajo.webp' width='20px'>";
			$textori="text-danger";
		}else{
			$flechari="<img src='../public/img/aumento.webp' width='20px'>";
			$textori="text-success";
		}
		/* *************************** ***** ****************/

		/* formula para calcular el porcentaje con respecto al periodo anterior en los convenios sumale*/
		if ($sumalea != 0) {
			$pornuevosumale=(($sumale-$sumalea)/$sumalea)*100;
			$pornuevosumalef=round($pornuevosumale, 2);
		}else{
			$pornuevosumale=0;
			$pornuevosumalef=0;
		}
		if($pornuevosumale == 0) {
			$flechasumale="<div class='pl-2'><i class='fa-solid fa-equals text-primary'></i></div>";
			$textosumale="text-primary";
		}
		elseif($pornuevosumale < 0) {
			$flechasumale="<img src='../public/img/bajo.webp' width='20px'>";
			$textosumale="text-danger";
		}else{
			$flechasumale="<img src='../public/img/aumento.webp' width='20px'>";
			$textosuamle="text-success";
		}
		/* *************************** ***** ****************/

		/* formula para calcular el porcentaje con respecto al periodo anterior en los convenios la u en tu colegio*/
		if ($laua != 0) {
			$pornuevolau=(($lau-$laua)/$laua)*100;
			$pornuevolauf=round($pornuevolau, 2);
		}else{
			$pornuevolau=0;
			$pornuevolauf=0;
		}
		
		if($pornuevolau == 0) {
			$flechalau="<div class='pl-2'><i class='fa-solid fa-equals text-primary'></i></div>";
			$textolau="text-primary";
		}
		elseif($pornuevolau < 0) {
			$flechalau="<img src='../public/img/bajo.webp' width='20px'>";
			$textolau="text-danger";
		}else{
			$flechalau="<img src='../public/img/aumento.webp' width='20px'>";
			$textolau="text-success";
		}
		/* *************************** ***** ****************/

		/* formula para calcular el porcentaje con respecto al periodo anterior en los convenios la u en Cuba*/
		if ($laucubaa != 0) {
			$pornuevolaucuba=(($laucuba-$laucubaa)/$laucubaa)*100;
			$pornuevolaucubaf=round($pornuevolaucuba, 2);
		}else{
			$pornuevolaucuba=0;
			$pornuevolaucubaf=0;
		}
		if($pornuevolaucuba == 0) {
			$flechalaucuba="<div class='pl-2'><i class='fa-solid fa-equals text-primary'></i></div>";
			$textolaucuba="text-primary";
		}
		elseif($pornuevolaucuba < 0) {
			$flechalaucuba="<img src='../public/img/bajo.webp' width='20px'>";
			$textolaucuba="text-danger";
		}else{
			$flechalaucuba="<img src='../public/img/aumento.webp' width='20px'>";
			$textolaucuba="text-success";
		}
		/* *************************** ***** ****************/

		/* formula para calcular el porcentaje con respecto al periodo anterior en los estudiantes directos*/
		if ($directosa != 0) {
			$pornuevodirectos=(($directos-$directosa)/$directosa)*100;
			$pornuevodirectosf=round($pornuevodirectos, 2);
		}else{
			$pornuevodirectos=0;
			$pornuevodirectosf=0;
		}
		if($pornuevodirectos == 0) {
			$flechadirectos="<div class='pl-2'><i class='fa-solid fa-equals text-primary'></i></div>";
			$textodirectos="text-primary";
		}
		elseif($pornuevodirectos < 0) {
			$flechadirectos="<img src='../public/img/bajo.webp' width='20px'>";
			$textodirectos="text-danger";
		}else{
			$flechadirectos="<img src='../public/img/aumento.webp' width='20px'>";
			$textodirectos="text-success";
		}
		/* *************************** ***** ****************/

		
		$data["dtotal"] .='
			<div class="col-xl-4 mt-4">
				
				<div class="row">
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
									<div class="col-4 text-right"><span class="titulo-2 fs-24">'. $risaralda . '</span></div>
									<div class="col-auto pointer" title="'.$risaraldaa.' Estudiantes">
										<span class="small fs-12 line-height-16 '.$textori.'">'.$pornuevorif.'%</span><br>
										<span class="fs-12 line-height-16">'. $periodoantes .'</span>
									</div>
									<div class="col-2 pt-2">'.$flechari.'</div>
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
									<div class="col-4 text-right"><span class="titulo-2 fs-24">'. $sumale . '</span></div>
									<div class="col-auto pointer" title="'.$sumalea.' Estudiantes">
										<span class="small fs-12 line-height-16 '.$textosumale.'">'.$pornuevosumalef.'%</span><br>
										<span class="fs-12 line-height-16">'. $periodoantes .'</span>
									</div>
									<div class="col-2 pt-2">'.$flechasumale.'</div>
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
									<div class="col-4 text-right"><span class="titulo-2 fs-24">'. $lau . '</span></div>
									<div class="col-auto pointer" title="'.$laua.' Estudiantes">
										<span class="small fs-12 line-height-16 '.$textolau.'">'.$pornuevolauf.'%</span><br>
										<span class="fs-12 line-height-16">'. $periodoantes .'</span>
									</div>
									<div class="col-2 pt-2">'.$flechalau.'</div>
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
									<div class="col-4 text-right"><span class="titulo-2 fs-24">'. $laucuba . '</span></div>
									<div class="col-auto pointer" title="'.$laucubaa.' Estudiantes">
										<span class="small fs-12 line-height-16 '.$textolaucuba.'">'.$pornuevolaucubaf.'%</span><br>
										<span class="fs-12 line-height-16">'. $periodoantes .'</span>
									</div>
									<div class="col-2 pt-2">'.$flechalaucuba.'</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-12 tono-3 p-x py-4 mt-4">
						<div class="row align-items-center">
							<div class="col-1 text-center">
								<i class="fa-solid fa-chart-simple p-2 bg-light-blue text-primary rounded "></i>
							</div>
							<div class="col-6">
								<span class="mb-0 fs-24">Directos</span>
							</div>
							<div class="col-5">
								<div class="row">
									<div class="col-4 text-right"><span class="titulo-2 fs-24">'. $directos . '</span></div>
									<div class="col-auto pointer" title="'.$directosa.' Estudiantes">
										<span class="small fs-12 line-height-16 '.$textodirectos.'">'.$pornuevodirectosf.'%</span><br>
										<span class="fs-12 line-height-16">'. $periodoantes .'</span>
									</div>
									<div class="col-2 pt-2">'.$flechadirectos.'</div>
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

		for ($i=0;$i<10;$i++){
			$periodo_historico=$poblacionestudiantil->periodoanterior($id_periodo_actual);

			$datoshistorico=$poblacionestudiantil->total($periodo_historico["periodo"],$escuela_enviar,$nivel_enviar,$jornada_enviar,$semestre_enviar,$programa_enviar);// consulta periodo consultado
			
			if($i<10-1){
				$coma=",";
			}else{
				$coma="";
			}

			$valornuevo=$total;

			if(count($datoshistorico) > $valoranterior){
				$ganancia="gain";
				$figura="triangle";
				$color="#6B8E23";
			}else{
				$ganancia="loss";
				$figura="cross";
				$color="tomato";
			}


			$data["datosuno"] .='{ "label": "'.$periodo_historico["periodo"].'", "y": '.count($datoshistorico).', "indexLabel": "'.count($datoshistorico).'", "markerType": "'.$figura.'",  "markerColor": "'.$color.'" }'.$coma.'';
			
			$id_periodo_actual++;
			$valoranterior=count($datoshistorico);
		}	
	
	$data["datosuno"] .=' ]';

		echo json_encode($data);

	break;




}

?>