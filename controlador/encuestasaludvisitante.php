<?php

require_once "../modelos/Encuestasaludvisitante.php";
$encuestasalud = new Encuestasalud();
switch ($_GET['op']) {
    case 'buscar':
       $cc = $_POST['cc'];
       $cc = intval($cc);
       $rtp = $encuestasalud->buscar($cc);
       $rtp3 = $encuestasalud->preguntas();
       $rtp4 = $encuestasalud->consultaEncuesta($rtp['id']);

       $preguntas1 = "";
       $preguntas2 = "";
       $preguntas3 = "";

       for ($i=0; $i < count($rtp3); $i++) { 
        
            if ($rtp3[$i]['tabla'] == "1"){
                $preguntas1 .= '
                    <tr>
                        <td>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="pregunta'.$rtp3[$i]['id'].'" name="pregunta'.$rtp3[$i]['id'].'" class="custom-control-input" value="si" >
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="pregunta'.$rtp3[$i]['id'].'" name="pregunta'.$rtp3[$i]['id'].'" class="custom-control-input" value="no" >
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
                                <input type="radio" id="pregunta'.$rtp3[$i]['id'].'" name="pregunta'.$rtp3[$i]['id'].'" class="custom-control-input" value="si" >
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="pregunta'.$rtp3[$i]['id'].'" name="pregunta'.$rtp3[$i]['id'].'" class="custom-control-input" value="no" >
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

       

        $fecha = date("Y-m-d");

        $contenido2 = ($rtp == false || $rtp['celular'] == 0) ? '
                                        <label>Celular</label>
                                        <input type="number" class="form-control" name="celular" required placeholder="Celular"></br>' 
                                    : 
                                    '<B>Celular: '.$rtp['celular'].'</B>';
              
        $data['status'] = "ok";
        $data['msj'] = "Exito";
        $data['bandera'] = "1";
        $data['consulta'] = $rtp4;
        $data['conte'] = '
        
            <table class="table table-bordered col-md-4">
                <tr>
                    <td>'.$contenido2.'</td>
                    <td>
                        <label>Temperatura</label>
                        <input type="text" class="form-control" name="temperatura" required placeholder="Temperatura">
                    </td>
                </tr>
            </table> 

        ';
        $data['estado'] = $rtp['estado'];
        $id_c = ($rtp == false) ? "0" : $rtp['id'];

        if ($rtp4 == false) {
            
            $data['conte2'] = '
                <table class="table table-bordered col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <tr>
                        <th>SI</th>
                        <th>NO</th>
                        <th>Descripción</th>
                    </tr>
                    <input type="hidden" name="id" value="'.$id_c.'">
                    <input type="hidden" name="estado" value="'.$rtp['estado'].'">
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
            //$data['bandera'] = "1";
            
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

       echo json_encode($data);

    break;

    case 'registro':

        $rtp3 = $encuestasalud->preguntas();
        $id = $_POST['id'];

        $identificacion = $_POST['identificacion'];
        $apellido = $_POST['apellido'];
        $apellido_2 = $_POST['apellido_2'];
        $nombre = $_POST['nombre'];
        @$nombre_2 = $_POST['nombre_2'];
        $genero = $_POST['genero'];
        $fecha = $_POST['fecha_nacimiento'];
        $tipo_sangre = $_POST['tipo_sangre'];

        $estado = $_POST['estado'];
        $ano = substr($fecha,-4);
        $dia = substr($fecha,0,-6);
        $mes = substr($fecha,2,-4);
        $fecha_nacimiento = $ano.'-'.$mes.'-'.$dia;

        //echo $nombre;

        
        $temperatura = $_POST['temperatura'];
        $celular = isset($_POST['celular'])? $_POST['celular'] : 0;
        for ($i=0; $i < count($rtp3); $i++) { 
            $array[$i] = ($_POST['pregunta'.($i+1)] == "si") ? 1 : 0 ;
        }

        

        if ($estado == '0') {
            $encuestasalud->actualizardato($id,$identificacion,$nombre,$nombre_2,$apellido,$apellido_2,$genero,$fecha_nacimiento,$tipo_sangre,$celular);
        }

        if ($id == "0") {
            $val = $encuestasalud->insertar_visitante($identificacion,$nombre,$nombre_2,$apellido,$apellido_2,$genero,$fecha_nacimiento,$tipo_sangre,$celular);
            $encuestasalud->registro($array,$val,$temperatura);
        } else {
            $encuestasalud->registro($array,$id,$temperatura);
        }
        

        

    break;
}

?>