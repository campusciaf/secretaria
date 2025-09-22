<?php
session_start();
require_once "../modelos/OnEliminarEstudiante.php";
require('../public/mail/sendMailPreinscrito.php');

date_default_timezone_set('America/Bogota');

$oneliminarestudiante = new OnEliminarEstudiante();

$id_estudiante_mover = isset($_POST["id_estudiante_mover"]) ? limpiarCadena($_POST["id_estudiante_mover"]) : "";
$estado = isset($_POST["estado"]) ? limpiarCadena($_POST["estado"]) : "";
$id_usuario = $_SESSION['id_usuario'];
$fecha = date('Y-m-d');
$hora = date('H:i:s');

$id_estudiante = isset($_POST["id_estudiante"]) ? limpiarCadena($_POST["id_estudiante"]) : "";


switch ($_GET['op']) {
    case 'consultacliente':
        $dato = $_POST['dato'];
        $tipo = $_POST['tipo'];
        $data['conte'] = '';
        $data['conte2'] = '';
        $val = '';
        if ($tipo == "1") {
            $val = 'identificacion = ' . $dato;
        }
        if ($tipo == "2") {
            $val = 'id_estudiante = ' . $dato;
        }
        if ($tipo == "3") {

            $val = 'celular = ' . $dato;
        }
        $datos = $oneliminarestudiante->consulta($val);
        if ($datos) {
            if (file_exists('../files/oncenter/img_fotos/' . $datos[0]["identificacion"] . '.jpg')) {
                $foto = '<img src="../files/oncenter/img_fotos/' . $datos[0]["identificacion"] . '.jpg" class="direct-chat-img" style="width:50px;height:50px">';
            } else {
                $foto = '<i class="fa-solid fa-user-slash"></i>';
            }
            $data['conte2'] .= '
            <div class="row col-12 " >
                <div class="col-12 px-4 d-flex align-items-center">
                    <div class="row col-12 ">
                        <div class="col-12 px-2 pt-4 pb-2 ">
                            <div class="row align-items-center" id="t-Nc">
                                <div class="pl-4">
                                    <span class="rounded bg-light-blue p-2 text-primary ">
                                        ' . $foto . '
                                    </span> 
                                </div>
                                <div class="col-10">
                                <div class="col-10 fs-14 line-height-18"> 
                                    <span class="">' . $datos[0]['nombre'] . ' ' . $datos[0]['nombre_2'] . '</span> <br>
                                    <span class="text-semibold fs-14">' . $datos[0]['apellidos'] . ' ' . $datos[0]['apellidos_2'] . '</span> 
                                </div> 
                                </div>
                            </div>
                        </div>
                        <div class="col-12 px-2 py-2">
                            <div class="row align-items-center" id="t-Ce">
                                <div class="pl-4">
                                    <span class="rounded bg-light-red p-2 text-danger">
                                        <i class="fa-regular fa-envelope"></i>
                                    </span> 
                                </div>
                                <div class="col-10">
                                <div class="col-10 fs-14 line-height-18"> 
                                    <span class="">Correo electrónico</span> <br>
                                    <span class="text-semibold fs-14">' . $datos[0]['email'] . '</span> 
                                </div> 
                                </div>
                            </div>
                        </div>
                        <div class="col-12 px-2 py-2">
                            <div class="row align-items-center" id="t-NT">
                                <div class="pl-4">
                                    <span class="rounded bg-light-green p-2 text-success">
                                        <i class="fa-solid fa-mobile-screen"></i>
                                    </span>
                                </div>
                                <div class="col-10">
                                <div class="col-10 fs-14 line-height-18"> 
                                    <span class="">Número celular</span> <br>
                                    <span class="text-semibold fs-14">' . $datos[0]['celular'] . '</span> 
                                </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
            $data['conte'] .= '
                <div class="row mt-4" id="t-TP">
                    <div class="col-12 px-2 py-3 tono-3">
                        <div class="row align-items-center">
                            <div class="pl-4">
                                <span class="rounded bg-light-blue p-2 text-primary ">
                                    <i class="fa-solid fa-table"></i>
                                </span>
                            </div>
                            <div class="col-10">
                            <div class="col-5 fs-14 line-height-18"> 
                                <span class="">Programas</span> <br>
                                <span class="text-semibold fs-14">Matriculados</span> 
                            </div> 
                            </div>
                        </div>
                    </div>
                    <div class="col-12 card p-4">
                        <table class="table" id="tbl_datos">
                            <thead>
                            <tr>
                                <th id="t-Cs">Caso</th>
                                <th id="t-P">Programa</th>
                                <th id="t-Jr">Jornada</th>
                                <th id="t-FI">Fecha ingresa</th>
                                <th id="t-ME">Medio</th>
                                <th id="t-ES">Estado</th>
                                <th id="t-PC">Periodo campaña</th>
                                <th id="t-AC">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>';
            for ($i = 0; $i < count($datos); $i++) {
                $data['conte'] .= '
                <tr>
                    <td>' . $datos[$i]['id_estudiante'] . '</td>
                    <td>' . $datos[$i]['fo_programa'] . '</td>
                    <td>' . $datos[$i]['jornada_e'] . '</td>
                    <td>' . $oneliminarestudiante->fechaesp($datos[$i]['fecha_ingreso']) . '</td>
                    <td>' . $datos[$i]['medio'] . '</td>
                    <td>' . $datos[$i]['estado'] . '</td>
                    <td>' . $datos[$i]['periodo_campana'] . '</td>
                    <td>
                    <button onclick="on_eliminar_estudiante(' . $datos[$i]['id_estudiante'] . ')" id="t2-el" class="btn btn-danger btn-xs" title="Eliminar"><i class="far fa-trash-alt"></i></button>
                    </td>-
                </tr>';
            }
            $data['conte'] .= '
                            </tbody>
                        </table>
                    </div>
                </div>';
        } else {
            $data['status'] = 'error';
        }
        echo json_encode($data);
        break;


    case 'on_eliminar_estudiante':
        $id_estudiante = $_POST['id_estudiante'];

        $eliminado = true; 
        // Eliminar soporte de compromiso
        $soporte = $oneliminarestudiante->soporteCompromiso($id_estudiante);
        if ($soporte) {
            $consulta = $oneliminarestudiante->eliminar_soporte_compromiso($soporte['id_compromiso'], $id_estudiante);
            if ($consulta) {
                unlink('../files/oncenter/img_compromiso/' . $soporte['nombre_archivo']);
            } else {
                $eliminado = false;
            }
        }
        // Eliminar soporte de protección de datos
        $soporte = $oneliminarestudiante->misoporteProtecciondatos($id_estudiante);
        if ($soporte) {
            $consulta = $oneliminarestudiante->eliminar_soporte_proteccion_datos($soporte['id_proteccion_datos']);
            if ($consulta) {
                unlink('../files/oncenter/img_proteccion_datos/' . $soporte['nombre_archivo']);
            } else {
                $eliminado = false;
            }
        }
        // Eliminar soporte de cédula
        $soporte = $oneliminarestudiante->soporteCedula($id_estudiante);
        if ($soporte) {
            $consulta = $oneliminarestudiante->eliminar_soporte_cc($soporte['id_cedula'], $id_estudiante);
            if ($consulta) {
                unlink('../files/oncenter/img_cedula/' . $soporte['nombre_archivo']);
            } else {
                $eliminado = false;
            }
        }
        // Eliminar soporte de diploma
        $soporte = $oneliminarestudiante->soporteDiploma($id_estudiante);
        if ($soporte) {
            $consulta = $oneliminarestudiante->eliminar_soporte_diploma($soporte['id_diploma'], $id_estudiante);
            if ($consulta) {
                unlink('../files/oncenter/img_diploma/' . $soporte['nombre_archivo']);
            } else {
                $eliminado = false;
            }
        }
        // Eliminar soporte de acta
        $soporte = $oneliminarestudiante->soporteActa($id_estudiante);
        if ($soporte) {
            $consulta = $oneliminarestudiante->eliminar_soporte_acta($soporte['id_acta'], $id_estudiante);
            if ($consulta) {
                unlink('../files/oncenter/img_acta/' . $soporte['nombre_archivo']);
            } else {
                $eliminado = false;
            }
        }
        // Eliminar soporte de prueba
        $soporte = $oneliminarestudiante->soportePrueba($id_estudiante);
        if ($soporte) {
            $consulta = $oneliminarestudiante->eliminar_soporte_prueba($soporte['id_prueba'], $id_estudiante);
            if ($consulta) {
                unlink('../files/oncenter/img_prueba/' . $soporte['nombre_archivo']);
            } else {
                $eliminado = false;
            }
        }
        // Eliminar soporte de Salud 
        $soporte = $oneliminarestudiante->soporteSalud($id_estudiante);
        if ($soporte) {
            $consulta = $oneliminarestudiante->eliminar_soporte_salud($soporte['id_salud'], $id_estudiante);
            if ($consulta) {
                unlink('../files/oncenter/img_salud/' . $soporte['nombre_archivo']);
            } else {
                $eliminado = false;
            }
        }
        //soporte inscripcion
        $soporte = $oneliminarestudiante->soporte_inscripcion($id_estudiante);
        if ($soporte) {
            $consulta = $oneliminarestudiante->eliminar_soporte_inscripcion($soporte['id_inscripcion'], $id_estudiante);
            if ($consulta) {
                unlink('../files/oncenter/img_inscripcion/' . $soporte['nombre_archivo']);
            } else {
                $eliminado = false;
            }
        }
        if ($eliminado) {
            $data['status'] = 'ok';
            $data['msj'] = 'Estudiante eliminado con éxito.';
        } else {
            $data['status'] = 'error';
            $data['msj'] = 'Estudiante no se pudo eliminar.';
        }

        $rspta1 = $oneliminarestudiante->eliminarDatos($id_estudiante);
		$rspta2 = $oneliminarestudiante->eliminarSeguimiento($id_estudiante);
		$rspta3 = $oneliminarestudiante->eliminarTareas($id_estudiante);
		$rspta = $oneliminarestudiante->eliminar($id_estudiante);
        $estado = "Interesado";
        $rspta4 = $oneliminarestudiante->insertarEliminar($id_estudiante, $estado, $fecha, $hora, $id_usuario);
        
        echo json_encode($data);
        break;
}
