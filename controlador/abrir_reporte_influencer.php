<?php
require_once "../modelos/AbrirReporteInfluencer.php";
require("../public/mail/sendSolicitud.php");
require("../public/mail/templateInfluencer.php");
require_once "../modelos/WhatsappModule.php";
$consulta = new AbrirReporteInfluencer();
$whatsapp_obj = new whatsappModule();
switch ($_GET['op']) {
    case 'buscar_estudiante': //traemos los datos personales del estudiante
        $ciclos = array(1, 2, 3, 4);
        $id_programa_ac = 0;
        $id_estudiante = 0;
        $dato_a_buscar = $_POST['dato_busqueda']; /*tomamos el dato enviado desde js*/
        $rsta = $consulta->consultaEstudiante($dato_a_buscar);
        if (empty($rsta)) {
            $data = array(
                'exito' => '0',
                'info' => 'Revisa el documento, no se encontraron datos.'
            );
        } else {
            //verificacion de la imagen
            if (file_exists('../files/estudiantes/' . $rsta['credencial_identificacion'] . '.jpg')) {
                $foto = '../files/estudiantes/' . $rsta['credencial_identificacion'] . '.jpg';
            } else {
                $foto = '../files/null.jpg';
            }
            $data = array(
                'exito' => '1',
                'info' => array(
                    'id_credencial' => $rsta["id_credencial"],
                    'nombre_estudiante' => $rsta["credencial_nombre"] . " " . $rsta["credencial_nombre_2"],
                    'apellido_estudiante' => $rsta["credencial_apellido"] . " " . $rsta["credencial_apellido_2"],
                    'tipo_identificacion' => $rsta["tipo_documento"],
                    'numero_documento' => $rsta["credencial_identificacion"],
                    'direccion' => $rsta["direccion"],
                    'celular' => $rsta["celular"],
                    'email' => $rsta["credencial_login"],
                    'foto' => $foto,
                )
            );
            $html = "";
            $html .= '<div class="row">';
            $programas = $consulta->consultaProgramas($rsta["id_credencial"]);
            for ($i = 0; $i < count($programas); $i++) {
                $html .= '<div class="col-6 borde rounded">
                            <b> Programa:</b><br> <a class=" box-profiledates profile-programa">' . $programas[$i]['fo_programa'] . '</a>
                            <b>Semestre:</b> <a class="pull-right box-profiledates profile-semestre">' . $programas[$i]['semestre_estudiante'] . '</a>
                        </div>';
                if (in_array($programas[$i]["ciclo"], $ciclos)) {
                    $id_programa_ac = $programas[$i]["id_programa_ac"];
                    $id_estudiante = $programas[$i]["id_estudiante"];
                }
            }
            $html .= '</div>';
            $data['programas'] = $html;
            $data["id_programa_ac"] = $id_programa_ac; 
            $data["id_estudiante"] = $id_estudiante; 
        }
        echo (json_encode($data));
        break;
    case 'buscar_casos': //traemos los casos del estudiante
        $estado = array(1 => '<span class="badge bg-success">Activo</span>', 0 => '<span class="badge bg-warning">Cerrado</span>');
        $color_nivel_accion = array("Positiva" => "text-success", "Media" => "text-warning", "Alta" => "text-danger");
        $texto_nivel_accion = array("Positiva" => "Positiva", "Media" => "Atención Suave", "Alta" => "Ruta Inmediata");
        $dato_a_buscar = $_POST['dato_busqueda']; /*tomamos el dato enviado desde js*/
        $id_usuario = $_SESSION["id_usuario"];
        $rspta = $consulta->consultaCasos($dato_a_buscar, $id_usuario);
        $data = array();
        //print_r($rsta);
        for ($i = 0; $i < count($rspta); $i++) {
            $data[] = array(
                "0" => "<button onclick='mostrarInfoReporte(" . $rspta[$i]['id_influencer_reporte'] . ")' class='btn btn-primary btn-xs' title='Ver reporte'><i class='fa fa-eye'></i></button>",
                "1" => "<i class='fas fa-circle " . $color_nivel_accion[$rspta[$i]['influencer_nivel_accion']] . "'> </i> " . $texto_nivel_accion[$rspta[$i]['influencer_nivel_accion']],
                "2" => $rspta[$i]['influencer_dimension'],
                "3" => $rspta[$i]['influencer_mensaje'],
                "4" => $estado[$rspta[$i]['reporte_estado']],
                "5" => $rspta[$i]['fecha'],
                "6" => $rspta[$i]['hora'],
                "7" => $rspta[$i]['periodo'],
            );
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);
        break;
    case 'reporteinfluencer':
        $id_estudiante = isset($_POST["id_estudiante"]) ? $_POST["id_estudiante"] : "";
        $id_usuario = $_SESSION["id_usuario"];
        $id_programa_ac = isset($_POST["id_programa_ac"]) ? $_POST["id_programa_ac"] : "";
        $id_materia = isset($_POST["id_materia"]) ? $_POST["id_materia"] : 0;
        $influencer_mensaje = isset($_POST["influencer_mensaje"]) ? $_POST["influencer_mensaje"] : "";
        $fecha = date("Y-m-d");
        $hora = date("H:i:s");
        $periodo_actual = $_SESSION["periodo_actual"];
        $influencer_nivel_accion = isset($_POST["influencer_nivel_accion"]) ? $_POST["influencer_nivel_accion"] : "";
        $influencer_dimension = isset($_POST["influencer_dimension"]) ? $_POST["influencer_dimension"] : "";
        $traerIDirector = $consulta->programaacademico($id_programa_ac);
        $id_director = $traerIDirector["programa_director"];
        $traerDatosDirector = $consulta->traerDatosDirector($id_director);
        $correodir = $traerDatosDirector["usuario_login"];
        $nombre_docente = $_SESSION["usuario_nombre"] . ' ' . $_SESSION["usuario_apellido"];
        $traerdatosestuidantes = $consulta->estudianteDatos($id_estudiante);
        $nombre_estudiante = $traerdatosestuidantes["credencial_nombre"] . ' ' . $traerdatosestuidantes["credencial_nombre_2"] . ' ' . $traerdatosestuidantes["credencial_apellido"]  . ' ' . $traerdatosestuidantes["credencial_apellido_2"];
        $identificacion = $traerdatosestuidantes["credencial_identificacion"];
        $correo = $correodir;
        $asunto = "Se ha generado un reporte Influencer + Caso: " . $identificacion;
        $mensaje = set_template_influencer($influencer_mensaje, $nombre_docente, $nombre_estudiante, $identificacion);
        $rspta = $consulta->insertarreporteinfluencer($id_estudiante, $id_usuario, $id_programa_ac, $id_materia, $influencer_mensaje, $fecha, $hora, $periodo_actual, $influencer_nivel_accion, $influencer_dimension);
        if($rspta){
            enviar_correo($correo, $asunto, $mensaje);
            if ($influencer_nivel_accion == "Alta" && $influencer_nivel_accion == "Media") {
                $numeros_celular = array(
                    0 => array("numero_celular" => "3122118798", "usuario_nombre" => "Julian Jimenez", "usuario_cargo" => "Director"),
                    1 => array("numero_celular" => "3125002048", "usuario_nombre" => "Gina Barreto", "usuario_cargo" => "Rectora"),
                    2 => array("numero_celular" => "3007779574", "usuario_nombre" => "Andres Buchelli", "usuario_cargo" => "Vicerrector"),
                    3 => array("numero_celular" => "3046452836", "usuario_nombre" => "Adrian Rios", "usuario_cargo" => "Vicerrector"),
                    4 => array("numero_celular" => $celular_director, "usuario_nombre" => $nombre_director, "usuario_cargo" => "Director/Coordinador"),
                    5 => array("numero_celular" => "3107354509", "usuario_nombre" => "David Gonzalez", "usuario_cargo" => "Coordinador"),
                );
                for ($i = 0; $i < count($numeros_celular); $i++) {
                    $mensaje = '{
						"messaging_product": "whatsapp",
						"to": "' . $numeros_celular[$i]["numero_celular"] . '",
						"type": "template",
						"template": {
							"name": "reporte_influencer",
							"language": { "code": "es" },
							"components": [{
								"type": "body",
								"parameters": [
								{
									"type": "text",
									"text": "' . $numeros_celular[$i]["usuario_cargo"] . '"
								},
								{
									"type": "text",
									"text": "' . $numeros_celular[$i]["usuario_nombre"] . '"
								},
								{
									"type": "text",
									"text": "' . $nombre_estudiante . '"
								},
								{
									"type": "text",
									"text": "' . $influencer_dimension . '"
								}]
							}]
						},
					}';
                    //almacenar datos en array para genrera el text
                    $datos_mensaje = array(
                        'numero_whatsapp' => $numeros_celular[$i]["numero_celular"],
                        'nombre_perfil' => "CIAF",
                        'texto' => "Aviso creación Influencer +",
                        'align' => "chat-right",
                        'background' => "color_send_message",
                        'fecha' => date("Y-m-d"),
                        'hora' => date("H:i:s"),
                        'id_usuario' => 0,
                        'tipo_mensaje' => "template",
                    );
                    $datos = $whatsapp_obj->enviarMensajeMeta($token, $url, $mensaje, $numeros_celular[$i]["numero_celular"], $datos_mensaje);
                }
            }
        }
        $data["0"] = $rspta ? "ok" : "error";
        $results = array($data);
        echo json_encode($results);
        break;
    case 'mostrarInfoReporte':
        $id_influencer_reporte = $_POST["id_influencer_reporte"];
        $rspta = $consulta->mostrarInfoReporte($id_influencer_reporte);
        $html = "";
        if (isset($rspta["docente_nombre"])) {
            $data["exito"] = 1;
            $fecha = $consulta->fechaesp($rspta["fecha"]);
            if (file_exists('../files/estudiantes/' . $rspta['credencial_identificacion'] . '.jpg')) {
                $img = '<img src=../files/estudiantes/' . $rspta['credencial_identificacion'] . '.jpg class="direct-chat-img">';
            } else {
                $img = '<img src=../files/null.jpg class="direct-chat-img">';
            }
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
            $rspta_reporte = $consulta->respuestasReporteInfluencer($id_influencer_reporte);
            for ($i = 0; $i < count($rspta_reporte); $i++) {
                $fecha = explode(" ", $rspta_reporte[$i]["created_dt"]);
                $fecha_respuesta = $consulta->fechaesp($fecha[0]);
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
            if($rspta["reporte_estado"] == 1){
                $html .= '<div class="text-right">
                    <button class="btn btn-warning my-3" onclick="abrirFormCerrarCaso(' . $rspta['id_influencer_reporte'] . ')"> Cerrar Caso </button>
                </div>';
            }
        } else {
            $data["exito"] = 0;
        }
        $data["info"] = $html;
        echo json_encode($data);
        break;
    case 'cerrarReporteInfluencer':
        $id_influencer_reporte = isset($_POST["id_influencer_reporte"]) ? $_POST["id_influencer_reporte"] : "";
        $influencer_tipo_cierre = isset($_POST["influencer_tipo_cierre"]) ? $_POST["influencer_tipo_cierre"] : "";
        $influencer_reflexion = isset($_POST["influencer_reflexion"]) ? $_POST["influencer_reflexion"] : "";
        $influencer_acciones = isset($_POST['influencer_acciones']) ? $_POST['influencer_acciones'] : [];
        if (in_array('otro', $influencer_acciones) && !empty($_POST['influencer_otra_accion'])) {
            $influencer_acciones = array_diff($influencer_acciones, ['otro']); // quita "otro" del array
            $influencer_acciones[] = $_POST['influencer_otra_accion']; // agrega el texto personalizado
        }
        $influencer_acciones = implode(', ', $influencer_acciones);
        $influencer_resultado_final = isset($_POST["influencer_resultado_final"]) ? $_POST["influencer_resultado_final"] : "";
        $influencer_comentario_final = isset($_POST["influencer_comentario_final"]) ? $_POST["influencer_comentario_final"] : "";
        $cierre_caso = $consulta->cerrarReporteInfluencer($influencer_tipo_cierre, $influencer_reflexion, $influencer_acciones, $influencer_resultado_final, $influencer_comentario_final, $id_influencer_reporte);
        if ($cierre_caso) {
            $data = array("exito" => 1, "info" => "Cierre exitoso");
        } else {
            $data = array("exito" => 0, "info" => "Error al realizar el cierre");
        }
        echo json_encode($data);
        break;
}
