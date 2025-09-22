<?php 
require_once "../modelos/Calificaciondocente.php";

$calificacion = new Calificaciondocente();
switch ($_GET['op']) {
    case 'listarProgra':
        $calificacion->listarProgra();
    break;
    case 'listarJornada':
        $calificacion->listarJornada();
    break;
    case 'buscar':
        $programa = $_POST['programa'];
        $jornada = $_POST['jornada'];

        $datos = $calificacion->buscar($programa,$jornada);

        $data['conte'] = '';
        $data['conte'] .= '
        <table class="table table-striped" id="tbl_datos">
            <thead>
            <tr>
                <th>Docente</th>
                <th>Programa</th>
                <th>Materia</th>
                <th>Semestre</th>
                <th>Acción</th>
            </tr>
            </thead>
            <tbody>';

            for ($i=0; $i < count($datos); $i++) {
                $nombre_usuario = $calificacion->nombre_usuario($datos[$i]['id_docente']);
                $programa = $calificacion->nombre_programa($datos[$i]['id_programa']);
                $materiadatos=$calificacion->materianombre($datos[$i]['id_materia']);

                $si = '<button onclick=cambiarestado('.$datos[$i]['id_docente_grupo'].',0) class="btn btn-danger"><i class="fas fa-lock"></i></button>';
                $no = '<button onclick=cambiarestado('.$datos[$i]['id_docente_grupo'].',1) class="btn btn-success"><i class="fas fa-lock-open"></i></button>';
                $estado = ($datos[$i]['estado'] == "0" ) ? $no : $si;
                $data['conte'] .= '
                <tr>
                    <td>'.$nombre_usuario.'</td>
                    <td>'.$programa.'</td>
                    <td>'.$materiadatos.'</td>
                    <td>'.$datos[$i]['semestre'].'</td>
                    <td>'.$estado.'</td>
                </tr>';
            }

        
        $data['conte'] .= '</tbody></table>';

        echo json_encode($data);

    break;
    case 'cambiarestado':
        $id = $_POST['id'];
        $val = $_POST['val'];
        $calificacion->cambiarestado($id,$val);
    break;
}

?>