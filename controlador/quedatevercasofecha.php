<?php 
require_once "../modelos/Quedatevercasofecha.php";
$estado = new Estado();
switch($_GET['op']) {
    case 'buscar':
        $mes = $_POST['mes'];
        $ano = $_POST['ano'];
        $datos = $estado->buscar($mes,$ano);
        $data['conte'] = '';
        $data['conte'] .= '
            <table class="table table-hover table-nowarp" id="tbl_casos">
                <thead>
                    <tr>
                        <th>Cant.</th>
                        <th>Caso id</th>
                        <th>Categoria</th>
                        <th>Contenido</th>
                        <th>Nombre</th>
                        <th>Programa</th>
                        <th>jornada</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Ver</th>
                    </tr>
                </thead>
                <tbody>';
        for ($i=0; $i < count($datos); $i++) {
            $fecha = explode(" ",$datos[$i]['created_at']);
            $variable = ($datos[$i]["caso_estado"] == "Cerrado") ? "badge badge-danger":"badge badge-success"; 
            $data['conte'] .= '<tr>
                        <td>'.($i+1).'</td>
                        <td>'.$datos[$i]['caso_id'].'</td>
                        <td>'.$datos[$i]['categoria_caso'].'</td>
                        <td>'.$datos[$i]['caso_asunto'].'</td>
                        <td>'.$datos[$i]['nombre'].'</td>
                        <td>'.$datos[$i]['fo_programa'].'</td>
                        <td>'.$datos[$i]['jornada_e'].'</td>
                        <td>'.$estado->convertir_fecha($fecha[0]).'</td>
                        <td>
                            <div class="text-center">
                                <span class="'.$variable.'">'.$datos[$i]["caso_estado"].'</span>
                            </div>
                        </td>
                        <td><a href="quedatevercaso.php?op=verC&caso='.$datos[$i]["caso_id"].'" target="_blank" type="submit" class="btn btn-primary"> <i class="fas fa-external-link-alt"></i> </a></td>
                    </tr>';
        }
        $data['conte'] .= '</tbody>
                    </table>';
        echo json_encode($data);
    break;
}
?>