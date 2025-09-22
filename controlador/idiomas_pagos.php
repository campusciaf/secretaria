<?php 

session_start(); 
require_once "../modelos/Idiomas_pagos.php";
$idiotranfe = new Idiotranfe();

switch ($_GET['op']) {
    case 'listar':
        
        $fecha = $_POST['fecha'];
        $data['fecha'] = $fecha;
        $data['conte'] = '';
        $datos = $idiotranfe->listar($fecha);

        $data['conte'] .= '
                    <table id="tbllistado" class="table table-hover">
                            <thead>                                
                                <th> Ref CIAF </th>
                                <th> CC </th>
                                <th> Nombre </th>
                                <th> Valor </th>
                                <th> Descripcion </th>
                                <th> Estado </th>
                                <th> Tipo de pago </th>
                            </thead>
                            <tbody>  
        ';

        for ($i=0; $i < count($datos); $i++) { 
            $tipo = ($datos[$i]['tipo_pago'] == 'pago_minimo') ? 'Minimo' : 'Completo';

            if ($datos[$i]['x_respuesta'] == 'Aceptada') {
                $color = 'success';
            }

            if ($datos[$i]['x_respuesta'] == 'Abandonada') {
                $color = 'warning';
            }

            if ($datos[$i]['x_respuesta'] == 'Cancelada' || $datos[$i]['x_respuesta'] == 'Rechazada') {
                $color = 'danger';
            }

            $estudiante = $idiotranfe->datos_estu($datos[$i]['id_persona']);

            $data['conte'] .= '
            <tr>
                <th scope="row">'.$datos[$i]['consecutivo'].'</th>
                <td>'.$estudiante['credencial_identificacion'].'</td>
                <td>'.$estudiante['credencial_nombre'].' '.$estudiante['credencial_nombre_2'].' '.$estudiante['credencial_apellido'].' '.$estudiante['credencial_apellido_2'].'</td>
                <td>'.$datos[$i]['x_amount_base'].'</td>
                <td>'.$datos[$i]['x_description'].'</td>
                <td><small class="badge badge-'.$color.'">'.$datos[$i]['x_respuesta'].'</small></td>
                <td>'.$tipo.'</td>
            </tr>
            ';
        }

        $data['conte'] .= '
                </tbody>
                <tfoot>
                    <th> Ref CIAF </th>
                    <th> CC </th>
                    <th> Nombre </th>
                    <th> Valor </th>
                    <th> Descripcion </th>
                    <th> Estado </th>
                    <th> Tipo de pago </th>
                </tfoot>
            </table>
        ';

        echo json_encode($data);

        break;
}

?>