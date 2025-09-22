<?php
require_once "../modelos/Guiacasosestado.php";
$estado = new Estado();
switch ($_GET['op']) {
    case 'buscar':
        $val = $_POST['val'];
        $datos = $estado->guia_estado_buscar($val);
        $data['conte'] = '';
        $titulo = ($val == "Cerrado") ? '<th>Cerrado por</th>' : '' ;
        $data['conte'] .= '
            <table class="table table-hover table-nowarp" id="tbl_casos">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Contenido</th>
                        <th>Fecha</th>
                        <th>Creado por</th>
                        '.$titulo.'
                        <th>Ver</th>
                    </tr>
                </thead>
                <tbody>';
        for ($i=0; $i < count($datos); $i++) {
            $datos2 = $estado->guia_estado_consulta_caso($datos[$i]['caso_id']);
            $usuario_abre = $estado->guia_estado_nombre_usuario($datos2["area_id"]);
            if(empty($datos2["cerrado_por"])){
                $usuario_cierra["nombre"] = "";
            }else{
                $usuario_cierra = $estado->guia_estado_nombre_usuario($datos2["cerrado_por"]);
            }
            $data['conte'] .= '<tr>
                        <td>'.$datos[$i]['caso_id'].'</td>
                        <td>'.$datos[$i]['caso_asunto'].'</td>
                        <td>'.$datos[$i]['created_at'].'</td>
                        <td>'.$usuario_abre["nombre"].'</td>
                        '.(($val == "Cerrado") ? "<td>".$usuario_cierra["nombre"]."</td>":"").'
                        <td><a href="guiavercaso.php?op=verC&caso='.$datos[$i]["caso_id"].'" target="_blank" type="submit" class="btn btn-primary"> <i class="fas fa-external-link-alt"></i> </a></td>
                    </tr>';
        }
        $data['conte'] .= '</tbody></table>';
        echo json_encode($data);
    break;
}

?>