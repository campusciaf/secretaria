<?php
session_start();
require_once "../modelos/CarExperiencia.php";

$carexperiencia = new CarExperiencia();
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
		    $rspta=$carexperiencia->verificar($id_credencial);

        $data = $rspta ? '1' : '0';
        echo json_encode($data);

		
	break;

    case 'guardardata':
        $data= Array();
		$data["0"] ="";//iniciamos el arreglo

        $aceptodata=0;
        $rspta=$carexperiencia->insertardata($id_credencial,$aceptodata,$fecha);
        $rspta ? "1" : "2";

        $data["0"] .= $rspta;

        $results = array($data);
        echo json_encode($data);

    break; 	

    case 'listarPreguntas':

        $data= Array();
		$data["datos"] ="";//iniciamos el arreglo
        $data["condi"] ="";//para saber si es hombre o mujer

        $pre=$carexperiencia->listar($id_credencial);
        $data["condi"] .=$pre["genero"];//para saber si es hombre o mujer

        $data["datos"] .= '';
            $data["datos"] .= '<div class="row">';

                $data["datos"] .= '

                <div class="col-12">
                    <h6 class="title">Información básica</h6>
                </div>';
           


                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp1">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["eap1"].'"  id="p1_val">
                                <select class="form-control border-start-0" name="p1" id="p1" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Interés y pasión por el aprendizaje">Interés y pasión por el aprendizaje</option>
                                    <option value="Mejoras laborales y profesionales">Mejoras laborales y profesionales</option>
                                    <option value="Influencia y apoyo de figuras cercanas">Influencia y apoyo de figuras cercanas</option>
                                    <option value="Búsqueda de estabilidad y seguridad">Búsqueda de estabilidad y seguridad</option>
                                    <option value="Desarrollo personal y crecimiento">Desarrollo personal y crecimiento</option>
                                    <option value="Necesidades académicas y profesionales">Necesidades académicas y profesionales</option>
                                    <option value="Exploración y descubrimiento de nuevas áreas">Exploración y descubrimiento de nuevas áreas</option>
                                    <option value="Superación y desafío personal">Superación y desafío personal</option>
                                    <option value="Necesidades económicas y financieras">Necesidades económicas y financieras</option>
                                    <option value="Contribución a la sociedad y comunidad">Contribución a la sociedad y comunidad</option>
                                </select>
                                <label>¿Qué te motivó a estudiar</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp2">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["eap2"].'"  id="p2_val">
                                <select class="form-control border-start-0" name="p2" id="p2" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Visitó nuestra sede">Visitó nuestra sede</option>
                                    <option value="Redes sociales">Redes sociales</option>
                                    <option value="Página web">Página web</option>
                                    <option value="Lo refirió un amigo y/o familia">Lo refirió un amigo y/o familia </option>
                                    <option value="Publicidad">Publicidad</option>
                                </select>
                                <label>¿Cómo te enteraste de CIAF?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp3">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["eap3"].'"  id="p3_val">
                                <select class="form-control border-start-0" name="p3" id="p3" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Herramientas digitales">Herramientas digitales</option>
                                    <option value="Matemáticas">Matemáticas</option>
                                    <option value="Inteligencia Artificial">Inteligencia Artificial</option>
                                    <option value="Marketing Digital">Marketing Digital</option>
                                    <option value="Liderazgo">Liderazgo</option>
                                    <option value="Lecto-escritura">Lecto-escritura</option>
                                    <option value="Matemáticas y analítica">Matemáticas y analítica</option>
                                    <option value="Oratoria">Oratoria</option>
                                    <option value="Relaciones sociales">Relaciones sociales</option>
                                    <option value="Programación y Desarrollo de Software">Programación y Desarrollo de Software</option>
                                    <option value="Gestión de Proyectos">Gestión de Proyectos</option>
                                    <option value="Análisis de Datos">Análisis de Datos</option>
                                    <option value="Creación de Contenido Digital">Creación de Contenido Digital</option>
                                    <option value="Planificación Estratégica">Planificación Estratégica</option>
                                    <option value="Emprendimiento y Startups">Emprendimiento y Startups</option>
                                    <option value="Ninguna">Ninguna</option>
                                </select>
                                <label>¿Cuál de las siguientes áreas es de tu preferencia?</label>
                            </div>
                        </div>
                    </div>
                </div>';
             

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp4">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["eap4"].'"  id="p4_val">
                                <select class="form-control border-start-0" name="p4" id="p4">
                                    <option value="">Seleccionar</option>
                                    <option value="Haciendo">Haciendo</option>
                                    <option value="Viendo">Viendo</option>
                                    <option value="Escuchando">Escuchando</option>
                                    <option value="Leyendo">Leyendo</option>
                                    <option value="Escribiendo">Escribiendo</option>
                                </select>
                                <label>¿De qué manera aprendes más fácil?</label>
                            </div>
                        </div>
                    </div>
                </div>';


                if($pre["eap5"]==1){
                    $p5option='
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
                }else{
                    $p5option='
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
                }

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select required class="form-control border-start-0"  name="p5" id="p5" onchange="mostrarp5(this.value)">
                                '.$p5option.'
                            </select>
                            <label>¿Te gustaría realizar una doble titulación en nuestros programas?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp6">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["eap6"].'" id="p6_val">
                                <select class="form-control border-start-0" name="p6" id="p6">
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
                                <label>¿Qué programa te interesaría?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                if($pre["eap7"]==1){
                    $p7option='
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
                }else{
                    $p7option='
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
                }

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select required class="form-control border-start-0" name="p7" id="p7" onchange="mostrarp7(this.value)">
                                '.$p7option.'
                            </select>
                            <label>¿Dominas un segundo idioma?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp8">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["eap8"].'" id="p8_val">
                                <select class="form-control border-start-0" name="p8" id="p8">
                                    <option value="">Seleccionar</option>
                                    <option value="Mandarín">Mandarín</option>
                                    <option value="Español">Español</option>
                                    <option value="Francés">Francés</option>
                                    <option value="Árabe">Árabe</option>
                                    <option value="Alemán">Alemán</option>
                                    <option value="Japonés">Japonés</option>
                                    <option value="Ruso">Ruso</option>
                                    <option value="Portugués">Portugués</option>
                                    <option value="Italiano">Italiano</option>
                                    <option value="Inglés">Inglés</option>
                                    <option value="Hindi>Hindi</option>
                                    <option value="Coreano">Coreano</option>
                                    <option value="Holandés">Holandés</option>
                                    <option value="Sueco">Sueco</option>
                                    <option value="Turco">Turco</option>
                                    <option value="Polaco">Polaco</option>
                                    <option value="Danés">Danés</option>
                                    <option value="Griego">Griego</option>
                                    <option value="Hebreo">Hebreo</option>
                                    <option value="Swahili">Swahili</option>
                                    <option value="Tailandés">Tailandés</option>
                                    <option value="Latín">Latín</option>

                                </select>
                                <label>¿Qué idioma?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp9">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["eap9"].'"  id="p9_val">
                                <select class="form-control border-start-0" name="p9" id="p9">
                                    <option value="">Seleccionar</option>
                                    <option value="Básico">Básico</option>
                                    <option value="Intermedio">Intermedio</option>
                                    <option value="Avanzado">Avanzado</option>

                                </select>
                                <label>¿En qué nivel te encuentras?</label>
                            </div>
                        </div>
                    </div>
                </div>';


                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="'.$pre["eap10"].'" class="form-control border-start-0" name="p10" id="p10" maxlength="100" required>
                            <label>¿Cuál es el nombre completo de tu segundo contacto de emergencia?</label>
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


			$rspta=$carexperiencia->editarDatos($id_credencial,$p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8,$p9,$p10,$fecha);
			$datos=$rspta ? "si" : "no";	
		

		$data["estado"] = $datos;
        echo json_encode($data);
	break;

    
}

?>