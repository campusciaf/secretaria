<?php
session_start();
require_once "../modelos/CarInspiradores.php";

$carinspiradores = new CarInspiradores();
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
$p31=isset($_POST["p31"])? limpiarCadena($_POST["p31"]):"";

switch ($_GET['op']) {

    case 'verificar':
        $data= Array();
		$data["0"] ="";//iniciamos el arreglo
		    $rspta=$carinspiradores->verificar($id_credencial);

        $data = $rspta ? '1' : '0';
        echo json_encode($data);

		
	break;

    case 'guardardata':
        $data= Array();
		$data["0"] ="";//iniciamos el arreglo

        $aceptodata=0;
        $rspta=$carinspiradores->insertardata($id_credencial,$aceptodata,$fecha);
        $rspta ? "1" : "2";

        $data["0"] .= $rspta;

        $results = array($data);
        echo json_encode($data);

    break; 	

    case 'listarPreguntas':

        $data= Array();
		$data["datos"] ="";//iniciamos el arreglo
        $data["condi"] ="";//para saber si es hombre o mujer

        $pre=$carinspiradores->listar($id_credencial);
        $data["condi"] .=$pre["genero"];//para saber si es hombre o mujer

        $data["datos"] .= '';
            $data["datos"] .= '<div class="row">';

                $data["datos"] .= '

                <div class="col-12">
                    <h6 class="title">Información familia tradicional (padres, hermanos, hijos, pareja)</h6>
                </div>';
                
          

                if($pre["ip1"]==1){
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
                <div class="col-xl-3 col-lg-6 col-md-6 col-12" id="mostrarp1">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["ip1"].'"  id="p1_val">
                                <select class="form-control border-start-0" name="p1" id="p1" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Soltero (a)">Soltero (a)</option>
                                    <option value="Casado (o)">Casado (o)</option>
                                    <option value="Unión libre">Unión libre</option>
                                    <option value="Separado (a)">Separado (a)</option>
                                    <option value="Viudo (a)">Viudo (a)</option>
                                </select>
                                <label>Estado civil</label>
                            </div>
                        </div>
                    </div>
                </div>';

                if($pre["ip2"]==1){
                    $p2option='
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
                }else{
                    $p2option='
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
                }

                $data["datos"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select required class="form-control border-start-0"  name="p2" id="p2" onchange="mostrarp2(this.value)" required>
                                '.$p2option.'
                            </select>
                            <label>¿Tienes hijos?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12" id="mostrarp2">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["ip3"].'" id="p3_val">
                                <select class="form-control border-start-0" name="p3" id="p3">
                                    <option value="">Seleccionar</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value=">4">>4</option>
                                </select>
                                <label>¿Cuántos hijos tienes?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '<div class="col-12"></div>';
                
                if($pre["ip4"]==1){
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
                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select required class="form-control border-start-0"  name="p4" id="p4" onchange="mostrarp5(this.value)" required>
                                '.$p6option.'
                            </select>
                            <label>¿Tu padre se encuentra vivo?</label>
                        </div>
                    </div>
                </div>';


                $data["datos"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12" id="mostrarp6">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="text"  value="'.$pre["ip5"].'"  class="form-control border-start-0" name="p5" id="p5" maxlength="50">
                                <label>Nombre completo de tu padre</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12" id="mostrarp7">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="number"  value="'.$pre["ip6"].'" class="form-control border-start-0" name="p6" id="p6" maxlength="10">
                                <label>Teléfono de contacto del padre</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12" id="mostrarp8">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["ip7"].'"  id="p7_val">
                                <select class="form-control border-start-0" name="p7" id="p7">
                                    <option value="">Seleccionar</option>
                                    <option value="Básica primaria">Básica primaria</option>
                                    <option value="Básica secundaria">Básica secundaria</option>
                                    <option value="Técnico profesional">Técnico profesional</option>
                                    <option value="Tecnólogo">Tecnólogo</option>
                                    <option value="Profesional">Profesional</option>
                                    <option value="Pos-grado">Pos-grado</option>
                                </select>
                                <label>Nivel educativo de tu padre</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '<div class="col-12"></div>';
                
                if($pre["ip8"]==1){
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
                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select required class="form-control border-start-0"  name="p8" id="p8" onchange="mostrarp8(this.value)" required>
                                '.$p8option.'
                            </select>
                            <label>¿Tu madre se encuentra viva?</label>
                        </div>
                    </div>
                </div>';


                $data["datos"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12" id="mostrarp9">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="text"  value="'.$pre["ip9"].'"  class="form-control border-start-0" name="p9" id="p9" maxlength="50">
                                <label>Nombre completo de tu madre</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12" id="mostrarp10">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="number"  value="'.$pre["ip10"].'" class="form-control border-start-0" name="p10" id="p10" maxlength="10">
                                <label>Teléfono de contacto de la madre</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12" id="mostrarp11">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["ip11"].'"  id="p11_val">
                                <select class="form-control border-start-0" name="p11" id="p11">
                                    <option value="">Seleccionar</option>
                                    <option value="Básica primaria">Básica primaria</option>
                                    <option value="Básica secundaria">Básica secundaria</option>
                                    <option value="Técnico profesional">Técnico profesional</option>
                                    <option value="Tecnólogo">Tecnólogo</option>
                                    <option value="Profesional">Profesional</option>
                                    <option value="Pos-grado">Pos-grado</option>
                                </select>
                                <label>Nivel educativo de tu madre</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["ip12"].'"  id="p12_val">
                                <select class="form-control border-start-0" name="p12" id="p12">
                                    <option value="">Seleccionar</option>
                                    <option value="empleo fijo">Empleo fijo</option>
                                    <option value="trabajo independiente">Trabajo independiente</option>
                                    <option value="desempleado">Desempleado</option>
                                    <option value="empresario">Empresario</option>
                                </select>
                                <label>¿Cuál es la situación laboral actual de tus padres? </label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp13">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["ip13"].'"  id="p13_val">
                                <select class="form-control border-start-0" name="p13" id="p13">
                                    <option value="">Seleccionar</option>
                                    <option value="Tecnología">Tecnología</option>
                                    <option value="Salud">Salud</option>
                                    <option value="Educación">Educación</option>
                                    <option value="Finanzas">Finanzas</option>
                                    <option value="Arte y Entretenimiento">Arte y Entretenimiento</option>
                                    <option value="Construcción">Construcción</option>
                                    <option value="Agricultura">Agricultura</option>
                                    <option value="Transporte y Logística">Transporte y Logística</option>
                                    <option value="Energía">Energía</option>
                                    <option value="Turismo y Hostelería">Turismo y Hostelería</option>
                                    <option value="Moda y Diseño">Moda y Diseño</option>
                                    <option value="Ciencias e Investigación">Ciencias e Investigación</option>
                                    <option value="Servicios Legales">Servicios Legales</option>
                                    <option value="Marketing y Publicidad">Marketing y Publicidad</option>
                                    <option value="Manufactura">Manufactura</option>
                                    <option value="Medio Ambiente y Sostenibilidad">Medio Ambiente y Sostenibilidad</option>
                                    <option value="Recursos Humanos">Recursos Humanos</option>
                                    <option value="Deportes y Fitness">Deportes y Fitness</option>
                                    <option value="Alimentación y Bebidas">Alimentación y Bebidas</option>
                                    <option value="Bienes Raíces">Bienes Raíces</option>
                                    <option value="Telecomunicaciones">Telecomunicaciones</option>
                                    <option value="Automotriz">Automotriz</option>
                                    <option value="Servicios Sociales">Servicios Sociales</option>
                                    <option value="Editorial y Publicaciones">Editorial y Publicaciones</option>
                                    <option value="Música y Producción Musical">Música y Producción Musical</option>
                                    <option value="Fotografía y Videografía">Fotografía y Videografía</option>
                                    <option value="Consultoría">Consultoría</option>
                                    <option value="Defensa y Seguridad">Defensa y Seguridad</option>
                                    <option value="Logística y Cadena de Suministro">Logística y Cadena de Suministro</option>
                                    <option value="Biotecnología">Biotecnología</option>
                                    <option value="Minería">Minería</option>
                                    <option value="Espacio y Aeronáutica">Espacio y Aeronáutica</option>
                                    <option value="Economía y Comercio Internacional">Economía y Comercio Internacional</option>
                                    <option value="Psicología y Terapia">Psicología y Terapia</option>
                                    <option value="Parques y Recreación">Parques y Recreación</option>
                                    <option value="Gastronomía y Artes Culinarias">Gastronomía y Artes Culinarias</option>
                                    <option value="Trabajador independiente">Trabajador independiente</option>
                                    <option value="Trabajador público">Trabajador público </option>
                                    <option value="Otro">Otro</option>
                                </select>
                                <label>¿En qué industria o sector trabajan tus padres? </label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp14">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["ip14"].'"  id="p14_val">
                                <select class="form-control border-start-0" name="p14" id="p14">
                                    <option value="">Seleccionar</option>
                                    <option value="Administración de empresas">Administración de empresas</option>
                                    <option value="Contaduría pública">Contaduría pública</option>
                                    <option value="Ingeniería de software">Ingeniería de software</option>
                                    <option value="Ingeniería industrial">Ingeniería industrial</option>
                                    <option value="Seguridad y salud en el trabajo">Seguridad y salud en el trabajo</option>
                                    <option value="Técnico laboral en auxiliar de enfermería">Técnico laboral en auxiliar de enfermería</option>
                                    <option value="Técnico laboral administrativo en salud">Técnico laboral administrativo en salud</option>
                                    <option value="Técnico laboral por competencias en mecánica de motos">Técnico laboral por competencias en mecánica de motos</option>
                                    <option value="Técnico laboral en auxiliar de veterinaria y cuidado de mascotas">Técnico laboral en auxiliar de veterinaria y cuidado de mascotas</option>
                                    <option value="Diplomado Marketing Digital para Pymes">Diplomado Marketing Digital para Pymes</option>
                                    <option value="Curso Video Pitch-Vende tu proyecto en 3 minutos">Curso Video Pitch-Vende tu proyecto en 3 minutos</option>
                                    <option value="Diplomado en Barismo">Diplomado en Barismo</option>
                                    <option value="Diplomado en Formulación de Proyectos">Diplomado en Formulación de Proyectos</option>
                                    <option value="Curso de Diseño de Producto y Experiencias Turísticas">Curso de Diseño de Producto y Experiencias Turísticas</option>
                                    <option value="Curso De Piloto Profesional De Dron">Curso De Piloto Profesional De Dron</option>
                                    <option value="Seminario taller en Declaración Renta Persona Natural">Seminario taller en Declaración Renta Persona Natural</option>
                                    <option value="Diplomado de Excel">Diplomado de Excel</option>
                                    <option value="Diplomado en Docencia Universitaria">Diplomado en Docencia Universitaria</option>
                                </select>
                                <label>¿Qué cursos o diplomados de interés para tus padres? </label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '<div class="col-12"></div>';

                if($pre["ip15"]==1){
                    $p15option='
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
                }else{
                    $p15option='
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
                }

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select required class="form-control border-start-0"  name="p15" id="p15" onchange="mostrarp15(this.value)" required>
                                '.$p15option.'
                            </select>
                            <label>¿Tienes pareja actualmente?</label>
                        </div>
                    </div>
                </div>';


                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp16">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="text"  value="'.$pre["ip16"].'"  class="form-control border-start-0" name="p16" id="p16" maxlength="50">
                                <label>¿Nombre de tu pareja?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp17">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="text"  value="'.$pre["ip17"].'" class="form-control border-start-0" name="p17" id="p17" maxlength="10">
                                <label>¿Número de celular de tu pareja?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '<div class="col-12"></div>';

                if($pre["ip18"]==1){
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
                            <select required class="form-control border-start-0"  name="p18" id="p18" onchange="mostrarp18(this.value)" required>
                                '.$p18option.'
                            </select>
                            <label>¿Tienes hermanos?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp19">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["ip19"].'" id="p19_val">
                                <select class="form-control border-start-0" name="p19" id="p19">
                                    <option value="">Seleccionar</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value=">4">>4</option>
                                </select>
                                <label>¿Cuántos hermanos tienes?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-8 col-md-6 col-12" id="mostrarp20">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["ip20"].'" id="p20_val">
                                <select class="form-control border-start-0" name="p20" id="p20">
                                    <option value="">Seleccionar</option>
                                    <option value="0-5">0-5 Años</option>
                                    <option value="0-13">0-13 Años</option>
                                    <option value="0-18">0-18 Años</option>
                                    <option value="0-25">0-25 Años</option>
                                    <option value=">26">>26 Años</option>
                                </select>
                                <label>¿En qué rango de edad se encuentran tus hermanos?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '<div class="col-12"></div>';

                
                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp21">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["ip21"].'" id="p21_val">
                                <select class="form-control border-start-0" name="p21" id="p21">
                                    <option value="">Seleccionar</option>
                                    <option value="Papá">Papá</option>
                                    <option value="Mamá">Mamá</option>
                                    <option value="Papá y Mamá">Papá y Mamá</option>
                                    <option value="Solo">Solo</option>
                                    <option value="Hijos">Hijos</option>
                                    <option value="Pareja">Pareja</option>
                                    <option value="Hermanos(a)">Hermanos(a)</option>
                                    <option value="Tios(a)">Tios(a)</option>
                                    <option value="Amigo(a)">Amigo(a)</option>
                                </select>
                                <label>¿Con quién vive?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                
                if($pre["ip22"]==1){
                    $p22option='
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
                }else{
                    $p22option='
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
                }

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select required class="form-control border-start-0"  name="p22" id="p22" onchange="mostrarp22(this.value)" required>
                                '.$p22option.'
                            </select>
                            <label>¿Tienes personas a tu cargo?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp23">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["ip23"].'" id="p23_val">
                                <select class="form-control border-start-0" name="p23" id="p23">
                                    <option value="">Seleccionar</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value=">4">>4</option>
                                </select>
                                <label>¿Cuántas personas tienes a cargo?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-12">
                    <h6 class="title">Información del inspirador</h6>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp24">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["ip24"].'" id="p24_val">
                                <select class="form-control border-start-0" name="p24" id="p24" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Padre">Padre</option>
                                    <option value="Madre">Madre</option>
                                    <option value="Abuelo (a)">Abuelo (a)</option>
                                    <option value="Tío (a)">Tío (a)</option>
                                    <option value="Primo (a)">Primo (a)</option>
                                    <option value="Amigo (a)">Amigo (a) </option>
                                    <option value="Esposo (a)">Esposo (a)</option>
                                    <option value="Hijo (a)">Hijo (a)</option>
                                </select>
                                <label>¿Quién es la persona que te inspiró a estudiar ?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="'.$pre["ip25"].'" required class="form-control border-start-0" name="p25" id="p25" maxlength="150">
                            <label>¿Cuál es el nombre de tu inspirador? </label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="number" value="'.$pre["ip26"].'" required class="form-control border-start-0" name="p26" id="p26" maxlength="20">
                            <label>WhatsApp del inspirador </label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="email" value="'.$pre["ip27"].'" required class="form-control border-start-0" name="p27" id="p27" maxlength="60">
                            <label>Correo electrónico del inspirador</label>
                        </div>
                    </div>
                </div>';
                
                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp28">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["ip28"].'"  id="p28_val">
                                <select class="form-control border-start-0" name="p28" id="p28" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Básica primaria">Básica primaria</option>
                                    <option value="Básica secundaria">Básica secundaria</option>
                                    <option value="Técnico profesional">Técnico profesional</option>
                                    <option value="Tecnólogo">Tecnólogo</option>
                                    <option value="Profesional">Profesional</option>
                                    <option value="Especialista">Especialista</option>
                                    <option value="Magíster">Magíster</option>
                                    <option value="Doctor">Doctor</option>
                                    <option value="PH">PH</option>
                                    <option value="No sabe">No sabe</option>
                                </select>
                                <label>¿Nivel de formación de tu inspirador?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp29">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["ip29"].'"  id="p29_val">
                                <select class="form-control border-start-0" name="p29" id="p29" required>
                                    <option value="">Seleccionar</option>
                                    <option value="empleo fijo">Empleo fijo</option>
                                    <option value="trabajo independiente">Trabajo independiente</option>
                                    <option value="desempleado">Desempleado</option>
                                    <option value="empresario">Empresario</option>
                                </select>
                                <label>¿Cuál es la situación laboral actual de tu inspirador? </label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp30">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["ip30"].'"  id="p30_val">
                                <select class="form-control border-start-0" name="p30" id="p30" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Tecnología">Tecnología</option>
                                    <option value="Salud">Salud</option>
                                    <option value="Educación">Educación</option>
                                    <option value="Finanzas">Finanzas</option>
                                    <option value="Arte y Entretenimiento">Arte y Entretenimiento</option>
                                    <option value="Construcción">Construcción</option>
                                    <option value="Agricultura">Agricultura</option>
                                    <option value="Transporte y Logística">Transporte y Logística</option>
                                    <option value="Energía">Energía</option>
                                    <option value="Turismo y Hostelería">Turismo y Hostelería</option>
                                    <option value="Moda y Diseño">Moda y Diseño</option>
                                    <option value="Ciencias e Investigación">Ciencias e Investigación</option>
                                    <option value="Servicios Legales">Servicios Legales</option>
                                    <option value="Marketing y Publicidad">Marketing y Publicidad</option>
                                    <option value="Manufactura">Manufactura</option>
                                    <option value="Medio Ambiente y Sostenibilidad">Medio Ambiente y Sostenibilidad</option>
                                    <option value="Recursos Humanos">Recursos Humanos</option>
                                    <option value="Deportes y Fitness">Deportes y Fitness</option>
                                    <option value="Alimentación y Bebidas">Alimentación y Bebidas</option>
                                    <option value="Bienes Raíces">Bienes Raíces</option>
                                    <option value="Telecomunicaciones">Telecomunicaciones</option>
                                    <option value="Automotriz">Automotriz</option>
                                    <option value="Servicios Sociales">Servicios Sociales</option>
                                    <option value="Editorial y Publicaciones">Editorial y Publicaciones</option>
                                    <option value="Música y Producción Musical">Música y Producción Musical</option>
                                    <option value="Fotografía y Videografía">Fotografía y Videografía</option>
                                    <option value="Consultoría">Consultoría</option>
                                    <option value="Defensa y Seguridad">Defensa y Seguridad</option>
                                    <option value="Logística y Cadena de Suministro">Logística y Cadena de Suministro</option>
                                    <option value="Biotecnología">Biotecnología</option>
                                    <option value="Minería">Minería</option>
                                    <option value="Espacio y Aeronáutica">Espacio y Aeronáutica</option>
                                    <option value="Economía y Comercio Internacional">Economía y Comercio Internacional</option>
                                    <option value="Psicología y Terapia">Psicología y Terapia</option>
                                    <option value="Parques y Recreación">Parques y Recreación</option>
                                    <option value="Gastronomía y Artes Culinarias">Gastronomía y Artes Culinarias</option>
                                    <option value="Trabajador independiente">Trabajador independiente</option>
                                    <option value="Trabajador público">Trabajador público </option>
                                    <option value="Otro">Otro</option>
                                </select>
                                <label>¿En qué industria o sector trabaja tu inspirador?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-8 col-lg-6 col-md-6 col-12" id="mostrarp31">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["ip31"].'" id="p31_val">
                                <select class="form-control border-start-0" name="p31" id="p31" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Administración de empresas">Administración de empresas</option>
                                    <option value="Contaduría pública">Contaduría pública</option>
                                    <option value="Ingeniería de software">Ingeniería de software</option>
                                    <option value="Ingeniería industrial">Ingeniería industrial</option>
                                    <option value="Seguridad y salud en el trabajo">Seguridad y salud en el trabajo</option>
                                    <option value="Técnico laboral en auxiliar de enfermería">Técnico laboral en auxiliar de enfermería</option>
                                    <option value="Técnico laboral administrativo en salud">Técnico laboral administrativo en salud</option>
                                    <option value="Técnico laboral por competencias en mecánica de motos">Técnico laboral por competencias en mecánica de motos</option>
                                    <option value="Técnico laboral en auxiliar de veterinaria y cuidado de mascotas">Técnico laboral en auxiliar de veterinaria y cuidado de mascotas</option>
                                    <option value="Diplomado Marketing Digital para Pymes">Diplomado Marketing Digital para Pymes</option>
                                    <option value="Curso Video Pitch-Vende tu proyecto en 3 minutos">Curso Video Pitch-Vende tu proyecto en 3 minutos</option>
                                    <option value="Diplomado en Barismo">Diplomado en Barismo</option>
                                    <option value="Diplomado en Formulación de Proyectos">Diplomado en Formulación de Proyectos</option>
                                    <option value="Curso de Diseño de Producto y Experiencias Turísticas">Curso de Diseño de Producto y Experiencias Turísticas</option>
                                    <option value="Curso De Piloto Profesional De Dron">Curso De Piloto Profesional De Dron</option>
                                    <option value="Seminario taller en Declaración Renta Persona Natural">Seminario taller en Declaración Renta Persona Natural</option>
                                    <option value="Diplomado de Excel">Diplomado de Excel</option>
                                    <option value="Diplomado en Docencia Universitaria">Diplomado en Docencia Universitaria</option>
                                    
                                </select>
                                <label>¿Qué cursos o diplomados de interés para tu inspirador?</label>
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


			$rspta=$carinspiradores->editarDatos($id_credencial,$p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8,$p9,$p10,$p11,$p12,$p13,$p14,$p15,$p16,$p17,$p18,$p19,$p20,$p21,$p22,$p23,$p24,$p25,$p26,$p27,$p28,$p29,$p30,$p31,$fecha);
			$datos=$rspta ? "si" : "no";	
		

		$data["estado"] = $datos;
        echo json_encode($data);
	break;

    
}

?>