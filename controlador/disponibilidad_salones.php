<?php
require_once "../modelos/Disponibilidad_salones.php";
require "../mail/send_reservas_notificacion.php";
require "../mail/template_notificacion_reservas_docentes.php";
$consulta = new Reserva();
$days = array("Lunes" => 1, "Martes" => 2, "Miercoles" => 3, "Jueves" => 4, "Viernes" => 5, "Sabado" => 6);

date_default_timezone_set("America/Bogota");

$rsptaperiodo = $consulta->periodoactual();
$periodo_actual = $rsptaperiodo["periodo_actual"];
$periodo_anterior = $rsptaperiodo["periodo_anterior"];




switch ($_GET['op']) {

    case 'actualizarEstado':
        $id_docente = isset($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : die(json_encode(array("exito" => 0, "info" => "Sesión caducada, vuelva e inicie sesión.")));
        $rspta = $consulta->actualizarEstado($id_docente);
        $data["exito"] = ($rspta) ? 1 : 0;
        echo json_encode($data);
        break;
    case 'consultarSalones':
        $data[0] = "";
        $sede = $_POST['sede'];
        $rspta = $consulta->consultarSalones($sede);
        $data[0] .= '
            <div class="col-12 tono-3 py-4">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="rounded bg-light-blue p-3 text-primary ">
                            <i class="fa-solid fa-landmark"></i>
                        </span>
                    </div>
                    <div class="col-auto line-height-18">
                        <span class="">Lista de</span> <br>
                        <span class="titulo-2 text-semibold fs-20 line-height-18">Salones</span>
                    </div>
                </div>
            </div>
            <div class="col-12 tono-2 py-2">';
        for ($a = 0; $a < count($rspta); $a++) {
            $codigo = $rspta[$a]["codigo"];
            $tv = $rspta[$a]["tv"];
            $video_beam = $rspta[$a]["video_beam"];
            $capacidad = $rspta[$a]["capacidad"];
            $estado_formulario = $rspta[$a]["estado_formulario"];
            $vertv = ($rspta[$a]["tv"] == 1) ? '<i class="fa-solid fa-tv"></i>' : '';
            $vervideo = ($rspta[$a]["video_beam"] == 1) ? '<i class="fa-solid fa-video"></i>' : '';


            $data[0] .= '<div class="row pb-2 mb-2 border-bottom">';
            $data[0] .= '
                                <div class="col-auto">
                                    <a onclick="iniciarCalendario(`' . $codigo . '`,' . $estado_formulario . ')" class="btn btn-primary btn-xs text-white" title="Ver Horarios y reservas"> <i class="fa-solid fa-calendar-days"></i> Reservar </a>
                                </div>
                            ';
            $data[0] .= '
                                <div class="col-3">
                                   <span class="pl-2">' . $codigo . '</span>
                                </div>
                            ';

            $data[0] .= '
                                <div class="col-2">
                                <span class="pl-2">' . $vertv . '</span>
                                </div>
                            ';
            $data[0] .= '
                                <div class="col-1">
                                <span class="badge bg-info"> ' . $capacidad . '</span>
                                </div>
                            ';

            $data[0] .= '
                                <div class="col-2">
                                <span class="pl-2">' . $vervideo . '</span>
                                </div>
                            ';

            $data[0] .= '<div class="border-bottom my-2"></div>';
            $data[0] .= '</div>';
        }
        $data[0] .= '
            </div>
        </div>';
        echo json_encode($data);
        break;
    case 'iniciarcalendario':
        $codigo_salon = $_POST["codigo_salon"]; // id del salon
        $startDate = $_POST["startDate"]; // fecha de inicio de la semana del calendario
        $endDate = $_POST["endDate"]; // fecha final de al semana del calendario
        $impresion = "";
        $eventos_horarios = $consulta->eventosHorarios($codigo_salon);
        $impresion .= '[';
        for ($i = 0; $i < count($eventos_horarios); $i++) {
            @$id_docente = $eventos_horarios[$i]["id_docente"];
            @$id_docente_grupo = $eventos_horarios[$i]["id_docente_grupo"];
            @$id_materia = $eventos_horarios[$i]["id_materia"];
            @$salon = $eventos_horarios[$i]["salon"];
            @$diasemana = $eventos_horarios[$i]["dia"];
            @$horainicio = $eventos_horarios[$i]["hora"];
            @$horafinal = $eventos_horarios[$i]["hasta"];
            @$corte = $eventos_horarios[$i]["corte"];
            $datosmateria = $consulta->BuscarDatosAsignatura($id_materia);
            @$nombre_materia = $datosmateria["nombre"];
            if ($id_docente == null) {
                $nombre_docente = "Sin Asignar";
            } else {
                $datosdocente = $consulta->docente_datos($id_docente);
                $nombre_docente = $datosdocente["usuario_nombre"] . ' ' . $datosdocente["usuario_apellido"];
            }
            switch ($diasemana) {
                case 'Lunes':
                    $dia = 1;
                    break;
                case 'Martes':
                    $dia = 2;
                    break;
                case 'Miercoles':
                    $dia = 3;
                    break;
                case 'Jueves':
                    $dia = 4;
                    break;
                case 'Viernes':
                    $dia = 5;
                    break;
                case 'Sabado':
                    $dia = 6;
                    break;
                case 'Domingo':
                    $dia = 0;
                    break;
            }
            if ($corte == "1") {
                $color = "#fff";
            } else {
                $color = "#252e53";
            }
            $impresion .= '{
                    "title":"' . $nombre_materia . ' - Salón ' . $salon . ' - doc: ' . $nombre_docente . ' ",
                    "daysOfWeek":"' . $dia . '",   
                    "startTime":"' . $horainicio . '",
                    "endTime":"' . $horafinal . '",
                    "color":"' . $color . '",
                    "fijo": "1"}';
            if ($i + 1 < count($eventos_horarios)) {
                $impresion .= ',';
            }
        }
        $eventos_reservados = $consulta->eventosReservas($codigo_salon, $startDate, $endDate);
        for ($j = 0; $j < count($eventos_reservados); $j++) {
            if (count($eventos_horarios) > 1) {
                $impresion .= ',';
            }
            $id_docente_r = $eventos_reservados[$j]["id_docente"];
            $id_docente_grupo_r = $eventos_reservados[$j]["id_docente_grupo"];
            $id_materia_r = $eventos_reservados[$j]["id_materia"];
            $salon_r = $eventos_reservados[$i]["salon"];
            $fechareserva = $eventos_reservados[$j]["fecha_reserva"];
            $timestamp = strtotime($fechareserva); // Convertir la fecha a timestamp
            $diasemana_r = date("N", $timestamp); // Obtener el día de la semana (1=Lunes, 7=Domingo)
            $horainicio_r = $eventos_reservados[$j]["horario"];
            $horafinal_r = $eventos_reservados[$j]["hora_f"];
            $corte_r = $eventos_reservados[$j]["corte"];
            $datosmateria_r = $consulta->BuscarDatosAsignatura($id_materia_r);
            $nombre_materia_r = $datosmateria_r["nombre"];
            if ($id_docente_r == null) {
                $nombre_docente_r = "Sin Asignar";
            } else {
                $datosdocente_r = $consulta->docente_datos($id_docente_r);
                $nombre_docente_r = $datosdocente_r["usuario_nombre"] . ' ' . $datosdocente_r["usuario_apellido"];
            }
            $color_r = "#ff9900";
            $impresion .= '{"title":"' . $nombre_materia_r . ' - Salón ' . $salon_r . ' - doc: ' . $nombre_docente_r . ' ","daysOfWeek":"' . $diasemana_r . '","startTime":"' . $horainicio_r . '","endTime":"' . $horafinal_r . '","color":"' . $color_r . '", "fijo": "0"}';
            if ($j + 1 < count($eventos_reservados)) {
                $impresion .= ',';
            }
        }
        $impresion .= ']';
        echo $impresion;
        // echo json_encode($diasemana_r);
        break;
    case 'aggReserva':
        $data['conte'] = '';
        $data['conte2'] = '';
        $id_docente = isset($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : die(json_encode(array("exito" => 0, "info" => "Sesión caducada, vuelva e inicie sesión.")));
        // $motivo_reserva = isset($_POST['motivo_reserva']) ? $_POST['motivo_reserva'] : die(json_encode(array("exito" => 0, "info" => "Motivo Obligatorio")));
        // $fecha_reserva = isset($_POST['fecha_reserva']) ? $_POST['fecha_reserva'] : die(json_encode(array("exito" => 0, "info" => "Fecha Obligatoria")));
        // $hora = isset($_POST['startTime']) ? $_POST['startTime'] : die(json_encode(array("exito" => 0, "info" => "Hora Obligatoria")));
        // $hasta = isset($_POST['endTime']) ? $_POST['endTime'] : die(json_encode(array("exito" => 0, "info" => "Hora Obligatoria")));
        // $codigo_salon = isset($_POST['codigo_salon']) ? $_POST['codigo_salon'] : die(json_encode(array("exito" => 0, "info" => "Salon Obligatorio")));

        $motivo_reserva = isset($_POST['motivo_reserva']) ? $_POST['motivo_reserva'] : "";
        $fecha_reserva = isset($_POST['fecha_reserva']) ? $_POST['fecha_reserva'] : "";
        $hora = isset($_POST['startTime']) ? $_POST['startTime'] : "";
        $hasta = isset($_POST['endTime']) ? $_POST['endTime'] : "";
        $codigo_salon = isset($_POST['codigo_salon']) ? $_POST['codigo_salon'] : "";
        // colocamos los campos para que no sean requeridos ya que los colocamos requeridos desde el jquery para los campos nuevos
        $nombre_docente = isset($_POST["nombre_docente"]) ? $_POST["nombre_docente"] : "";
        $correo_docente = isset($_POST["correo_docente"]) ? $_POST["correo_docente"] : "";
        $telefono_docente = isset($_POST["telefono_docente"]) ? $_POST["telefono_docente"] : "";
        $programa = isset($_POST["programa"]) ? $_POST["programa"] : "";
        $programa_otro = isset($_POST["programa_otro"]) ? $_POST["programa_otro"] : "";
        $asistentes = isset($_POST["asistentes"]) ? $_POST["asistentes"] : "";
        $asistentes_otro = isset($_POST["asistentes_otro"]) ? $_POST["asistentes_otro"] : "";
        $materia_evento = isset($_POST["materia_evento"]) ? $_POST["materia_evento"] : "";
        $experiencia_nombre = isset($_POST["experiencia_nombre"]) ? $_POST["experiencia_nombre"] : "";
        $experiencia_objetivo = isset($_POST["experiencia_objetivo"]) ? $_POST["experiencia_objetivo"] : "";
        $duracion_horas = isset($_POST["duracion_horas"]) ? $_POST["duracion_horas"] : "";
        // $requerimientos = isset($_POST["requerimientos"]) ? implode(",", $_POST["requerimientos"]) : "";
        $requerimientos_otro = isset($_POST["requerimientos_otro"]) ? $_POST["requerimientos_otro"] : "";
        $novedad = isset($_POST["novedad"]) ? $_POST["novedad"] : "";
        $estado_formulario = isset($_POST["estado_formulario"]) ? $_POST["estado_formulario"] : "";
        //obtengo el numero del dia en la semana 1 = lunes .... 6 = sabado
        $num_dia = date('N', strtotime($fecha_reserva));
        //obtengo el nombre del dia del array $days, por medio del valor del dia
        $dia = array_search($num_dia, $days);
        //añadimos y restamos un minuto a $hora y $hasta respectivamente para buscar en el servidor
        $nueva_hora = date('H:i:s', strtotime($hora . '+1 minute'));
        $nueva_hasta = date('H:i:s', strtotime($hasta . '-1 minute'));
        //se verifica que no este ocupada por horarios
        $verificarHorario = $consulta->verificarHorario($codigo_salon, $nueva_hora, $nueva_hasta, $dia);
        //se verifica que no este ocupada reservadas de docentes
        $verificarReserva = $consulta->verificarReserva($codigo_salon, $nueva_hora, $nueva_hasta, $fecha_reserva);
        //se verifica que no tenga este mismo salon activo
        $verificarDocenteSalon = $consulta->verificarDocenteSalon($codigo_salon, $id_docente);

        $requerimientos = isset($_POST['requerimientos']) ? $_POST['requerimientos'] : [];
        if (in_array('otro', $requerimientos) && !empty($_POST['req_otro'])) {
            $requerimientos = array_diff($requerimientos, ['otro']); // quita "otro" del array
            $requerimientos[] = $_POST['req_otro']; // agrega el texto personalizado
        }
        $requerimientos = implode(', ', $requerimientos);

        //si estan ocupados no puede dejar agendar
        if (count($verificarHorario) > 0 || count($verificarReserva) > 0) {
            $data['conte'] .= 2;
            $data['conte2'] .= "Esta hora esta ocupada, revisa el calendario.";
            // $data = array("exito" => 0, "info" => "Esta hora esta ocupada, revisa el calendario. ". count($verificarHorario));
        } else if (count($verificarDocenteSalon) > 0) {
            $data['conte'] .= 2;
            $data['conte2'] .= "Ya no puedes volver a seleccionar este salon, primero debes terminar la reserva actual..";
        } else {
            // $rspta = $consulta->aggReserva($id_docente, $hora, $hasta, $codigo_salon, $motivo_reserva, $fecha_reserva);
            $rspta = $consulta->aggReserva($id_docente, $hora, $hasta, $codigo_salon, $motivo_reserva, $fecha_reserva, $nombre_docente, $correo_docente, $telefono_docente, $programa, $programa_otro, $asistentes, $asistentes_otro, $materia_evento, $experiencia_nombre, $experiencia_objetivo, $duracion_horas, $requerimientos, $requerimientos_otro, $novedad);

            $programa_final   = ($programa === 'otro' && !empty($programa_otro)) ? $programa_otro : $programa;
            $asistentes_final = ($asistentes === 'otro' && !empty($asistentes_otro))  ? $asistentes_otro  : $asistentes;
            if ($rspta) {
                if ($estado_formulario == 1) {
                    $mensaje = set_template_notificacion_reservas_docentes($hora, $hasta, $codigo_salon, $nombre_docente, $correo_docente, $telefono_docente, $programa_final, $asistentes_final, $materia_evento, $experiencia_nombre, $experiencia_objetivo, $duracion_horas, $requerimientos, $requerimientos_otro, $novedad, $fecha_reserva);
                    $correos = "crailab@ciaf.edu.co,albeiro.cruz@ciaf.edu.co";
                    enviar_correo($correos, "Reserva Salon", $mensaje);
                }
                $data['conte'] .= 1;
                $data['conte2'] .= $codigo_salon;
            } else {
                $data['conte1'] .= 2;
                $data['conte2'] .= "Error de reserva";
            }
            // if ($rspta) {
            //     $data['conte'] .= 1;
            //     $data['conte2'] .= $codigo_salon;
            // } else {
            //     $data['conte1'] .= 2;
            //     $data['conte2'] .= "Error de reserva";
            // }
        }
        echo json_encode($data);
        break;
    case 'listarmisreservas':
        $id_docente = isset($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : die(json_encode(array("exito" => 0, "info" => "Sesión caducada, vuelva e inicie sesión.")));
        $rspta = $consulta->listarmisreservas($id_docente);
        $data = array();
        for ($i = 0; $i < count($rspta); $i++) {
            $data[] = array(
                "0" => $rspta[$i]["salon"],
                "1" => $rspta[$i]["detalle_reserva"],
                "2" => $consulta->convertir_fecha_completa($rspta[$i]["fecha_reserva"]),
                "3" => $rspta[$i]["horario"] . " A " . $rspta[$i]["hora_f"],
                "4" => '<span class="badge badge-success">Reservado</span>',
                "5" => '<button type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" onclick="cancelarReservas(' . $rspta[$i]["id"] . ', `' . $rspta[$i]["salon"] . '`)" title="Cancelar Reservas"><i class="fas fa-minus-circle"></i></button>'
            );
        }
        $result = array(
            "sEcho" => 1, //Información para el datatble
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($result);
        break;
    case 'historialReservas':
        $id_docente = isset($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : die(json_encode(array("exito" => 0, "info" => "Sesión caducada, vuelva e inicie sesión.")));
        $rspta = $consulta->historialReservas($id_docente, $periodo_actual);
        $data = array();
        for ($i = 0; $i < count($rspta); $i++) {
            $data[] = array(
                "0" => $rspta[$i]["salon"],
                "1" => $rspta[$i]["detalle_reserva"],
                "2" => $consulta->convertir_fecha_completa($rspta[$i]["fecha_reserva"]),
                "3" => $rspta[$i]["horario"] . " A " . $rspta[$i]["hora_f"],
                "4" => '<span class="badge badge-success">' . (($rspta[$i]["estado"] == 1) ? "Finalizada" : "activa") . '</span>'
            );
        }
        $result = array(
            "sEcho" => 1, //Información para el datatble
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($result);
        break;
    case 'cancelarReserva':
        $id = $_POST['id'];
        $rspta = $consulta->cancelarReserva($id);
        if ($rspta) {
            $data = array('exito' => 1);
        } else {
            $data = array('exito' => 0, 'info' => "Error al cancelar su reserva.");
        }
        echo json_encode($data);
        break;
    case 'listarSalones':
        $consulta = new Reserva();
        $jornada = $_GET['jornada'];
        $cantidad = $_GET['cantidad'];
        $fecha = date('Y-m-d');
        $retVal = $_GET['fecha'];
        $listar = $consulta->listarSalones($jornada, $retVal);
        $salones = $consulta->listarSalonesPiso($cantidad);
        //print_r($salones);
        $cantidadSalo = count($salones);
        $cantidadHoras = count($listar);
        $data['table'] = '';
        $data['table'] .= '<table class="table table-striped" id="table_listar_salones">
                <thead>
                    <tr>
                    <td>#</td>';
        for ($e = 0; $e < $cantidadSalo; $e++) {
            $tv = ($salones[$e]['tv'] == "1") ? '<i class="fas fa-tv"></i>' : '';
            $video = ($salones[$e]['video_beam'] == "1") ? '<i class="fas fa-video"></i>' : '';
            $data['table'] .= '<td>' . $salones[$e]['codigo'] . ' ' . $tv . ' ' . $video . '</td>';
        }
        $data['table'] .= '
                    </tr>
                </thead>';
        $data['table'] .= '<tbody>';
        for ($i = 0; $i < $cantidadHoras; $i++) {
            $data['table'] .= '<tr>';
            $data['table'] .= '<td>' . $listar[$i]['formato'] . '</td>';
            for ($a = 0; $a < $cantidadSalo; $a++) {
                $data['table'] .= '<td>' . $consulta->ConsultaReserva($salones[$a]['codigo'], $listar[$i]['id_horas'], $retVal) . '</td>';
            }
            $data['table'] .= "</tr>";
        }
        $data['table'] .= '</tbody> </table>';
        echo json_encode($data);
        break;
    case 'listarHoraSalones':
        $salon = $_GET['salon'];
        $reser->listarHoraSalones($salon);
        break;
    case 'consultaHoraI':
        $hora = $_POST['id'];
        $reser->consultaHoraI($hora);
        break;
    case 'consultaHoraF':
        $hora = $_POST['id'];
        $jornada = $_POST['jornada'];
        $reser->consultaHoraF($hora, $jornada);
        break;
    case 'consultaSalon':
        $piso = $_POST['piso'];
        $consulta = new Reserva();
        $salon = $consulta->listarSalonesPiso($piso);
        echo json_encode($salon);
        break;
    case 'fecha':
        $fecha = date("Y-m-d");
        $fecha2 = date("Y-m-d", strtotime($fecha . "+ 10 days"));
        $data['actual'] = $fecha;
        $data['despues'] = $fecha2;
        echo json_encode($data);
        break;
    case 'mostrar_datos_personales_usuarios':
        $usuario_identificacion = $_SESSION['usuario_identificacion'];
        // print_r($_SESSION);
        $rspta = $consulta->consultar_informacion_usuario($usuario_identificacion);
        echo json_encode($rspta);
        break;
}
