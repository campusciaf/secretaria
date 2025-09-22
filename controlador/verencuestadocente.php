<?php
require_once "../modelos/VerEncuestaDocente.php";
$verencuestadocente = new VerEncuestaDocente();
switch ($_GET['op']) {
    case 'listar':
        $estadoHeteroevalaucion = $verencuestadocente->estado()["estado"];
        if ($estadoHeteroevalaucion == 0) {
            $data['conte'] = "";
            $data['cantidad'] = 0;
            $data['completo'] = false;
        } else {
            $text_preguntas = '';
            $colores = array("primary", "success", "warning", "danger");
            $data['conte'] = '';
            $data['cantidad'] = 0;
            $data['completo'] = false;
            $consulta_programas = $verencuestadocente->consulta_programas($_SESSION['id_usuario']);
            for ($i = 0; $i < count($consulta_programas); $i++) {
                $consulta_materias = $verencuestadocente->consulta_materias($consulta_programas[$i]['id_estudiante'], $consulta_programas[$i]['ciclo']);
                for ($a = 0; $a < count($consulta_materias); $a++) {
                    $activar_grupo_esp = $consulta_materias[$a]["activar_grupo_esp"];
                    $id_docente_grupo_esp = $consulta_materias[$a]["id_docente_grupo_esp"];
                    if ($activar_grupo_esp == 0) {

                        $consulta_grupo = $verencuestadocente->consulta_grupo($consulta_materias[$a]['nombre_materia'], $consulta_materias[$a]['jornada'], $consulta_materias[$a]['semestre'], $consulta_materias[$a]['programa'], $consulta_materias[$a]['grupo']);
                        for ($e = 0; $e < count($consulta_grupo); $e++) {
                            // Verificar si el estudiante ya ha respondido esta evaluación
                            $consulta_respondio = $verencuestadocente->consulta_respondio_docente($consulta_grupo[$e]['id_docente_grupo'], $consulta_grupo[$e]['id_docente'], $consulta_programas[$i]['id_estudiante']);
                            // Si no ha respondido, mostrar el formulario
                            if (!$consulta_respondio) {
                                $datos_docente = $verencuestadocente->datos_docente($consulta_grupo[$e]['id_docente']);
                                if (file_exists('../files/docentes/' . $datos_docente['usuario_identificacion'] . '.jpg')) {
                                    $foto = '<img src=../files/docentes/' . $datos_docente['usuario_identificacion'] . '.jpg width=50px height=50px class=user-image>';
                                } else {
                                    $foto = '<img src=../files/null.jpg width=50px height=50px class=user-image>';
                                }
                                $data['conte'] .= '
                            <div class="col-md-3">
                                <div class="card card-' . $colores[$i] . '">
                                    <div class="card-header">
                                        <h3 class="card-title">' . $consulta_grupo[$e]['nombre'] . '</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i> </button>
                                        </div>
                                    </div>
                                    <div class="card-body" style="display: block;">
                                        <form class="form_preguntas_docente' . ($data['cantidad'] + 1) . '" method="POST">
                                            <input type="hidden" name="id_docente_grupo" value="' . $consulta_grupo[$e]['id_docente_grupo'] . '">
                                            <input type="hidden" name="id_docente" value="' . $consulta_grupo[$e]['id_docente'] . '">
                                            <input type="hidden" name="id_estudiante" value="' . $consulta_programas[$i]['id_estudiante'] . '">
                                            <div class="col-md-12">
                                                ' . $foto . ' <strong>' . $datos_docente['usuario_nombre'] . ' ' . $datos_docente['usuario_nombre_2'] . ' ' . $datos_docente['usuario_apellido'] . ' ' . $datos_docente['usuario_apellido_2'] . '</strong>
                                            </div>
                                            <div class="text-danger"> Califique de 0 a 5 siendo 0 la calificación más baja y 5 la calificación más alta. </div>
                                            <div class="card-body">
                                                
                                                    <div class="form-group">
                                                    <label><b>¿Cómo calificarías la efectividad del docente en la enseñanza de la asignatura?</b></label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta1b" value="1" required>
                                                        <label class="form-check-label">Excelente</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta1b" value="2">
                                                        <label class="form-check-label">Buena</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta1b" value="3">
                                                        <label class="form-check-label">Regular</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta1b" value="4">
                                                        <label class="form-check-label">Deficiente</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label><b>¿El docente utiliza herramientas digitales e inteligencia artificial para facilitar el aprendizaje?</b></label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta2b" value="1" required>
                                                        <label class="form-check-label">Siempre</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta2b" value="2">
                                                        <label class="form-check-label">Frecuentemente</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta2b" value="3">
                                                        <label class="form-check-label">Raramente</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta2b" value="4">
                                                        <label class="form-check-label">Nunca</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label><b>¿Consideras que el docente emplea metodologías creativas que te ayudan a comprender mejor los temas?</b></label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta3b" value="1" required>
                                                        <label class="form-check-label">Siempre</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta3b" value="2">
                                                        <label class="form-check-label">Frecuentemente</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta3b" value="3">
                                                        <label class="form-check-label">A veces</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta3b" value="4">
                                                        <label class="form-check-label">Nunca</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label><b>¿El ambiente de aprendizaje en la clase es motivador y facilita la colaboración entre estudiantes?</b></label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta4b" value="1" required>
                                                        <label class="form-check-label">Siempre</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta4b" value="2">
                                                        <label class="form-check-label">Frecuentemente</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta4b" value="3">
                                                        <label class="form-check-label">A veces</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta4b" value="4">
                                                        <label class="form-check-label">Nunca</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label><b>¿Te sientes satisfecho(a) con el nivel de apoyo que recibiste para entender el contenido de la clase?</b></label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta5b" value="1" required>
                                                        <label class="form-check-label">Muy satisfecho(a)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta5b" value="2">
                                                        <label class="form-check-label">Satisfecho(a)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta5b" value="3">
                                                        <label class="form-check-label">Poco satisfecho(a)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta5b" value="4">
                                                        <label class="form-check-label">Insatisfecho(a)</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label><b>¿Los exámenes y evaluaciones reflejaron adecuadamente lo aprendido en la asignatura?</b></label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta6b" value="1" required>
                                                        <label class="form-check-label">Totalmente</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta6b" value="2">
                                                        <label class="form-check-label">En su mayoría</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta6b" value="3">
                                                        <label class="form-check-label">En parte</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta6b" value="4">
                                                        <label class="form-check-label">No reflejaron lo aprendido</label>
                                                    </div>
                                                </div>
                                                <div class="box-footer clearfix mt-3">
                                                    <button type="reset" class="btn btn-sm btn-info btn-flat pull-left">Cancelar</button>
                                                    <button type="submit" class="btn btn-sm btn-success btn-flat pull-right">Enviar respuesta</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>';
                                $data['cantidad']++;
                            }
                        }
                    }
                    // entra aqui cuando el estudiante tiene un horario especial.
                    else {
                        //se consulta el grupo
                        $consulta_grupo = $verencuestadocente->consulta_grupo($consulta_materias[$a]['nombre_materia'], $consulta_materias[$a]['jornada'], $consulta_materias[$a]['semestre'], $consulta_materias[$a]['programa'], $consulta_materias[$a]['grupo']);
                        for ($e = 0; $e < count($consulta_grupo); $e++) {
                            //se consulta el docente por medio del id_docente_grupo_esp 
                            $rspta3 = $verencuestadocente->docente_grupo_por_id($id_docente_grupo_esp);
                            
                            $id_docente = $rspta3["id_docente"];
                            // Verificar si el estudiante ya ha respondido esta evaluación
                            $consulta_respondio = $verencuestadocente->consulta_respondio_docente($id_docente_grupo_esp, $id_docente, $consulta_programas[$i]['id_estudiante']);
                            // Si no ha respondido, mostrar el formulario
                            if (!$consulta_respondio) {
                                $datos_docente = $verencuestadocente->datos_docente( $id_docente);
                                if (file_exists('../files/docentes/' . $datos_docente['usuario_identificacion'] . '.jpg')) {
                                    $foto = '<img src=../files/docentes/' . $datos_docente['usuario_identificacion'] . '.jpg width=50px height=50px class=user-image>';
                                } else {
                                    $foto = '<img src=../files/null.jpg width=50px height=50px class=user-image>';
                                }
                                $data['conte'] .= '
                            <div class="col-md-3">
                                <div class="card card-' . $colores[$i] . '">
                                    <div class="card-header">
                                        <h3 class="card-title">' . $consulta_grupo[$e]['nombre'] . '</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i> </button>
                                        </div>
                                    </div>
                                    <div class="card-body" style="display: block;">
                                        <form class="form_preguntas_docente' . ($data['cantidad'] + 1) . '" method="POST">
                                            <input type="hidden" name="id_docente_grupo" value="' . $id_docente_grupo_esp . '">
                                            <input type="hidden" name="id_docente" value="' . $consulta_grupo[$e]['id_docente'] . '">
                                            <input type="hidden" name="id_estudiante" value="' . $consulta_programas[$i]['id_estudiante'] . '">
                                            <div class="col-md-12">
                                                ' . $foto . ' <strong>' . $datos_docente['usuario_nombre'] . ' ' . $datos_docente['usuario_nombre_2'] . ' ' . $datos_docente['usuario_apellido'] . ' ' . $datos_docente['usuario_apellido_2'] . '</strong>
                                            </div>
                                            <div class="text-danger"> Califique de 0 a 5 siendo 0 la calificación más baja y 5 la calificación más alta. </div>
                                            <div class="card-body">
                                                
                                                    <div class="form-group">
                                                    <label><b>¿Cómo calificarías la efectividad del docente en la enseñanza de la asignatura?</b></label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta1b" value="1" required>
                                                        <label class="form-check-label">Excelente</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta1b" value="2">
                                                        <label class="form-check-label">Buena</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta1b" value="3">
                                                        <label class="form-check-label">Regular</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta1b" value="4">
                                                        <label class="form-check-label">Deficiente</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label><b>¿El docente utiliza herramientas digitales e inteligencia artificial para facilitar el aprendizaje?</b></label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta2b" value="1" required>
                                                        <label class="form-check-label">Siempre</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta2b" value="2">
                                                        <label class="form-check-label">Frecuentemente</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta2b" value="3">
                                                        <label class="form-check-label">Raramente</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta2b" value="4">
                                                        <label class="form-check-label">Nunca</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label><b>¿Consideras que el docente emplea metodologías creativas que te ayudan a comprender mejor los temas?</b></label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta3b" value="1" required>
                                                        <label class="form-check-label">Siempre</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta3b" value="2">
                                                        <label class="form-check-label">Frecuentemente</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta3b" value="3">
                                                        <label class="form-check-label">A veces</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta3b" value="4">
                                                        <label class="form-check-label">Nunca</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label><b>¿El ambiente de aprendizaje en la clase es motivador y facilita la colaboración entre estudiantes?</b></label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta4b" value="1" required>
                                                        <label class="form-check-label">Siempre</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta4b" value="2">
                                                        <label class="form-check-label">Frecuentemente</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta4b" value="3">
                                                        <label class="form-check-label">A veces</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta4b" value="4">
                                                        <label class="form-check-label">Nunca</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label><b>¿Te sientes satisfecho(a) con el nivel de apoyo que recibiste para entender el contenido de la clase?</b></label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta5b" value="1" required>
                                                        <label class="form-check-label">Muy satisfecho(a)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta5b" value="2">
                                                        <label class="form-check-label">Satisfecho(a)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta5b" value="3">
                                                        <label class="form-check-label">Poco satisfecho(a)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta5b" value="4">
                                                        <label class="form-check-label">Insatisfecho(a)</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label><b>¿Los exámenes y evaluaciones reflejaron adecuadamente lo aprendido en la asignatura?</b></label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta6b" value="1" required>
                                                        <label class="form-check-label">Totalmente</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta6b" value="2">
                                                        <label class="form-check-label">En su mayoría</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta6b" value="3">
                                                        <label class="form-check-label">En parte</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="pregunta6b" value="4">
                                                        <label class="form-check-label">No reflejaron lo aprendido</label>
                                                    </div>
                                                </div>
                                                <div class="box-footer clearfix mt-3">
                                                    <button type="reset" class="btn btn-sm btn-info btn-flat pull-left">Cancelar</button>
                                                    <button type="submit" class="btn btn-sm btn-success btn-flat pull-right">Enviar respuesta</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>';
                                $data['cantidad']++;
                            }
                        }
                    }
                }
            }
            if ($data['cantidad'] == 0) {
                $data['completo'] = true;
            }
        }
        echo json_encode($data);
        break;

    case 'registro_docente':
        $id_docente_grupo = isset($_POST['id_docente_grupo']) ? $_POST['id_docente_grupo'] : 0;
        $id_docente = isset($_POST['id_docente']) ? $_POST['id_docente'] : 0;
        $id_estudiante = isset($_POST['id_estudiante']) ? $_POST['id_estudiante'] : 0;
        $pregunta1b = isset($_POST['pregunta1b']) ? $_POST['pregunta1b'] : 0;
        $pregunta2b = isset($_POST['pregunta2b']) ? $_POST['pregunta2b'] : 0;
        $pregunta3b = isset($_POST['pregunta3b']) ? $_POST['pregunta3b'] : 0;
        $pregunta4b = isset($_POST['pregunta4b']) ? $_POST['pregunta4b'] : 0;
        $pregunta5b = isset($_POST['pregunta5b']) ? $_POST['pregunta5b'] : 0;
        $pregunta6b = isset($_POST['pregunta6b']) ? $_POST['pregunta6b'] : 0;
        $verencuestadocente->registro_bienestar($id_docente_grupo, $id_docente, $id_estudiante, $pregunta1b, $pregunta2b, $pregunta3b, $pregunta4b, $pregunta5b, $pregunta6b);

        break;
}
