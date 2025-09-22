<?php
require_once "../modelos/Preguntasheteroevaluacion.php"; 
$preguntas = new Preguntas();
switch ($_GET['op']) {
    case 'listar':
        $datos = $preguntas->listar();
        $data['conte'] = '';
		$data['conte'] .= '<div class="row">';
        for ($i=0; $i < count($datos); $i++) {
            $input = ($datos[$i]['tipo'] == 0) ? 'checked' : '' ;
            $radio = ($datos[$i]['tipo'] == 1) ? 'checked' : '' ;
            $data['conte'] .= '
                <div class="card col-md-6">
                    <form id="pregunta'.($i+1).'" method="post">
                        <div class="form-group">
                            <textarea type="text" name="pregunta" class="form-control">' . $datos[$i]['pregunta'] . '</textarea>
                            <input type="hidden" name="id" value="'.$datos[$i]['id'].'">
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="abierta_'.$datos[$i]['id'].'" name="tipo" value="0" class="custom-control-input" '.$input.'>
                            <label class="custom-control-label" for="abierta_'.$datos[$i]['id'].'">Pregunta abierta</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="opcional_'.$datos[$i]['id'].'" name="tipo" value="1" class="custom-control-input" '.$radio.'>
                            <label class="custom-control-label" for="opcional_'.$datos[$i]['id'].'">Opcional</label>
                        </div>
                        <button type="submit" class="btn btn-success btn-xs"> <i class="fa fa-save"></i> Guardar</button>
                    </form>
                </div>
            ';
        }
		$data['conte'] .= '</div>';
        $data['cantidad'] = count($datos);
        echo json_encode($data);
    break;
    case 'guardar':
        $pregunta = $_POST['pregunta'];
        $id = $_POST['id'];
        $tipo = $_POST['tipo'];
        $preguntas->guardar($pregunta,$id,$tipo);
    break;
}

?>