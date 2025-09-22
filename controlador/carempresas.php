<?php
session_start();
require_once "../modelos/CarEmpresas.php";

$carempresas = new CarEmpresas();
$periodo_actual = $_SESSION['periodo_actual'];
$id_credencial = $_SESSION['id_usuario'];

date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i:s');


$p1=isset($_POST["p1"])? limpiarCadena($_POST["p1"]):"";
$p2=isset($_POST["p2"])? limpiarCadena($_POST["p2"]):"";
$p3=isset($_POST["p3"])? limpiarCadena($_POST["p3"]):"";
$p4=isset($_POST["p4"])? limpiarCadena($_POST["p4"]):"";
$p5=isset($_POST["p5"])? limpiarCadena($_POST["p5"]):"";
$p6=isset($_POST["p6"])? limpiarCadena($_POST["p6"]):"";
$p7=isset($_POST["p7"])? limpiarCadena($_POST["p7"]):"";
$p8=isset($_POST["p8"])? limpiarCadena($_POST["p8"]):"";
$p9=isset($_POST["p9"])? limpiarCadena($_POST["p9"]):"";
$p10=isset($_POST["p10"])? limpiarCadena($_POST["p10"]):"";
$p11=isset($_POST["p11"])? limpiarCadena($_POST["p11"]):"";
$p12=isset($_POST["p12"])? limpiarCadena($_POST["p12"]):"";
$p13=isset($_POST["p13"])? limpiarCadena($_POST["p13"]):"";
$p14=isset($_POST["p14"])? limpiarCadena($_POST["p14"]):"";
$p15=isset($_POST["p15"])? limpiarCadena($_POST["p15"]):"";
$p16=isset($_POST["p16"])? limpiarCadena($_POST["p16"]):"";
$p17=isset($_POST["p17"])? limpiarCadena($_POST["p17"]):"";
$p18=isset($_POST["p18"])? limpiarCadena($_POST["p18"]):"";
$p19=isset($_POST["p19"])? limpiarCadena($_POST["p19"]):"";
$p20=isset($_POST["p20"])? limpiarCadena($_POST["p20"]):"";


switch ($_GET['op']) {

    case 'verificar':
        $data= Array();
		$data["0"] ="";//iniciamos el arreglo
		    $rspta=$carempresas->verificar($id_credencial);

        $data = $rspta ? '1' : '0';
        echo json_encode($data);

		
	break;

    case 'guardardata':
        $data= Array();
		$data["0"] ="";//iniciamos el arreglo

        $aceptodata=0;
        $rspta=$carempresas->insertardata($id_credencial,$aceptodata,$fecha);
        $rspta ? "1" : "2";

        $data["0"] .= $rspta;

        $results = array($data);
        echo json_encode($data);

    break; 	

    case 'listarPreguntas':

        $data= Array();
		$data["datos"] ="";//iniciamos el arreglo
        $data["condi"] ="";//para saber si es hombre o mujer

        $pre=$carempresas->listar($id_credencial);
        $data["condi"] .=$pre["genero"];//para saber si es hombre o mujer

        $data["datos"] .= '';
            $data["datos"] .= '<div class="row">';

                $data["datos"] .= '

                <div class="col-12">
                    <h6 class="title">Información de ocupación</h6>
                </div>';
                


                if($pre["ep1"]==1){
                    $p1option='
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
                }else{
                    $p1option='
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
                }

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select  class="form-control border-start-0"  name="p1" id="p1" onchange="mostrarp1(this.value)">
                                '.$p1option.'
                            </select>
                            <label>¿Trabajas actualmente?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="'.$pre["ep2"].'"  class="form-control border-start-0" name="p2" id="p2" maxlength="50">
                            <label>¿Nombre de la empresa en la que trabajas ?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["ep3"].'"  id="p3_val">
                                <select class="form-control border-start-0" name="p3" id="p3">
                                    <option value="">Seleccionar</option>
                                    <option value="Pública">Pública</option>
                                    <option value="Privada">Privada</option>
                                </select>
                                <label>¿Tipo de sector de la empresa en la que trabajas?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="'.$pre["ep4"].'"  class="form-control border-start-0" name="p4" id="p4" maxlength="100">
                            <label>¿Dirección de la empresa donde trabaja?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="'.$pre["ep5"].'"  class="form-control border-start-0" name="p5" id="p5" maxlength="11">
                            <label>¿Teléfono de la empresa donde trabaja?</label>
                        </div>
                    </div>
                </div>';

                
                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["ep6"].'"  id="p6_val">
                                <select class="form-control border-start-0" name="p6" id="p6">
                                    <option value="">Seleccionar</option>
                                    <option value="Diurno">Diurno</option>
                                    <option value="Nocturno">Nocturno</option>
                                    <option value="Rotativo">Rotativo</option>
                                </select>
                                <label>¿Jornada laboral?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="'.$pre["ep7"].'" class="form-control border-start-0" name="p7" id="p7" maxlength="100">
                            <label>¿Qué incentivos genera tu empresa para tu proceso de formación?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '<div class="col-12"></div>';

                if($pre["ep8"]==1){
                    $p8option='
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
                }else{
                    $p8option='
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
                }

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select  class="form-control border-start-0"  name="p8" id="p8" onchange="mostrarp8(this.value)">
                                '.$p8option.'
                            </select>
                            <label>¿Alguien de tu trabajo actual o anteriores, te inspiró a estudiar?</label>
                        </div>
                    </div>
                </div>';


                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text"  value="'.$pre["ep9"].'"   class="form-control border-start-0" name="p9" id="p9" maxlength="80">
                            <label>¿Nombre completo ?</label>
                        </div>
                    </div>
                </div>';

                
                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="number"  value="'.$pre["ep10"].'"   class="form-control border-start-0" name="p10" id="p10" maxlength="50">
                            <label>¿teléfono de contacto?</label>
                        </div>
                    </div>
                </div>';


                $data["datos"] .= '
                    <div class="col-12">
                        <h6 class="title">Información de tu empresa/emprendimiento </h6>
                    </div>
                ';

                if($pre["ep11"]==1){
                    $p11option='
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
                }else{
                    $p11option='
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
                }

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select  class="form-control border-start-0"  name="p11" id="p11" onchange="mostrarp11(this.value)">
                                '.$p11option.'
                            </select>
                            <label>¿Tienes una empresa legalmente constituida?</label>
                        </div>
                    </div>
                </div>';


                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text"  value="'.$pre["ep12"].'"   class="form-control border-start-0" name="p12" id="p12" maxlength="80">
                            <label>¿Nombre y razón social de la empresa?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '<div class="col-12"></div>';

                if($pre["ep13"]==1){
                    $p13option='
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
                }else{
                    $p13option='
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
                }

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select  class="form-control border-start-0"  name="p13" id="p13" onchange="mostrarp13(this.value)">
                                '.$p13option.'
                            </select>
                            <label>¿Tienes una idea de negocio o emprendimiento?</label>
                        </div>
                    </div>
                </div>';


                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text"  value="'.$pre["ep14"].'"   class="form-control border-start-0" name="p14" id="p14" maxlength="80">
                            <label>¿Nombre de la empresa, emprendimiento o idea de negocio?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" >
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["ep15"].'" id="p15_val" >
                                <select class="form-control border-start-0" name="p15" id="p15" >
                                    <option value="">Seleccionar</option>
                                    <option value="Agricultura; plantaciones, otros sectores rurales">Agricultura; plantaciones, otros sectores rurales</option>
                                    <option value="Comercio">Comercio</option>
                                    <option value="Construcción">Construcción</option>
                                    <option value="Educación">Educación</option>
                                    <option value="Hotelería, restauración, turísmo">Hotelería, restauración, turísmo</option>
                                    <option value="Ingeniería mecánica y eléctrica">Ingeniería mecánica y eléctrica</option>
                                    <option value="Servicios de correos y telecomunicaciones">Servicios de correos y telecomunicaciones</option>
                                    <option value="Servicios de salud">Servicios de salud</option>
                                    <option value="Servicios financieros">Servicios financieros</option>
                                    <option value="Textiles; vestidos; cuero; calzado">Textiles; vestidos; cuero; calzado</option>
                                    <option value="Software">Software</option>
                                    <option value="Tecnología e Innovación">Tecnología e Innovación</option>
                                    <option value="Salud y Bienestar">Salud y Bienestar</option>
                                    <option value="Educación y Desarrollo Académico">Educación y Desarrollo Académico</option>
                                    <option value="Finanzas y Servicios Financieros">Finanzas y Servicios Financieros</option>
                                    <option value="Arte, Entretenimiento y Creatividad">Arte, Entretenimiento y Creatividad</option>
                                    <option value="Construcción e Ingeniería Civil">Construcción e Ingeniería Civil</option>
                                    <option value="Agricultura y Agroindustria">Agricultura y Agroindustria</option>
                                    <option value="Transporte, Logística y Distribución">Transporte, Logística y Distribución</option>
                                    <option value="Energía y Recursos Naturales">Energía y Recursos Naturales</option>
                                    <option value="Turismo, Hospitalidad y Viajes">Turismo, Hospitalidad y Viajes</option>

                                </select>
                                <label>¿Sector de la empresa, emprendimiento o idea de negocio?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="'.$pre["ep16"].'" class="form-control border-start-0" name="p16" id="p16" maxlength="100">
                            <label>¿Cuál fue tu principal motivación para emprender?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '<div class="col-12"></div>';

                $data["datos"] .= '
                <div class="col-xl-12 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="'.$pre["ep17"].'" class="form-control border-start-0" name="p17" id="p17" maxlength="100">
                            <label>¿Qué recursos o apoyo necesitarías para desarrollar tu emprendimiento?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '<div class="col-12"></div>';

                if($pre["ep18"]==1){
                    $p18option='
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
                }else{
                    $p18option='
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
                }

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select  class="form-control border-start-0"  name="p18" id="p18" onchange="mostrarp18(this.value)">
                                '.$p18option.'
                            </select>
                            <label>¿Has realizado algún curso o capacitación relacionada con emprendimiento?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-8 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="'.$pre["ep19"].'"  class="form-control border-start-0" name="p19" id="p19" maxlength="50">
                            <label>¿Cuál curso o capacitación?</label>
                        </div>
                    </div>
                </div>';






                    
                $data["datos"] .= '<div class="col-12 p-4 text-right" style="margin-bottom:100px"><button type="submit" class="btn btn-success">Guardar datos</button></div>';


            $data["datos"] .= '</div>';
        $data["datos"] .= '';
        
        $results = array($data);
        echo json_encode($data);

    break;

    case 'guardaryeditar':

		$data= Array();
		$data["estado"] ="";


			$rspta=$carempresas->editarDatos($id_credencial,$p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8,$p9,$p10,$p11,$p12,$p13,$p14,$p15,$p16,$p17,$p18,$p19,$fecha);
			$datos=$rspta ? "si" : "no";	
		

		$data["estado"] = $datos;
        echo json_encode($data);
	break;

    
}

?>