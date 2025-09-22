<?php
require_once "../modelos/Cantidadfaltas.php";
$consulta = new Consulta();
$rsptaperiodo = $consulta->periodoactual();
$periodo_actual = $rsptaperiodo["periodo_actual"];
$periodo_anterior = $rsptaperiodo["periodo_anterior"];
$periodo_siguiente = $rsptaperiodo["periodo_siguiente"];
$programa = $_POST['programa'];
$estado = $_POST['estado'];
$periodo = $_POST['periodo'];
$semestre = $_POST['semestre'];
$c = $_POST['c'];
date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$fecha_rango = date("Y-m-d", strtotime($fecha . "- 2 week"));
switch ($_GET['op']) {


    case 'consulta_tabla':
        $datos = $consulta->listar($programa, $periodo, $c, $semestre, $estado);
        $data['conte'] = ' <div class="panel-body table-responsive">';
        $data['conte'] .= '<table class="table table-hover" id="dtl_notas" style="width:100%">
            <thead>
                <tr>
                    <th>Identificación</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Programa</th>
                    <th scope="col">Asignatura</th>
                    <th scope="col">Jornada</th>
                    <th scope="col">Faltas</th>
                    <th scope="col">Celular</th>
                    <th scope="col">Promedio</th>
                    <th scope="col">Correo CIAF</th>
                    <th scope="col">Correo personal</th>
                </tr>
            </thead>
            <tbody>';
        for ($i = 0; $i < count($datos); $i++) {

            $estu = $consulta->datos($datos[$i]['id_estudiante']);
            $pro = $consulta->programa($datos[$i]['programa']);
            /* $f = $datos[$i]['faltas'];
            $con = ($estado == "4") ?  $f >= $estado  :  $f == $estado ;
            //echo $con;
            if ($con) { */
            $data['conte'] .= '<tr>
                                <th>' . $estu['cc'] . '</th>
                                <td>' . $estu['nombre'] . '</td>
                                <td>' . $pro['nombre'] . '</td>
                                <td>' . $datos[$i]['nombre_materia'] . '</td>
                                <td>' . $datos[$i]['jornada'] . '</td>
                                <td>' . $datos[$i]['faltas'] . '</td>
                                <td>' . $estu['telefono'] . '</td>
                                <td>' . $datos[$i]['promedio'] . '</td>
                                <td>' . $estu['correo'] . '</td>
                                <td>' . $estu['correo_p'] . '</td>

                            </tr>';
            //}
        }
        $data['conte'] .= '</table></div>';
        echo json_encode($data);
        break;

    case 'listarescuelas':
        $data = array(); //Vamos a declarar un array
        $data["mostrar"] = ""; //iniciamos el arreglo
        $data["mostrar"] .= '<div class="row">
                            <div class="col-12 pb-2">Buscar por:</div>';
        $traerescuelas = $consulta->listarescuelas();
        for ($a = 0; $a < count($traerescuelas); $a++) {
            $escuela = $traerescuelas[$a]["escuelas"];
            $color = $traerescuelas[$a]["color"];
            $color_ingles = $traerescuelas[$a]["color_ingles"];
            $nombre_corto = $traerescuelas[$a]["nombre_corto"];
            $id_escuelas = $traerescuelas[$a]["id_escuelas"];
            $data["mostrar"] .= '

                        <div style="width:170px">
                            <a onclick="consultaescuela(' . $id_escuelas . ')" title="ver cifras" class="row pointer m-2">
                                <div class="col-3 rounded bg-light-' . $color_ingles . '">
                                    <div class="text-red text-center pt-1">
                                        <i class="fa-regular fa-calendar-check fa-2x  text-' . $color_ingles . '" aria-hidden="true"></i>
                                    </div>
                                    
                                </div>
                                <div class="col-9 borde">
                                    <span>Escuela de</span><br>
                                    <span class="titulo-2 fs-12 line-height-16"> ' . $nombre_corto . '</span>
                                </div>
                            </a>
                        </div>';
        }
        $data["mostrar"] .= '</div>';
        echo json_encode($data);
        break;

    case 'consultaescuela':
        $id_escuela = $_GET['id_escuela'];
        $datos = $consulta->listarprogamas($id_escuela);
        $data['conte'] = ' <div class="col-12 table-responsive">';
        $data['conte'] .= '<table class="table table-hover" id="dtl_notas" style="width:100%">
            <thead>
                <tr>
                    <th>Identificación</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Programa</th>
                    <th scope="col">Asignatura</th>
                    <th scope="col">Jornada</th>
                    <th scope="col">Promedio</th>
                    <th scope="col">#faltas</th>
                    <th scope="col">Celular</th>
                    <th scope="col">Correo CIAF</th>
                    <th scope="col">Correo personal</th>
                </tr>
            </thead>
            <tbody>';
        for ($i = 0; $i < count($datos); $i++) { // trae los datos de los programas asociados a la escuela
            $id_programa = $datos[$i]["id_programa"];
            $ciclo = $datos[$i]["ciclo"];
            $traerfaltas = $consulta->listarfaltas($id_programa, $periodo_actual);
            for ($j = 0; $j < count($traerfaltas); $j++) { // tae los datos de de las fatas por programa
                $id_estudiante = $traerfaltas[$j]["id_estudiante"];
                $id_materia = $traerfaltas[$j]["id_materia"];
                $datosmateria = $consulta->listardatosmateria($id_materia, $ciclo);
                @$nombre_materia = $datosmateria["nombre_materia"];
                @$promedio_materia = $datosmateria["promedio"];
                $datosestudiante = $consulta->listardatosestudiante($id_estudiante);
                @$id_credencial = $datosestudiante["id_credencial"];
                $datoscredencial = $consulta->listardatoscredencial($id_credencial);
                @$identificacion = $datoscredencial["credencial_identificacion"];
                $numerofaltas = $consulta->listarnumerofaltas($id_estudiante, $id_materia, $periodo_actual);
                $totalfaltas = count($numerofaltas);
                $data['conte'] .= '
                    <tr style="font-size:14px">
                        <td>' . $identificacion . '</td>
                        <td>' . $datoscredencial["credencial_apellido"] . ' ' . $datoscredencial["credencial_apellido_2"] . ' ' . $datoscredencial["credencial_nombre"] . ' ' . $datoscredencial["credencial_nombre_2"] . '</td>
                        <td>' . $datos[$i]["nombre"] . '</td>
                        <td>' . @$nombre_materia . '</td>
                        <td>' . $datosestudiante["jornada_e"] . '</td>
                        <td>' . $promedio_materia . '</td>
                        <td class="text-center">
                            <a onclick="verfaltas(' . $id_estudiante . ',' . $id_materia . ')" class="badge badge-primary text-white pointer" title="Ver faltas">' . $totalfaltas . '</a>
                        </td>
                        <td>' . $datoscredencial["celular"] . '</td>
                        <td>' . $datoscredencial["credencial_login"] . '</td>
                        <td>' . $datoscredencial["email"] . '</td>
                    </tr>';
            }
        }
        $data['conte'] .= '</table></div>';
        echo json_encode($data);
        break;

    case 'verfaltas':
        $id_estudiante = $_POST["id_estudiante"];
        $id_materia = $_POST["id_materia"];
        $data = array(); //Vamos a declarar un array
        $data["mostrar"] = ""; //iniciamos el arreglo
        $data["mostrar"] .= '
        <table class="table table-sm compact">
            <thead class="table table-hover">
                <tr>
                <th scope="col">#</th>
                <th scope="col">Fecha</th>
                <th scope="col">Motivo</th>
                <th scope="col">Asignatura</th>
                <th scope="col">Docente</th>
                </tr>
            </thead>
            <tbody class="titulo-2 fs-12 line-height-16">
            ';
        $contador = 0;
        $traerfaltas = $consulta->verfaltas($id_estudiante, $id_materia);
        for ($a = 0; $a < count($traerfaltas); $a++) {
            $fecha_falta = $traerfaltas[$a]["fecha_falta"];
            $motivo = $traerfaltas[$a]["motivo_falta"];
            $id_docente = $traerfaltas[$a]["id_docente"];
            $materia_falta = $traerfaltas[$a]["materia_falta"];
            $datosdocente = $consulta->datosdocente($id_docente);
            @$nombredocente = $datosdocente["usuario_apellido"] . ' ' . $datosdocente["usuario_apellido_2"] . ' ' . $datosdocente["usuario_nombre"] . ' ' . $datosdocente["usuario_nombre_2"];
            $contador = $a + 1;
            $data["mostrar"] .= '
                <tr>
                    <th scope="row">' . $contador . '</th>
                    <td>' . $consulta->fechaesp($fecha_falta) . '</td>
                    <td>' . $motivo . '</td>
                    <td>' . $materia_falta . '</td>
                    <td>' . $nombredocente . '</td>
                </tr>
                ';
        }
        $data["mostrar"] .= '</table>';
        echo json_encode($data);
        break;
    case "grafico":
        $data["datosuno"] = array();

        for ($i = 0; $i <= 14; $i++) { //14 son los días de consulta
            $fecha_consulta = date("Y-m-d", strtotime($fecha_rango . "+" . $i . " days"));

            $listafaltas = $consulta->grafico($fecha_consulta);
            $fecha_enviar = new DateTime($fecha_consulta);
            $fecha_actual_iso = $fecha_enviar->format('Y-m-d\TH:i:s\Z'); // Formato ISO correcto

            $data["datosuno"][] = array("x" => $fecha_actual_iso, "y" => count($listafaltas));
        }

        echo json_encode($data);
        break;


        //se muestra la grafica cuando se selecciona la escuela
    case "grafico_escuela":
        // Para saber qué escuela se seleccionó
        $id_escuela_seleccionada = $_POST["id_escuela"];
        $mostrar_programa_seleccionado = $consulta->listarMateriaporgrafica($id_escuela_seleccionada);
        $data["datosuno"] = array();
        for ($a = 0; $a < count($mostrar_programa_seleccionado); $a++) {
            $programa = $mostrar_programa_seleccionado[$a]["id_programa"];
            for ($i = 0; $i < 14; $i++) {
                $fecha_consulta = date("Y-m-d", strtotime($fecha_rango . "+$i days"));
                $cantidad_faltas = $consulta->listarfaltasGrafica_escuela($fecha_consulta, $programa);
                // print_r($cantidad_faltas.$programa);
                $fecha_actual_iso = (new DateTime($fecha_consulta))->format('c');
                $data["datosuno"][] = array(
                    "x" => $fecha_actual_iso,
                    "y" => isset($cantidad_faltas[0]['total_faltas']) ? (int) $cantidad_faltas[0]['total_faltas'] : 0  // Convertir a entero para asegurar que sea un número
                );
            }
        }

        echo json_encode($data);
        break;
    case 'listarProgramas':
        $id_escuela = isset($_POST['id_escuela']) ? $_POST['id_escuela'] : "";
        // Llamar a la función `listarMateria` con `0` para indicar que queremos todas las materias
        $resultado = ($id_escuela === "0") ? $consulta->listarTodasMaterias() : $consulta->listarMateria($id_escuela);
        echo json_encode($resultado);
        break;


    case 'progra':
        $val = $_POST['val'];
        $consulta->progra($val);
        break;

        // muestra el grafico cuando se selecciona la consulta filtrada.
        case "grafico_consulta":
            $periodo = isset($_POST['periodo']) ? $_POST['periodo'] : "";
            $semestre = isset($_POST['semestre']) ? $_POST['semestre'] : "";
            $programa = isset($_POST['programa']) ? $_POST['programa'] : "";
            $data["datosuno"] = array();
            $fecha_rango = date("Y-m-d");
            for ($i = 0; $i < 15; $i++) {
                $fecha_consulta = date("Y-m-d", strtotime($fecha_rango . "-$i days"));
                $cantidad_faltas_por_estado = $consulta->listarfaltasGrafica_consulta($periodo, $semestre, $programa, $fecha_consulta);
                foreach ($cantidad_faltas_por_estado as $row) {
                    $data["datosuno"][] = array(
                        "x" => $fecha_consulta, 
                        "y" => (int) $row['total_faltas'], 
                        "estado" => $row['estado']
                    );
                }
            }
            echo json_encode($data);
            break;
        
        
}
