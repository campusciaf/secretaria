<?php

date_default_timezone_set("America/Bogota");
require_once "../modelos/Ayuda.php";
require('../public/mail/sendAyuda.php');
$ayuda = new Ayuda();
$mensaje_final = "";
$id_credencial = $_SESSION['id_usuario'];
$periodo_actual = $_SESSION['periodo_actual'];
$id_ayuda = isset($_POST["id_ayuda"]) ? limpiarCadena($_POST["id_ayuda"]) : "";
$id_asunto = isset($_POST["id_asunto"]) ? limpiarCadena($_POST["id_asunto"]) : "";
$mensaje = isset($_POST["mensaje"]) ? limpiarCadena($_POST["mensaje"]) : "";
$id_asunto_opcion = isset($_POST["id_asunto_opcion"]) ? limpiarCadena($_POST["id_asunto_opcion"]) : "";
$fecha = date('Y-m-d');
$hora = date('H:i:s');
switch ($_GET["op"]) {
    case 'guardaryeditar':
        if (empty($id_ayuda)) {
            $mensaje_final .= '<h2> Mensaje generado desde el módulo de contáctanos </h2><br>';
            $mensaje_final .= $mensaje;
            $mensaje_final .= '<br><br>';
            $mensaje_final .= 'Recordemos dar solución usando el campus virtual (Contáctanos)';
            $buscardependencia = $ayuda->buscardependencia($id_asunto_opcion);
            $id_dependencia = $buscardependencia["dependencia"];
            $buscarcorreo = $ayuda->datosDependencia($id_dependencia);
            $id_usuario = $buscarcorreo["id_usuario"];
            $destino = $buscarcorreo["usuario_login"];
            $buscaropcionasunto = $ayuda->buscaropcionasunto($id_asunto_opcion); // busca el asunto
            $opcion = $buscaropcionasunto["opcion"];
            $asunto = $opcion;
            enviar_correo($destino, $asunto, $mensaje_final);
            $rspta = $ayuda->insertar($id_credencial, $id_asunto, $id_asunto_opcion, $id_usuario, $mensaje, $fecha, $hora, $periodo_actual);
            echo $rspta ? "Mensaje enviado-'.$destino.'" : "mensaje no se pudo Enviar";
        } else {
            echo "Error";
        }
        break;
  case 'listar':
    $rspta = $ayuda->listar();
    $reg = $rspta;
    $data = array();
    $data["0"] = '';

    $data["0"] .= '<div class="d-flex" style="position: relative;">';


    $data["0"] .= '
    <div style="width:60px;display:flex;flex-direction:column;align-items:center;position:relative;">
        <div style="position:absolute;top:0;bottom:0;left:50%;transform:translateX(-50%);width:4px;background:#ccc;"></div>';

   
    for ($i = 0; $i < count($reg); $i++) {
        $estado = $reg[$i]["estado"];
        $color_estado = $estado == 1 ? "#fff" : "#28a745";
        $borde_estado = $estado == 1 ? "3px solid #ccc" : "none";
        $icono = $estado == 1 ? "" : '<i class="fas fa-check text-white" style="font-size:12px;"></i>';

        $data["0"] .= '
        <div style="margin: 30px 0; z-index:1;">
            <div style="width:24px;height:24px;background:' . $color_estado . ';border:' . $borde_estado . ';border-radius:50%;display:flex;align-items:center;justify-content:center;">
                ' . $icono . '
            </div>
        </div>';
    }

    $data["0"] .= '</div>'; 

    
    $data["0"] .= '<div class="flex-grow-1" style="padding-left:20px;">';

    for ($i = 0; $i < count($reg); $i++) {
        $nombre1 = $reg[$i]["credencial_nombre"];
        $nombre2 = $reg[$i]["credencial_nombre_2"];
        $apellido1 = $reg[$i]["credencial_apellido"];
        $apellido2 = $reg[$i]["credencial_apellido_2"];
        $nombre_completo = trim($nombre1 . ' ' . $nombre2 . ' ' . $apellido1 . ' ' . $apellido2);

        $buscarasunto = $ayuda->buscarasunto($reg[$i]["id_asunto"]);
        $asunto = $buscarasunto["asunto"];
        $buscaropcionasunto = $ayuda->buscaropcionasunto($reg[$i]["id_asunto_opcion"]);
        $opcion = $buscaropcionasunto["opcion"];

        $estado = $reg[$i]["estado"] == 1 ? "Pendiente" : "Solucionado";
        $color_estado = $reg[$i]["estado"] == 1 ? "#17a2b8" : "#28a745";
        $icono_estado = $reg[$i]["estado"] == 1 ? "" : '<i class="fas fa-arrow-circle-right text-success" style="font-size:1.5em;"></i>';
        $img_usuario = (file_exists('../files/estudiantes/' . $_SESSION['usuario_imagen'] . '.jpg') ? '../files/estudiantes/' . $_SESSION['usuario_imagen'] . '.jpg' : '../files/null.jpg');

        $data["0"] .= '
        <div class="mb-4">
            <div class="card shadow-sm p-3 mb-2" style="border-radius:16px;">
                <div class="d-flex align-items-center justify-content-between" data-toggle="collapse" data-target="#conversacion' . $reg[$i]["id_ayuda"] . '" style="cursor:pointer;">
                    <div class="d-flex align-items-center">
                        <img src="' . $img_usuario . '" class="rounded-circle mr-3" style="width:48px;height:48px;object-fit:cover;border:3px solid ' . $color_estado . ';margin-right:15px;">
                        <div>
                            <div class="font-weight-bold" style="font-size:1.1em;">' . $nombre_completo . '</div>
                            <div class="small text-muted">' . $ayuda->fechaesp($reg[$i]["fecha_solicitud"]) . ' | ' . $reg[$i]["hora_solicitud"] . ' | ' . $asunto . ' - ' . $opcion . '</div>
                        </div>
                    </div>
                    <div class="ml-auto">' . $icono_estado . '</div>
                </div>

                <div id="conversacion' . $reg[$i]["id_ayuda"] . '" class="collapse mt-3">
                    <div class="mb-3" style="background:#ffffff;color:#000000;border-radius:20px;padding:14px 18px;position:relative;max-width:85%;margin-left:auto;margin-right:0;border:1px solid #ccc;">
                        <i class="fas fa-user-circle text-primary"></i> <b>Tu mensaje:</b><br>
                        ' . nl2br($reg[$i]["mensaje"]) . '
                    </div>';

       
        $rspta2 = $ayuda->listarRespuesta($reg[$i]["id_ayuda"]);
        $reg2 = $rspta2;
        for ($j = 0; $j < count($reg2); $j++) {
            $datosusuario = $ayuda->datosDependencia($reg2[$j]["id_usuario"]);
            $img_respuesta = (file_exists('../files/usuarios/' . $datosusuario['usuario_imagen'])) ? '../files/usuarios/' . $datosusuario['usuario_imagen'] : '../files/null.jpg';
            $cargo = $datosusuario["usuario_cargo"];
            $fecha = $ayuda->fechaesp($reg2[$j]["fecha_respuesta"]);
            $hora = $reg2[$j]["hora_respuesta"];
            $periodo = $reg2[$j]["periodo_respuesta"];
            $is_redirigido = $reg2[$j]["accion"] != 0;
            $color_resp = $is_redirigido ? "#fff3cd" : "#e9f7ef";
            $color_text = $is_redirigido ? "#856404" : "#155724";
            $icono_resp = $is_redirigido ? "fas fa-random" : "fas fa-reply";
            $borde_resp = $is_redirigido ? "2px solid #ffc107" : "2px solid #28a745";

            $data["0"] .= '
                    <div class="d-flex align-items-start mb-3" style="max-width:85%;">
                        <img src="' . $img_respuesta . '" class="rounded-circle mr-3" style="width:40px;height:40px;object-fit:cover;border:' . $borde_resp . ';margin-right:15px;">
                        <div style="background:' . $color_resp . ';color:' . $color_text . ';border-radius:16px;padding:14px 18px;border:1px solid #ccc;position:relative;">
                            <div class="font-weight-bold"><i class="' . $icono_resp . '"></i> ' . $cargo . '</div>
                            <div class="small text-muted mb-2">' . $fecha . ' | ' . $hora . ' | Periodo: ' . $periodo . '</div>
                            <div>' . nl2br($reg2[$j]["mensaje_dependencia"]) . '</div>';

            if ($is_redirigido) {
                $rspta3 = $ayuda->datosDependencia($reg2[$j]["id_remite_a"]);
                $data["0"] .= '
                            <div class="alert alert-info mt-2 p-2" style="font-size:0.95em;">
                                <i class="fas fa-exchange-alt"></i> Caso redirigido a <b>' . $rspta3["usuario_cargo"] . '</b>
                            </div>';
            }

            $data["0"] .= '
                        </div>
                    </div>';
        }

        $data["0"] .= '
                </div> <!-- /.collapse -->
            </div> <!-- /.card -->
        </div>'; 
    }

    $data["0"] .= '</div>'; 
    $data["0"] .= '</div>'; 

    $results = array($data);
    echo json_encode($results);
    break;


    case 'listaropciones':
        $id_asunto = $_POST["id_asunto"];
        $rspta = $ayuda->listaropciones($id_asunto);
        $data = array();
        $data["0"] = "";
        $reg = $rspta;
        $data["0"] .= '<label>Asunto:</label>';
        $data["0"] .= '<div class="row">';
        for ($i = 0; $i < count($reg); $i++) {
            $data["0"] .= '
                <div class="col-xl-4 col-lg-6 col-md-4 col-6">
                    <div class="form-check">
                        <label class="form-check-label">	  
                            <input type="radio" name="id_asunto_opcion" class="form-check-input" value="' . $reg[$i]["id_asunto_opcion"] . '">' . $reg[$i]["opcion"] . '
                        </label>
                    </div>
                </div>';
        }
        $data["0"] .= '<div class="row">';
        $results = array($data);
        echo json_encode($results);
        break;
    case "selectDependencia":
        $rspta = $ayuda->selectDependencia();
        for ($i = 0; $i < count($rspta); $i++) {
            echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
        }
        break;
    case "selectAsunto":
        $rspta = $ayuda->selectAsunto();
        echo "<option value=''>Seleccionar</option>";
        for ($i = 0; $i < count($rspta); $i++) {
            echo "<option value='" . $rspta[$i]["id_asunto"] . "'>" . $rspta[$i]["asunto"] . "</option>";
        }
        break;
}