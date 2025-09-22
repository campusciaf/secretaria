<?php
require_once "../modelos/ReporteInfluencer.php";
require "../mail/send_notificacion_respuesta_reserva.php";
require "../mail/template_notificacion_respuesta_influencer.php";
// variables para datos de registro
$fecha = date('Y-m-d');
$hora = date('H:i');
$ip = $_SERVER['REMOTE_ADDR'];
//variable para saber que usuario hizo el registro
$id_usuario = $_SESSION['id_usuario'];
// error_reporting(1); 
$reporte_influencer = new ReporteInfluencer();
switch ($_GET["op"]) {
    case 'listarprogramas':
        $color_nivel_accion = array("Positiva" => "text-success", "Media" => "text-warning", "Alta" => "text-danger", "Neutra" => "text-secondary");
        $texto_nivel_accion = array("Positiva" => "Positiva", "Media" => "Atención Suave", "Alta" => "Ruta Inmediata", "Neutra" => "Sin Nivel");
        $traer_ultimo_periodo = $reporte_influencer->mostrarPeriodos();
        // traemos el ultimo periodo para tomarlo como periodo actual y filtra la tabla por ese ultimo periodo
        if (count($traer_ultimo_periodo) > 0) {
            $ultimo_periodo = reset($traer_ultimo_periodo)['periodo'];
            //traemos tanto el periodo seleccionado como el ultimo y dependiendo de lo que seleccione el usuario se muestra el periodo que seleccione o carga el ultimo periodo por defecto.
            $periodoSeleccionado = isset($_POST['periodoSeleccionado']) && !empty($_POST['periodoSeleccionado']) ? $_POST['periodoSeleccionado'] : $ultimo_periodo;
        }
        $nivelSeleccionado = isset($_POST['nivelSeleccionado']) ? $_POST['nivelSeleccionado'] : 'Todos';
        $rspta = $reporte_influencer->mostrarreporteinfluencer($periodoSeleccionado);
        $data = array();
        $reg = $rspta;
        for ($i = 0; $i < count($reg); $i++) {
            $id_influencer_reporte  = $reg[$i]["id_influencer_reporte"];
            $id_estudiante = $reg[$i]["id_estudiante"];
            $mensaje = $reg[$i]["influencer_mensaje"];
            $influencer_dimension = $reg[$i]["influencer_dimension"];
            $area_responsable = $reg[$i]["area_responsable"];
            $reporte_estado = $reg[$i]["reporte_estado"];
            $influencer_nivel_accion = (empty($reg[$i]["influencer_nivel_accion"])) ? "Neutra" : $reg[$i]["influencer_nivel_accion"];
            if ($nivelSeleccionado !== 'Todos' && $influencer_nivel_accion !== $nivelSeleccionado) {
                continue;
            }
            $mensaje_html = '<div class="expandir_texto" data-toggle="tooltip" data-html="true" title="' . htmlspecialchars($mensaje) . '" style="height:50px; overflow:hidden; cursor:pointer; tu-propiedad-css:aquí;">' . $mensaje . '</div>';
            $fecha = $reporte_influencer->fechaesp($reg[$i]["fecha"]);
            $hora = $reg[$i]["hora"];
            $datos_estudiante = $reporte_influencer->datos_estudiantes($id_estudiante);
            if (empty($datos_estudiante) || !isset($datos_estudiante[0])) {
                $cedula_estudiante = "";
                $nombre_estudiante = "";
                $semestre_estudiante = "";
                $credencial_login = "";
                $fo_programa = "";
                $periodo_activo = "";
            } else {
                $cedula_estudiante = $datos_estudiante[0]["credencial_identificacion"];
                $nombre_estudiante = $datos_estudiante[0]["credencial_nombre"] . " " . $datos_estudiante[0]["credencial_nombre_2"] . " " . $datos_estudiante[0]["credencial_apellido"] . " " . $datos_estudiante[0]["credencial_apellido_2"];
                $semestre_estudiante = $datos_estudiante[0]["semestre_estudiante"];
                $credencial_login = $datos_estudiante[0]["credencial_login"];
                $fo_programa = $datos_estudiante[0]["fo_programa"];
                $periodo_activo = $datos_estudiante[0]["periodo_activo"];
            }
            $id_materia = $reg[$i]["id_materia"];
            $id_docente = $reg[$i]["id_docente"];
            $id_usuario = $reg[$i]["id_usuario"];
            $id_programa = $reg[$i]["id_programa"];
            if (empty($id_docente)) {
                $datosdocente =  $reporte_influencer->datosUsuario($id_usuario);
                $boton_seguimiento = '<button class="btn btn-outline-primary btn-sm" onclick="mostrarInfoReporte(' . $id_influencer_reporte . ', `usuario`)"><i class="fa fa-eye"></i></button>';
            } else {
                $datosdocente = $reporte_influencer->datosdocente($id_docente);
                $boton_seguimiento = '<button class="btn btn-outline-primary btn-sm" onclick="mostrarInfoReporte(' . $id_influencer_reporte . ', `docente`)"><i class="fa fa-eye"></i></button>';
            }
            $id_materia_influencer = $reporte_influencer->datos_materia($id_programa, $id_docente, $id_materia, $periodo_activo);
            $id_materia = isset($id_materia_influencer[0]["id_materia"]) ? $id_materia_influencer[0]["id_materia"] : "";
            $semestre = isset($id_materia_influencer[0]["semestre"]) ? $id_materia_influencer[0]["semestre"] : "";
            $jornada = isset($id_materia_influencer[0]["jornada"]) ? $id_materia_influencer[0]["jornada"] : "";
            $rspta_reporte = $reporte_influencer->respuestasReporteInfluencer($id_influencer_reporte);
            $con_respuesta = count($rspta_reporte);

            $data[] = array(
                "0" => $boton_seguimiento,
                "1" => $datosdocente["usuario_nombre"] . ' ' . $datosdocente["usuario_apellido"],
                "2" => $cedula_estudiante,
                "3" => $nombre_estudiante,
                "4" => $credencial_login,
                "5" => $fo_programa,
                //"6" => $nombre,
                "6" => $semestre,
                "7" => $jornada,
                "8" => '<span class="' . $color_nivel_accion[$influencer_nivel_accion] . '"> <i class="fas fa-circle"></i> ' . $texto_nivel_accion[$influencer_nivel_accion] . '</span>',
                "9" => $influencer_dimension,
                "10" => $mensaje_html,
                "11" => $fecha . " - " . $hora,
                "12" => $area_responsable,
                "13" => ($con_respuesta == 0) ? '<span class="badge bg-secondary">Sin Respuesta</span>' : '<span class="badge bg-success">Con Respuesta</span>',
                "14" => ($reporte_estado == 0) ? '<span class="badge bg-info">Cerrado</span>' : '<span class="badge bg-warning">Abierto</span>'
            );
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);
        break;
    case 'mostrarInfoReporte':
        $id_influencer_reporte = $_POST["id_influencer_reporte"];
        $tipo_influencer = $_POST["tipo_influencer"];
        if ($tipo_influencer == 'usuario') {
            $rspta = $reporte_influencer->mostrarInfoReporteUsuario($id_influencer_reporte);
        } else {
            $rspta = $reporte_influencer->mostrarInfoReporteDocente($id_influencer_reporte);
        }
        $html = "";
        if (isset($rspta["docente_nombre"])) {
            $data["exito"] = 1;
            $fecha = $reporte_influencer->fechaesp($rspta["fecha"]);
            if (file_exists('../files/estudiantes/' . $rspta['credencial_identificacion'] . '.jpg')) {
                $img = '<img src=../files/estudiantes/' . $rspta['credencial_identificacion'] . '.jpg class="direct-chat-img">';
            } else {
                $img = '<img src=../files/null.jpg class="direct-chat-img">';
            }
            // datos para enviar el correo una vez den resputa.
            $data["docente_nombre"]    = $rspta["docente_nombre"];
            $data["nombre_estudiante"] = $rspta["nombre_estudiante"];
            $data["usuario_login"] = $rspta["usuario_login"];
            $html .= '<div class="direct-chat-msg">';
            $html .= '    <div class="direct-chat-info clearfix">';
            $html .= '        <span class="direct-chat-name pull-left"> Doc.  ' . $rspta["docente_nombre"] . ' <i class="fas fa-arrow-right"></i>  ' . $rspta["nombre_estudiante"] . '</span><br>';
            $html .= '        <small><span class="direct-chat-timestamp">' . $fecha . ' a las ' . $rspta["hora"] . '</span></small>';
            $html .= '    </div>';
            $html .=      $img;
            $html .= '    <div class="direct-chat-text">';
            $html .=          $rspta["influencer_mensaje"];
            $html .= '    </div>';
            $html .= '</div>';
            $rspta_reporte = $reporte_influencer->respuestasReporteInfluencer($id_influencer_reporte);
            for ($i = 0; $i < count($rspta_reporte); $i++) {
                $fecha = explode(" ", $rspta_reporte[$i]["created_dt"]);
                $fecha_respuesta = $reporte_influencer->fechaesp($fecha[0]);
                $hora_respuesta = $fecha[1];
                if (file_exists('../files/usuarios/' . $rspta_reporte[$i]['id_usuario'] . '.jpg')) {
                    $img_respuesta = '<img src=../files/usuarios/' . $rspta_reporte[$i]['id_usuario'] . '.jpg class="direct-chat-img">';
                } else {
                    $img_respuesta = '<img src=../files/null.jpg class="direct-chat-img">';
                }
                $html .= '<div class="direct-chat-msg right">';
                $html .= '    <div class="direct-chat-info clearfix">';
                $html .= '        <span class="direct-chat-name pull-right">' . $rspta_reporte[$i]["usuario_nombre"] . ' ' . $rspta_reporte[$i]["usuario_apellido"] . '</span><br>';
                $html .= '        <small><span class="direct-chat-timestamp pull-left">' . $fecha_respuesta . ' a las: ' . $hora_respuesta . '</span></small>';
                $html .= '    </div>';
                $html .=      $img_respuesta;
                $html .= '    <div class="direct-chat-text">';
                $html .=          $rspta_reporte[$i]["mensaje_respuesta"];
                $html .= '    </div>';
                $html .= '</div>';
            }
        } else {
            $data["exito"] = 0;
        }
        $data["info"] = $html;
        echo json_encode($data);
        break;
    case 'insertarRespuestaReporte':
        $id_influencer_reporte = $_POST["id_reporte_influencer"];
        $mensaje_respuesta = $_POST["mensaje_respuesta"];
        $id_usuario = $_SESSION['id_usuario'];

        $docente_nombre_correo = $_POST["docente_nombre"];
        $nombre_estudiante_correo = $_POST["nombre_estudiante"];
        $usuario_login_correo = $_POST["usuario_login"];

        $respuesta = $reporte_influencer->insertarRespuestaReporte($id_influencer_reporte, $mensaje_respuesta, $id_usuario);
        if ($respuesta) {
            // enviamos el correo al docente o funcionario notificando que se les dio respuesta al caso.
            $mensaje = set_template_notificacion_respuesta_influencer($docente_nombre_correo, $nombre_estudiante_correo);
            enviar_correo($usuario_login_correo.", sistemasdeinformacion@ciaf.edu.co", "Se ha generado una respuesta sobre tu caso de influencer +", $mensaje);

            $fecha = date("Y-d-m");
            $hora_respuesta = date("H:i:s");
            $fecha_respuesta = $reporte_influencer->fechaesp($fecha);
            if (file_exists('../files/usuarios/' . $_SESSION['id_usuario'] . '.jpg')) {
                $img_respuesta = '<img src=../files/usuarios/' . $_SESSION['id_usuario'] . '.jpg class="direct-chat-img">';
            } else {
                $img_respuesta = '<img src=../files/null.jpg class="direct-chat-img">';
            }
            $html = '<div class="direct-chat-msg right">';
            $html .= '    <div class="direct-chat-info clearfix">';
            $html .= '        <span class="direct-chat-name pull-right">' . $_SESSION["usuario_nombre"] . ' ' . $_SESSION["usuario_apellido"] . '</span><br>';
            $html .= '        <small><span class="direct-chat-timestamp pull-left">' . $fecha_respuesta . ' a las: ' . $hora_respuesta . '</span></small>';
            $html .= '    </div>';
            $html .=      $img_respuesta;
            $html .= '    <div class="direct-chat-text">';
            $html .=          $mensaje_respuesta;
            $html .= '    </div>';
            $html .= '</div>';
            echo json_encode(array("exito" => 1, "info" => "Respuesta enviada correctamente.", "html" => $html));
        } else {
            echo json_encode(array("exito" => 0, "info" => "Error al enviar la respuesta."));
        }
        break;
    case "selectPeriodo":
        $rspta = $reporte_influencer->mostrarPeriodos();
        echo "<option selected>Nothing selected</option>";
        for ($i = 0; $i < count($rspta); $i++) {
            $periodo = $rspta[$i]["periodo"];
            echo "<option value='" . $periodo . "'>" . $periodo . "</option>";
        }
        break;
}
