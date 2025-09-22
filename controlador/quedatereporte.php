<?php 
require_once "../modelos/Quedatereporte.php";
$reporte = new Reporte();
switch($_GET['op']){
    case 'buscar':
        $mes = $_POST['mes'];
        $datos = $reporte->categorias();
        $datos2 = $reporte->programas();
        $data['conte'] = '';
        $th_categorias = '';
        $td_categorias = '';
        // tabla para los casos activos
        for ($i=0; $i < count($datos); $i++) {
            $th_categorias .= '<th>'.$datos[$i]['categoria_caso'].'</th>';
        }
        for ($a=0; $a < count($datos2); $a++) { 
            $td_categorias .= '<tr>';
            $td_categorias .= '<td>'.$datos2[$a]['nombre'].' </td>';
            for ($i=0; $i < count($datos); $i++) { 
                $datos3 = $reporte->buscar($datos[$i]['categoria_caso'],$datos2[$a]['id_programa'],$mes);
                $td_categorias .= '<td>'.count($datos3).'</td>';
            }
            $td_categorias .= '</tr>';
        }
        $meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
        $td_categorias .= '<tr>';
        $td_categorias .= '<td><B>Total casos</B></td>';

        // total de casos los cuenta.
        for ($i=0; $i < count($datos); $i++) { 
            // total de casos activos sin el idioma de ingles 
            $datos4 = $reporte->buscar2($datos[$i]['categoria_caso'],$mes);
            $td_categorias .= '<td><B>'.count($datos4).' </B></td>';
        }
        $td_categorias .= '</tr>';
        $data['select'] = '<select class="form-control" value="10" id="mes" onchange="buscar()">
                <option value="" selected disabled>Meses</option>
                <option value="01">Enero</option>
                <option value="02">Febrero</option>
                <option value="03">Marzo</option>
                <option value="04">Abril</option>
                <option value="05">Mayo</option>
                <option value="06">Junio</option>
                <option value="07">Julio</option>
                <option value="08">Agosto</option>
                <option value="09">Septiembre</option>
                <option value="10">Octubre</option>
                <option value="11">Noviembre</option>
                <option value="12">Diciembre</option>
            </select>';
        $data['conte'] .= '
            <table class="table table-hover table-nowarp" id="tbl_casos">
                <thead>
                    <tr>
                        <td class="text-center" colspan="'.(count($datos)+1).'">Reporte del mes '.$meses[($mes-1)].'</td>
                    </tr>
                    <tr>
                        <th>Programa</th>
                        '.$th_categorias.'
                    </tr>
                </thead>
                <tbody>
                '.$td_categorias.'
                </tbody>
        </table>';
        $datos_cerrados = $reporte->categorias_cerrados();
        $data['conte2'] = '';
        $th_categorias_c = '';
        $td_categorias_c = '';
        // label para la tabla 2 
        for ($i=0; $i < count($datos_cerrados); $i++) {
            $th_categorias_c .= '<th>'.$datos_cerrados[$i]['nombre'].'</th>';
        }
        for ($a=0; $a < count($datos2); $a++) { 
            $td_categorias_c .= '<tr>';
            // nombres de programa para casos cerrados.
            $td_categorias_c .= '<td>'.$datos2[$a]['nombre'].'</td>';
            for ($i=0; $i < count($datos_cerrados); $i++) { 
                $datos3 = $reporte->buscar_cerrados($datos_cerrados[$i]['nombre'],$datos2[$a]['id_programa'],$mes);
                $td_categorias_c .= '<td>'.count($datos3).'</td>';
            }
            $td_categorias_c .= '</tr>';
        }
        //$meses = array('Enero','Febrero','Marzo','Abril','Mayo','Juni','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
        $td_categorias_c .= '<tr>';
        $td_categorias_c .= '<td><B>Total casos</B></td>';
        // total de casos en la tabla casos cerrados
        for ($i=0; $i < count($datos_cerrados); $i++) { 
            $data4 = $reporte->buscar2_cerrados($datos_cerrados[$i]['nombre'],$mes);
            $td_categorias_c .= '<td><B>'.count($data4).'</B></td>';
        }
        $td_categorias_c .= '</tr>';
        $data['conte2'] .= '<table class="table table-hover table-nowarp" id="tbl_casos_cerrados">
                <thead>
                    <tr>
                        <td class="text-center" colspan="'.(count($datos)+1).'">Reporte casos cerrados del mes '.$meses[($mes-1)].'</td>
                    </tr>
                    <tr>
                        <th>Programa</th>
                        '.$th_categorias_c.'
                    </tr>
                </thead>
                <tbody>
                '.$td_categorias_c.'
                </tbody>
        </table>';
        $data['mes'] = $mes;
        echo json_encode($data);
    break;
}
?>