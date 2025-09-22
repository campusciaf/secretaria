<?php
require_once "../modelos/Evaluaciondocente.php";
$evaluacion = new Evaluacion();
date_default_timezone_set("America/Bogota");	

$fecha=date('Y-m-d');
$hora=date('H:i:s');

switch ($_GET['op']) {

    case 'listar':
        $data = array(); //Vamos a declarar un arra
		$data["conte"] = ""; //iniciamos el arreglo
        $consulta_programas = $evaluacion->consulta_programas($_SESSION['id_usuario']);
        
        for ($i = 0; $i < count($consulta_programas); $i++) {
            $nombreprograma=$consulta_programas[$i]['fo_programa'];
            $id_estudiante=$consulta_programas[$i]['id_estudiante'];
            $ciclo=$consulta_programas[$i]['ciclo'];
            $evaluados=0;// contiene el numero de evaluaciones terminadas por el estudiante
            $data["conte"] .='
                <div class="col-xl-4 col-lg-4 col-md-6 col-12 mb-4 pb-4 mr-2">
                    <div class="row align-items-center tono-1 py-4 mb-4">
                        <div class="col-auto">
                            <i class="fa-regular fa-user avatar bg-light-blue rounded"></i>
                        </div>
                        <div class="col">
                            <h6 class="fw-medium mb-0">'.$nombreprograma.'</h6>
                        </div>

                    </div>
                    <div class="px-0">';  
                     
                        $consulta_materias = $evaluacion->consulta_materias($id_estudiante, $ciclo);// consulta para traer las materias matriculadas por el estudiante
                        $reales=count($consulta_materias);
                        for ($a = 0; $a < count($consulta_materias); $a++) {
                            
                            $nombremateria=$consulta_materias[$a]["nombre_materia"];
                            $jornada_e=$consulta_materias[$a]['jornada'];
                            $semestre=$consulta_materias[$a]['semestre'];
                            $programa=$consulta_materias[$a]['programa'];
                            $grupo=$consulta_materias[$a]['grupo'];

                            $traeridmateria=$evaluacion->traeridmateria($nombremateria,$programa);// consulta para taer el id de la materia
                            $idmateria=$traeridmateria["id"];

                            $consulta_grupo = $evaluacion->consulta_grupo($idmateria, $jornada_e,$semestre , $programa, $grupo);// consulta para traer el docente que da la asignatura
                            $id_docente_grupo=$consulta_grupo['id_docente_grupo'];
                            $id_docente=$consulta_grupo['id_docente'];

                            $datos_docente = $evaluacion->datos_docente($id_docente);// consulta para traer los datos del docente

                                if($datos_docente){// si hay docente
                                    $nombre=$datos_docente['usuario_nombre'] . ' ' . $datos_docente['usuario_nombre_2'] . ' ' . $datos_docente['usuario_apellido'] . ' ' . $datos_docente['usuario_apellido_2'];
                               
                                    if (file_exists('../files/docentes/' . $datos_docente['usuario_identificacion'] . '.jpg')) {
                                        $foto = '<img src=../files/docentes/' . $datos_docente['usuario_identificacion'] . '.jpg width=50px height=50px class=user-image>';
                                    } else {
                                        $foto = '<img src=../files/null.jpg width=50px height=50px class=user-image>';
                                    }
                                }else{
                                    $nombre="Por asignar";
                                    $foto = '<img src=../files/null.jpg width=50px height=50px class=user-image>';
                                }
                                

                                $consulta_respondio = $evaluacion->consulta_respondio($id_docente_grupo,$id_docente,$id_estudiante);
                                $total=$consulta_respondio["total"];
                                if($consulta_respondio){
                                    $boton='Evaluado';
                                    $evaluados++;
                                }else{
    
                                    $boton = '<a class="btn btn-primary text-white" onclick="preguntas('.$id_docente_grupo.','.$id_docente.','.$id_estudiante.')">Evaluar</a>';

                                }
                            
                               if( $nombre =="Por asignar"){
                                $reales--;
                               }else{

                                    $data["conte"] .='    
                                        <div class="row align-items-center tono-3 border-bottom ">
                                            <div class="col-auto">
                                                '.$foto.'
                                            </div>
                                            <div class="col-8">
                                                <p class="mb-0">'.$nombre.'</p>
                                                <p class="text-secondary small">'.$nombremateria.' ' . count($consulta_materias).'</p>
                                            </div>
                                            <div class="col-xl-auto col-2 ps-0 text-end">
                                                '.$boton.'
                                            </div>
                                        </div>     
                                    ';
                                }
                            
                        }
                        if($evaluados == $reales){
                            $data["conte"] .='<a onclick="terminar()" class="btn btn-success text-white">Marcar como terminado</a> ';
                        }

                        $data["conte"] .=' 
                                
                    </div>
            
                </div>';

        }
        $data["conte"] .=' <div class="col-12 my-4 py-4"></div>';

        echo json_encode($data);
   
    break;

    case 'preguntas':

        $data = array(); //Vamos a declarar un arra
		$data["conte"] = ""; //iniciamos el arreglo

        $id_docente_grupo=$_POST["id"];
        $id_docente=$_POST["id2"];
        $id_estudiante=$_POST["id3"];

            $data["conte"] .= '
        
            <div class="text-danger"> Califica de 0 a 5 siendo 0 la calificación mas baja y 5 la calificación mas alta. </div>
            <input type="hidden" name="id_docente_grupo" value="' . $id_docente_grupo . '">
            <input type="hidden" name="id_docente" value="' . $id_docente . '">
            <input type="hidden" name="id_estudiante" value="' . $id_estudiante . '">';

            $preguntas = $evaluacion->preguntas_heteroevaluacion();
                for ($i = 0; $i < count($preguntas); $i++) {
                    $data["conte"] .= '<div class="col mt-3 border-bottom">';
                    if ($preguntas[$i]['tipo'] == "0") {
                        $data["conte"] .=
                            '<p><B>' . $preguntas[$i]['pregunta'] . '</B></p>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pregunta' . $preguntas[$i]['id'] . '" value="0" required>
                                <label class="form-check-label" for="pregunta' . $preguntas[$i]['id'] . '">0</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pregunta' . $preguntas[$i]['id'] . '" value="1" required>
                                <label class="form-check-label" for="pregunta' . $preguntas[$i]['id'] . '">1</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pregunta' . $preguntas[$i]['id'] . '" value="2" required>
                                <label class="form-check-label" for="pregunta' . $preguntas[$i]['id'] . '">2</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pregunta' . $preguntas[$i]['id'] . '" value="3" required>
                                <label class="form-check-label" for="pregunta' . $preguntas[$i]['id'] . '">3</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pregunta' . $preguntas[$i]['id'] . '" value="4" required>
                                <label class="form-check-label" for="pregunta' . $preguntas[$i]['id'] . '">4</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pregunta' . $preguntas[$i]['id'] . '" value="5" required>
                                <label class="form-check-label" for="pregunta' . $preguntas[$i]['id'] . '">5</label>
                            </div>';
                    } elseif ($preguntas[$i]['tipo'] == "9") {
                        $data["conte"] .=
                            '<p><B>' . $preguntas[$i]['pregunta'] . '</B></p>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pregunta' . ($i + 1) . '" value="0" required>
                                <label class="form-check-label" for="pregunta' . ($i + 1) . '">No</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pregunta' . ($i + 1) . '" value="1" required>
                                <label class="form-check-label" for="pregunta' . ($i + 1) . '">Si</label>
                            </div>';
                    } else {
                        $data["conte"] .= '
                        <div class="form-group mt-3">
                            <label for="exampleFormControlTextarea1">' . $preguntas[$i]['pregunta'] . '</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" name="pregunta' . $preguntas[$i]['id'] . '" rows="3" style="resize: none;"></textarea>
                        </div>';
                    }
                    $data["conte"] .= '</div>';
                }

            $data["conte"] .= '
            <button type="submit" class="btn btn-sm btn-success col-12" id="btnGuardar">Enviar calificación</button>';
            
        
        echo json_encode($data);
   
    break;
   
    case 'listar2':
        $estadoHeteroevalaucion = $evaluacion->estado()["estado"];
        if ($estadoHeteroevalaucion == 0) {
            $data['conte'] = "";
            $data['cantidad'] = 0;
        } else {
            $text_preguntas = '';
            $preguntas = $evaluacion->preguntas_heteroevaluacion();
            for ($i = 0; $i < count($preguntas); $i++) {
                $text_preguntas .= '<div class="col mt-3 border-bottom">';
                if ($preguntas[$i]['tipo'] == "0") {
                    $text_preguntas .=
                        '<p><B>' . $preguntas[$i]['pregunta'] . '</B></p>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pregunta' . $preguntas[$i]['id'] . '" value="0" required>
                            <label class="form-check-label" for="pregunta' . $preguntas[$i]['id'] . '">0</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pregunta' . $preguntas[$i]['id'] . '" value="1" required>
                            <label class="form-check-label" for="pregunta' . $preguntas[$i]['id'] . '">1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pregunta' . $preguntas[$i]['id'] . '" value="2" required>
                            <label class="form-check-label" for="pregunta' . $preguntas[$i]['id'] . '">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pregunta' . $preguntas[$i]['id'] . '" value="3" required>
                            <label class="form-check-label" for="pregunta' . $preguntas[$i]['id'] . '">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pregunta' . $preguntas[$i]['id'] . '" value="4" required>
                            <label class="form-check-label" for="pregunta' . $preguntas[$i]['id'] . '">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pregunta' . $preguntas[$i]['id'] . '" value="5" required>
                            <label class="form-check-label" for="pregunta' . $preguntas[$i]['id'] . '">5</label>
                        </div>';
                } elseif ($preguntas[$i]['tipo'] == "9") {
                    $text_preguntas .=
                        '<p><B>' . $preguntas[$i]['pregunta'] . '</B></p>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pregunta' . ($i + 1) . '" value="0" required>
                            <label class="form-check-label" for="pregunta' . ($i + 1) . '">No</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pregunta' . ($i + 1) . '" value="1" required>
                            <label class="form-check-label" for="pregunta' . ($i + 1) . '">Si</label>
                        </div>';
                } else {
                    $text_preguntas .= '
                    <div class="form-group mt-3">
                        <label for="exampleFormControlTextarea1">' . $preguntas[$i]['pregunta'] . '</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" name="pregunta' . $preguntas[$i]['id'] . '" rows="3" style="resize: none;"></textarea>
                    </div>';
                }
                $text_preguntas .= '</div>';
            }
            $data['conte'] = '';
            $data['cantidad'] = 0;
            $colores = array("primary", "success", "warning", "danger");
            $consulta_programas = $evaluacion->consulta_programas($_SESSION['id_usuario']);
            for ($i = 0; $i < count($consulta_programas); $i++) {
                $consulta_materias = $evaluacion->consulta_materias($consulta_programas[$i]['id_estudiante'], $consulta_programas[$i]['ciclo']);
                for ($a = 0; $a < count($consulta_materias); $a++) {
                    $consulta_grupo = $evaluacion->consulta_grupo($consulta_materias[$a]['nombre_materia'], $consulta_materias[$a]['jornada'], $consulta_materias[$a]['semestre'], $consulta_materias[$a]['programa'], $consulta_materias[$a]['grupo']);
                    //print_r($consulta_grupo);
                    for ($e = 0; $e < count($consulta_grupo); $e++) {
                        if ($consulta_grupo[$e]['estado'] == 1) {
                            $consulta_respondio = $evaluacion->consulta_respondio($consulta_grupo[$e]['id_docente_grupo'], $consulta_grupo[$e]['id_docente'], $consulta_programas[$i]['id_estudiante']);
                            if (!$consulta_respondio) {
                                $datos_docente = $evaluacion->datos_docente($consulta_grupo[$e]['id_docente']);
                                if (file_exists('../files/docentes/' . $datos_docente['usuario_identificacion'] . '.jpg')) {
                                    $foto = '<img src=../files/docentes/' . $datos_docente['usuario_identificacion'] . '.jpg width=50px height=50px class=user-image>';
                                } else {
                                    $foto = '<img src=../files/null.jpg width=50px height=50px class=user-image>';
                                }
                                $data['conte'] .= '
                                <div class="col-md-3">
                                    <div class="card card-' . $colores[$i] . '">
                                        <div class="card-header">
                                            <h3 class="card-title">' . $consulta_grupo[$e]['nombre'] . '</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i> </button>
                                            </div>
                                      </div>
                                      <div class="card-body" style="display: block;">
                                        <form class="form_preguntas_' . ($data['cantidad'] + 1) . '" method="POST">
                                            <input type="hidden" name="id_docente_grupo" value="' . $consulta_grupo[$e]['id_docente_grupo'] . '">
                                            <input type="hidden" name="id_docente" value="' . $consulta_grupo[$e]['id_docente'] . '">
                                            <input type="hidden" name="id_estudiante" value="' . $consulta_programas[$i]['id_estudiante'] . '">
                                            <div class="col-md-12">
                                                ' . $foto . ' <strong>' . $datos_docente['usuario_nombre'] . ' ' . $datos_docente['usuario_nombre_2'] . ' ' . $datos_docente['usuario_apellido'] . ' ' . $datos_docente['usuario_apellido_2'] . '</strong>
                                            </div>
                                            <div class="text-danger"> Califique de 0 a 5 siendo 0 la calificación mas baja y 5 la calificación mas alta. </div>
                                            <div class="table-responsive">
                                                ' . $text_preguntas . '
                                            </div>
                                            <div class="box-footer clearfix mt-3">
                                                <button type="reset" class="btn btn-sm btn-info btn-flat pull-left">Cancelar</button>
                                                <button type="submit" class="btn btn-sm btn-success btn-flat pull-right">Enviar respuesta</button>
                                            </div>
                                        </form>
                                      </div>
                                    </div>
                                </div>';
                                $data['cantidad']++;
                            }
                        }
                    }
                }
            }
        }
        echo json_encode($data);
   
    break;

    case 'registro':
        $id_usuario=$_SESSION['id_usuario'];
        $id_docente_grupo = isset($_POST['id_docente_grupo']) ? $_POST['id_docente_grupo'] : 0;
        $id_docente = isset($_POST['id_docente']) ? $_POST['id_docente'] : 0;
        $id_estudiante = isset($_POST['id_estudiante']) ? $_POST['id_estudiante'] : 0;

        $pregunta1 = isset($_POST['pregunta1']) ? $_POST['pregunta1'] : 0;
        $pregunta2 = isset($_POST['pregunta2']) ? $_POST['pregunta2'] : 0;
        $pregunta3 = isset($_POST['pregunta3']) ? $_POST['pregunta3'] : 0;
        $pregunta4 = isset($_POST['pregunta4']) ? $_POST['pregunta4'] : 0;
        $pregunta5 = isset($_POST['pregunta5']) ? $_POST['pregunta5'] : 0;
        $pregunta6 = isset($_POST['pregunta6']) ? $_POST['pregunta6'] : 0;
        $pregunta7 = isset($_POST['pregunta7']) ? $_POST['pregunta7'] : 0;
        $pregunta8 = isset($_POST['pregunta8']) ? $_POST['pregunta8'] : 0;
        $pregunta9 = isset($_POST['pregunta9']) ? $_POST['pregunta9'] : 0;
        $pregunta10 = isset($_POST['pregunta10']) ? $_POST['pregunta10'] : 0;
        $pregunta11 = isset($_POST['pregunta11']) ? $_POST['pregunta11'] : 0;
        $pregunta12 = isset($_POST['pregunta12']) ? $_POST['pregunta12'] : 0;
        $pregunta13 = isset($_POST['pregunta13']) ? $_POST['pregunta13'] : 0;
        $pregunta14 = isset($_POST['pregunta14']) ? $_POST['pregunta14'] : 0;
        $pregunta15 = isset($_POST['pregunta15']) ? $_POST['pregunta15'] : 0;
        $pregunta16 = isset($_POST['pregunta16']) ? $_POST['pregunta16'] : 0;
        $pregunta17 = isset($_POST['pregunta17']) ? $_POST['pregunta17'] : 0;
        $pregunta18 = isset($_POST['pregunta18']) ? $_POST['pregunta18'] : 0;
        $pregunta19 = isset($_POST['pregunta19']) ? $_POST['pregunta19'] : 0;
        $pregunta20 = isset($_POST['pregunta20']) ? $_POST['pregunta20'] : 0;
        $pregunta21 = isset($_POST['pregunta21']) ? $_POST['pregunta21'] : 0;
        $pregunta22 = isset($_POST['pregunta22']) ? $_POST['pregunta22'] : 0;
        $pregunta23 = isset($_POST['pregunta23']) ? $_POST['pregunta23'] : 0;
        $evaluacion->registro($id_docente_grupo, $id_usuario, $id_docente, $id_estudiante, $pregunta1, $pregunta2, $pregunta3, $pregunta4, $pregunta5, $pregunta6, $pregunta7, $pregunta8, $pregunta9, $pregunta10, $pregunta11, $pregunta12, $pregunta13, $pregunta14, $pregunta15, $pregunta16, $pregunta17, $pregunta18, $pregunta19, $pregunta20, $pregunta21, $pregunta22, $pregunta23);
    break;

    case 'terminar':

        $data = array();
		$data["datos"] = "";
        $data["puntos"] = "";
        $data["puntosotorgados"] = "";

    
        $terminarhetero=$evaluacion->terminar();
        $resultado=$terminarhetero? 'si':'no';

        $data["datos"] =$resultado;

        //otorgar puntos
            $punto_nombre="hetero";
            $puntos_cantidad=100;
            $validarpuntos=$evaluacion->validarpuntos($punto_nombre,);// para validar si el punto de perfil fue otorgado
            if ($validarpuntos) {
                // Sí se obtuvo un resultado (al menos una fila) quiere decir que el punto fue otorgado
                
            } else {
                // No se obtuvo ningún resultado no hay punto otorgado
                $insertarpunto=$evaluacion->insertarPunto($punto_nombre,$puntos_cantidad,$fecha,$hora);

                $totalpuntos=$evaluacion->verpuntos();
                $puntoscredencial=$totalpuntos["puntos"];
                $sumapuntos=$puntos_cantidad+$puntoscredencial;
                $evaluacion->actulizarValor($sumapuntos);
                $data["puntos"] = "si";
                $data["puntosotorgados"] = $puntos_cantidad;

            }

        $results = array($data);
 		echo json_encode($results);
    
    break;


}
