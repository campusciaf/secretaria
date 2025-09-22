<?php
require_once "../modelos/Guiaremisiones.php";
$guia_remisiones = new Remisiones();
switch ($_GET['op']) {
    case 'guiabuscar':
        $val = $_POST['val'];
        $data['conte'] = '';
        $datos = $guia_remisiones->guiabuscar($val);
            $data['conte'] .= '
                <table class="table table-striped" id="tbl_guia_remisiones">
                    <thead>
                        <tr>
                            <th>Observaciòn</th>
                            <th>Desde</th>
                            <th>Para</th>
                            <th>Fecha</th>
                            <th>estado</th>
                        </tr>
                    </thead>';
        for ($i=0; $i < count($datos); $i++) {
            if($datos[$i]["remision_visualizada"] == "0"){
                $variable = "badge badge-danger"; 
                $estado = "No vizualizada"; 
            }else{
                $variable = "badge badge-success";
                $estado = "Vizualizada"; 
            }
            //echo $datos[$i]['remision_desde'];
            //echo $datos[$i]['remision_para'];
            $desde = $guia_remisiones->guia_nombre_usuario($datos[$i]['remision_desde']);
            $para = $guia_remisiones->guia_nombre_usuario($datos[$i]['remision_para']);
            //echo '-'.$datos[$i]['remision_para'];
            $data['conte'] .= '<tr>
                        <td>'.$datos[$i]['remision_observacion'].'</td>
                        <td>'.$desde['nombre'].'</td>
                        <td>'.$para['nombre'].'</td>
                        <td>'.$datos[$i]['remision_fecha'].'</td>
                        <td>
                            <div class="text-center">
                                <span class="'.$variable.'">'.$estado.'</span>
                            </div>
                        </td>
                    </tr>';
        }
        $data['conte'] .= '</tbody></table>';
        echo json_encode($data);
    break;
}
?>