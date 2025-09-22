<?php 
session_start(); 
require_once "../modelos/Idiomas_asignar_grupo.php";

$idiomas_asig = new IdiomasAsig();

switch ($_GET['op']) {
    case 'listar':
        $datos = $idiomas_asig->listar();
        $data['conte'] = '';
        
        $data['conte'] .= '
        <table class="table" id="tbl_estu">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">CC</th>
                    <th scope="col">Programa</th>
                    <th scope="col">Celular</th>
                    <th scope="col">Matriculado</th>
                    <th scope="col">Acción</th>
                </tr>
            </thead>
            <tbody>';
        $grupos = $idiomas_asig->grupos();
        
        

        

        for ($i=0; $i < count($datos); $i++) {
            $estudiante = $idiomas_asig->estudiante($datos[$i]['id_estudiante']);
            $datos_estudiante = $idiomas_asig->datos_estudiante($estudiante['id_credencial']);
            $estudiante_datos_pero = $idiomas_asig->estudiante_datos_pero($estudiante['id_credencial']);
            $progrma = $idiomas_asig->fo_programa($datos[$i]['id_programa']);
            $progrma = explode(" ",$progrma['nombre']);

            $programa_activo = $idiomas_asig->programa_activo($estudiante['id_credencial']);

            $select = '';

            if ($programa_activo) {
                $datos_grupo = $idiomas_asig->grupos_datos($programa_activo['id_grupo']);
                $docente = $idiomas_asig->docente($datos_grupo['id_docente_ingles']);
                $tipo_grupo = $idiomas_asig->tipo_grupo($datos_grupo['id_tipo_grupo']);
                $hora = explode("-",$tipo_grupo['hora']);
                $info_grupos = $docente['nombre'].' / '.$tipo_grupo['nombre'].'/'.$tipo_grupo['dia'].'/'.date("g:i a",strtotime($hora[0])).' '.date("g:i a",strtotime($hora[1]));
                $select = '<button type="button" class="btn btn-warning btn-xs _tooltip" onclick="sacar_grupo('.$estudiante['id_credencial'].') data-toggle="tooltip" data-placement="top" title="'.$info_grupos.'"><i class="fas fa-user-times"></i> Sacar de grupo</button>';
            } else { 
                
                $select .= '
                <select class="form-control" id="select" onchange="asignar_grupo(this.value,'.$estudiante['id_credencial'].')">
                <option selected disabled>-Elige Grupo-</option>
                ';
                for ($i=0; $i < count($grupos); $i++) {
                    $docente = $idiomas_asig->docente($grupos[$i]['id_docente_ingles']);
                    $tipo_grupo = $idiomas_asig->tipo_grupo($grupos[$i]['id_tipo_grupo']);
                    $hora = explode("-",$tipo_grupo['hora']);
    
                    $select .= '<option value="'.$grupos[$i]['id'].'">'.$docente['nombre'].' / '.$tipo_grupo['nombre'].'/'.$tipo_grupo['dia'].'/'.date("g:i a",strtotime($hora[0])).' '.date("g:i a",strtotime($hora[1])).'</option>';
                }
    
                $select .= '</select>';
            }
            
            
            $data['conte'] .= '
                <tr>
                    <th scope="row">'.($i+1).'</th>
                    <td>'.$datos_estudiante['credencial_nombre'].' '.$datos_estudiante['credencial_apellido'].'</td>
                    <td>'.$datos_estudiante['credencial_identificacion'].'</td>
                    <td>'.$estudiante['fo_programa'].'</td>
                    <td>'.$estudiante_datos_pero['celular'].'</td>
                    <td>'.$progrma[1].'</td>
                    <td>'.$select.'</td>
                </tr>
            ';
        }

        $data['conte'] .= '</tbody></table>';

        echo json_encode($data);

    break;

    case 'asignar_grupo':
        $id = $_POST['id'];
        $id_credencial = $_POST['id_credencial'];
        $idiomas_asig->asignar_grupo($id,$id_credencial);

    break;

    case 'sacar_grupo':
        $id = $_POST['id'];
        $idiomas_asig->sacar_grupo($id);
    break;
}

?>