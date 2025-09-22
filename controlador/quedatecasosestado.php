<?php
require_once "../modelos/Quedatecasosestado.php";
$estado = new Estado();
switch ($_GET['op']) {
    case 'buscar':
        $val = $_POST['val'];
        $ano = $_POST['ano'];
        $datos = $estado->buscar($val,$ano);
        $data['conte'] = '';
        $titulo = ($val == "Cerrado") ? '<th> Cerrado por </th>' : '' ;
        $data['conte'] .= '
            <table class="table table-hover table-nowarp" id="tbl_casos">
                <thead>
                    <tr>
                        <th> # </th>
                        <th> Identificación </th>
                        <th> Contenido </th>
                        <th> Fecha </th>
                        <th> Creado por </th>
                        '.$titulo.'
                        <th> Ver </th>
                    </tr>
                </thead>
                <tbody>';
        for($i = 0; $i < count($datos); $i++) {
            $variable = ($val == "Cerrado")?'<td>'.ucfirst(mb_strtolower($estado->nombre_usuario($datos[$i]['cerrado_por']), 'UTF-8')).'</td>':'';
            $data['conte'] .= '<tr>
                        <td> '.$datos[$i]['caso_id'].' </td>
                        <td> '.$datos[$i]['credencial_identificacion'].' </td>
                        <td> '.ucfirst(mb_strtolower($datos[$i]['caso_asunto'], 'UTF-8')).' </td>
                        <td> '. $fecha = $estado->fechaesp($datos[$i]["created_at"]).' </td>
                        <td> '.ucfirst(mb_strtolower($estado->nombre_usuario($datos[$i]['area_id']), 'UTF-8')).' </td>
                        '.$variable.'
                        <td> 
                            <a href="quedatevercaso.php?op=verC&caso='.$datos[$i]["caso_id"].'" target="_blank" type="submit" class="btn btn-primary"> <i class="fas fa-external-link-alt"></i> </a> 
                        </td>
                    </tr>';
        }
        $data['conte'] .= '</tbody></table>';
        echo json_encode($data);
    break;
}