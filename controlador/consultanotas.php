<?php 
require_once "../modelos/Consultanotas.php";
$consulta = new Consulta();
switch ($_GET['op']) {
    case 'progra':
        $val = $_POST['val'];
        $consulta->progra($val);
    break;
    case 'periodos':
        $data = $consulta->periodos();
        echo json_encode($data);
    break;
    case 'consulta':
        $programa = $_POST['programa'];
        $estado = $_POST['estado'];
        $semestre = $_POST['semestre'];
        $corte = $_POST['corte'];
        $corteCan = $_POST['cortes'];
        $c = $_POST['c'];
        $jornada = $_POST['jornada'];
        $periodo = $_POST['periodo'];
        $datos = $consulta->consul($programa,$semestre,$c,$jornada,$periodo);
        $data['conte'] = "";
        $data['conte'] .= '<table class="table table-hover" id="dtl_notas" style="width:100%">
            <thead>
                <tr>
                    <th></th>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Materia</th>
                    <th>Programa</th>
                    <th>Corte1</th>
                    <th>corte2</th>
                    <th>corte3</th>
                    <th>Promedio</th>
                    <th>Jornada</th>
                    <th>Semestre</th>
                    <th>Telefono</th>
                    <th>Correo</th>
                    <th>Correo Personal</th>
                    <th>Id estudiante</th>
                </tr>
            </thead>
            <tbody>';
                //echo count($datos);
                for ($i=0; $i < count($datos); $i++) {
                    $estu = $consulta->datos($datos[$i]['id_estudiante']);
                    $pro = $consulta->programa($datos[$i]['programa']);

                    if ($estado==2) {
                        
                        $data['conte'] .= '<tr>
                                    <td></td>
                                    <td>'.$estu['cc'].'</td>
                                    <td>'.$estu['nombre'].'</td>
                                    <td>'.$datos[$i]['nombre_materia'].'</td>
                                    <td>'.$pro['nombre'].'</td>
                                    <td>'.$datos[$i]['c1'].'</td>
                                    <td>'.$datos[$i]['c2'].'</td>
                                    <td>'.$datos[$i]['c3'].'</td>
                                    <td>'.$datos[$i]['promedio'].'</td>
                            <td>'.$datos[$i]['jornada'].'</td>
                            <td>'.$datos[$i]['semestre'].'</td>
                            <td>'.$estu['telefono'].'</td>
                            <td>'.$estu['correo'].'</td>
                            <td>'.$estu['correo_p'].'</td>
                            <td>'.$datos[$i]['id_estudiante'].'</td>
                        </tr>';
                    }
                    if ($estado==1) {//aprobadas
                        
                        if($datos[$i][$corte] >= 3){
                            $data['conte'] .= '<tr>
                                        <td></td>
                                        <td>'.$estu['cc'].'</td>
                                        <td>'.$estu['nombre'].'</td>
                                        <td>'.$datos[$i]['nombre_materia'].'</td>
                                        <td>'.$pro['nombre'].'</td>';
                            $data['conte'] .= '<td>'.$datos[$i][$corte].'</td>';
                            $data['conte'] .='
                                <td>'.$datos[$i]['jornada'].'</td>
                                <td>'.$datos[$i]['semestre'].'</td>
                                <td>'.$estu['telefono'].'</td>
                                <td>'.$estu['correo'].'</td>
                                <td>'.$estu['correo_p'].'</td>
                                <td>'.$datos[$i]['id_estudiante'].'</td>
                            </tr>';
                        }
                    }
                    if($estado==0){//perdidas
                        if($datos[$i][$corte] < 3){ 
                            $data['conte'] .= '<tr>
                                        <td></td>
                                        <td>'.$estu['cc'].'</td>
                                        <td>'.$estu['nombre'].'</td>
                                        <td>'.$datos[$i]['nombre_materia'].'</td>
                                        <td>'.$pro['nombre'].'</td>';
                            $data['conte'] .= '<td>'.$datos[$i][$corte].'</td>';
                            $data['conte'] .='
                                <td>'.$datos[$i]['jornada'].'</td>
                                <td>'.$datos[$i]['semestre'].'</td>
                                <td>'.$estu['telefono'].'</td>
                                <td>'.$estu['correo'].'</td>
                                <td>'.$estu['correo_p'].'</td>
                                <td>'.$datos[$i]['id_estudiante'].'</td>
                            </tr>';
                        }
                    }
                }
                $data['conte'] .= '
            </tbody>
        </table>';
        echo json_encode($data);
    break;
}

?>