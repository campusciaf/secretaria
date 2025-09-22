<?php 
require_once "../modelos/Oncentertrazabilidad.php";
$trazabilidad = new Oncentertrazabilidad();

$rsptaperiodo = $trazabilidad->periodoactual();
$periodo_campana = $rsptaperiodo["periodo_campana"];


switch ($_GET['op']) {
    case 'buscar':
        $val = $_POST['val'];
        $datos = $trazabilidad->buscar($val,$periodo_campana);

        if ($val == 1) {
            $campos = '<th id="t-fa">Fecha anterior</th><th id="t-nf">Nueva fecha</th>';
        } else {
            $campos = '<th>Usario anterior</th><th>Nueva usuario</th>';
        }
        

        $data['conte'] = '';
        $data['conte'] .= '
        <table class="table table-striped" id="tbl_datos">
            <thead>
            <tr>
                <th id="t-uc">Usario cambio</th>
                <th id="t-fr">Fecha realización</th>
                <th id="t-it">Id tarea</th>
                '.$campos.'
            </tr>
            </thead>
            <tbody>';

            for ($i=0; $i < count($datos); $i++) {
                $nombre_usuario = $trazabilidad->nombre_usuario($datos[$i]['id_usuario']);
                if ($val == 1) {
                    $campos2 = '<td>'.$datos[$i]['fecha_anterior'].'</td><td>'.$datos[$i]['fecha_nueva'].'</td>';
                } else {
                    $nombre_usuario2 = $trazabilidad->nombre_usuario($datos[$i]['usuario_anterior']);
                    $nombre_usuario3 = $trazabilidad->nombre_usuario($datos[$i]['usuario_nuevo']);
                    $campos2 = '<td>'.$nombre_usuario2.'</td><td>'.$nombre_usuario3.'</td>';
                }
                
                
                $data['conte'] .= '
                <tr>
                    <td>'.$nombre_usuario.'</td>
                    <td>'.$datos[$i]['fecha_realizado'].'</td>
                    <td>'.$datos[$i]['id_tarea'].'</td>
                    '.$campos2.'
                </tr>';
            }

        
        $data['conte'] .= '</tbody></table>';

        echo json_encode($data);

    break;
}

?>