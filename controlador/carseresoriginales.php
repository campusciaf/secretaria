<?php
session_start();
require_once "../modelos/CarSeresOriginales.php";

$carseresoriginales = new CarSeresOriginales();
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
$p21=isset($_POST["p21"])? limpiarCadena($_POST["p21"]):"";
$p22=isset($_POST["p22"])? limpiarCadena($_POST["p22"]):"";
$p23=isset($_POST["p23"])? limpiarCadena($_POST["p23"]):"";
$p24=isset($_POST["p24"])? limpiarCadena($_POST["p24"]):"";
$p25=isset($_POST["p25"])? limpiarCadena($_POST["p25"]):"";
$p26=isset($_POST["p26"])? limpiarCadena($_POST["p26"]):"";
$p27=isset($_POST["p27"])? limpiarCadena($_POST["p27"]):"";
$p28=isset($_POST["p28"])? limpiarCadena($_POST["p28"]):"";
$p29=isset($_POST["p29"])? limpiarCadena($_POST["p29"]):"";
$p30=isset($_POST["p30"])? limpiarCadena($_POST["p30"]):"";

switch ($_GET['op']) {

    case 'verificar':
        $data= Array();
		$data["0"] ="";//iniciamos el arreglo
		    $rspta=$carseresoriginales->verificar($id_credencial);

        $data = $rspta ? '1' : '0';
        echo json_encode($data);

		
	break;

    case 'guardardata':
        $data= Array();
		$data["0"] ="";//iniciamos el arreglo

        $aceptodata=0;
        $rspta=$carseresoriginales->insertardata($id_credencial,$aceptodata,$fecha);
        $rspta ? "1" : "2";

        $data["0"] .= $rspta;

        $results = array($data);
        echo json_encode($data);

    break; 	

    case 'listarPreguntas':

        $data= Array();
		$data["datos"] ="";//iniciamos el arreglo
        $data["condi"] ="";//para saber si es hombre o mujer

        $pre=$carseresoriginales->listar($id_credencial);
        $data["condi"] .=$pre["genero"];//para saber si es hombre o mujer

        $data["datos"] .= '';
            $data["datos"] .= '<div class="row">';

                $data["datos"] .= '

                <div class="col-12">
                    <h6 class="title">Información básica</h6>
                </div>';
                
                if($pre["genero"]=="Femenino"){ // estas embarazada

                    if($pre["p1"]==1){
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
                    <div class="col-xl-2 col-lg-3 col-md-6 col-12">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <select required class="form-control border-start-0"  name="p1" id="p1" onchange="mostrarp1(this.value)">
                                    '.$p1option.'
                                </select>
                                <label>¿Estás embarazada?</label>
                            </div>
                        </div>
                    </div>';

                    $data["datos"] .= '
                    <div class="col-xl-3 col-lg-6 col-md-6 col-12" id="mostrarp2">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <div class="form-floating">
                                    <input type="hidden" value="'.$pre["p2"].'"  id="p2_val">
                                    <select class="form-control border-start-0" name="p2" id="p2">
                                        <option value="">Seleccionar</option>
                                        <option value="1">1 Mes</option>
                                        <option value="2">2 Meses</option>
                                        <option value="3">3 Meses</option>
                                        <option value="4">4 Meses</option>
                                        <option value="5">5 Meses</option>
                                        <option value="6">6 Meses</option>
                                        <option value="7">7 Meses</option>
                                        <option value="8">8 Meses</option>
                                        <option value="9">9 Meses</option>
                                    </select>
                                    <label>¿Cuántos meses de embarazo tienes?</label>
                                </div>
                            </div>
                        </div>
                    </div>';
                }

                
                if($pre["p3"]==1){
                    $p3option='
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
                }else{
                    $p3option='
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
                }

                $data["datos"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select required class="form-control border-start-0"  name="p3" id="p3" onchange="mostrarp3(this.value)">
                                '.$p3option.'
                            </select>
                            <label>¿Eres desplazado(a) por la violencia?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp4">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["p4"].'"  id="p4_val">
                                <select class="form-control border-start-0" name="p4" id="p4">
                                    <option value="">Seleccionar</option>
                                    <option value="Conflicto armado">Conflicto armado</option>
                                    <option value="Social">Social</option>
                                    <option value="Económico">Económico</option>
                                </select>
                                <label>¿qué tipo de desplazamiento has experimentado?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-5 col-lg-6 col-md-6 col-12" id="mostrarp5">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["p5"].'"  id="p5_val">
                                <select class="form-control border-start-0" name="p5" id="p5">
                                    <option value="">Seleccionar</option>
                                    <option value="Adulto mayor">Adulto mayor</option>
                                    <option value="Ciudadano Rural">Ciudadano Rural</option>
                                    <option value="Comunidad Negra, Afrocolombiano, Palenquero, Raizal">Comunidad Negra, Afrocolombiano, Palenquero, Raizal</option>
                                    <option value="Desplazado">Desplazado</option>
                                    <option value="Indígena">Indígena</option>
                                    <option value="Madre cabeza de familia">Madre cabeza de familia</option>
                                    <option value="Madre comunitaria">Madre comunitaria</option>
                                    <option value="Mujer embarazada">Mujer embarazada</option>
                                    <option value="Ninguna de las anteriores">Ninguna de las anteriores</option>
                                    <option value="Otras entidades">Otras entidades</option>
                                    <option value="Persona en condición con discapacidad">Persona en condición con discapacidad</option>
                                    <option value="Personas en situación de pobreza extrema (Sisben 1)">Personas en situación de pobreza extrema (Sisben 1)</option>
                                    <option value="Víctima de la violencia">Víctima de la violencia</option>
                                </select>
                                <label>¿A qué grupo poblacional perteneces?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                if($pre["p6"]==1){
                    $p6option='
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
                }else{
                    $p6option='
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
                }

                $data["datos"] .= '
                <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select required class="form-control border-start-0"  name="p6" id="p6" onchange="mostrarp6(this.value)">
                                '.$p6option.'
                            </select>
                            <label>¿Perteneces a la comunidad LGBTIQ+?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp7">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["p7"].'"  id="p7_val">
                                <select class="form-control border-start-0" name="p7" id="p7">
                                    <option value="">Seleccionar</option>
                                    <option value="Lesbiana">Lesbiana</option>
                                    <option value="gay">gay</option>
                                    <option value="bisexual">bisexual</option>
                                    <option value="transgenero">transgenero</option>
                                    <option value="Intersexual">Intersexual</option>
                                    <option value="Queer">Queer</option>
                                    <option value="No Binario">No Binario</option>
                                </select>
                                <label>¿Perteneces a la comunidad LGBTIQ</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                    <div class="col-12">
                        <h6 class="title">Información básica de contactos de emergencia</h6>
                    </div>
                ';

                
                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="'.$pre["p8"].'" required class="form-control border-start-0" name="p8" id="p8" maxlength="50">
                            <label>¿Cuál es el nombre completo de tu primer contacto de emergencia?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp5">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["p9"].'"  id="p9_val">
                                <select class="form-control border-start-0" name="p9" id="p9">
                                    <option value="">Seleccionar</option>
                                    <option value="Madre">Madre</option>
                                    <option value="Padre">Padre</option>
                                    <option value="Hermano (a)">Hermano (a)</option>
                                    <option value="Abuelo (a)">Abuelo (a)</option>
                                    <option value="Tío (a)">Tío (a)</option>
                                    <option value="Esposo (a)">Esposo (a)</option>
                                    <option value="Primo (a)">Primo (a)</option>
                                    <option value="Amigo (a)">Amigo (a)</option>
                                </select>
                                <label>¿Cuál es tu relación o parentesco con esta persona?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="email"  value="'.$pre["p10"].'"  required class="form-control border-start-0" name="p10" id="p10" maxlength="50">
                            <label>¿Cuál es el correo electrónico de este contacto de emergencia?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text"  value="'.$pre["p11"].'"  required class="form-control border-start-0" name="p11" id="p11" maxlength="10">
                            <label>Teléfono del contacto de emergencia</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '<div class="col-12"></div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="'.$pre["p12"].'" class="form-control border-start-0" name="p12" id="p12" maxlength="50">
                            <label>¿Cuál es el nombre completo de tu segundo contacto de emergencia?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp5">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["p13"].'"  id="p13_val">
                                <select class="form-control border-start-0" name="p13" id="p13">
                                    <option value="">Seleccionar</option>
                                    <option value="Madre">Madre</option>
                                    <option value="Padre">Padre</option>
                                    <option value="Hermano (a)">Hermano (a)</option>
                                    <option value="Abuelo (a)">Abuelo (a)</option>
                                    <option value="Tío (a)">Tío (a)</option>
                                    <option value="Esposo (a)">Esposo (a)</option>
                                    <option value="Primo (a)">Primo (a)</option>
                                    <option value="Amigo (a)">Amigo (a)</option>
                                </select>
                                <label>¿Cuál es tu relación o parentesco con esta persona?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="email"  value="'.$pre["p14"].'" class="form-control border-start-0" name="p14" id="p14" maxlength="50">
                            <label>¿Cuál es el correo electrónico de este contacto de emergencia?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text"  value="'.$pre["p15"].'" class="form-control border-start-0" name="p15" id="p15" maxlength="10">
                            <label>Teléfono del contacto de emergencia</label>
                        </div>
                    </div>
                </div>';


                $data["datos"] .= '
                <div class="col-12">
                    <h6 class="title">Información de conectividad</h6>
                </div>
                ';

                $data["datos"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12" id="mostrarp5">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["p16"].'"  id="p16_val" required>
                                <select class="form-control border-start-0" name="p16" id="p16" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Computador portatil">Computador portatil</option>
                                    <option value="Computador de mesa">Computador de mesa</option>
                                    <option value="Tablet">Tablet </option>
                                    <option value="No cuento con computador">No cuento con computador </option>
                                </select>
                                <label>¿Tienes un computador o tablet?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp5">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["p17"].'"  id="p17_val">
                                <select class="form-control border-start-0" name="p17" id="p17" required>
                                    <option value="">Seleccionar</option>
                                    <option value="No cuento con internet">No cuento con internet</option>
                                    <option value="Con velocidad menos a 10mb">Con velocidad menos a 10mb</option>
                                    <option value="Con velocidad entre 10mb y 40mb">Con velocidad entre 10mb y 40mb</option>
                                    <option value="Con velocidad entre 40mb y 80mb">Con velocidad entre 40mb y 80mb </option>
                                    <option value="Con velocidad entre 80mb y 120 mb">Con velocidad entre 80mb y 120 mb</option>
                                    <option value="Con velocidad entre 120mb y 200mb">Con velocidad entre 120mb y 200mb</option>
                                    <option value="Con velocidad entre 200mb y 280mb">Con velocidad entre 200mb y 280mb</option>
                                    <option value="Con velocidad entre 280mb y 350mb">Con velocidad entre 280mb y 350mb</option>
                                    <option value="Con velocidad mayor a 350mb">Con velocidad mayor a 350mb</option>
                                </select>
                                <label>¿Tienes conexión a internet en casa?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp5">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["p18"].'"  id="p18_val">
                                <select class="form-control border-start-0" name="p18" id="p18" required>
                                    <option value="">Seleccionar</option>
                                    <option value="No">No</option>
                                    <option value="Si">Si</option>
                                </select>
                                <label>¿Tienes planes de datos en tu celular?</label>
                            </div>
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


			$rspta=$carseresoriginales->editarDatos($id_credencial,$p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8,$p9,$p10,$p11,$p12,$p13,$p14,$p15,$p16,$p17,$p18,$fecha);
			$datos=$rspta ? "si" : "no";	
		

		$data["estado"] = $datos;
        echo json_encode($data);
	break;

    
}

?>