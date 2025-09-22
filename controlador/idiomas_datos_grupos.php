<?php 
session_start(); 
require_once "../modelos/Idiomas_datos_grupos.php";

$idiomas = new Idiomas();

switch ($_GET['op']) {

    case 'agregar_grupo':
        $nombre = $_POST['nombre'];
        $dia = $_POST['dia'];
        $hora1 = $_POST['hora1'];
        $hora2 = $_POST['hora2'];

        $idiomas->agregar_grupo($nombre,$dia,$hora1,$hora2);

    break;

    case 'agregar_docente':
        $nombre = $_POST['nombre'];
        $idiomas->agregar_docente($nombre);

    break;
    
    case 'listar_datos':
        
        $data['docente'] = '';
        $data['tipo_grupo'] = '';

        $data['docente'] .= '
            <label>Docente</label>
            <select class="form-control" name="docente">
                <option selected disabled>-Elige docente-</option>
        ';

        $docente = $idiomas->docente();

        for ($i=0; $i < count($docente); $i++) { 
            $data['docente'] .= '<option value="'.$docente[$i]['id'].'">'.$docente[$i]['nombre'].'</option>';
        }

        $data['tipo_grupo'] .= '</select>';


        $data['tipo_grupo'] .= '
            <label>Grupo</label>
            <select class="form-control" name="grupo">
                <option selected disabled>-Elige Grupo-</option>
        ';

        $tipo_grupo = $idiomas->tipo_grupo();

        for ($i=0; $i < count($tipo_grupo); $i++) { 
            $data['tipo_grupo'] .= '<option value="'.$tipo_grupo[$i]['id'].'">'.$tipo_grupo[$i]['nombre'].' - '.$tipo_grupo[$i]['hora'].'</option>';
        }

        $data['tipo_grupo'] .= '</select>';


        echo json_encode($data);

    break;

    case 'crear_grupo':
        $docente = $_POST['docente'];
        $grupo = $_POST['grupo'];
        $idiomas->crear_grupo($docente,$grupo);

    break;

    case 'listar':
        $datos = $idiomas->listar();

        $data['conte'] = '';

        $data['conte'] .= '
        <table class="table" id="tbl_grupos">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Docente</th>
                    <th scope="col">Nivel</th>
                    <th scope="col">Dia</th>
                    <th scope="col">Desde</th>
                    <th scope="col">hasta</th>
                </tr>
            </thead>
            <tbody>';

        for ($i=0; $i < count($datos); $i++) { 
            $docente = $idiomas->docente_datos($datos[$i]['id_docente_ingles']);
            $tipo_grupo_datos = $idiomas->tipo_grupo_datos($datos[$i]['id_tipo_grupo']);
            $hora = explode("-",$tipo_grupo_datos['hora']);
            $data['conte'] .= '
                <tr>
                    <th scope="row">'.($i+1).'</th>
                    <td>'.$docente['nombre'].'</td>
                    <td>'.$tipo_grupo_datos['nombre'].'</td>
                    <td>'.$tipo_grupo_datos['dia'].'</td>
                    <td>'.date("g:i a",strtotime($hora[0])).'</td>
                    <td>'.date("g:i a",strtotime($hora[1])).'</td>
                </tr>
            ';
        }

        $data['conte'] .= '</tbody></table>';

        echo json_encode($data);

    break;
}

?>