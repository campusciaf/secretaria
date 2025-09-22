<?php
require_once "../modelos/AjusteDatos.php";
$ajustedatos = new AjusteDatos();
date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$rsptaperiodo = $ajustedatos->periodoactual();
$periodo_actual = $rsptaperiodo["periodo_actual"];
$periodo_anterior = $rsptaperiodo["periodo_anterior"];
$periodo_pecuniario = $rsptaperiodo['periodo_pecuniario'];



$id_usuario = $_SESSION['id_usuario'];
switch ($_GET["op"]) {
    case "traerPeriodo":
        echo $periodo_actual;
        break;
    case "opcion":
        $data = array();
        $data["datos"] = "";
        $niveles = $ajustedatos->niveles();
        $data["datos"] .= '<div class="alert col-12"><b>Nota:</b> Esta consulta muestra estudiantes que estan activos, pero que no tienen materias matriculadas.</div>';
        for ($a = 0; $a < count($niveles); $a++) {
            $nivel = $niveles[$a]["nivel"];
            $titulo = $niveles[$a]["titulo"];
            $programas = $niveles[$a]["programas"];
            $data["datos"] .= '
            <a class="btn btn-app" onclick="activos(' . $nivel . ')">
                <span class="badge bg-success">' . $titulo . '</span>
                <i class="fas fa-search"></i> ' . $programas . '
            </a>
            ';
        }
        echo json_encode($data);
    break;
    case "opciondos":
        $data = array();
        $data["datos"] = "";
        $niveles = $ajustedatos->niveles();
        $data["datos"] .= '<div class="alert col-12"><b>Nota:</b> Esta consulta muestra estudiantes que estan activos, pero que no tienen materias matriculadas.</div>';
        for ($a = 0; $a < count($niveles); $a++) {
            $nivel = $niveles[$a]["nivel"];
            $titulo = $niveles[$a]["titulo"];
            $programas = $niveles[$a]["programas"];
            $data["datos"] .= '
            <a class="btn btn-app" onclick="activosdos(' . $nivel . ')">
                <span class="badge bg-success">' . $titulo . '</span>
                <i class="fas fa-search"></i> ' . $programas . '
            </a>
            ';
        }
        echo json_encode($data);
        break;
    case "activos":
        $nivel = $_POST["nivel"];
        $data = array();
        $data["datos"] = "";
        $estudiantesactivos = $ajustedatos->estudiantesactivos($periodo_actual, $nivel);
        $estudiantesunicos = $ajustedatos->estudiantesunicos($periodo_actual, $nivel);
        $totalestudiantesactivos = count($estudiantesactivos);
        $data["datos"] .= '<div class="col-12 p-2">';
        $data["datos"] .= 'Matriculas <span class="badge bg-danger"> ' . $totalestudiantesactivos . ' </span>';
        $data["datos"] .= 'Estudiantes <span class="badge bg-success"> ' . count($estudiantesunicos) . ' </span>';
        $data["datos"] .= '</div>';
        $data["datos"] .= '
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 40px">Identificación</th>
                        <th style="width: 10px">Id Credencial</th>
                        <th style="width: 10px">Id estudiante</th>
                        <th>Nombre Completo</th>
                        <th>Programa</th>
                    </tr>
                </thead>
                <tbody>';
        for ($a = 0; $a < count($estudiantesactivos); $a++) {
            $id_estudiante = $estudiantesactivos[$a]["id_estudiante"];
            $id_credencial = $estudiantesactivos[$a]["id_credencial"];
            $ciclo = $estudiantesactivos[$a]["ciclo"];
            $programa = $estudiantesactivos[$a]["fo_programa"];
            $verificarmaterias = $ajustedatos->verificarmaterias($id_estudiante, $ciclo, $periodo_actual);
            $datoscredencial = $ajustedatos->datoscredencial($id_credencial);
            $identificacion = $datoscredencial["credencial_identificacion"];
            $nombre = $datoscredencial["credencial_nombre"] . ' ' . $datoscredencial["credencial_nombre_2"] . ' ' . $datoscredencial["credencial_apellido"] . ' ' . $datoscredencial["credencial_apellido_2"];
            if ($verificarmaterias == true) {
            } else {
                $data["datos"] .= '    
                        <tr>
                            <td>' . $identificacion . '</td>
                            <td>' . $id_credencial . '</td>
                            <td>' . $id_estudiante . '</td>
                            <td>' . $nombre . '</td>
                            <td>' . $programa . '</td>
                        </tr>';
            }
        }
        $data["datos"] .= '
                </tbody>
            </table>
        </div>';
        echo json_encode($data);
        break;
    case "activosdos":
        $nivel = $_POST["nivel"];
        $data = array();
        $data["datos"] = "";
        $estudiantesactivos = $ajustedatos->estudiantesactivosdos($periodo_actual, $nivel);
        $data["datos"] .= '<div class="col-12 p-2">';
        $data["datos"] .= 'Matriculas <span class="badge bg-danger"> ' . count($estudiantesactivos) . ' </span>';
        // $data["datos"] .= 'Estudiantes <span class="badge bg-success"> '.count($estudiantesunicos).' </span>';
        $data["datos"] .= '</div>';
        $data["datos"] .= '
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 40px">Identificación</th>
                        <th style="width: 10px">Id Credencial</th>
                        <th style="width: 10px">Id estudiante</th>
                        <th>Nombre Completo</th>
                        <th>Programa</th>
                    </tr>
                </thead>
                <tbody>';
        for ($a = 0; $a < count($estudiantesactivos); $a++) {
            $id_estudiante = $estudiantesactivos[$a]["id_estudiante"];
            $verificarperiodo = $ajustedatos->verificarperiodo($id_estudiante, $periodo_anterior);
            if ($verificarperiodo["id_credencial"] == '') {
            } else {
                $datoscredencial = $ajustedatos->datoscredencial($verificarperiodo["id_credencial"]);
                $identificacion = $datoscredencial["credencial_identificacion"];
                $nombre = $datoscredencial["credencial_nombre"] . ' ' . $datoscredencial["credencial_nombre_2"] . ' ' . $datoscredencial["credencial_apellido"] . ' ' . $datoscredencial["credencial_apellido_2"];
                $data["datos"] .= '   
                        <tr>
                            <td>' . $identificacion . '</td>
                            <td>' . $verificarperiodo["id_credencial"] . '</td>
                            <td>' . $id_estudiante . '</td>
                            <td>' . $nombre . '</td>
                            <td></td>
                        </tr>';
            }
        }
        $data["datos"] .= '
                </tbody>
            </table>
        </div>';
        echo json_encode($data);
        break;
    case "porrenovar":
        $data = array();
        $data["datos"] = "";
        $niveles = $ajustedatos->programas();
        $data["datos"] .= '<div class="alert col-12"><b>Nota:</b> Esta consulta es para ajustar los estudiants que deben renovar del periodo. ' . $periodo_anterior . '</div>';
        for ($a = 0; $a < count($niveles); $a++) {
            $id_programa = $niveles[$a]["id_programa"];
            $nombre = $niveles[$a]["nombre"];
            $ciclo = $niveles[$a]["ciclo"];
            $semestres = $niveles[$a]["semestres"];
            $data["datos"] .= '<a class="btn btn-default" onclick="ajustarrenovacion(' . $id_programa . ',' . $ciclo . ',' . $semestres . ')">' . $id_programa . ' - ' . $nombre . ' </a>';
        }
        echo json_encode($data);
        break;
    case "ajustarrenovacion":
        $id_programa = $_POST["id_progama"];
        $ciclo = $_POST["ciclo"];
        $semestres = $_POST["semestres"];
        $data = array();
        $data["datos"] = "";
        $renuevan = $ajustedatos->renuevan($id_programa, $semestres, $periodo_anterior);
        $data["datos"] .= count($renuevan) . '<br>';
        for ($a = 0; $a < count($renuevan); $a++) {
            $id_credencial = $renuevan[$a]["id_credencial"];
            $id_estudiante = $renuevan[$a]["id_estudiante"];
            $identificacion = $renuevan[$a]["credencial_identificacion"];
            $data["datos"] .=  $identificacion . ' - ' . $id_estudiante;
            $mirarnortas = $ajustedatos->promediorenovar($id_estudiante, $id_programa, $ciclo);
            if ($mirarnortas) {
                $data["datos"] .= '- perdio';
            } else {
                $data["datos"] .= '- gano';
                $actualizarestadorenovacion = $ajustedatos->actualizarestadorenovacion($id_estudiante);
            }
            $data["datos"] .= '<br>';
        }
        echo json_encode($data);
        break;
    case "estudiantesactivos":
        $data = array();
        $data["datos"] = "";
        $consultaactivos = $ajustedatos->estudiantesperiodoactivo($periodo_actual);
        $data["datos"] .= '<div class="alert col-12"><b>Nota:</b> Esta consulta muestra los estudiantes activos de la tabla estudiantes que deben estar en la tabla estudiantes activos</div>';
        $data["datos"] .= 'Total activos tabla estudiantes: ' . count($consultaactivos) . '<br>';
        for ($a = 0; $a < count($consultaactivos); $a++) {
            $id_estudiante = $consultaactivos[$a]["id_estudiante"];
            $id_credencial = $consultaactivos[$a]["id_credencial"];
            $jornada_e = $consultaactivos[$a]["jornada_e"];
            $semestre = $consultaactivos[$a]["semestre_estudiante"];
            $programa = $consultaactivos[$a]["id_programa_ac"];
            $nivel = $consultaactivos[$a]["ciclo"];
            $verescuela = $ajustedatos->verescuela($programa);
            $escuela = $verescuela["escuela"];
            $data["datos"] .= $id_estudiante . ' - ';
            $consultarsiesta = $ajustedatos->consultarsiesta($id_estudiante, $periodo_actual);
            $resultado = $consultarsiesta ? 'si' : 'no';
            $data["datos"] .= $resultado . '<br>';
            if ($resultado == "no") { //si el estudiante no esta, realizar inserción en la tabla estuidantes activos
                $insertar = $ajustedatos->insertarestudianteactivo($id_estudiante, $id_credencial, $jornada_e, $periodo_actual, $semestre, $programa, $nivel, $escuela);
            }
        }
        echo json_encode($data);
        break;
    case "marcaregresados":
        $data = array();
        $data["datos"] = "";
        $niveles = $ajustedatos->programas();
        $data["datos"] .= '<div class="alert col-12"><b>Nota:</b> Esta consulta es para ajustar los estudiantes terminaron materias y deben pasar a egresados.</div>';
        for ($a = 0; $a < count($niveles); $a++) {
            $id_programa = $niveles[$a]["id_programa"];
            $nombre = $niveles[$a]["nombre"];
            $ciclo = $niveles[$a]["ciclo"];
            $semestres = $niveles[$a]["semestres"];
            $data["datos"] .= '<a class="btn btn-default" onclick="ajustaregresados(' . $id_programa . ',' . $ciclo . ',' . $semestres . ')">' . $id_programa . ' - ' . $nombre . ' </a>';
        }
        echo json_encode($data);
        break;
    case "ajustaregresados":
        $id_programa = $_POST["id_progama"];
        $ciclo = $_POST["ciclo"];
        $semestres = $_POST["semestres"];
        $data = array();
        $data["datos"] = "";
        $renuevan = $ajustedatos->listarestudiantes($id_programa, $semestres);
        for ($a = 0; $a < count($renuevan); $a++) {
            $id_credencial = $renuevan[$a]["id_credencial"];
            $id_estudiante = $renuevan[$a]["id_estudiante"];
            $identificacion = $renuevan[$a]["credencial_identificacion"];
            $periodo_activo = $renuevan[$a]["periodo_activo"];
            $mirarnortas = $ajustedatos->promediorenovar($id_estudiante, $id_programa, $ciclo);
            if ($mirarnortas) {
                $data["datos"] .= '';
            } else {
                $data["datos"] .= '<a onclick="cambiaregresado(' . $id_estudiante . ',' . $id_programa . ',' . $ciclo . ')" class="btn btn-success btn-xs">Cambiar egresado</a>';
                $data["datos"] .=  $identificacion . ' - ' . $id_estudiante . '-' . $periodo_activo;
                $data["datos"] .= '- gano';
                $data["datos"] .= '<br>';
            }
        }
        echo json_encode($data);
        break;
    case "cambiaregresado":
        $id_estudiante = $_POST["id_estudiante"];
        $id_programa = $_POST["id_progama"];
        $ciclo = $_POST["ciclo"];
        $data = array();
        $data["datos"] = "";
        $datoprograma = $ajustedatos->verescuela($id_programa);
        $cant_asignaturas = $datoprograma["cant_asignaturas"];
        $materias = $ajustedatos->listarmaterias($id_estudiante, $id_programa, $ciclo);
        if (count($materias) == $cant_asignaturas) {
            $actualizarestado = $ajustedatos->actualizarestado($id_estudiante);
            $data["datos"] .= "1";
        } else {
            $data["datos"] .= 'No cumple: ' . count($materias) . ' ' . $cant_asignaturas;
        }
        echo json_encode($data);
        break;
    case "marcarniveltario":
        $data = array();
        $data["datos"] = "";
        $niveles = $ajustedatos->programasnivelatorio();
        $data["datos"] .= '
            <div class="alert col-12">
                <b>Nota:</b>
                Esta es para mirar si las personas que tienen un nivelatorio, matricularon un programa profesional, 
                para colocarles el estado de <b>pago_renovar</b> de la tabla estudiantes en 0, que quiere decir pago nivelatorio.
            </div>';
        for ($a = 0; $a < count($niveles); $a++) {
            $id_programa = $niveles[$a]["id_programa"];
            $nombre = $niveles[$a]["nombre"];
            $ciclo = $niveles[$a]["ciclo"];
            $semestres = $niveles[$a]["semestres"];
            $data["datos"] .= '<a class="btn btn-default" onclick="ajustarnivelatorio(' . $id_programa . ',' . $ciclo . ',' . $semestres . ')">' . $id_programa . ' - ' . $nombre . ' </a>';
        }
        echo json_encode($data);
        break;
    case "ajustarnivelatorio":
        $id_programa = $_POST["id_progama"];
        $ciclo = $_POST["ciclo"];
        $semestres = $_POST["semestres"];
        $data = array();
        $data["datos"] = "";
        $renuevan = $ajustedatos->listarestudiantesnivelatorio($id_programa);
        $buscarprograma = $ajustedatos->verescuela($id_programa);
        $data["datos"] .= '<h2>' . $buscarprograma["nombre"] . '</h2>';
        $data["datos"] .= '
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Estudiante</th>
                                <th>cc - id_est.</th>
                                <th>Estado académico</th>
                                <th>Periodo Activo</th>
                            </tr>
                        </thead>
                        <tbody style="font-size:14px">
                        ';
        for ($a = 0; $a < count($renuevan); $a++) {
            $id_credencial = $renuevan[$a]["id_credencial"];
            $id_estudiante = $renuevan[$a]["id_estudiante"];
            $identificacion = $renuevan[$a]["credencial_identificacion"];
            $periodo_activo = $renuevan[$a]["periodo_activo"];
            $nombre = $renuevan[$a]["credencial_apellido"] . '  ' . $renuevan[$a]["credencial_apellido_2"] . ' ' . $renuevan[$a]["credencial_nombre"] . ' ' . $renuevan[$a]["credencial_nombre_2"];
            $estado = $renuevan[$a]["estado"];
            $nombreestado = $ajustedatos->nombreestado($estado);
            $data["datos"] .= '
                                <tr>
                                    <td>' . $a . '</td>
                                    <td>' . $nombre . '</td>
                                    <td>' . $identificacion . ' - ' . $id_estudiante . '</td>
                                    <td><span class="badge bg-success">' . $nombreestado["estado"] . '</span></td>
                                    <td><span class="badge bg-success">' . $periodo_activo . '</span></td>
                                </tr>';
            $mirarprogramaterminal = $ajustedatos->mirarprogramaterminal($id_credencial);
            for ($b = 0; $b < count($mirarprogramaterminal); $b++) {
                $id_estudiante_terminal = $mirarprogramaterminal[$b]["id_estudiante"];
                $cambiarestadopago = $ajustedatos->cambiarestadopago($id_estudiante_terminal);
                $estadopago = $mirarprogramaterminal[$b]["pago_renovar"];
                $estadoacademico = $mirarprogramaterminal[$b]["estado"];
                $periodo_activo_terminal = $mirarprogramaterminal[$b]["periodo_activo"];
                $nombreestadoacademico = $ajustedatos->nombreestado($estadoacademico);
                if ($estadopago == 1) {
                    $btn_texto = "Pago Normal";
                } else {
                    $btn_texto = "Pago Nivelatorio";
                }
                $data["datos"] .= '
                                <tr class="">
                                    <td></td>
                                    <td>' . $mirarprogramaterminal[$b]["fo_programa"] . '</td>
                                    <td><span class="badge bg-primary">' . $btn_texto . '</span> - ' . $id_estudiante_terminal . '</td>
                                    <td>' . $nombreestadoacademico["estado"] . '</td>
                                    <td>' . $periodo_activo_terminal . '</td>
                                </tr>';
            }
            // $data["datos"] .= '<a onclick="cambiaregresado('.$id_estudiante.','.$id_programa.','.$ciclo.')" class="btn btn-success btn-xs">Cambiar egresado</a>';
            // }
        }
        $data["datos"] .= '                        
                    </tbody>
                    </table>
                </div>
            </div>
        ';
        echo json_encode($data);
        break;
    case "ajusteactivos":
        $data = array();
        $data["datos"] = "";
        $consultaactivos = $ajustedatos->estudiantestablaactivo($periodo_actual);
        $data["datos"] .= '<div class="alert col-12"><b>Nota:</b> Esta consulta muestra los estudiantes de la tabla estudiantes activos y los compara con la tabla estudiantes, para ver si estan activos</div>';
        $data["datos"] .= '<h2 class="titulo-1">Total activos tabla estudiantes: ' . count($consultaactivos) . '</h2>';
        $data["datos"] .= '<div class="row">';
        $observar = 0;
        for ($a = 0; $a < count($consultaactivos); $a++) {
            $id_estudiante_activo = $consultaactivos[$a]["id_estudiante_activo"];
            $id_estudiante = $consultaactivos[$a]["id_estudiante"];
            $id_credencial = $consultaactivos[$a]["id_credencial"];
            $jornada_e = $consultaactivos[$a]["jornada_e"];
            $semestre = $consultaactivos[$a]["semestre"];
            $programa = $consultaactivos[$a]["programa"];
            $nivel = $consultaactivos[$a]["nivel"];
            $datos_credencial = $ajustedatos->datoscredencial($id_credencial);
            @$identificacion = $datos_credencial["credencial_identificacion"];
            $verescuela = $ajustedatos->verescuela($programa);
            $escuela = $verescuela["escuela"];
            $consultarsiesta = $ajustedatos->consultarsiestaactivo($id_estudiante, $periodo_actual);
            $datotablaestudiante = $ajustedatos->datoTablaEstuidante($id_estudiante);
            $resultado = $consultarsiesta ? 'si' : 'no';
            if ($resultado == "no") {
                $observar++;
                $data["datos"] .= '<div class="col-12">';
                $data["datos"] .= $identificacion . ' - ' . $id_estudiante . ' - ';
                $data["datos"] .= @$datotablaestudiante["estado"] . ' - ';
                $data["datos"] .= @$datotablaestudiante["fo_programa"] . ' - ';
                $data["datos"] .= @$datotablaestudiante["periodo"] . ' - ';
                $data["datos"] .= @$datotablaestudiante["periodo_activo"] . ' - ';
                $data["datos"] .= '<a onclick=eliminarActivo("' . $id_estudiante_activo . '") class="btn btn-success btn-xs text-white"> Eliminar </a>';
                $data["datos"] .= '</div>';
            }
            //     if($resultado=="no"){//si el estudiante no esta, realizar inserción en la tabla estuidantes activos
            //         $insertar=$ajustedatos->insertarestudianteactivo($id_estudiante,$id_credencial,$jornada_e,$periodo_actual,$semestre,$programa,$nivel,$escuela);
            //     }
        }
        $data["datos"] .= $observar;
        $data["datos"] .= '</div>';
        echo json_encode($data);
        break;
    case "ajustedatospersonales":
        $data = array();
        $data["datos"] = "";
        $consultaactivos = $ajustedatos->listarcredencialestudiante();
        $data["datos"] .= '<div class="alert col-12"><b>Nota:</b> Esta consulta muestra los estudiantes de la tabla credencial estudiantes y verifica que tenga la tabla  estudiantes datos personales </div>';
        $data["datos"] .= '<h2 class="titulo-1">Total activos tabla estudiantes: ' . count($consultaactivos) . '</h2>';
        $data["datos"] .= '<div class="row">';
        $observar = 0;
        for ($a = 0; $a < count($consultaactivos); $a++) {
            $id_credencial = $consultaactivos[$a]["id_credencial"];
            $nombre = $consultaactivos[$a]["credencial_nombre"];
            $identificacion = $consultaactivos[$a]["credencial_identificacion"];
            $datos_credencial = $ajustedatos->datospersonales($id_credencial);
            $resultado = $datos_credencial ? 'si' : 'no';
            if ($resultado == "no") {
                $data["datos"] .= '<div class="col-6">';
                $data["datos"] .= $identificacion . ' ' . $id_credencial . ' ' . $nombre . ' - ';
                $data["datos"] .= $resultado . ' <a onclick=insertarDatosPersonales("' . $id_credencial . '") class="btn btn-success btn-xs text-white"> Insertar </a>';
                $data["datos"] .= '</div>';
            }
        }
        $data["datos"] .= $observar;
        $data["datos"] .= '</div>';
        echo json_encode($data);
        break;
    case "eliminarActivo":
        $id_estudiante_activo = $_POST["id_estudiante_activo"];
        $data = array();
        $data["datos"] = "";
        $estudiante = $ajustedatos->eliminaractivo($id_estudiante_activo);
        echo json_encode($data);
        break;
    case "insertarDatosPersonales":
        $id_credencial = $_POST["id_credencial"];
        $data = array();
        $data["datos"] = "";
        $estudiante = $ajustedatos->insertardatospersonales($id_credencial);
        $data["datos"] .= $resultado = $estudiante ? 'si' : 'no';
        echo json_encode($data);
        break;
    case "opcionsemestre":
        $data = array();
        $data["datos"] = "";
        $niveles = $ajustedatos->niveles();
        $data["datos"] .= '<div class="alert col-12"><b>Nota:</b> Esta consulta muestra estudiantes que estan activos, pero que no tienen materias matriculadas.</div>';
        for ($a = 0; $a < count($niveles); $a++) {
            $nivel = $niveles[$a]["nivel"];
            $titulo = $niveles[$a]["titulo"];
            $programas = $niveles[$a]["programas"];
            $data["datos"] .= '
            <a class="btn btn-app" onclick="semestre(' . $nivel . ')">
                <span class="badge bg-success">' . $titulo . '</span>
                <i class="fas fa-search"></i> ' . $programas . '
            </a>
            ';
        }
        echo json_encode($data);
        break;
    case "semestre":
        $nivel = $_POST["nivel"];
        $data = array();
        $data["datos"] = "";
        $estudiantesactivos = $ajustedatos->estudiantesactivos($periodo_actual, $nivel);
        $totalestudiantesactivos = count($estudiantesactivos);
        $data["datos"] .= '<div class="col-12 p-2">';
        $data["datos"] .= 'Matriculas <span class="badge bg-danger"> ' . $totalestudiantesactivos . ' </span>';
        $data["datos"] .= '</div>';
        $data["datos"] .= '
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 40px">Identificación</th>
                        <th style="width: 10px">Id Credencial</th>
                        <th style="width: 10px">Id estudiante</th>
                        <th>Nombre Completo</th>
                        <th>Programa</th>
                        <th>semestre</th>
                        <th>Creditos</th>
                    </tr>
                </thead>
                <tbody>';
        for ($a = 0; $a < count($estudiantesactivos); $a++) {
            $id_estudiante = $estudiantesactivos[$a]["id_estudiante"];
            $id_credencial = $estudiantesactivos[$a]["id_credencial"];
            $ciclo = $estudiantesactivos[$a]["ciclo"];
            $programa = $estudiantesactivos[$a]["fo_programa"];
            $id_programa = $estudiantesactivos[$a]["id_programa_ac"];
            $semestre = $estudiantesactivos[$a]["semestre_estudiante"];
            $datoscredencial = $ajustedatos->datoscredencial($id_credencial);
            $identificacion = $datoscredencial["credencial_identificacion"];
            $nombre = $datoscredencial["credencial_nombre"] . ' ' . $datoscredencial["credencial_nombre_2"] . ' ' . $datoscredencial["credencial_apellido"] . ' ' . $datoscredencial["credencial_apellido_2"];
            $materiasmatriculadas = $ajustedatos->listarmateriassemestre($id_estudiante, $id_programa, $nivel, $semestre);
            $data["datos"] .= '   
                        <tr>
                            <td>' . $identificacion . '</td>
                            <td>' . $id_credencial . '</td>
                            <td>' . $id_estudiante . '</td>
                            <td>' . $nombre . '</td>
                            <td>' . $programa . '</td>
                            <td>' . $semestre . '</td>
                            <td>' . count($materiasmatriculadas) . '</td>
                        </tr>';
        }
        $data["datos"] .= '
                </tbody>
            </table>
        </div>';
        echo json_encode($data);
        break;
    case "sexo":
        $data = array();
        $data["datos"] = "";
        $estudiantesactivos = $ajustedatos->estudiantesdatospersonales();
        $totalestudiantesactivos = count($estudiantesactivos);
        $data["datos"] .= '<div class="col-12 p-2">';
        $data["datos"] .= 'Matriculas <span class="badge bg-danger"> ' . $totalestudiantesactivos . ' </span>';
        $data["datos"] .= '</div>';
        $data["datos"] .= '
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">Id Credencial</th>
                        <th style="width: 40px">Identificación</th>
                        <th>Nombre Completo</th>
                        <th>Sexo</th>
                        <th>semestre</th>
                        <th>Creditos</th>
                    </tr>
                </thead>
                <tbody>';
        for ($a = 0; $a < count($estudiantesactivos); $a++) {
            $id_credencial = $estudiantesactivos[$a]["id_credencial"];
            $genero = $estudiantesactivos[$a]["genero"];
            // $ciclo=$estudiantesactivos[$a]["ciclo"];
            // $programa=$estudiantesactivos[$a]["fo_programa"];
            // $id_programa=$estudiantesactivos[$a]["id_programa_ac"];
            // $semestre=$estudiantesactivos[$a]["semestre_estudiante"];
            $datoscredencial = $ajustedatos->datoscredencial($id_credencial);
            $identificacion = $datoscredencial["credencial_identificacion"];
            $nombre = $datoscredencial["credencial_nombre"] . ' ' . $datoscredencial["credencial_nombre_2"] . ' ' . $datoscredencial["credencial_apellido"] . ' ' . $datoscredencial["credencial_apellido_2"];
            //     $materiasmatriculadas=$ajustedatos->listarmateriassemestre($id_estudiante,$id_programa,$nivel,$semestre);
            $data["datos"] .= '   
                        <tr>
                            <td>' . $id_credencial . '</td>
                            <td>' . $identificacion . '</td>
                            <td>' . $nombre . '</td>
                            <td>' . $genero . '</td>
                            <td>
                                <a onclick=cambiosexo(' . $id_credencial . ',"Masculino") class="btn bg-primary">Masculino</a>
                                <a onclick=cambiosexo(' . $id_credencial . ',"Femenino") class="btn bg-pink">Femenino</a>
                            </td>
                            <td><a onclick=eliminarRegistrodato(' . $id_credencial . ') class="btn btn-danger text-white">Eliminar registro</a></td>
                        </tr>';
        }
        $data["datos"] .= '
                </tbody>
            </table>
        </div>';
        echo json_encode($data);
        break;
    case "cambiosexo":
        $id_credencial = $_POST["id_credencial"];
        $sexo = $_POST["sexo"];
        $data = array();
        $data["datos"] = "";
        $estudiante = $ajustedatos->cambiosexo($id_credencial, $sexo);
        echo json_encode($data);
        break;
    case "eliminarRegistrodato":
        $id_credencial = $_POST["id_credencial"];
        $data = array();
        $data["datos"] = "";
        $estudiante = $ajustedatos->eliminarRegistrodato($id_credencial);
        echo json_encode($data);
        break;
    case "activoegresado":
        $data = array();
        $data["datos"] = "";
        $niveles = $ajustedatos->niveles();
        $data["datos"] .= '<div class="alert col-12"><b>Nota:</b> buscar el nivel para ajustar si se graduo en el periodo consultado</div>';
        for ($a = 0; $a < count($niveles); $a++) {
            $nivel = $niveles[$a]["nivel"];
            $titulo = $niveles[$a]["titulo"];
            $programas = $niveles[$a]["programas"];
            $periodo = $periodo_anterior; // esta es al variable que contiene el periodo a analizar
            $data["datos"] .= '
            <a class="btn btn-app" onclick=buscaractivostotal(' . $nivel . ',"' . $periodo . '")>
                <span class="badge bg-success">' . $titulo . '</span>
                <i class="fas fa-search"></i> ' . $programas . '
            </a>
            ';
        }
        echo json_encode($data);
        break;
    case "buscaractivostotal":
        $nivel = $_POST["nivel"];
        $periodo = $_POST["periodo"];
        $cuantos = 0;
        $data = array();
        $data["datos"] = "";
        $data["datos"] .= '<table class="table"> ';
        $data["datos"] .= '<thead>';
        $data["datos"] .= '<th>Identificacion</th>';
        $data["datos"] .= '<th>Id estudiante activo</th>';
        $data["datos"] .= '<th>periodo activo</th>';
        $data["datos"] .= '<th>estado</th>';
        $data["datos"] .= '<th>Estado academico</th>';
        $data["datos"] .= '<thead>';
        $data["datos"] .= '<tbody>';
        $consulta = $ajustedatos->buscaractivostotal($nivel, $periodo);
        for ($a = 0; $a < count($consulta); $a++) {
            $data["datos"] .= '<tr>';
            if ($consulta[$a]["periodo_activo"] == $periodo) {
                $data["datos"] .=  '<td>' . $consulta[$a]["credencial_identificacion"] . '</td>';
                $data["datos"] .=  '<td>' . $consulta[$a]["id_estudiante_activo"] . '</td>';
                $data["datos"] .= '<td>' . $consulta[$a]["periodo_activo"] . '</td>';
                $data["datos"] .= '<td>' . $consulta[$a]["estado"] . ' ';
                if ($consulta[$a]["estado"] == '2' || $consulta[$a]["estado"] == '5') {
                    $data["datos"] .= '<td>Termino</td>';
                    $actualizar = $ajustedatos->actualizaractivoegresado($consulta[$a]["id_estudiante_activo"]);
                } else {
                    $data["datos"] .= '<td>En curso</td>';
                }
                $cuantos++;
            }
            $data["datos"] .= '</tr>';
        }
        $data["datos"] .= '</table>';
        $data["datos"] .= $cuantos;
        echo json_encode($data);
        break;
    case "marcarmatricula":
        $data = array();
        $data["datos"] = "";
        $data["datos"] .= '<table class="table"> ';
        $data["datos"] .= '<thead>';
        $data["datos"] .= '<th>Identificacion</th>';
        $data["datos"] .= '<th>Id estudiante activo</th>';
        $data["datos"] .= '<th>Periodo Ingreso</th>';
        $data["datos"] .= '<th>graduado</th>';
        $data["datos"] .= '<th>Estado</th>';
        $data["datos"] .= '<thead>';
        $data["datos"] .= '<tbody>';
        $periodo_actual = $periodo_actual;
        $consulta = $ajustedatos->buscaractivostotalperiodo($periodo_actual);
        for ($a = 0; $a < count($consulta); $a++) {
            $data["datos"] .= '<tr>';
            $estadograduado = ($consulta[$a]["graduado"] == 0) ? 'Graduado' : 'En curso';
            $estadohomologado = ($consulta[$a]["homologado"] == 0) ? 'Homologado' : '';
            if ($consulta[$a]["periodo"] == $periodo_actual && $consulta[$a]["admisiones"] == "si" && $consulta[$a]["homologado"] == 1) {
                $estado = "Nuevo";
            } else if ($consulta[$a]["periodo"] == $periodo_actual && $consulta[$a]["admisiones"] == "si" && $consulta[$a]["homologado"] == 0) {
                $estado = "Homologado";
            } else if ($consulta[$a]["periodo"] == $periodo_actual && $consulta[$a]["admisiones"] == "no" && $consulta[$a]["homologado"] == 1) {
                $estado = "Interno";
            } else {
                $estado = "Rematricula";
            }
            $data["datos"] .=  '<td>' . $consulta[$a]["credencial_identificacion"] . '</td>';
            $data["datos"] .=  '<td>' . $consulta[$a]["id_estudiante_activo"] . '</td>';
            $data["datos"] .= '<td>' . $consulta[$a]["periodo"] . '</td>';
            $data["datos"] .= '<td>' . $estadograduado . ' </td>';
            $data["datos"] .= '<td>' . $estado . '</td> ';
            $actualizar = $ajustedatos->actualizarestadomatricula($consulta[$a]["id_estudiante_activo"], $estado);
            $data["datos"] .= '</tr>';
        }
        $data["datos"] .= '</table>';
        $data["datos"] .= count($consulta);
        echo json_encode($data);
        break;
    case "sofipersonacredencial":
        $data = array();
        $data["datos"] = "";
        $consultaactivos = $ajustedatos->sofi_persona();
        $data["datos"] .= '<div class="alert col-12"><b>Nota:</b>Muestras las personas que no tienen ID credencial</div>';
        $data["datos"] .= '<h2 class="titulo-1">Total activos tabla estudiantes: ' . count($consultaactivos) . '</h2>';
        $data["datos"] .= '<div class="row">';
        $data["datos"] .= '<table class="table">';
        $data["datos"] .= '<thead">';
        $data["datos"] .= '<th>Id_persona</th>';
        $data["datos"] .= '<th>Identificacion</th>';
        $data["datos"] .= '<th>Nombre</th>';
        $data["datos"] .= '<th>celular</th>';
        $data["datos"] .= '</thead">';
        $data["datos"] .= '<tbody">';
        for ($a = 0; $a < count($consultaactivos); $a++) {
            $id_persona = $consultaactivos[$a]["id_persona"];
            $numero_documento = $consultaactivos[$a]["numero_documento"];
            $nombre = $consultaactivos[$a]["nombres"];
            $celular = $consultaactivos[$a]["celular"];
            $datos_credencial = $ajustedatos->mirarCredencial($numero_documento);
            @$idcredencial = $datos_credencial["id_credencial"];
            $data["datos"] .= '<tr>';
            $data["datos"] .= '<td>' . $id_persona . '</td>';
            $data["datos"] .= '<td>' . $numero_documento . '</td>';
            $data["datos"] .= '<td>' . $nombre . '</td>';
            $data["datos"] .= '<td>' . $celular . '</td>';
            $data["datos"] .= '</tr>';
            $actualizar = $ajustedatos->actualizarCredencial($id_persona, $idcredencial);
        }
        $data["datos"] .= '</tbody">';
        $data["datos"] .= '</table">';
        $data["datos"] .= '</div>';
        echo json_encode($data);
        break;
    case "sofitareascredencial":
        $data = array();
        $data["datos"] = "";
        $consultaactivos = $ajustedatos->sofi_tareas();
        $data["datos"] .= '<div class="alert col-12"><b>Nota:</b>Muestras las personas que no tienen ID credencial en sofi tareas</div>';
        $data["datos"] .= '<h2 class="titulo-1">Total activos tabla estudiantes: ' . count($consultaactivos) . '</h2>';
        $data["datos"] .= '<div class="row">';
        $data["datos"] .= '<table class="table">';
        $data["datos"] .= '<thead">';
        $data["datos"] .= '<th>Id_persona</th>';
        $data["datos"] .= '<th>Identificacion</th>';
        $data["datos"] .= '<th>Nombre</th>';
        $data["datos"] .= '<th>celular</th>';
        $data["datos"] .= '</thead">';
        $data["datos"] .= '<tbody">';
        for ($a = 0; $a < count($consultaactivos); $a++) {
            $id_persona = $consultaactivos[$a]["id_persona"];
            $numero_documento = $consultaactivos[$a]["numero_documento"];
            $nombre = $consultaactivos[$a]["nombres"];
            $celular = $consultaactivos[$a]["celular"];
            $datos_credencial = $ajustedatos->mirarCredencial($numero_documento);
            @$idcredencial = $datos_credencial["id_credencial"];
            $data["datos"] .= '<tr>';
            $data["datos"] .= '<td>' . $id_persona . '</td>';
            $data["datos"] .= '<td>' . $numero_documento . '</td>';
            $data["datos"] .= '<td>' . $nombre . '</td>';
            $data["datos"] .= '<td>' . $celular . '</td>';
            $data["datos"] .= '</tr>';
            $actualizar = $ajustedatos->actualizarCredencialTareas($id_persona, $idcredencial);
        }
        $data["datos"] .= '</tbody">';
        $data["datos"] .= '</table">';
        $data["datos"] .= '</div>';
        echo json_encode($data);
        break;
    case 'sofiVerificarFinalizados':
        $html = '<div class="row">
                    <div class="col-6 border font-weight-bold">Consecutivo</div>
                    <div class="col-6 border font-weight-bold">Estado</div>';

        //traemos todos los creditos en que credito_finalizado = 0
        $creditos_activo = $ajustedatos->listarCreditosActivos();
        //listamos todos los creditos y buscamos la cantidad de pago referente a la cantidad de la deuda
        for ($i = 0; $i < count($creditos_activo); $i++) {
            $consecutivo = $creditos_activo[$i]["id"];
            //con el consecutivo, buscamos las cuotas en sofi_financiamiento
            $valores_x_credito = $ajustedatos->calcularValoresDeuda($consecutivo);
            $estado = "Activo";
            if ($valores_x_credito["total_deuda"] <= $valores_x_credito["total_pagado"]) {
                $ajustedatos->finalizarCredito($consecutivo);
                $estado = "Finalizado";
            }
            $html .= '<div class="col-6 border">' . $consecutivo . '</div>
                    <div class="col-6 border">' . $estado . '</div>';
        }
        $html .= '</div>';
        echo json_encode(array("datos" => $html));
        break;

    case "sofiSeguiWhatsapp":
        $data = array();
        $data["datos"] = "";
        $consultaactivos = $ajustedatos->sofipersonamatricula();
        $data["datos"] .= '<div class="alert col-12"><b>Nota:</b>Muestra los seguimientos que no tienen id_persona del whatsapp</div>';
        $data["datos"] .= '<h2 class="titulo-1">Total casos: ' . count($consultaactivos) . '</h2>';
        $data["datos"] .= '<div class="row">';
        $data["datos"] .= '<table class="table">';
        $data["datos"] .= '<thead">';
        $data["datos"] .= '<th>Id_credencial</th>';
        $data["datos"] .= '<th>Id_seguimiento</th>';
        $data["datos"] .= '<th>Id persona encontrado</th>';
        $data["datos"] .= '<th>celular</th>';
        $data["datos"] .= '</thead">';
        $data["datos"] .= '<tbody">';
        for ($a = 0; $a < count($consultaactivos); $a++) {
            $id_credencial = $consultaactivos[$a]["id_credencial"];
            $id_seguimiento = $consultaactivos[$a]["id_segumiento"];

            $buscarelidpersona = $ajustedatos->buscarIdPersona($id_credencial);
            if ($buscarelidpersona) {
                $idencontrado = $buscarelidpersona["id_persona"];
                $actualizar = $ajustedatos->actualizarIdPersonaSegui($id_seguimiento, $idencontrado);
            } else {
                $idencontrado = "Sin datos";
            }

            $data["datos"] .= '<tr>';
            $data["datos"] .= '<td>' . $id_credencial . '</td>';
            $data["datos"] .= '<td>' . $id_seguimiento . '</td>';
            $data["datos"] .= '<td>' . $idencontrado . '</td>';
            $data["datos"] .= '<td>' . $id_credencial . '</td>';
            $data["datos"] .= '</tr>';
        }
        $data["datos"] .= '</tbody">';
        $data["datos"] .= '</table">';
        $data["datos"] .= '</div>';
        echo json_encode($data);
        break;

    case "marcarreonovacion":
        $data = array();
        $data["datos"] = "";
        $consultaactivos = $ajustedatos->debenrenovar($periodo_anterior);
        $data["datos"] .= '<div class="alert col-12"><b>Nota:</b>Muestran las personas que no tienen pago en estudiantes_activos donde renovo financiera esta en 1</div>';
        $data["datos"] .= '<h2 class="titulo-1">Total casos: ' . count($consultaactivos) . '</h2>';
        $data["datos"] .= '<div class="row">';
        $data["datos"] .= '<table class="table">';
        $data["datos"] .= '<thead">';
        $data["datos"] .= '<th>Id_estudiante_activo</th>';
        $data["datos"] .= '<th>Id_seguimiento</th>';
        $data["datos"] .= '<th>Id persona encontrado</th>';
        $data["datos"] .= '<th>celular</th>';
        $data["datos"] .= '</thead">';
        $data["datos"] .= '<tbody">';
        for ($a = 0; $a < count($consultaactivos); $a++) {
            $id_estudiante_activo = $consultaactivos[$a]["id_estudiante_activo"];
            $id_credencial = $consultaactivos[$a]["id_credencial"];
            $renovo_financiera = $consultaactivos[$a]["renovo_financiera"];

            $datoscredencial = $ajustedatos->datoscredencial($id_credencial);
            $identificacion = $datoscredencial["credencial_identificacion"];

            if ($renovo_financiera == 1) {
                $bucarcredito = $ajustedatos->buscarcredito($identificacion, $periodo_pecuniario);
                // Verificar si se encontró algo
                if ($bucarcredito) {
                    $renovo = 'si';
                    $actualizar = $ajustedatos->actualizarPagoRenovacion($id_estudiante_activo, 2); // dos quiere decir renovo con financiacion
                } else {
                    $renovo = 'no';
                }
            } else {
                $renovo = 'no';
            }


            $data["datos"] .= '<tr>';
            $data["datos"] .= '<td>' . $id_estudiante_activo . '</td>';
            $data["datos"] .= '<td>' . $renovo_financiera . '</td>';
            $data["datos"] .= '<td>' . $identificacion . '</td>';
            $data["datos"] .= '<td>' . $renovo . '</td>';
            $data["datos"] .= '</tr>';
        }
        $data["datos"] .= '</tbody">';
        $data["datos"] .= '</table">';
        $data["datos"] .= '</div>';
        echo json_encode($data);
        break;

    case "marcarreonovacionefectivo":
        $data = array();
        $data["datos"] = "";
        $consultaactivos = $ajustedatos->debenrenovar($periodo_anterior);
        $data["datos"] .= '<div class="alert col-12"><b>Nota:</b>Muestran las personas que no tienen pago en estudiantes_activos donde renovo financiera esta en 1</div>';
        $data["datos"] .= '<h2 class="titulo-1">Total casos: ' . count($consultaactivos) . '</h2>';
        $data["datos"] .= '<div class="row">';
        $data["datos"] .= '<table class="table">';
        $data["datos"] .= '<thead">';
        $data["datos"] .= '<th>Id_estudiante_activo</th>';
        $data["datos"] .= '<th>Id_seguimiento</th>';
        $data["datos"] .= '<th>Id persona encontrado</th>';
        $data["datos"] .= '<th>celular</th>';
        $data["datos"] .= '</thead">';
        $data["datos"] .= '<tbody">';
        for ($a = 0; $a < count($consultaactivos); $a++) {
            $id_estudiante_activo = $consultaactivos[$a]["id_estudiante_activo"];
            $id_credencial = $consultaactivos[$a]["id_credencial"];
            $renovo_financiera = $consultaactivos[$a]["renovo_financiera"];

            $datoscredencial = $ajustedatos->datoscredencial($id_credencial);
            $identificacion = $datoscredencial["credencial_identificacion"];

            if ($renovo_financiera == 1) {
                $bucarcarpago = $ajustedatos->buscarpagos($identificacion, $periodo_pecuniario);
                // Verificar si se encontró algo
                if ($bucarcarpago) {
                    $renovo = 'si';
                    $actualizar = $ajustedatos->actualizarPagoRenovacion($id_estudiante_activo, 3); // dos quiere decir renovo con pago en efectivo, sin financiación
                } else {
                    $renovo = 'no';
                }
            } else {
                $renovo = 'no';
            }


            $data["datos"] .= '<tr>';
            $data["datos"] .= '<td>' . $id_estudiante_activo . '</td>';
            $data["datos"] .= '<td>' . $renovo_financiera . '</td>';
            $data["datos"] .= '<td>' . $identificacion . '</td>';
            $data["datos"] .= '<td>' . $renovo . '</td>';
            $data["datos"] .= '</tr>';
        }
        $data["datos"] .= '</tbody">';
        $data["datos"] .= '</table">';
        $data["datos"] .= '</div>';
        echo json_encode($data);
        break;

    case "marcarreonovacionweb":
        $data = array();
        $data["datos"] = "";
        $consultaactivos = $ajustedatos->debenrenovar($periodo_anterior);
        $data["datos"] .= '<div class="alert col-12"><b>Nota:</b>Muestran los estudiantes que tienen algun pago por la web, para marcar como renovo en la tabla estuidiantes activos</div>';
        $data["datos"] .= '<h2 class="titulo-1">Total casos: ' . count($consultaactivos) . '</h2>';
        $data["datos"] .= '<div class="row">';
        $data["datos"] .= '<table class="table">';
        $data["datos"] .= '<thead">';
        $data["datos"] .= '<th>Id_estudiante_activo</th>';
        $data["datos"] .= '<th>identificacion</th>';
        $data["datos"] .= '<th>Descripción</th>';
        $data["datos"] .= '<th>Monto</th>';
        $data["datos"] .= '<th>Acción</th>';
        $data["datos"] .= '</thead">';
        $data["datos"] .= '<tbody">';
        for ($a = 0; $a < count($consultaactivos); $a++) {
            $id_estudiante_activo = $consultaactivos[$a]["id_estudiante_activo"];
            $id_credencial = $consultaactivos[$a]["id_credencial"];
            $renovo_financiera = $consultaactivos[$a]["renovo_financiera"];

            $datoscredencial = $ajustedatos->datoscredencial($id_credencial);
            $identificacion = $datoscredencial["credencial_identificacion"];

            if ($renovo_financiera == 1) {
                $bucarcarpago = $ajustedatos->buscarpagosweb($identificacion, $periodo_pecuniario);
                // Verificar si se encontró algo
                if ($bucarcarpago) {
                    $renovo = 'si';

                    $data["datos"] .= '<tr>';
                    $data["datos"] .= '<td>' . $id_estudiante_activo . '</td>';
                    $data["datos"] .= '<td>' . $identificacion . '</td>';
                    $data["datos"] .= '<td>' . $bucarcarpago["x_description"] . '</td>';
                    $data["datos"] .= '<td>' . $bucarcarpago["x_amount_base"] . '</td>';
                    $data["datos"] .= '<td><a class="btn btn-success" onclick="marcarpago(' . $id_estudiante_activo . ')">Marcar</a></td>';
                    $data["datos"] .= '</tr>';
                }
                //$actualizar = $ajustedatos->actualizarPagoRenovacion($id_estudiante_activo,3);// dos quiere decir renovo con pago en efectivo, sin financiación

            }
        }
        $data["datos"] .= '</tbody">';
        $data["datos"] .= '</table">';
        $data["datos"] .= '</div>';
        echo json_encode($data);
        break;

    case "marcarpago":
        $id_estudiante_activo = $_POST["id_estudiante_activo"];
        $data = array();
        $data["datos"] = "";
        $actualizar = $ajustedatos->actualizarPagoRenovacion($id_estudiante_activo, 3); // dos quiere decir renovo con pago en efectivo, sin financiación

        if ($actualizar >= 0) {
            $data["datos"] .= "1";
        } else {
            $data["datos"] .= 'No cumple: ';
        }
        echo json_encode($data);
        break;
    case "renovacioncontrol":

        $data = array();
        $data["datos"] = "";

        $general = $ajustedatos->general($periodo_anterior);
        $generalrenovo = $ajustedatos->generalrenovo($periodo_anterior);
        $generalpendiente = $ajustedatos->generalpendiente($periodo_anterior);
        $generalcumplimiento = round((count($generalrenovo) / count($general)) * 100);
        $generalrenovof = $ajustedatos->generalrenovofc($periodo_anterior, 2); //2 es financiado
        $generalrenovoc = $ajustedatos->generalrenovofc($periodo_anterior, 3); //3 es contado

        $admingeneral = $ajustedatos->generalprograma($periodo_anterior, 1); //administracion
        $adminrenovo = $ajustedatos->programarenovo($periodo_anterior, 1); //administracion
        $adminpendiente = $ajustedatos->programapendiente($periodo_anterior, 1); //administracion
        $admincumplimiento = round((count($adminrenovo) / count($admingeneral)) * 100);
        $adminrenovof = $ajustedatos->programarenovofc($periodo_anterior, 1, 2); //2 es financiado
        $adminrenovoc = $ajustedatos->programarenovofc($periodo_anterior, 1, 3); //3 es contado

        $ingegeneral = $ajustedatos->generalprograma($periodo_anterior, 2);
        $ingerenovo = $ajustedatos->programarenovo($periodo_anterior, 2);
        $ingependiente = $ajustedatos->programapendiente($periodo_anterior, 2);
        $ingecumplimiento = round((count($ingerenovo) / count($ingegeneral)) * 100);
        $ingerenovof = $ajustedatos->programarenovofc($periodo_anterior, 2, 2); //2 es financiado
        $ingerenovoc = $ajustedatos->programarenovofc($periodo_anterior, 2, 3); //3 es contado

        $sstgeneral = $ajustedatos->generalprograma($periodo_anterior, 3);
        $sstrenovo = $ajustedatos->programarenovo($periodo_anterior, 3);
        $sstpendiente = $ajustedatos->programapendiente($periodo_anterior, 3);
        $sstcumplimiento = round((count($sstrenovo) / count($sstgeneral)) * 100);
        $sstrenovof = $ajustedatos->programarenovofc($periodo_anterior, 3, 2); //2 es financiado
        $sstrenovoc = $ajustedatos->programarenovofc($periodo_anterior, 3, 3); //3 es contado

        $indgeneral = $ajustedatos->generalprograma($periodo_anterior, 5);
        $indrenovo = $ajustedatos->programarenovo($periodo_anterior, 5);
        $indpendiente = $ajustedatos->programapendiente($periodo_anterior, 5);
        $indcumplimiento = round((count($indrenovo) / count($indgeneral)) * 100);
        $indrenovof = $ajustedatos->programarenovofc($periodo_anterior, 5, 2); //2 es financiado
        $indrenovoc = $ajustedatos->programarenovofc($periodo_anterior, 5, 3); //3 es contado

        $contageneral = $ajustedatos->generalprograma($periodo_anterior, 6);
        $contarenovo = $ajustedatos->programarenovo($periodo_anterior, 6);
        $contapendiente = $ajustedatos->programapendiente($periodo_anterior, 6);
        $contacumplimiento = round((count($contarenovo) / count($contageneral)) * 100);
        $contarenovof = $ajustedatos->programarenovofc($periodo_anterior, 6, 2); //2 es financiado
        $contarenovoc = $ajustedatos->programarenovofc($periodo_anterior, 6, 3); //3 es contado

        $enfermeriageneral = $ajustedatos->generallaboral($periodo_anterior, 7, 89);
        $enfermeriarenovo = $ajustedatos->laboralrenovo($periodo_anterior, 7, 89);
        $enfermeriapendiente = $ajustedatos->laboralpendiente($periodo_anterior, 7, 89);
        $enfermeriacumplimiento = round((count($enfermeriarenovo) / count($enfermeriageneral)) * 100);
        $enfermeriarenovof = $ajustedatos->laboralrenovofc($periodo_anterior, 7, 89, 2); //2 es financiado
        $enfermeriarenovoc = $ajustedatos->laboralrenovofc($periodo_anterior, 7, 89, 3); //3 es contado

        $adminsaludgeneral = $ajustedatos->generallaboral($periodo_anterior, 7, 103);
        $adminsaludrenovo = $ajustedatos->laboralrenovo($periodo_anterior, 7, 103);
        $adminsaludpendiente = $ajustedatos->laboralpendiente($periodo_anterior, 7, 103);
        $adminsaludcumplimiento = round((count($adminsaludrenovo) / count($adminsaludgeneral)) * 100);
        $adminsaludrenovof = $ajustedatos->laboralrenovofc($periodo_anterior, 7, 103, 2); //2 es financiado
        $adminsaludrenovoc = $ajustedatos->laboralrenovofc($periodo_anterior, 7, 103, 3); //3 es contado

        $veterinariageneral = $ajustedatos->generallaboral($periodo_anterior, 7, 115);
        $veterinariarenovo = $ajustedatos->laboralrenovo($periodo_anterior, 7, 115);
        $veterinariapendiente = $ajustedatos->laboralpendiente($periodo_anterior, 7, 115);
        $veterinariacumplimiento = round((count($veterinariarenovo) / count($veterinariageneral)) * 100);
        $veterinariarenovof = $ajustedatos->laboralrenovofc($periodo_anterior, 7, 115, 2); //2 es financiado
        $veterinariarenovoc = $ajustedatos->laboralrenovofc($periodo_anterior, 7, 115, 3); //3 es contado

        $motosgeneral = $ajustedatos->generallaboral($periodo_anterior, 7, 121);
        $motosrenovo = $ajustedatos->laboralrenovo($periodo_anterior, 7, 121);
        $motospendiente = $ajustedatos->laboralpendiente($periodo_anterior, 7, 121);
        $motoscumplimiento = round((count($motosrenovo) / count($motosgeneral)) * 100);
        $motosrenovof = $ajustedatos->laboralrenovofc($periodo_anterior, 7, 121, 2); //2 es financiado
        $motosrenovoc = $ajustedatos->laboralrenovofc($periodo_anterior, 7, 121, 3); //3 es contado



        $data["datos"] .= '
            <table class="table">
                <thead>
                    <th>Progama</th>
                    <th>Meta</th>
                    <th>Matriculados</th>
                    <th>Por Matricular</th>
                    <th>Cumplimiento</th>
                    <th>Financiado</th>
                    <th>Contado</th>
                </thead>
                <tbody>
                    <tr>
                        <td>GENERAL</td>
                        <td>' . count($general) . '</td>
                        <td>' . count($generalrenovo) . '</td>
                        <td>' . count($generalpendiente) . '</td>
                        <td>' . $generalcumplimiento . '%</td>
                        <td>' . count($generalrenovof) . '</td>
                        <td>' . count($generalrenovoc) . '</td>
                    </tr>
                    <tr>
                        <td>ADMINISTRACION</td>
                        <td>' . count($admingeneral) . '</td>
                        <td>' . count($adminrenovo) . '</td>
                        <td>' . count($adminpendiente) . '</td>
                        <td>' . $admincumplimiento . '%</td>
                        <td>' . count($adminrenovof) . '</td>
                        <td>' . count($adminrenovoc) . '</td>
                    </tr>
                    <tr>
                        <td>SOFTWARE</td>
                        <td>' . count($ingegeneral) . '</td>
                        <td>' . count($ingerenovo) . '</td>
                        <td>' . count($ingependiente) . '</td>
                        <td>' . $ingecumplimiento . '%</td>
                        <td>' . count($ingerenovof) . '</td>
                        <td>' . count($ingerenovoc) . '</td>
                    </tr>
                    <tr>
                        <td>SST</td>
                        <td>' . count($sstgeneral) . '</td>
                        <td>' . count($sstrenovo) . '</td>
                        <td>' . count($sstpendiente) . '</td>
                        <td>' . $sstcumplimiento . '%</td>
                        <td>' . count($sstrenovof) . '</td>
                        <td>' . count($sstrenovoc) . '</td>
                    </tr>
                    <tr>
                        <td>ING INDUSTRIAL</td>
                        <td>' . count($indgeneral) . '</td>
                        <td>' . count($indrenovo) . '</td>
                        <td>' . count($indpendiente) . '</td>
                        <td>' . $indcumplimiento . '%</td>
                        <td>' . count($indrenovof) . '</td>
                        <td>' . count($indrenovoc) . '</td>
                    </tr>
                    <tr>
                        <td>CONTADURIA</td>
                        <td>' . count($contageneral) . '</td>
                        <td>' . count($contarenovo) . '</td>
                        <td>' . count($contapendiente) . '</td>
                        <td>' . $contacumplimiento . '%</td>
                        <td>' . count($contarenovof) . '</td>
                        <td>' . count($contarenovoc) . '</td>
                    </tr>
                    <tr>
                        <td>AUX ENFERMERIA</td>
                        <td>' . count($enfermeriageneral) . '</td>
                        <td>' . count($enfermeriarenovo) . '</td>
                        <td>' . count($enfermeriapendiente) . '</td>
                        <td>' . $enfermeriacumplimiento . '%</td>
                        <td>' . count($enfermeriarenovof) . '</td>
                        <td>' . count($enfermeriarenovoc) . '</td>
                    </tr>
                    <tr>
                        <td>ADMINISTRATIVO EN SALUD</td>
                        <td>' . count($adminsaludgeneral) . '</td>
                        <td>' . count($adminsaludrenovo) . '</td>
                        <td>' . count($adminsaludpendiente) . '</td>
                        <td>' . $adminsaludcumplimiento . '%</td>
                        <td>' . count($adminsaludrenovof) . '</td>
                        <td>' . count($adminsaludrenovoc) . '</td>
                    </tr>
                    <tr>
                        <td>VETERINARIA</td>
                        <td>' . count($veterinariageneral) . '</td>
                        <td>' . count($veterinariarenovo) . '</td>
                        <td>' . count($veterinariapendiente) . '</td>
                        <td>' . $veterinariacumplimiento . '%</td>
                        <td>' . count($veterinariarenovof) . '</td>
                        <td>' . count($veterinariarenovoc) . '</td>
                    </tr>
                    <tr>
                        <td>MOTOS</td>
                        <td>' . count($motosgeneral) . '</td>
                        <td>' . count($motosrenovo) . '</td>
                        <td>' . count($motospendiente) . '</td>
                        <td>' . $motoscumplimiento . '%</td>
                        <td>' . count($motosrenovof) . '</td>
                        <td>' . count($motosrenovoc) . '</td>
                    </tr>
                </tbody>
            
            </table>';


        echo json_encode($data);
        break;

    case "renovacionaca":
        $data = array();
        $data["datos"] = "";
        $consultaactivos = $ajustedatos->marcaracademica($periodo_anterior);
        $data["datos"] .= '<div class="alert col-12"><b>Nota:</b>Muestran las personas que renovaron academicamente </div>';
        $data["datos"] .= '<h2 class="titulo-1">Total casos: ' . count($consultaactivos) . '</h2>';
        $data["datos"] .= '<div class="row">';
        $data["datos"] .= '<table class="table">';
        $data["datos"] .= '<thead">';
        $data["datos"] .= '<th>Id_estudiante_activo</th>';
        $data["datos"] .= '<th>Identificacion</th>';
        $data["datos"] .= '<th>Programa</th>';
        $data["datos"] .= '<th>Semestre</th>';
        $data["datos"] .= '<th>renovo</th>';
        $data["datos"] .= '</thead">';
        $data["datos"] .= '<tbody">';




        for ($a = 0; $a < count($consultaactivos); $a++) {

            $id_estudiante_activo = $consultaactivos[$a]["id_estudiante_activo"];
            $id_credencial = $consultaactivos[$a]["id_credencial"];
            $renovo_financiera = $consultaactivos[$a]["renovo_financiera"];

            $datoscredencial = $ajustedatos->datoscredencial($id_credencial);
            $identificacion = $datoscredencial["credencial_identificacion"];

            $renovo = $ajustedatos->marcaracademicarenovo($id_credencial, $periodo_actual);
            $nom_programa_renovo = $ajustedatos->traer_nom_programa($renovo["programa"]);
            $programa = $nom_programa_renovo["nombre"];
            $semestrenuevo = $renovo["semestre"];
            $estadorenovo = "Sin renovar";
            $semestrerenovo = null;
            if ($renovo) {

                $actualizar = $ajustedatos->actualizarrenovoacademica($id_estudiante_activo, $programa, $semestrenuevo); // quiere decir que renovo academicamente
            } else {

                $actualizar = $ajustedatos->actualizarrenovoacademica($id_estudiante_activo, $estadorenovo, $semestrerenovo); // quiere decir que no renovo academicamente
            }

            $data["datos"] .= '<tr>';
            $data["datos"] .= '<td>' . $id_estudiante_activo . '</td>';
            $data["datos"] .= '<td>' . $identificacion . '</td>';
            $data["datos"] .= '<td>' . $programa . '</td>';
            $data["datos"] .= '<td>' . $renovo["semestre"] . '</td>';
            $data["datos"] .= '<td>' . $semestrenuevo . '</td>';
            $data["datos"] .= '</tr>';
        }
        $data["datos"] .= '</tbody">';
        $data["datos"] .= '</table">';
        $data["datos"] .= '</div>';
        echo json_encode($data);
        break;

    case 'SegmentacionEstudiante':
        $html = '
                <table class="table table-striped">
                    <thead> 
                        <tr>
                            <th>Nombre Completo</th>
                            <th>Documento de Identidad</th>
                            <th>Estado</th>
                            <th>Periodo</th>
                            <th>Ciclo</th>
                        </tr>
                    </thead>
                    <tbody>';
        $traer_estudiantes = $ajustedatos->traer_estudiantes();
        for ($i = 0; $i < count($traer_estudiantes); $i++) {
            $estudiante = $traer_estudiantes[$i];
            $credencial_identificacion = $estudiante["credencial_identificacion"];
            $id_credencial = $estudiante["id_credencial"];
            $datos_estudiante = $ajustedatos->inicio_ingreso_estudiante($id_credencial);
            $periodo = !empty($datos_estudiante['periodo'])? $datos_estudiante['periodo']: NULL;
            $programa = !empty($datos_estudiante['fo_programa']) ? $datos_estudiante['fo_programa']: NULL;
            $ciclo_estudiante = !empty($datos_estudiante['ciclo']) ? $datos_estudiante['ciclo']: 0;
            if (!$ajustedatos->verificarExistenciaDocumento($credencial_identificacion)) {
                $fecha_nacimiento = $estudiante["fecha_nacimiento"];
                if ($fecha_nacimiento == "0000-00-00") {
                    $fecha_nacimiento = NULL;
                }
                $insertar_estudiantes = $ajustedatos->Insertar_Datos_Estudiantes($estudiante["id_credencial"], $estudiante["credencial_nombre"], $estudiante["credencial_nombre_2"], $estudiante["credencial_apellido"], $estudiante["credencial_apellido_2"], $credencial_identificacion, $fecha_nacimiento, $periodo, $programa, $ciclo_estudiante);
                $estado = "Estudiante Insertado";
            } else {
                $estado = "Estudiante ya se encuentra Insertado";
            }
            $html .= '
                    <tr>
                        <td>' . $estudiante["credencial_nombre"] . ' ' . $estudiante["credencial_nombre_2"] . ' ' . $estudiante["credencial_apellido"] . ' ' . $estudiante["credencial_apellido_2"] . '</td>
                        <td>' . $credencial_identificacion . '</td>
                        <td>' . $estado . '</td>
                        <td>' . $periodo . '</td>
                        <td>' . $ciclo_estudiante . '</td>
                    </tr>';
        }
        $html .= '</tbody></table>';

        echo json_encode(array("datos" => $html));
    break;


    case 'ajusteporcentajehojadevida':
        $html = '
                <table class="table table-striped">
                    <thead> 
                        <tr>
                            <th>Porcentaje </th>
                            <th>Cedula</th>
                        </tr>
                    </thead>
                    <tbody>';


        $rspta = $ajustedatos->listar();
        //Vamos a declarar un array
        $data  = array();
        $reg   = $rspta;
       for ($i = 0; $i < count($rspta); $i++) {
        $id_usuario = $rspta[$i]["id_usuario_cv"];
            $cedula = $rspta[$i]["usuario_identificacion"];

            // obtenemos los datos reales de la hoja de vida de cada usuario.
            $progreso = $ajustedatos->obtenerProgresoUsuario($id_usuario);

            // obtenemos el total de los documentos obligatorios
        $documentos_validos = $ajustedatos->obtenertotaldocumentosobligatorios($id_usuario);
            $pasos_completados = 0;
            // paso 1
            if ($progreso['info_personal'] >= 1) $pasos_completados++;
            // paso 2
            if ($progreso['educacion'] >= 2) $pasos_completados++;
            // paso 3
            if ($progreso['experiencia'] >= 2) $pasos_completados++;
            // paso 4
            if ($progreso['habilidades'] >= 5) $pasos_completados++;
            //paso 5
            if ($progreso['portafolio'] >= 2) $pasos_completados++;
            // paso 6
            if ($progreso['referencias_personales'] >= 2) $pasos_completados++;
            // paso 7
            if ($progreso['referencias_laborales'] >= 2) $pasos_completados++;
            // paso 8
            if ($documentos_validos == 8) $pasos_completados++;
            // paso 9 documentos adicional
            if ($progreso['documentos_adicionales'] >= 1) $pasos_completados++;
            //paso 10 areas de conocimiento 
            if ($progreso['areas_conocimiento'] >= 5) $pasos_completados++;
            // tomamos el porcentaje de los pasos
            $porcentaje_avance = ($pasos_completados / 10) * 100;

            $ajustedatos->actualiazrporcentajehojavida($cedula,$porcentaje_avance);
        // Construir HTML fila por fila
        $html .= '
            <tr>
                <td>' . $porcentaje_avance . '%</td>
                <td>' . $cedula . '</td>
            </tr>';

        }
        $html .= '</tbody></table>';

        echo json_encode(array("datos" => $html));
    break;

    case "tablamadre":
        $data = array();
        $data["datos"] = "";

        $data["datos"] .= '<div class="alert col-12"><b>Nota:</b> Llevar datos a la tabla madre estudiantes_info_completa.</div>';

        $data["datos"] .= '
            <a class="btn btn-danger" onclick=datamadre("'.$periodo_actual.'",1) title="Esto solo se hace una vez cuando ya esten cerradas las matriculas, pues crea los id en la tabla madre">
                Insertar los nuevos del periodo
            </a>
            <a class="btn btn-primary" onclick=datamadre("'.$periodo_actual.'",2)>
                <i class="fas fa-search"></i> update perfiles
            </a>
            <a class="btn btn-primary" onclick=datamadre("'.$periodo_actual.'",3)>
                <i class="fas fa-search"></i> Seres originales
            </a>
            <a class="btn btn-primary" onclick=datamadre("'.$periodo_actual.'",4)>
                <i class="fas fa-search"></i> Inspiradores
            </a>
            <a class="btn btn-primary" onclick=datamadre("'.$periodo_actual.'",5)>
                <i class="fas fa-search"></i> Empresas
            </a>

             <a class="btn btn-primary" onclick=datamadre("'.$periodo_actual.'",6)>
                <i class="fas fa-search"></i> Confiamos
            </a>
            <a class="btn btn-primary" onclick=datamadre("'.$periodo_actual.'",7)>
                <i class="fas fa-search"></i> Experiencia académica
            </a>
            <a class="btn btn-primary" onclick=datamadre("'.$periodo_actual.'",8)>
                <i class="fas fa-search"></i> Bienestar
            </a>
             <a class="btn btn-primary" onclick=datamadre("'.$periodo_actual.'",9)>
                <i class="fas fa-search"></i> Sofi
            </a>
            <a class="btn btn-primary" onclick=datamadre("'.$periodo_actual.'",10)>
                <i class="fas fa-search"></i> %ingresos campus
            </a>
            <a class="btn btn-primary" onclick=datamadre("'.$periodo_actual.'",11)>
                <i class="fas fa-search"></i> Edad
            </a>
            ';

        echo json_encode($data);
    break;

    case 'datamadre':
        $periodo=$_POST["periodo"];
        $opcion=$_POST["opcion"];

        $data = array();
        $data["datos"] = "";

        if($opcion==1){// solo para registras los id en la tabla madre, esot solo se hace una vez cuando tengamos todos los matriculados o la campaña cerrada
            $listarid = $ajustedatos->listarmadre($periodo_actual);
            for ($i = 0; $i < count($listarid); $i++) {
                $id_credencial=$listarid[$i]["id_credencial"];
                $identificacion=$listarid[$i]["credencial_identificacion"];
			    $nombreCompleto = $listarid[$i]["credencial_nombre"] . " " . $listarid[$i]["credencial_nombre_2"] . " " . $listarid[$i]["credencial_apellido"] . " " . $listarid[$i]["credencial_apellido_2"];
			    $nombreFormateado = mb_convert_case(mb_strtolower($nombreCompleto, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
                $nomprograma=$listarid[$i]["fo_programa"];
                $programa=$listarid[$i]["id_programa_ac"];
                $jornada=$listarid[$i]["jornada_e"];
                $escuela=$listarid[$i]["escuela"];
                $semestre=$listarid[$i]["semestre_estudiante"];
                $nivel=$listarid[$i]["ciclo"];

                $insertarid=$ajustedatos->insertarmadreid($id_credencial,$identificacion,$nombreCompleto,$nomprograma,$programa,$jornada,$escuela,$semestre,$nivel,$periodo);

            }
        }
        if($opcion==2){
            $listarid = $ajustedatos->listarmadre($periodo_actual);
            for ($i = 0; $i < count($listarid); $i++) {

                $id_credencial             = $listarid[$i]["id_credencial"];
                $genero                    = $listarid[$i]["genero"];
                $periodo                   = $listarid[$i]["periodo"];
                $fecha_nacimiento          = $listarid[$i]["fecha_nacimiento"];
                $departamento_nacimiento   = $listarid[$i]["departamento_nacimiento"];
                $lugar_nacimiento          = $listarid[$i]["lugar_nacimiento"];
                $estado_civil              = $listarid[$i]["estado_civil"];
                $grupo_etnico              = $listarid[$i]["grupo_etnico"];
                $nombre_etnico             = $listarid[$i]["nombre_etnico"];
                $desplazado_violencia      = $listarid[$i]["desplazado_violencia"];
                $conflicto_armado          = $listarid[$i]["conflicto_armado"];
                $depar_residencia          = $listarid[$i]["depar_residencia"];
                $muni_residencia           = $listarid[$i]["muni_residencia"];
                $tipo_residencia           = $listarid[$i]["tipo_residencia"];
                $zona_residencia           = $listarid[$i]["zona_residencia"];
                $direccion                 = $listarid[$i]["direccion"];
                $barrio                    = $listarid[$i]["barrio"];
                $estrato                   = $listarid[$i]["estrato"];
                $celular                   = $listarid[$i]["celular"];
                $whatsapp                  = $listarid[$i]["whatsapp"];
                $instagram                 = $listarid[$i]["instagram"];
                $facebook                  = $listarid[$i]["facebook"];
                $twiter                    = $listarid[$i]["twiter"];
                $email                     = $listarid[$i]["email"];
                $tipo_sangre               = $listarid[$i]["tipo_sangre"];

               $actualizar = $ajustedatos->actualizarperfilmadre($id_credencial, $genero, $periodo, $fecha_nacimiento, $departamento_nacimiento, $lugar_nacimiento, $estado_civil, $grupo_etnico, $nombre_etnico, $desplazado_violencia, $conflicto_armado, $depar_residencia, $muni_residencia, $tipo_residencia, $zona_residencia, $direccion, $barrio, $estrato, $celular, $whatsapp, $instagram, $facebook, $twiter, $email, $tipo_sangre);

            }
        }

        if($opcion==3){
            $listarid = $ajustedatos->listarcredencialmadre($periodo_actual);
            for ($i = 0; $i < count($listarid); $i++) {
                $id_credencial= $listarid[$i]["id_credencial"];

                $datos=$ajustedatos->seresoriginales($id_credencial);
                    
                    $estas_embarazada = ($datos["p1"] == 2) ? "Si" : "No";
                    $meses_embarazo           = $datos["p2"];
                    $eres_desplazado_violencia= ($datos["p3"] == 2) ? "Si" : "No";
                    $tipo_desplazamiento      = $datos["p4"];
                    $grupo_poblacional        = $datos["p5"];
                    $comunidad_lgbtiq         = ($datos["p6"] == 2) ? "Si" : "No";
                    $cual_comunidad           = $datos["p7"];
                    $contacto1_nombre         = $datos["p8"];
                    $contacto1_relacion       = $datos["p9"];
                    $contacto1_email          = $datos["p10"];
                    $contacto1_telefono       = $datos["p11"];
                    $contacto2_nombre         = $datos["p12"];
                    $contacto2_relacion       = $datos["p13"];
                    $contacto2_email          = $datos["p14"];
                    $contacto2_telefono       = $datos["p15"];
                    $tiene_computador_tablet  = $datos["p16"];
                    $conexion_internet_casa   = $datos["p17"];
                    $planes_datos_celular     = $datos["p18"];
               
                $actualizar = $ajustedatos->actualizarseresmadre(
                    $id_credencial,
                    $estas_embarazada,
                    $meses_embarazo,
                    $eres_desplazado_violencia,
                    $tipo_desplazamiento,
                    $grupo_poblacional,
                    $comunidad_lgbtiq,
                    $cual_comunidad,
                    $contacto1_nombre,
                    $contacto1_relacion,
                    $contacto1_email,
                    $contacto1_telefono,
                    $contacto2_nombre,
                    $contacto2_relacion,
                    $contacto2_email,
                    $contacto2_telefono,
                    $tiene_computador_tablet,
                    $conexion_internet_casa,
                    $planes_datos_celular
                );


            }
        }
        
        if($opcion==4){

            $listarid = $ajustedatos->listarcredencialmadre($periodo_actual);
            
                for ($i = 0; $i < count($listarid); $i++) {
                    $id_credencial= $listarid[$i]["id_credencial"];
                    
                    $datos=$ajustedatos->inspiradores($id_credencial);
                    $estado_civil_2               = $datos["ip1"];
                    $tiene_hijos                  = ($datos["ip2"] == 2) ? "Si" : "No";
                    $cantidad_hijos               = $datos["ip3"];
                    $padre_vivo                   = ($datos["ip4"] == 2) ? "Si" : "No";
                    $nombre_padre                 = $datos["ip5"];
                    $telefono_padre               = $datos["ip6"];
                    $nivel_educativo_padre        = $datos["ip7"];
                    $madre_viva                   = ($datos["ip8"] == 2) ? "Si" : "No";
                    $nombre_madre                 = $datos["ip9"];
                    $telefono_madre               = $datos["ip10"];
                    $nivel_educativo_madre        = $datos["ip11"];
                    $situacion_laboral_padres     = $datos["ip12"];
                    $sector_laboral_padres        = $datos["ip13"];
                    $cursos_interes_padres        = $datos["ip14"];
                    $tienes_pareja                = ($datos["ip15"] == 2) ? "Si" : "No";
                    $nombre_pareja                = $datos["ip16"];
                    $celular_pareja               = $datos["ip17"];
                    $tienes_hermanos              = ($datos["ip18"] == 2) ? "Si" : "No";
                    $cantidad_hermanos            = $datos["ip19"];
                    $edad_hermanos                = $datos["ip20"];
                    $con_quien_vive               = $datos["ip21"];
                    $personas_a_cargo             = ($datos["ip22"] == 2) ? "Si" : "No";
                    $cantidad_personas_cargo      = $datos["ip23"];
                    $inspirador_estudio           = $datos["ip24"];
                    $nombre_inspirador            = $datos["ip25"];
                    $whatsapp_inspirador          = $datos["ip26"];
                    $email_inspirador             = $datos["ip27"];
                    $nivel_formacion_inspirador   = $datos["ip28"];
                    $situacion_laboral_inspirador = $datos["ip29"];
                    $sector_inspirador            = $datos["ip30"];
                    $cursos_inspirador            = $datos["ip31"];

                    $actualizar = $ajustedatos->actualizarinspmadre(
                    	$id_credencial,
                        $estado_civil_2,
                        $tiene_hijos,
                        $cantidad_hijos,
                        $padre_vivo,
                        $nombre_padre,
                        $telefono_padre,
                        $nivel_educativo_padre,
                        $madre_viva,
                        $nombre_madre,
                        $telefono_madre,
                        $nivel_educativo_madre,
                        $situacion_laboral_padres,
                        $sector_laboral_padres,
                        $cursos_interes_padres,
                        $tienes_pareja,
                        $nombre_pareja,
                        $celular_pareja,
                        $tienes_hermanos,
                        $cantidad_hermanos,
                        $edad_hermanos,
                        $con_quien_vive,
                        $personas_a_cargo,
                        $cantidad_personas_cargo,
                        $inspirador_estudio,
                        $nombre_inspirador,
                        $whatsapp_inspirador,
                        $email_inspirador,
                        $nivel_formacion_inspirador,
                        $situacion_laboral_inspirador,
                        $sector_inspirador,
                        $cursos_inspirador
                    );

                    $data["datos"] .=  $cursos_inspirador;
                }

        }

        if($opcion==5){

            $listarid = $ajustedatos->listarcredencialmadre($periodo_actual);
            
                for ($i = 0; $i < count($listarid); $i++) {
                    $id_credencial= $listarid[$i]["id_credencial"];
                    
                    $datos=$ajustedatos->empresas($id_credencial);
                    $trabajas_actualmente           = ($datos["ep1"] == 2) ? "Si" : "No";
                    $empresa_trabajas               = $datos["ep2"];
                    $sector_empresa_trabajas        = $datos["ep3"];
                    $direccion_empresa              = $datos["ep4"];
                    $telefono_empresa               = $datos["ep5"];
                    $jornada_laboral               = $datos["ep6"];
                    $incentivos_empresa_formacion  = $datos["ep7"];
                    $alguien_trabajo_te_inspiro    = ($datos["ep8"] == 2) ? "Si" : "No";
                    $nombre_inspirador_trabajo     = $datos["ep9"];
                    $telefono_inspirador_trabajo   = $datos["ep10"];
                    $empresa_propia                =($datos["ep11"] == 2) ? "Si" : "No";;
                    $nombre_razon_empresa          = $datos["ep12"];
                    $tienes_emprendimiento         = ($datos["ep13"] == 2) ? "Si" : "No";
                    $nombre_emprendimiento         = $datos["ep14"];
                    $sector_emprendimiento         = $datos["ep15"];
                    $motivacion_emprender          = $datos["ep16"];
                    $recursos_emprendimiento       = $datos["ep17"];
                    $curso_emprendimiento          = ($datos["ep18"] == 2) ? "Si" : "No";
                    $cual_curso_emprendimiento     = $datos["ep19"];



                   $actualizar = $ajustedatos->actualizarempresasmadre(
                        $id_credencial,
                        $trabajas_actualmente,
                        $empresa_trabajas,
                        $sector_empresa_trabajas,
                        $direccion_empresa,
                        $telefono_empresa,
                        $jornada_laboral,
                        $incentivos_empresa_formacion,
                        $alguien_trabajo_te_inspiro,
                        $nombre_inspirador_trabajo,
                        $telefono_inspirador_trabajo,
                        $empresa_propia,
                        $nombre_razon_empresa,
                        $tienes_emprendimiento,
                        $nombre_emprendimiento,
                        $sector_emprendimiento,
                        $motivacion_emprender,
                        $recursos_emprendimiento,
                        $curso_emprendimiento,
                        $cual_curso_emprendimiento
                    );
                }

        }

        if($opcion==6){

            $listarid = $ajustedatos->listarcredencialmadre($periodo_actual);
            
                for ($i = 0; $i < count($listarid); $i++) {
                    $id_credencial= $listarid[$i]["id_credencial"];
                    
                    $datos=$ajustedatos->confiamos($id_credencial);

                    $ingresos_mensuales         = $datos["cop1"];
                    $quien_paga_matricula       = $datos["cop2"];
                    $apoyo_financiero           = $datos["cop3"];
                    $recibe_prima_cesantias     = $datos["cop4"];
                    $obligaciones_financieras   = ($datos["cop5"] == 2) ? "Si" : "No";
                    $tipo_obligaciones          = $datos["cop6"];




                   $actualizar = $ajustedatos->actualizarconfiamosmadre(

                    $id_credencial,
                    $ingresos_mensuales,
                    $quien_paga_matricula,
                    $apoyo_financiero,
                    $recibe_prima_cesantias,
                    $obligaciones_financieras,
                    $tipo_obligaciones

                    );

                }

        }

        if($opcion==7){

            $listarid = $ajustedatos->listarcredencialmadre($periodo_actual);
            
                for ($i = 0; $i < count($listarid); $i++) {
                    $id_credencial= $listarid[$i]["id_credencial"];
                    
                    $datos=$ajustedatos->experiencia($id_credencial);

                    $motivacion_estudio               = $datos["eap1"];
                    $como_enteraste_ciaf             = $datos["eap2"];
                    $area_preferencia                = $datos["eap3"];
                    $forma_aprendizaje               = $datos["eap4"];
                    $doble_titulacion                = ($datos["eap5"] == 2) ? "Si" : "No";
                    $programa_interes                = $datos["eap6"];
                    $dominas_segundo_idioma          = ($datos["eap7"] == 2) ? "Si" : "No";
                    $cual_idioma                     = $datos["eap8"];
                    $nivel_idioma                    = $datos["eap9"];
                    $segundo_contacto_emergencia_nombre = $datos["eap10"];

                   $actualizar = $ajustedatos->actualizarexperienciamadre(
                        $id_credencial,
                        $motivacion_estudio,
                        $como_enteraste_ciaf,
                        $area_preferencia,
                        $forma_aprendizaje,
                        $doble_titulacion,
                        $programa_interes,
                        $dominas_segundo_idioma,
                        $cual_idioma,
                        $nivel_idioma,
                        $segundo_contacto_emergencia_nombre
                    );

                }

        }

        if($opcion==8){

            $listarid = $ajustedatos->listarcredencialmadre($periodo_actual);
            
                for ($i = 0; $i < count($listarid); $i++) {
                    $id_credencial= $listarid[$i]["id_credencial"];
                    
                    $datos=$ajustedatos->bienestar($id_credencial);

                        $enfermedad_fisica             = ($datos["bp1"] == 2) ? "Si" : "No";
                        $cual_enfermedad_fisica        = $datos["bp2"];
                        $tratamiento_enfermedad_fisica = $datos["bp3"];
                        $trastorno_mental              = ($datos["bp4"] == 2) ? "Si" : "No";
                        $cual_trastorno_mental         = $datos["bp5"];
                        $tratamiento_mental            = $datos["bp6"];
                        $bienestar_emocional           = $datos["bp7"];
                        $eps_afiliado                  = $datos["bp8"];
                        $medicamentos_permanentes      = ($datos["bp9"] == 2) ? "Si" : "No";
                        $cuales_medicamentos           = $datos["bp10"];
                        $habilidad_talento             = ($datos["bp11"] == 2) ? "Si" : "No";
                        $cual_habilidad                = $datos["bp12"];
                        $actividades_extracurriculares = $datos["bp13"];
                        $reconocimientos_habilidad     = $datos["bp14"];
                        $integracion_habilidad         = $datos["bp15"];
                        $actividades_interes           = $datos["bp16"];
                        $voluntariado                  = ($datos["bp17"] == 2) ? "Si" : "No";
                        $cual_voluntariado             = $datos["bp18"];
                        $participar_en_ciaf            = $datos["bp19"];
                        $temas_interes                 = $datos["bp20"];
                        $musica_preferencia            = $datos["bp21"];
                        $habilidades_a_desarrollar     = $datos["bp22"];
                        $deporte_interes               = $datos["bp23"];


                   $actualizar = $ajustedatos->actualizarbienestarmadre(
                        $id_credencial,
                        $enfermedad_fisica,
                        $cual_enfermedad_fisica,
                        $tratamiento_enfermedad_fisica,
                        $trastorno_mental,
                        $cual_trastorno_mental,
                        $tratamiento_mental,
                        $bienestar_emocional,
                        $eps_afiliado,
                        $medicamentos_permanentes,
                        $cuales_medicamentos,
                        $habilidad_talento,
                        $cual_habilidad,
                        $actividades_extracurriculares,
                        $reconocimientos_habilidad,
                        $integracion_habilidad,
                        $actividades_interes,
                        $voluntariado,
                        $cual_voluntariado,
                        $participar_en_ciaf,
                        $temas_interes,
                        $musica_preferencia,
                        $habilidades_a_desarrollar,
                        $deporte_interes
                    );

                }

        }

        if($opcion==9){
            $credito_finalizado_convertido="";
            $listarid = $ajustedatos->listarcredencialmadre($periodo_actual);
            
                for ($i = 0; $i < count($listarid); $i++) {
                    $id_credencial= $listarid[$i]["id_credencial"];
                    $identificacion= $listarid[$i]["credencial_identificacion"];

                    $datos=$ajustedatos->sofi($identificacion,$periodo_actual);

                    $estado_credito = !empty($datos["estado"]) ? $datos["estado"] : null;
                    $dias_atraso = !empty($datos["atraso"]) ? $datos["atraso"] : null;
                    $credito_finalizado = !empty($datos["credito_finalizado"]) ? $datos["credito_finalizado"] : null;

                    

                    if ($credito_finalizado == 1) {
                        $credito_finalizado_convertido = "finalizado";
                    } elseif ($credito_finalizado == 0) {
                        $credito_finalizado_convertido = "activo";
                    } else {
                        $credito_finalizado_convertido = "no tiene";
                    }


                   $actualizar = $ajustedatos->actualizarsofimadre(
                        $id_credencial,
                        $estado_credito,
                        $dias_atraso,
                        $credito_finalizado_convertido
                    );

                }

        }

        if($opcion==10){
            
            
            $fecha_inicial = '2025-02-01';
            $fecha_final = date('Y-m-d'); // fecha actual

            $inicio = new DateTime($fecha_inicial);
            $fin = new DateTime($fecha_final);

            $diferencia = $inicio->diff($fin);
            $dias = $diferencia->days;
            
            $total_dias_rango = $dias;


            $listarid = $ajustedatos->listarmadre($periodo_actual);
            for ($i = 0; $i < count($listarid); $i++) {
                $id_credencial=$listarid[$i]["id_credencial"];

                $calculo_ingresos=$ajustedatos->diasUnicosDesdeFechas($id_credencial,$fecha_inicial,$fecha);
                $porcentaje_ingreso = ($calculo_ingresos / $total_dias_rango) * 100;
                
                $actualizar = $ajustedatos->actualizarpordias(
                    $id_credencial,
                    $porcentaje_ingreso
                );

            }
          
        }

        if($opcion==11){
              


            $listarid = $ajustedatos->listarmadre($periodo_actual);
            for ($i = 0; $i < count($listarid); $i++) {
                $id_credencial = $listarid[$i]["id_credencial"];
                $fecha_nacimiento = $listarid[$i]["fecha_nacimiento"];

                // Calcular la edad
                $fecha_nac = new DateTime($fecha_nacimiento);
                $hoy = new DateTime();
                $edad = $hoy->diff($fecha_nac)->y;

                $actualizar = $ajustedatos->actualizaredad(
                    $id_credencial,
                    $edad
                );

                
            }

          
        }


          echo json_encode($data);
    break;


    case 'resultadodocente':

        $data = array();
        $data["datos"] = "";
        $periodo="2025-2";
        
        $data["datos"] .= '<div class="row">';
            $datos = $ajustedatos->listarDocentes();
            for ($i = 0; $i < count($datos); $i++) {
                $sumar_promedio = 0;
                $promedio_total = 0;
                $id_docente = $datos[$i]["id_usuario"];
                $porcentaje = $ajustedatos->promedioCalculado($id_docente, $periodo);

                $img = (file_exists("../files/docentes/" . $datos[$i]["usuario_identificacion"] . ".jpg")) ? "../files/docentes/" . $datos[$i]["usuario_identificacion"] . ".jpg" : "../files/null.jpg";
                $nombre = $datos[$i]["usuario_nombre"] . " " . $datos[$i]["usuario_nombre_2"] . " " . $datos[$i]["usuario_apellido"] . " " . $datos[$i]["usuario_apellido_2"];
                if ($porcentaje > 90) {
                    $color = "bg-success";
                } else if ($porcentaje > 80) {
                    $color = "bg-orange";
                } else if ($porcentaje > 70) {
                    $color = "bg-warning";
                } else {
                    $color = "bg-danger";
                }
                $total_heteroevaluacion = round($porcentaje, 2);
                //Co-evaluacion Docente
                $coevaluacion_rspta = $ajustedatos->buscarResultadoPeriodo($id_docente, $periodo);
                $total_coevaluacion = round((count($coevaluacion_rspta) > 0) ? $coevaluacion_rspta[0]["total"] : 0, 2);
                if ($total_coevaluacion > 90) {
                    $color_coevaluacion = "bg-success";
                } else if ($total_coevaluacion > 80) {
                    $color_coevaluacion = "bg-orange";
                } else if ($total_coevaluacion > 70) {
                    $color_coevaluacion = "bg-warning";
                } else {
                    $color_coevaluacion = "bg-danger";
                }
                //Auto-evaluacion Docente
                $autoevaluacion_rspta = $ajustedatos->autoevaluacionDocente($id_docente, $periodo);
                $total_autoevaluacion = round((count($autoevaluacion_rspta) > 0) ? $autoevaluacion_rspta[0]["total"] : 0, 2);
                if ($total_autoevaluacion > 90) {
                    $color_autoevaluacion = "bg-success";
                } else if ($total_autoevaluacion > 80) {
                    $color_autoevaluacion = "bg-orange";
                } else if ($total_autoevaluacion > 70) {
                    $color_autoevaluacion = "bg-warning";
                } else {
                    $color_autoevaluacion = "bg-danger";
                }
                //total promedio ponderado
                $total_ponderado = round(($total_heteroevaluacion * 0.30) + ($total_coevaluacion * 0.40) + ($total_autoevaluacion * 0.30), 2);
                if ($total_ponderado > 90) {
                    $color_ponderado = "bg-success";
                } else if ($total_ponderado > 80) {
                    $color_ponderado = "bg-orange";
                } else if ($total_ponderado > 70) {
                    $color_ponderado = "bg-warning";
                } else {
                    $color_ponderado = "bg-danger";
                }

                if($total_ponderado > 0){

                    $data["datos"] .= '<div class="col-12">';
                    $data["datos"] .= "<img src='" . $img . "' class='direct-chat-img' width='50px' height='50px'>";
                    $data["datos"] .=  mb_convert_case($nombre, MB_CASE_TITLE, "UTF-8") . ' - ' ;
                    $data["datos"] .= $datos[$i]["usuario_identificacion"] . ' - ';
                    $data["datos"] .= $total_heteroevaluacion . ' - ';
                    $data["datos"] .= $total_autoevaluacion . ' - ';
                    $data["datos"] .= $total_coevaluacion . ' - ';
                    $data["datos"] .= $total_ponderado . ' - ';
                    $data["datos"] .= '</div>';

                    $insertarResultados= $ajustedatos->evaluacionDocenteGeneral($datos[$i]["usuario_identificacion"],$total_heteroevaluacion,$total_autoevaluacion,$total_coevaluacion,$total_ponderado,$periodo);

                }

                
            }
        $data["datos"] .= '</div>';
             echo json_encode($data);
    break;

}
