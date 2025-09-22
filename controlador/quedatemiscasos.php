<?php
require_once "../modelos/Quedatemiscasos.php";
$estado = new Estado();
switch ($_GET['op']) {
    case 'buscar':
        $val = $_POST['val'];
        $ano = $_POST['ano'];
        $data['conte'] = '';
        if ($val == "casos") {
            $datos = $estado->casos($ano);
            $data['conte'] .= '
                <table class="table table-hover table-nowarp" id="tbl_casos">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Asunto</th>
                            <th>Fecha</th>
                            <th>Ver</th>
                            <th>Estado</th>
                        </tr>
                    </thead>';
            for ($i=0; $i < count($datos); $i++) {
                $variable = ($datos[$i]["caso_estado"] == "Cerrado")?"badge badge-danger":"badge badge-success"; 
                $data['conte'] .= '<tr>
                            <td>'.$datos[$i]['caso_id'].'</td>
                            <td>'.$datos[$i]['caso_asunto'].'</td>
                            <td>'. $estado->fechaesp($datos[$i]["created_at"]).'</td>
                            <td><a href="quedatevercaso.php?op=verC&caso='.$datos[$i]["caso_id"].'" target="_blank" type="submit" class="btn btn-primary"> <i class="fas fa-external-link-alt"></i> </a></td>
                            <td>
                                <div class="text-center">
                                    <span class="'.$variable.'">'.$datos[$i]["caso_estado"].'</span>
                                </div>
                            </td>
                        </tr>';
            }
            $data['conte'] .= '</tbody></table>';
        } else {
            $datos = $estado->remisiones($ano);
            $data['conte'] .= '
                <table class="table table-hover table-nowarp" id="tbl_remisiones">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Asunto</th>
                            <th>Fecha</th>
                            <th>Creado por</th>
                            <th>Ver</th>
                            <th>Estado</th>
                        </tr>
                    </thead>';
            for ($i=0; $i < count($datos); $i++) {
                $datos2 = $estado->consulta_caso($datos[$i]['caso_id']);
                $variable = ($datos2["caso_estado"] == "Cerrado") ? "badge badge-danger":"badge badge-success" ; 
                $data['conte'] .= '<tr>
                            <td>'.$datos2['caso_id'].'</td>
                            <td>'.$datos2['caso_asunto'].'</td>
                            <td>'.$estado->fechaesp($datos[$i]["remision_fecha"]).'</td>
                            <td>'.$estado->nombre_usuario($datos2['area_id']).'</td>
                            <td>
                                <a href="quedatevercaso.php?op=verC&caso='.$datos2["caso_id"].'" target="_blank" type="submit" class="btn btn-primary"> 
                                    <i class="fas fa-external-link-alt"></i> 
                                </a>
                            </td>
                            <td>
                                <div class="text-center">
                                    <span class="'.$variable.'">'.$datos2["caso_estado"].'</span>
                                </div>
                            </td>
                        </tr>';
            }
            $data['conte'] .= '</tbody></table>';
        }
        echo json_encode($data);
    break;
}
?>