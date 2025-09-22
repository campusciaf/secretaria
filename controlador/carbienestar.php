<?php
session_start();
require_once "../modelos/CarBienestar.php";

$carbienestar = new CarBienestar();
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

switch ($_GET['op']) {

    case 'verificar':
        $data= Array();
		$data["0"] ="";//iniciamos el arreglo
		    $rspta=$carbienestar->verificar($id_credencial);

        $data = $rspta ? '1' : '0';
        echo json_encode($data);

		
	break;

    case 'guardardata':
        $data= Array();
		$data["0"] ="";//iniciamos el arreglo

        $aceptodata=0;
        $rspta=$carbienestar->insertardata($id_credencial,$aceptodata,$fecha);
        $rspta ? "1" : "2";

        $data["0"] .= $rspta;

        $results = array($data);
        echo json_encode($data);

    break; 	

    case 'listarPreguntas':

        $data= Array();
		$data["datos"] ="";//iniciamos el arreglo
        $data["condi"] ="";//para saber si es hombre o mujer

        $pre=$carbienestar->listar($id_credencial);
        $data["condi"] .=$pre["genero"];//para saber si es hombre o mujer

        $data["datos"] .= '';
            $data["datos"] .= '<div class="row">';

                $data["datos"] .= '

                <div class="col-12">
                    <h6 class="title">Información de salud física y mental</h6>
                </div>';
                


                if($pre["bp1"]==1){
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
                            <label>¿Tienes alguna enfermedad física?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["bp2"].'"  id="p2_val">
                                <select class="form-control border-start-0" name="p2" id="p2">
                                    <option value="">Seleccionar</option>
                                    <option value="Artritis">Artritis</option>
                                    <option value="Asma">Asma</option>
                                    <option value="Bronquitis">Bronquitis</option>
                                    <option value="Cáncer">Cáncer</option>
                                    <option value="Colesterol-triglicéridos">Colesterol-triglicéridos</option>
                                    <option value="Diabetes">Diabetes</option>
                                    <option value="Enfermedades cardiacas">Enfermedades cardiacas</option>
                                    <option value="Epilepsia">Epilepsia</option>
                                    <option value="Hipertensión arterial">Hipertensión arterial</option>
                                    <option value="Hipoglucemia">Hipoglucemia</option>
                                    <option value="Trastorno tiroideo">Trastorno tiroideo</option>
                                    <option value="Vértigo">Vértigo</option>
                                    <option value="Anemia">Anemia</option>
                                    <option value="Artritis reumatoide">Artritis reumatoide</option>
                                    <option value="Aspergilosis">Aspergilosis</option>
                                    <option value="Celiaquía">Celiaquía</option>
                                    <option value="Cistitis">Cistitis</option>
                                    <option value="Colitis ulcerosa">Colitis ulcerosa</option>
                                    <option value="Dermatitis">Dermatitis</option>
                                    <option value="Esclerosis múltiple">Esclerosis múltiple</option>
                                    <option value="Faringitis">Faringitis</option>
                                    <option value="Fibromialgia">Fibromialgia</option>
                                    <option value="Gastritis">Gastritis</option>
                                    <option value="Gota">Gota</option>
                                    <option value="Hepatitis">Hepatitis</option>
                                    <option value="Infección urinaria">Infección urinaria</option>
                                    <option value="Insuficiencia renal">Insuficiencia renal</option>
                                    <option value="Lupus">Lupus</option>
                                    <option value="Migraña">Migraña</option>
                                    <option value="Neumonía">Neumonía</option>
                                    <option value="Obesidad">Obesidad</option>
                                    <option value="Osteoporosis">Osteoporosis</option>
                                    <option value="Parkinson">Parkinson</option>
                                    <option value="Psoriasis">Psoriasis</option>
                                    <option value="Reflujo gastroesofágico">Reflujo gastroesofágico</option>
                                    <option value="Síndrome del intestino irritable">Síndrome del intestino irritable</option>
                                    <option value="Sinusitis">Sinusitis</option>
                                    <option value="Tendinitis">Tendinitis</option>
                                    <option value="Tuberculosis">Tuberculosis</option>
                                    <option value="Úlcera péptica">Úlcera péptica</option>
                                </select>
                                <label>¿Qué enfermedad física?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-5 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["bp3"].'"  id="p3_val">
                                <select class="form-control border-start-0" name="p3" id="p3">
                                    <option value="">Seleccionar</option>
                                    <option value="No">No</option>
                                    <option value="Si">Si</option>
                                </select>
                                <label>¿Recibes algún tratamiento para esta enfermedad que padeces?</label>
                            </div>
                        </div>
                    </div>
                </div>';


                
                if($pre["bp4"]==1){
                    $p4option='
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
                }else{
                    $p4option='
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
                }

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select  class="form-control border-start-0"  name="p4" id="p4" onchange="mostrarp4(this.value)">
                                '.$p4option.'
                            </select>
                            <label>¿Has sido diagnosticado con algún trastorno mental?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["bp5"].'"  id="p5_val">
                                <select class="form-control border-start-0" name="p5" id="p5">
                                    <option value="">Seleccionar</option>
                                    <option value="Depresión">Depresión</option>
                                    <option value="Ansiedad">Ansiedad</option>
                                    <option value="Trastorno de ansiedad generalizada (TAG)">Trastorno de ansiedad generalizada (TAG)</option>
                                    <option value="Trastorno de pánico">Trastorno de pánico</option>
                                    <option value="Trastorno obsesivo-compulsivo (TOC)">Trastorno obsesivo-compulsivo (TOC)</option>
                                    <option value="Trastorno de estrés postraumático (TEPT)">Trastorno de estrés postraumático (TEPT)</option>
                                    <option value="Trastorno bipolar">Trastorno bipolar</option>
                                    <option value="Esquizofrenia">Esquizofrenia</option>
                                    <option value="Trastorno de personalidad límite (TPL)">Trastorno de personalidad límite (TPL)</option>
                                    <option value="Trastorno de la conducta alimentaria (anorexia, bulimia)">Trastorno de la conducta alimentaria (anorexia, bulimia)</option>
                                    <option value="Trastorno por déficit de atención e hiperactividad (TDAH)">Trastorno por déficit de atención e hiperactividad (TDAH)</option>
                                    <option value="Trastorno del espectro autista (TEA)">Trastorno del espectro autista (TEA)</option>
                                    <option value="Trastorno de la conducta">Trastorno de la conducta</option>
                                    <option value="Trastorno de la conducta disruptiva no especificado">Trastorno de la conducta disruptiva no especificado</option>
                                    <option value="Trastorno de conducta alimentaria no especificado">Trastorno de conducta alimentaria no especificado</option>
                                </select>
                                <label>¿Qué trastorno mental?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-5 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["bp6"].'"  id="p6_val">
                                <select class="form-control border-start-0" name="p6" id="p6">
                                    <option value="">Seleccionar</option>
                                    <option value="No">No</option>
                                    <option value="Si">Si</option>
                                </select>
                                <label>¿Recibes tratamiento médico del trastorno mental que presentas?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-7 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="'.$pre["bp7"].'"  class="form-control border-start-0" name="p7" id="p7" maxlength="100" required>
                            <label>¿Hay algún aspecto específico que desees compartir sobre tu bienestar emocional o psicológico?</label>
                        </div>
                    </div>
                </div>';


                $data["datos"] .= '
                <div class="col-xl-5 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["bp8"].'"  id="p8_val">
                                <select class="form-control border-start-0" name="p8" id="p8" required>
                                    <option value="">Seleccionar</option>
                                    <option value="EPS SURA">EPS SURA</option>
                                    <option value="Sanitas">Sanitas</option>
                                    <option value="Coomeva EPS">Coomeva EPS</option>
                                    <option value="Nueva EPS">Nueva EPS</option>
                                    <option value="Salud Total EPS">Salud Total EPS</option>
                                    <option value="EPS Famisanar">EPS Famisanar</option>
                                    <option value="Aliansalud EPS">Aliansalud EPS</option>
                                    <option value="Compensar EPS">Compensar EPS</option>
                                    <option value="Medimás EPS">Medimás EPS</option>
                                    <option value="Cruz Blanca EPS">Cruz Blanca EPS</option>
                                    <option value="FOMAG">Fondo Nacional de Prestaciones Sociales FOMAG</option>
                                    <option value="S.O.S">S.O.S</option>
                                    <option value="Sanidad">SANIDAD</option>
                                </select>
                                <label>¿A cuál EPS está afiliado actualmente?</label>
                            </div>
                        </div>
                    </div>
                </div>';



                if($pre["bp9"]==1){
                    $p9option='
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
                }else{
                    $p9option='
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
                }

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select  class="form-control border-start-0" name="p9" id="p9" onchange="mostrarp9(this.value)">
                                '.$p9option.'
                            </select>
                            <label>¿Consumes algún medicamento de manera permanente?</label>
                        </div>
                    </div>
                </div>';


                $data["datos"] .= '
                <div class="col-xl-8 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text"  value="'.$pre["bp10"].'" class="form-control border-start-0" name="p10" id="p10" maxlength="80">
                            <label>¿Qué medicamentos?</label>
                        </div>
                    </div>
                </div>';


                $data["datos"] .= '
                    <div class="col-12">
                        <h6 class="title">Información aptitudinal</h6>
                    </div>
                ';

                if($pre["bp11"]==1){
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
                <div class="col-xl-6 col-lg-3 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select  class="form-control border-start-0"  name="p11" id="p11" onchange="mostrarp11(this.value)">
                                '.$p11option.'
                            </select>
                            <label>¿Tienes alguna habilidad especial o talento que te gustaría mencionar?</label>
                        </div>
                    </div>
                </div>';


                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text"  value="'.$pre["bp12"].'"   class="form-control border-start-0" name="p12" id="p12" maxlength="80">
                            <label>¿Cual habilidad?</label>
                        </div>
                    </div>
                </div>';


               $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["bp13"].'" id="p13_val">
                                <select class="form-control border-start-0" name="p13" id="p13" required>
                                    <option value="">Seleccionar</option>
                                    <option value="No">No</option>
                                    <option value="Si">Si</option>
                                </select>
                                <label>¿Participas en actividades extracurriculares relacionadas con tus habilidades o talentos?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["bp14"].'" id="p14_val">
                                <select class="form-control border-start-0" name="p14" id="p14" required>
                                    <option value="">Seleccionar</option>
                                    <option value="No">No</option>
                                    <option value="Si">Si</option>
                                </select>
                                <label>¿Has recibido algún tipo de reconocimiento o premio por tus habilidades o talentos?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="'.$pre["bp15"].'" class="form-control border-start-0" name="p15" id="p15" maxlength="100" required>
                            <label>¿Cómo integras tus habilidades o talentos en tu vida universitaria y cotidiana?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12" >
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["bp16"].'" id="p16_val" >
                                <select class="form-control border-start-0" name="p16" id="p16" >
                                    <option value="">Seleccionar</option>
                                    <option value="Deportes">Deportes</option>
                                    <option value="Cultura">Cultura</option>
                                    <option value="Salud">Salud</option>
                                    <option value="Desarrollo humano">Desarrollo humano</option>
                                    <option value="Medio Ambiente">Medio Ambiente</option>
                                    <option value="Tecnología">Tecnología</option>
                                    <option value="Educación">Educación</option>
                                    <option value="Economía">Economía</option>
                                    <option value="Política">Política</option>
                                    <option value="Arte y Creatividad">Arte y Creatividad</option>
                                    <option value="Tercera Edad">Tercera Edad</option>
                                    <option value="Migración y Diversidad Cultural">Migración y Diversidad Cultural</option>
                                    <option value="Género y Diversidad Sexual">Género y Diversidad Sexual</option>
                                </select>
                                <label>¿Cuáles son las actividades de tu interés?</label>
                            </div>
                        </div>
                    </div>
                </div>';


                if($pre["bp17"]==1){
                    $p17option='
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
                }else{
                    $p17option='
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
                }

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select  class="form-control border-start-0"  name="p17" id="p17" onchange="mostrarp17(this.value)">
                                '.$p17option.'
                            </select>
                            <label>¿Pertenece a algún tipo de voluntariado?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="'.$pre["bp18"].'"  class="form-control border-start-0" name="p18" id="p18" maxlength="50">
                            <label>¿cuál voluntariado?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12" >
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["bp19"].'" id="p19_val" >
                                <select class="form-control border-start-0" name="p19" id="p19" >
                                    <option value="">Seleccionar</option>
                                    <option value="Monitor">Monitor</option>
                                    <option value="Líder estudiantil">Líder estudiantil</option>
                                    <option value="Participante de las actividades de Bienestar">Participante de las actividades de Bienestar</option>
                                </select>
                                <label>¿Desearía participar en CIAF cómo?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12" >
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["bp20"].'" id="p20_val" >
                                <select class="form-control border-start-0" name="p20" id="p20" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Salud mental">Salud mental</option>
                                    <option value="Violencia de género">Violencia de género</option>
                                    <option value="Meditación">Meditación</option>
                                    <option value="Técnicas de estudio">Técnicas de estudio</option>
                                    <option value="Tecnología">Tecnología</option>
                                    <option value="Inteligencia artificial">Inteligencia artificial</option>
                                    <option value="Nutrición y alimentación saludable">Nutrición y alimentación saludable</option>
                                    <option value="Ejercicio físico y entrenamiento deportivo">Ejercicio físico y entrenamiento deportivo</option>
                                    <option value="Prevención de enfermedades">Prevención de enfermedades</option>
                                    <option value="Gestión del estrés">Gestión del estrés</option>
                                    <option value="Relaciones interpersonales y habilidades sociales">Relaciones interpersonales y habilidades sociales</option>
                                    <option value="Desarrollo personal y autoayuda">Desarrollo personal y autoayuda</option>
                                    <option value="Emprendimiento y desarrollo empresarial">Emprendimiento y desarrollo empresarial</option>
                                    <option value="Innovación y creatividad">Innovación y creatividad</option>
                                    <option value="Filosofía y ética">Filosofía y ética</option>
                                    <option value="Historia y patrimonio cultural">Historia y patrimonio cultural</option>
                                    <option value="Ciencia y tecnología espaciales">Ciencia y tecnología espaciales</option>
                                    <option value="Desarrollo sostenible y responsabilidad ambiental">Desarrollo sostenible y responsabilidad ambiental</option>
                                    <option value="Justicia social y equidad">Justicia social y equidad</option>
                                    <option value="Derechos humanos y activismo">Derechos humanos y activismo</option>
                                </select>
                                <label>¿Seleccione los temas de tu interés ?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12" >
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["bp21"].'" id="p21_val" >
                                <select class="form-control border-start-0" name="p21" id="p21" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Clásica">Clásica</option>
                                    <option value="Parrandera">Parrandera</option>
                                    <option value="Rock">Rock</option>
                                    <option value="Vallenato">Vallenato</option>
                                    <option value="Salsa">Salsa</option>
                                    <option value="Romantica">Romantica</option>
                                    <option value="Pop">Pop</option>
                                    <option value="Metal">Metal</option>
                                    <option value="Andina">Andina</option>
                                    <option value="Reggaeton">Reggaeton</option>
                                    <option value="Despecho">Despecho</option>
                                    <option value="Boleros">Boleros</option>
                                    <option value="Tangos">Tangos</option>
                                    <option value="Hip-hop">Hip-hop</option>
                                    <option value="Rap">Rap</option>
                                    <option value="R&B (Rhythm and Blues)">R&B (Rhythm and Blues)</option>
                                    <option value="Jazz">Jazz</option>
                                    <option value="Blues">Blues</option>
                                    <option value="Reggae">Reggae</option>
                                    <option value="Electrónica">Electrónica</option>
                                    <option value="Folk">Folk</option>
                                    <option value="Country">Country</option>
                                    <option value="Punk">Punk</option>
                                    <option value="Indie">Indie</option>
                                    <option value="Funk">Funk</option>
                                    <option value="Soul">Soul</option>
                                    <option value="Gospel">Gospel</option>
                                    <option value="Dance">Dance</option>
                                    <option value="EDM (Electronic Dance Music)">EDM (Electronic Dance Music)</option>
                                    <option value="Ska">Ska</option>
                                    <option value="Flamenco">Flamenco</option>
                                    <option value="Merengue">Merengue</option>
                                    <option value="Cumbia">Cumbia</option>
                                    <option value="Tecno cumbia">Tecno cumbia</option>
                                    <option value="Bossa Nova">Bossa Nova</option>
                                    <option value="Trance">Trance</option>
                                    <option value="House">House</option>
                                    <option value="Techno">Techno</option>
                                    <option value="Ambient">Ambient</option>
                                    <option value="Dubstep">Dubstep</option>
                                    <option value="Soca">Soca</option>
                                    <option value="Mariachi">Mariachi</option>
                                    <option value="J-pop (Pop japonés)">J-pop (Pop japonés)</option>
                                    <option value="K-pop (Pop coreano)">K-pop (Pop coreano)</option>
                                    <option value="Bollywood">Bollywood</option>
                                    <option value="Banda">Banda</option>
                                    <option value="Grunge">Grunge</option>
                                </select>
                                <label>¿Música de tu preferencia ?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="'.$pre["bp22"].'"  class="form-control border-start-0" name="p22" id="p22" maxlength="100" required>
                            <label>¿Qué habilidades o talentos te gustaría desarrollar durante tu tiempo en la universidad?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12" >
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["bp23"].'" id="p23_val" >
                                <select class="form-control border-start-0" name="p23" id="p23" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Fútbol">Fútbol</option>
                                    <option value="Baloncesto">Baloncesto</option>
                                    <option value="Voleibol">Voleibol</option>
                                    <option value="Natación">Natación</option>
                                    <option value="Boxeo">Boxeo</option>
                                    <option value="Tenis">Tenis</option>
                                    <option value="Tenis de mesa">Tenis de mesa</option>
                                    <option value="Ajedrez">Ajedrez</option>
                                </select>
                                <label>¿Cuál es tu deporte de interés?</label>
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


			$rspta=$carbienestar->editarDatos($id_credencial,$p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8,$p9,$p10,$p11,$p12,$p13,$p14,$p15,$p16,$p17,$p18,$p19,$p20,$p21,$p22,$p23,$fecha);
			$datos=$rspta ? "si" : "no";	
		

		$data["estado"] = $datos;
        echo json_encode($data);
	break;

    
}

?>