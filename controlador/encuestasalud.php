<?php

require_once "../modelos/Encuestasalud.php";
$encuestasalud = new Encuestasalud();
switch ($_GET['op']) {
    case 'buscar1':
       $cc = $_POST['cc'];
       $cc_final = base64_decode($cc);
       $rtp = $encuestasalud->buscar($cc_final);
       $rtp2 = $encuestasalud->datosestudiante($rtp['id_estudiante']);
       $rtp3 = $encuestasalud->preguntas();
       $rtp4 = $encuestasalud->consultaEncuesta($rtp['id_estudiante'],$_GET['op']);

       $preguntas1 = "";
       $preguntas2 = "";
       $preguntas3 = "";

       for ($i=0; $i < count($rtp3); $i++) { 
        
            if ($rtp3[$i]['tabla'] == "1"){
                $preguntas1 .= '
                    <tr>
                        <td>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="pregunta'.$rtp3[$i]['id'].'" name="pregunta'.$rtp3[$i]['id'].'" class="custom-control-input" value="si" required>
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="pregunta'.$rtp3[$i]['id'].'" name="pregunta'.$rtp3[$i]['id'].'" class="custom-control-input" value="no" required>
                            </div>
                        </td>
                        <td>'.$rtp3[$i]['nombre'].'</td>
                    </tr> 
                ';
            }

            if ($rtp3[$i]['tabla'] == "2"){
                $preguntas2 .= '
                    <tr>
                        <td>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="pregunta'.$rtp3[$i]['id'].'" name="pregunta'.$rtp3[$i]['id'].'" class="custom-control-input" value="si" required>
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="pregunta'.$rtp3[$i]['id'].'" name="pregunta'.$rtp3[$i]['id'].'" class="custom-control-input" value="no" required>
                            </div>
                        </td>
                        <td>'.$rtp3[$i]['nombre'].'</td>
                    </tr> 
                ';
            }

            if ($rtp3[$i]['tabla'] == "3"){
                $preguntas3 .= '
                    <tr>
                        <td>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="pregunta'.$rtp3[$i]['id'].'" name="pregunta'.$rtp3[$i]['id'].'" class="custom-control-input" value="si">
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="pregunta'.$rtp3[$i]['id'].'" name="pregunta'.$rtp3[$i]['id'].'" class="custom-control-input" value="no">
                            </div>
                        </td>
                        <td>'.$rtp3[$i]['nombre'].'</td>
                    </tr> 
                ';
            }

       }

       if (file_exists("../files/estudiantes/".$rtp['credencial_identificacion'].".jpg")) {
           $url = "../files/estudiantes/".$rtp['credencial_identificacion'].".jpg";
       } else {
           $url = "../files/null.jpg";
       }

       $fecha = date("Y-m-d");

       if ($rtp != false) {
              
        $data['status'] = "ok";
        $data['msj'] = "Exito";
        $data['conte'] = '
        
            <table class="table table-bordered">
                <tr>                    
                    <td rowspan="4" class="text-center" style="padding: 0;"><img src="'.$url.'" width="100"></td>
                </tr>
                <tr>
                    <td>Nombre: '.$rtp['credencial_nombre'].' '.$rtp['credencial_nombre_2'].' '.$rtp['credencial_apellido'].' '.$rtp['credencial_apellido_2'].'</td>
                    <td>Dirección de residecia: '.$rtp['barrio'].' - '.$rtp['direccion'].'</td>
                    <td>Programa: '.$rtp2['fo_programa'].'</td>
                </tr>
                <tr>                
                    <td>Fecha de nacimiento: '.$rtp['fecha_nacimiento'].'</td>
                    <td>Celular: '.$rtp['celular'].'</td>
                    <td>Semestre: '.$rtp2['semestre_estudiante'].'</td>
                </tr>
                <tr>
                    <td>Fecha: '.$fecha.'</td>
                    <td>EPS: </td>
                    <td>Jornada: '.$rtp2['jornada_e'].'</td>
                </tr>
            </table>

        ';

        if ($rtp4 == false) {
            
            $data['conte2'] = '
                <table class="table table-bordered col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <tr>
                        <th>SI</th>
                        <th>NO</th>
                        <th>Descripción</th>
                    </tr>
                    <div class="input-group col-md-4">
                        <label>Temperatura</label>
                        <input type="text" class="form-control" name="temperatura" required placeholder="Temperatura"></br>
                    </div>
                    <input type="hidden" name="id_credencial" value="'.$rtp['id_credencial'].'">
                    '.$preguntas1.'                                   
                </table>        
            ';

            $data['conte3'] = '
                <h5>Indique cuales de las siguientes molestias ha experimentado con frecuencia en los ultimos 6 meses?</h5>
                <table class="table table-bordered col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <tr>
                        <th>SI</th>
                        <th>NO</th>
                        <th>Descripción</th>
                    </tr>
                    '.$preguntas2.'                                   
                </table>        
            ';

            $data['conte4'] = '
                <h5>Ha tenido las siguientes enfermedades en los ultimos 6 meses?</h5>
                <table class="table table-bordered col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <tr>
                        <th>SI</th>
                        <th>NO</th>
                        <th>Descripción</th>
                    </tr>
                    '.$preguntas3.'                                   
                </table>        
            ';
            $data['bandera'] = "1";
            
        } else {
            $data['bandera'] = "2";
            $rtp5 = $encuestasalud->registrarsalida($rtp4['id']);

            if ($rtp5) {
                $data['status2'] = "ok";
                $data['msj2'] = "Salida registrada con exito.";
            } else {
                $data['status2'] = "error";
                $data['msj2'] = "Error al registrar la salida.";
            }

        }

       }else {
           $data['status'] = "error";
           $data['bandera'] = "1";
           $data['msj'] = "No se encontro al estudiante.";
       }

       echo json_encode($data);

    break;

    case 'buscar2':
       $cc = $_POST['cc'];
       $cc_final = base64_decode($cc);
       $rtp = $encuestasalud->buscarDocente($cc_final);
       $rtp3 = $encuestasalud->preguntas();
       $rtp4 = $encuestasalud->consultaEncuesta($rtp['id_usuario'],$_GET['op']);

       $preguntas1 = "";
       $preguntas2 = "";
       $preguntas3 = "";

       for ($i=0; $i < count($rtp3); $i++) { 
        
            if ($rtp3[$i]['tabla'] == "1"){
                $preguntas1 .= '
                    <tr>
                        <td>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="pregunta'.$rtp3[$i]['id'].'" name="pregunta'.$rtp3[$i]['id'].'" class="custom-control-input" value="si" required>
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="pregunta'.$rtp3[$i]['id'].'" name="pregunta'.$rtp3[$i]['id'].'" class="custom-control-input" value="no" required>
                            </div>
                        </td>
                        <td>'.$rtp3[$i]['nombre'].'</td>
                    </tr> 
                ';
            }

            if ($rtp3[$i]['tabla'] == "2"){
                $preguntas2 .= '
                    <tr>
                        <td>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="pregunta'.$rtp3[$i]['id'].'" name="pregunta'.$rtp3[$i]['id'].'" class="custom-control-input" value="si" required>
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="pregunta'.$rtp3[$i]['id'].'" name="pregunta'.$rtp3[$i]['id'].'" class="custom-control-input" value="no" required>
                            </div>
                        </td>
                        <td>'.$rtp3[$i]['nombre'].'</td>
                    </tr> 
                ';
            }

            if ($rtp3[$i]['tabla'] == "3"){
                $preguntas3 .= '
                    <tr>
                        <td>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="pregunta'.$rtp3[$i]['id'].'" name="pregunta'.$rtp3[$i]['id'].'" class="custom-control-input" value="si">
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="pregunta'.$rtp3[$i]['id'].'" name="pregunta'.$rtp3[$i]['id'].'" class="custom-control-input" value="no">
                            </div>
                        </td>
                        <td>'.$rtp3[$i]['nombre'].'</td>
                    </tr> 
                ';
            }

       }

       if (file_exists("../files/docentes/".$rtp['usuario_identificacion'].".jpg")) {
           $url = "../files/docentes/".$rtp['usuario_identificacion'].".jpg";
       } else {
           $url = "../files/null.jpg";
       }

       $fecha = date("Y-m-d");

       if ($rtp != false) {
              
        $data['status'] = "ok";
        $data['msj'] = "Exito";
        $data['conte'] = '
        
            <table class="table table-bordered">
                <tr>                    
                    <td rowspan="4" class="text-center" style="padding: 0;"><img src="'.$url.'" width="100"></td>
                </tr>
                <tr>
                    <td>Nombre: '.$rtp['usuario_nombre'].' '.$rtp['usuario_nombre_2'].' '.$rtp['usuario_apellido'].' '.$rtp['usuario_apellido_2'].'</td>
                    <td>Dirección de residecia: '.$rtp['usuario_barrio'].' - '.$rtp['usuario_direccion'].'</td>
                    <td>Escuela: '.$rtp['usuario_escuela'].'</td>
                </tr>
                <tr>                
                    <td>Fecha de nacimiento: '.$rtp['usuario_fecha_nacimiento'].'</td>
                    <td>Celular: '.$rtp['usuario_celular'].'</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Fecha: '.$fecha.'</td>
                    <td>EPS: </td>
                    <td></td>
                </tr>
            </table>

        ';

        if ($rtp4 == false) {
            
            $data['conte2'] = '
                <table class="table table-bordered col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <tr>
                        <th>SI</th>
                        <th>NO</th>
                        <th>Descripción</th>
                    </tr>
                    <div class="input-group col-md-4">
                        <label>Temperatura</label>
                        <input type="text" class="form-control" name="temperatura" required placeholder="Temperatura"></br>
                    </div>
                    <input type="hidden" name="id_credencial" value="'.$rtp['id_usuario'].'">
                    '.$preguntas1.'                                   
                </table>        
            ';

            $data['conte3'] = '
                <h5>Indique cuales de las siguientes molestias ha experimentado con frecuencia en los ultimos 6 meses?</h5>
                <table class="table table-bordered col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <tr>
                        <th>SI</th>
                        <th>NO</th>
                        <th>Descripción</th>
                    </tr>
                    '.$preguntas2.'                                   
                </table>        
            ';

            $data['conte4'] = '
                <h5>Ha tenido las siguientes enfermedades en los ultimos 6 meses?</h5>
                <table class="table table-bordered col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <tr>
                        <th>SI</th>
                        <th>NO</th>
                        <th>Descripción</th>
                    </tr>
                    '.$preguntas3.'                                   
                </table>        
            ';
            $data['bandera'] = "1";
            
        } else {
            $data['bandera'] = "2";
            $rtp5 = $encuestasalud->registrarsalida($rtp4['id']);

            if ($rtp5) {
                $data['status2'] = "ok";
                $data['msj2'] = "Salida registrada con exito.";
            } else {
                $data['status2'] = "error";
                $data['msj2'] = "Error al registrar la salida.";
            }

        }

       }else {
           $data['status'] = "error";
           $data['bandera'] = "1";
           $data['msj'] = "No se encontro al docente.";
       }

       echo json_encode($data);

    break;

    case 'buscar3':
       $cc = $_POST['cc'];
       $cc_final = base64_decode($cc);
       $rtp = $encuestasalud->buscarAdministra($cc_final);
       $rtp3 = $encuestasalud->preguntas();
       $rtp4 = $encuestasalud->consultaEncuesta($rtp['id_usuario'],$_GET['op']);

       $preguntas1 = "";
       $preguntas2 = "";
       $preguntas3 = "";

       for ($i=0; $i < count($rtp3); $i++) { 
        
            if ($rtp3[$i]['tabla'] == "1"){
                $preguntas1 .= '
                    <tr>
                        <td>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="pregunta'.$rtp3[$i]['id'].'" name="pregunta'.$rtp3[$i]['id'].'" class="custom-control-input" value="si" required>
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="pregunta'.$rtp3[$i]['id'].'" name="pregunta'.$rtp3[$i]['id'].'" class="custom-control-input" value="no" required>
                            </div>
                        </td>
                        <td>'.$rtp3[$i]['nombre'].'</td>
                    </tr> 
                ';
            }

            if ($rtp3[$i]['tabla'] == "2"){
                $preguntas2 .= '
                    <tr>
                        <td>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="pregunta'.$rtp3[$i]['id'].'" name="pregunta'.$rtp3[$i]['id'].'" class="custom-control-input" value="si" required>
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="pregunta'.$rtp3[$i]['id'].'" name="pregunta'.$rtp3[$i]['id'].'" class="custom-control-input" value="no" required>
                            </div>
                        </td>
                        <td>'.$rtp3[$i]['nombre'].'</td>
                    </tr> 
                ';
            }

            if ($rtp3[$i]['tabla'] == "3"){
                $preguntas3 .= '
                    <tr>
                        <td>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="pregunta'.$rtp3[$i]['id'].'" name="pregunta'.$rtp3[$i]['id'].'" class="custom-control-input" value="si">
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="pregunta'.$rtp3[$i]['id'].'" name="pregunta'.$rtp3[$i]['id'].'" class="custom-control-input" value="no">
                            </div>
                        </td>
                        <td>'.$rtp3[$i]['nombre'].'</td>
                    </tr> 
                ';
            }

       }

       if (file_exists("../files/docentes/".$rtp['usuario_identificacion'].".jpg")) {
           $url = "../files/docentes/".$rtp['usuario_identificacion'].".jpg";
       } else {
           $url = "../files/null.jpg";
       }

       $fecha = date("Y-m-d");

       if ($rtp != false) {
              
        $data['status'] = "ok";
        $data['msj'] = "Exito";
        $data['conte'] = '
        
            <table class="table table-bordered">
                <tr>                    
                    <td rowspan="4" class="text-center" style="padding: 0;"><img src="'.$url.'" width="100"></td>
                </tr>
                <tr>
                    <td>Nombre: '.$rtp['usuario_nombre'].' '.$rtp['usuario_nombre_2'].' '.$rtp['usuario_apellido'].' '.$rtp['usuario_apellido_2'].'</td>
                    <td>Dirección de residecia: '.$rtp['usuario_direccion'].'</td>
                    <td>Cargo: '.$rtp['usuario_cargo'].'</td>
                </tr>
                <tr>                
                    <td>Fecha de nacimiento: '.$rtp['usuario_fecha_nacimiento'].'</td>
                    <td>Celular: '.$rtp['usuario_celular'].'</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Fecha: '.$fecha.'</td>
                    <td>EPS: </td>
                    <td></td>
                </tr>
            </table>

        ';

        if ($rtp4 == false) {
            
            $data['conte2'] = '
                <table class="table table-bordered col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <tr>
                        <th>SI</th>
                        <th>NO</th>
                        <th>Descripción</th>
                    </tr>
                    <div class="input-group col-md-4">
                        <label>Temperatura</label>
                        <input type="text" class="form-control" name="temperatura" required placeholder="Temperatura"></br>
                    </div>
                    <input type="hidden" name="id_credencial" value="'.$rtp['id_usuario'].'">
                    '.$preguntas1.'                                   
                </table>        
            ';

            $data['conte3'] = '
                <h5>Indique cuales de las siguientes molestias ha experimentado con frecuencia en los ultimos 6 meses?</h5>
                <table class="table table-bordered col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <tr>
                        <th>SI</th>
                        <th>NO</th>
                        <th>Descripción</th>
                    </tr>
                    '.$preguntas2.'                                   
                </table>        
            ';

            $data['conte4'] = '
                <h5>Ha tenido las siguientes enfermedades en los ultimos 6 meses?</h5>
                <table class="table table-bordered col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <tr>
                        <th>SI</th>
                        <th>NO</th>
                        <th>Descripción</th>
                    </tr>
                    '.$preguntas3.'                                   
                </table>        
            ';
            $data['bandera'] = "1";
            
        } else {
            $data['bandera'] = "2";
            $rtp5 = $encuestasalud->registrarsalida($rtp4['id']);

            if ($rtp5) {
                $data['status2'] = "ok";
                $data['msj2'] = "Salida registrada con exito.";
            } else {
                $data['status2'] = "error";
                $data['msj2'] = "Error al registrar la salida.";
            }

        }

       }else {
           $data['status'] = "error";
           $data['bandera'] = "1";
           $data['msj'] = "No se encontro al docente.";
       }

       echo json_encode($data);

    break;

    case 'registro':

        $rtp3 = $encuestasalud->preguntas();
        $id_credencial = $_POST['id_credencial'];
        $tipo = $_POST['tipo'];
        $temperatura = $_POST['temperatura'];
        for ($i=0; $i < count($rtp3); $i++) { 
            $array[$i] = ($_POST['pregunta'.($i+1)] == "si") ? 1 : 0 ;
        }

        $encuestasalud->registro($array,$id_credencial,$tipo,$temperatura);

    break;
}

?>