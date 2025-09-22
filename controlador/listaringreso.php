<?php

require_once "../modelos/ListarIngreso.php";
$listaringreso = new ListarIngreso();
switch ($_GET['op']) {
    case 'buscar':
       $val = $_POST['val'];

        $data['conte'] = '';
        $data['conte'] .= '
       
            <table class="table" id="tl_listar">
                <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Temperatura</th>
                        <th scope="col">Fecha ingreso</th>
                        <th scope="col">Hora de ingreso</th>
                        <th scope="col">Hora de salida</th>
                    </tr>
                </thead>
                <tbody>
       ';


       if ($val == "0") {
           $rst = $listaringreso->buscarVisitante();

           for ($i=0; $i < count($rst); $i++) { 
               $datos = $listaringreso->consultaVisitante($rst[$i]['id_visitante']);
               $condicion = ($rst[$i]['hora_salida'] == NULL) ? '<p class="text-danger">No registro salida</p>' : date("g:i a",strtotime($rst[$i]['hora_salida']));
               $data['conte'] .= '
                    <tr>
                        <td>'.$datos['nombre'].' '.$datos['nombre_2'].' '.$datos['apellido'].' '.$datos['apellido_2'].'</td>
                        <td>'.$rst[$i]['temperatura'].'</td>
                        <td>'.$listaringreso->convertir_fecha($rst[$i]['fecha']).'</td>
                        <td>'.date("g:i a",strtotime($rst[$i]['hora_ingreso'])).'</td>
                        <td>'.$condicion.'</td>
                    </tr>
               ';
           }

       } else {
            if ($val == "1") {
                $rst = $listaringreso->buscarCiaf($val);

                for ($i=0; $i < count($rst); $i++) { 
                    $datos = $listaringreso->consultaEstudiante($rst[$i]['id_usuario']);
                    $condicion = ($rst[$i]['hora_salida'] == NULL) ? '<p class="text-danger">No registro salida</p>' : date("g:i a",strtotime($rst[$i]['hora_salida']));
                    $data['conte'] .= '
                            <tr>
                                <td>'.$datos['credencial_nombre'].' '.$datos['credencial_nombre_2'].' '.$datos['credencial_apellido'].' '.$datos['credencial_apellido_2'].'</td>
                                <td>'.$rst[$i]['temperatura'].'</td>
                                <td>'.$listaringreso->convertir_fecha($rst[$i]['fecha']).'</td>
                                <td>'.date("g:i a",strtotime($rst[$i]['hora_ingreso'])).'</td>
                                <td>'.$condicion.'</td>
                            </tr>
                    ';
                }
            }
            if ($val == "2") {
                $rst = $listaringreso->buscarCiaf($val);

                for ($i=0; $i < count($rst); $i++) { 
                    $datos = $listaringreso->consultaDocente($rst[$i]['id_usuario']);
                    $condicion = ($rst[$i]['hora_salida'] == NULL) ? '<p class="text-danger">No registro salida</p>' : date("g:i a",strtotime($rst[$i]['hora_salida']));
                    $data['conte'] .= '
                            <tr>
                                <td>'.$datos['usuario_nombre'].' '.$datos['usuario_nombre_2'].' '.$datos['usuario_apellido'].' '.$datos['usuario_apellido_2'].'</td>
                                <td>'.$rst[$i]['temperatura'].'</td>
                                <td>'.$listaringreso->convertir_fecha($rst[$i]['fecha']).'</td>
                                <td>'.date("g:i a",strtotime($rst[$i]['hora_ingreso'])).'</td>
                                <td>'.$condicion.'</td>
                            </tr>
                    ';
                }
            }
            if ($val == "3") {
                $rst = $listaringreso->buscarCiaf($val);

                for ($i=0; $i < count($rst); $i++) { 
                    $datos = $listaringreso->consultaAdministra($rst[$i]['id_usuario']);
                    $condicion = ($rst[$i]['hora_salida'] == NULL) ? '<p class="text-danger">No registro salida</p>' : date("g:i a",strtotime($rst[$i]['hora_salida']));
                    $data['conte'] .= '
                            <tr>
                                <td>'.$datos['usuario_nombre'].' '.$datos['usuario_nombre_2'].' '.$datos['usuario_apellido'].' '.$datos['usuario_apellido_2'].'</td>
                                <td>'.$rst[$i]['temperatura'].'</td>
                                <td>'.$listaringreso->convertir_fecha($rst[$i]['fecha']).'</td>
                                <td>'.date("g:i a",strtotime($rst[$i]['hora_ingreso'])).'</td>
                                <td>'.$condicion.'</td>
                            </tr>
                    ';
                }
            }
       }

       $data['conte'] .= '        
                </tbody>
            </table>
       ';

       echo json_encode($data);

    break;
}

?>