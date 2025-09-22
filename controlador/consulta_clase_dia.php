<?php 

require_once "../modelos/Consulta_clase_dia.php";

$consulta = new Consultas();

switch ($_GET['op']) {
    case 'listarperiodo':
        $consulta->listarperiodo();
    break;

    case 'consulta':
        $dia = $_POST['dia'];
        $periodo = $_POST['periodo'];

        $rst = $consulta->consultaDatos($dia,$periodo);


        $data['conte'] = '';
        $data['conte'] .= '
            <table class="table table-striped" id="dtl_consulta">
                <thead>
                    <tr>
                        <th scope="col">Programa</th>
                        <th scope="col">Materia</th>
                        <th scope="col">Jornada</th>
                        <th scope="col">Semestre</th>
                        <th scope="col">Docente</th>
                        <th scope="col">Salon</th>
                        <th scope="col">Hora</th>
                    </tr>
                </thead>
                <tbody>';

        for ($i=0; $i < count($rst); $i++) {
            $grupo = $consulta->datosGrupo($rst[$i]['id_docente_grupo']);
            $docente = $consulta->datosdocente($grupo['id_docente']);
            $programa = $consulta->consultaPrograma($grupo['id_programa']);
            $data['conte'] .= '
                <tr>
                    <td>'.$programa['nombre'].'</td>
                    <td>'.$grupo['materia'].'</td>
                    <td>'.$grupo['jornada'].'</td>
                    <td>'.$grupo['semestre'].'</td>
                    <td>'.$docente.'</td> 
                    <td>'.$rst[$i]['salon'].'</td>                                       
                    <td> '.date("g:i a",strtotime($rst[$i]['hora'])).' - '.date("g:i a",strtotime($rst[$i]['hasta'])).'</td>
                </tr>';
        }

        $data['conte'] .= '</tbody>
            </table>';


        echo json_encode($data);

    break;
}

?>